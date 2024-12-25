<?php
session_start();

$user_name = "root";
$password = "";
$database = "acadmicproject";
$server = "localhost";

$con = new mysqli($server, $user_name, $password, $database);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$major = isset($_SESSION['major']) ? $_SESSION['major'] : null;
if (!$major) {
    header("Location: login.php");
    exit;
}

$student_id = isset($_SESSION['std_id']) ? $_SESSION['std_id'] : null;
if (!$student_id) {
    echo "Error: Student ID not found!";
    exit;
}

$student_info_query = "SELECT years, GPA, hour_complete FROM student WHERE std_id = $student_id";
$student_info_result = $con->query($student_info_query);
if ($student_info_result->num_rows > 0) {
    $student_info = $student_info_result->fetch_assoc();
    $student_year = (int)$student_info['years'];
    $student_gpa = (float)$student_info['GPA'];
    $hour_complete = (int)$student_info['hour_complete'];
} else {
    echo "Error: Student info not found!";
    exit;
}

$success_rate_priority = '';
if ($student_gpa >= 50 && $student_gpa <= 70) {
    $success_rate_priority = "'high', 'medium', 'low'";
} elseif ($student_gpa >= 71 && $student_gpa <= 78) {
    $success_rate_priority = "'medium', 'high', 'low'";
} else {
    $success_rate_priority = "'low', 'medium', 'high'";
}

$successful_hours = "SELECT SUM(c.num_hour) AS total_hours 
                            FROM {$major}_enrollments AS e 
                            JOIN {$major}_courses AS c ON e.course_id = c.course_id 
                            WHERE e.student_id = $student_id AND e.grade >= 50";


$successful_hours_result = $con->query($successful_hours);



// دالة للحصول على المواد المفتوحة
function getUnlockingCourses($con, $course_id, $major) {
    $unlocking_courses = [];
    $courses_to_check = [$course_id]; // قائمة بالمواد للتحقق منها

    while (!empty($courses_to_check)) {
        $current_course_id = array_pop($courses_to_check); // احصل على آخر مادة للتحقق منها

        // استعلام للحصول على المواد المتطلبة
        $query = "SELECT num_of_prereq FROM {$major}_courses WHERE course_id = $current_course_id";
        $result = $con->query($query);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $prerequisite_id = $row['num_of_prereq'];
                if ($prerequisite_id != '0' && !in_array($prerequisite_id, $unlocking_courses)) {
                    $unlocking_courses[] = $prerequisite_id; // أضف المادة المفتوحة
                    $courses_to_check[] = $prerequisite_id; // أضف المادة للتحقق منها لاحقاً
                }
            }
        }
    }

    return $unlocking_courses; // إرجاع المواد المفتوحة
}

// استعلام المواد المقترحة
$suggested_courses_query = "
    SELECT c.course_id, c.course_name, c.num_hour, c.evaluation, c.academic_year, c.have_prerequisite,
           c.success_rate,
           CASE 
               WHEN c.success_rate = 'low' THEN 'نسبة النجاح منخفضة'
               WHEN c.success_rate = 'medium' THEN 'نسبة النجاح متوسطة'
               WHEN c.success_rate = 'high' THEN 'نسبة النجاح عالية'
               ELSE 'نسبة النجاح متوسطة'
           END AS success_level
    FROM {$major}_courses AS c 
    LEFT JOIN {$major}_enrollments AS e ON e.course_id = c.num_of_prereq AND e.student_id = $student_id AND e.grade >= 50
    WHERE c.course_id NOT IN 
    (SELECT e.course_id FROM {$major}_enrollments AS e WHERE e.student_id = $student_id AND e.grade >= 50)
    AND (
        c.evaluation = 'more important' OR 
        (c.evaluation = 'year1' AND $student_year >= 1 AND $hour_complete > 6) OR 
        (c.evaluation = 'year1 less' AND $student_year >= 1 AND $hour_complete > 6) OR 
        (c.evaluation = 'year1 more' AND $student_year >= 1 AND $hour_complete > 12) OR 
        (c.evaluation = 'year2' AND $student_year >= 2 AND $hour_complete > 32) OR 
        (c.evaluation = 'year2 more' AND $student_year >= 2 AND $hour_complete > 32) OR 
        (c.evaluation = 'year3' AND $student_year >= 3 AND $hour_complete > 62) OR 
        (c.evaluation = 'year3 more' AND $student_year >= 3 AND $hour_complete > 62) OR 
        (c.evaluation = 'year4' AND $student_year >= 4 AND $hour_complete > 92) OR
        (c.academic_year = 'any time')   -- شرط للمواد التي يمكن دراستها في أي وقت
    )
    AND (c.num_of_prereq='0' OR e.course_id IS NOT NULL)  
    AND (
        c.num_of_prereq='0' OR 
        c.num_of_prereq IN (
            SELECT e.course_id 
            FROM {$major}_enrollments AS e 
            WHERE e.student_id = $student_id AND e.grade >= 50
        )  
    )
    AND (c.course_name != 'مشروع تخرج 1' OR $hour_complete >= 80)  -- 1شرط لمادة مشروع التخرج
    AND (c.have_prerequisite != 'ان يكون الطالب قاطع اكثر من 100 ساعة' OR $hour_complete >= 100) 
    ORDER BY 
    CASE 
        WHEN c.evaluation = 'more important' THEN 1 
        WHEN c.evaluation = 'year1 more' THEN 2
        WHEN c.evaluation = 'year2 more' THEN 3
        WHEN c.evaluation = 'year3 more' THEN 4
        WHEN c.evaluation = 'year4 more' THEN 5
        ELSE 6
    END,
 FIELD(c.success_rate, $success_rate_priority),
    (c.academic_year = 'any time') DESC";
$suggested_courses_result = $con->query($suggested_courses_query);

$total_hours = 0;
$suggested_courses = [];
$any_time_count = 0; // عداد للمواد التي تحمل القيمة 'any time'

if (isset($_POST['hours']) && is_numeric($_POST['hours'])) {
    $desired_hours = (int)$_POST['hours'];

    // التحقق من أن عدد الساعات المدخلة 6 أو أكثر
    $message = '';

    if ($desired_hours < 6) {
        $message = 'لا يسمح بتنزيل أقل من 6 ساعات في الفصل الواحد, الرجاء ادخال عدد ساعات من 6 و أكثر !!';
    } elseif ($desired_hours > 18 && $hour_complete <= 111) {
        $message = 'لا يسمح بتنزيل أكثر من 18 ساعة في الفصل الواحد ,لغير الخريج !!';
    }
   
    else {
        // متابعة تنفيذ الكود إذا كانت الساعات المدخلة صحيحة
        while ($row = $suggested_courses_result->fetch_assoc()) {
            if ($total_hours + $row['num_hour'] <= $desired_hours) {
                // تحقق مما إذا كانت المادة من نوع 'any time'
                if ($row['academic_year'] === 'any time') {
                    if ($any_time_count < 1) { // إذا كان العدد أقل من1
                        $suggested_courses[] = $row;
                        $any_time_count++;
                        $total_hours += $row['num_hour'];
                    }
                } else {
                    $suggested_courses[] = $row;
                    $total_hours += $row['num_hour'];
                }
            }
        }
    }
} else {
    $desired_hours = 0;
}

// الحصول على المواد المفتوحة لكل مادة مقترحة
foreach ($suggested_courses as &$course) {
    $course['unlocking_courses'] = getUnlockingCourses($con, $course['course_id'], $major);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <title>Academic Advisor MU</title>
    <link rel="icon" href="img/mu_logo.jpg">
    <link rel="stylesheet" href="Style.css">
    <script src="script.js" defer></script>
    <style>
        #desired_hours {
            border: 2px solid #094067;
            max-width: 500px;
            border-radius: 10px;
            color: black;
        }
        #desired_hours:hover {
            box-shadow: black 0px 5px 10px;
            border: 3px solid #ef4565;
        }
        #btn_ok {
            border: 2px solid #094067;
            width: 130px;
            max-width: 200px;
            border-radius: 20px;
            color: white;
            background-color: #ef4565;
        }
        #btn_ok:hover {
            box-shadow: black 0px 5px 10px;
            border: 3px solid #ef4565;
            background-color: crimson;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.6);
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 400px;
            height: 190px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .btn {
            background-color: #28a745;
            color: #eff6f5;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
            margin-top: 30px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color:rgb(25, 106, 43);
            color:rgb(215, 224, 223);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

    </style>
</head>
<body>
<div class="container-fluid">
    <nav style="background-color: #094067;" class="navbar bg-body-tertiary fixed-top">
        <div class="container-fluid">
            <h2 style="color: #eff6f5; margin-left: 30px; font-size: 25px;" class="navbar-brand"><b>Academic Advisor for <span style="color: #ef4565">IT</span></b></h2>
            <div class="group">
                <button id="button1" onclick="document.location='plane tree.php'"><b>Plane Tree</b></button>
                <button id="button1" onclick="document.location='remaining courses.php'"><b>Remaining courses</b></button>
                <button id="button1" onclick="document.location='view courses.php'"><b>View your courses</b></button>
                <button style="border: #ef4565 2px solid; border-radius: 5px" id="button1" onclick="document.location='suggestion page.php'"><b>Suggestion page</b></button>
            </div>
            <button style="width: 60px; height: 40px" class="navbar-toggler bg-danger" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <i class="bi bi-list-ul"></i>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h4 class="offcanvas-title text-danger" id="offcanvasNavbarLabel"><b>Academic Advisor for IT</b></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a id="abor" style="color: #094067" class="nav-link active linecolor" aria-current="page" href="main page.php"><i class="bi bi-house-door"></i> <b>Home</b></a>
                        </li>
                        <li>
                            <a id="abor" style="color: #094067" class="nav-link active linecolor" aria-current="page" href="myinfo page.php"><i class="bi bi-card-checklist"></i> <b>My info</b></a>
                        </li>
                        <li class="nav-item">
                            <a id="abor" style="color: #094067" class="nav-link linecolor" href="aboutsystem.php"><i class="bi bi-info-circle"></i> <b>About System</b></a>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="abor" style="color: #094067; text-decoration: none" class="nav-link dropdown-toggle linecolor" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <b><i class="bi bi-three-dots-vertical"></i>For questions</b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a id="abor" style="color: #094067" class="nav-link active linecolor" aria-current="page" href="ask page.php"><i class="bi bi-patch-question"></i> <b>Ask a question</b></a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a id="abor" style="color: #094067" class="dropdown-item" href="show answer.php"><i class="bi bi-clipboard-check"></i> <b>Answer your questions</b></a></li>
                            </ul>
                        </li>
                        <li><a id="abor" style="color: #094067" class="nav-link linecolor" href="login.php"><i class="bi bi-box-arrow-right"></i> <b>Logout</b></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <br>
    <div style="text-align: center;padding:20px;" class="alert alert-danger mt-5">
        <button style="float: left;" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong style="float: right;color:red">: تنبيه هام <i class="bi bi-exclamation-triangle-fill"></i></strong> ! سوف يتم اقتراح عدد ساعات محدد بناءً على عدد الساعات التي قطعتها
        , <strong>في حين بالغت في وضع عدد الساعات التي ترغب بتسجيلها </strong>
    </div>

    <form style="margin-top: 70px;" method="post">
        <div class="mb-3">
            <label for="hours" class="form-label"><b>أدخل عدد الساعات التي ترغب بتسجيلها:</b></label>
            <input type="number" name="hours" id="desired_hours" class="form-control" required min="1">
        </div>
        <button id="btn_ok" type="submit" class="btn">OK</button>
    </form>

    <?php if ($message): ?>
    <div id="myModal" class="modal" style="display: block;">
        <div class="modal-content">
            <p><?php echo $message; ?></p>
            <button class="btn" onclick="document.getElementById('myModal').style.display='none'">موافق</button>
        </div>
    </div>
<?php endif; ?>

    <h4 class="text-center mt-5"><b>المواد المقترحة بناءً على عدد الساعات المطلوبة</b></h4>
    <div id="suggested_courses" class="d-flex justify-content-center mb-3">
        <div class="me-2" style="background-color: red; width: 2%; height: 25px;"></div>
        <span class="me-3"><b>المواد هامة جدا يجب تنزيلها</b></span>
        <div class="me-2" style="background-color:bisque; width: 2%; height: 25px;"></div>
        <span class="me-3"><b>مواد هامة يفضل تنزيلها</b></span>
        <div class="me-2" style="background-color: #fef65b; width: 2%; height: 25px;"></div>
        <span class="me-3"><b>المواد ليست هامة يمكن تأجيل تنزيلها</b></span>
        <div class="me-2" style="background-color:#6dffdf; width: 2%; height: 25px;"></div>
        <span><b>مواد هامة من المهم تنزيلها في اقرب وقت</b></span>
    </div>
    <br>
    <table class="table table-bordered-dark mt-3">
        <thead>
            <tr>
                <th style="color: black;">Course ID</th>
                <th style="color: black;">Course Name</th>
                <th style="color: black;">Num Hours</th>
                <th style="color: black;">Academic Year</th>
                <th style="color: black;">Have a prerequisite</th>
                <th style="color: black;">Success Level</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($suggested_courses) > 0) {
                foreach ($suggested_courses as $row) {
                    $bg_color = '';
                    if ($row['evaluation'] === 'more important') {
                        $bg_color = 'style="background-color: #f73b2e; color: white;"';
                    } elseif ($row['evaluation'] === 'year1 less') {
                        $bg_color = 'style="background-color: #fef65b; color: black;"';
                    } elseif ($row['evaluation'] === 'year2 more') {
                        $bg_color = 'style="background-color: #6dffdf; color: black;"';
                    } else {
                        $bg_color = 'style="background-color: #fff8e4; color: black;"';
                    }

                    echo "<tr $bg_color>
                        <td><b>" . htmlspecialchars($row["course_id"]) . "</b></td>
                        <td>" . htmlspecialchars($row["course_name"]) . "</td>
                        <td>" . htmlspecialchars($row["num_hour"]) . "</td>
                        <td><b>Year:</b> " . htmlspecialchars($row["academic_year"]) . "</td>
                        <td>" . htmlspecialchars($row["have_prerequisite"]) . "</td>
                        <td>" . htmlspecialchars($row["success_level"]) . "</td>
                    </tr>";
                }
            } else {
                echo "<tr><td style='color: red;' colspan='6'>لا يوجد مواد مقترحة, يجب ادخال عدد الساعات التي ترغب بتسجيلها</td></tr>";
            }
            ?>
        </tbody>
    </table>
    
   
    <footer class="footer">
    <div class="container text-center">
        <p>Copyrights @2024 / 2025 by: <span style="color: white;">Mohammed Albadawi</span></p>
        <div class="row">
            <div class="col">
                <img src="img/el.png" alt="Logo" width="200" height="150">
                <p><b>E-Learning And Educational Resources Center</b></p>
            </div>
            <div class="col">
                <h2 style="color:#ef4565;">Follow Us:</h2>
                <a href="https://www.facebook.com/mutah2019/"><img src="img/facebook.png" alt="Facebook" width="50" height="50"></a>
                <a href="https://www.linkedin.com/school/mutahuniversity/"><img style="border-radius: 25px; border:none" src="img/ll.png" alt="LinkedIn" width="50" height="50"></a>
                <a href="https://www.instagram.com/mohamadebadawi?igsh=MTBvMjA0cjhwNzM1dg=="><img style="border-radius: 25px; border:none" src="img/in.jfif" alt="Instagram" width="50" height="50"></a>
            </div>
            <div class="col">
                <h2 style="color:#ef4565;">Contact with us:</h2>
                <p><b>الأردن-الكرك | الرمز البريدي(61710)</b></p>
                <p><b><i class="bi bi-telephone-fill"></i> Phone Number :</b> (+962) 03-2372-380</p>
                <p><b><i class="bi bi-envelope-fill"></i> Email :</b> unit_admin@mutah.edu.jo</p>
            </div>
            <div class="col">
                <h2 style="color:#ef4565;">Quick Links:</h2>
                <a class="footer-link" href="https://www.mutah.edu.jo/stu.aspx" target="_blank">Home page MU</a><br>
                <a class="footer-link" href="https://www.mutah.edu.jo/en/english/Lists/Services/StudentServices.aspx" target="_blank">Student Services MU</a><br>
                <a class="footer-link" href="http://app.mutah.edu.jo:7777/studreg/" target="_blank">Registration subjects page MU</a>
            </div>
        </div>
        <div style="background-color:#12020269; color:white;">
            <p style="text-align: center;">Developed by: <span style="color: #ef4565">Mohammed Albadawi / Ibrahim Alturk / Adel Bassam / Tariq Khaled</span></p>
        </div>
    </div>
</footer>

<button id="myBtn" class="btn btn-danger"><b><i class="bi bi-arrow-up"></i></b></button>

<script>
 window.onclick = function(event) {
        var modal = document.getElementById('myModal');
        if (event.target == modal) {
            modal.style.display = "none";
            
        }
    }



    let mybutton = document.getElementById("myBtn");
    window.onscroll = function () {
        scrollFunction();
    };
    function scrollFunction() {
        if (document.body.scrollTop > 150 || document.documentElement.scrollTop > 150) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }
    mybutton.onclick = function scroll() {
        window.scroll({
            left: 0,
            top: 0,
            behavior: 'smooth'
        });
    };




</script>
</div>

</body>
</html>
