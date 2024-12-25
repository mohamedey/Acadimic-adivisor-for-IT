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

if (isset($_POST['search'])) {
    $search_id = trim($_POST['search']);
    $search_name = trim($_POST['search']);

    $sql = "SELECT course_id, course_name, num_hour, academic_year, have_prerequisite FROM {$major}_courses WHERE course_id = '$search_id' OR course_name LIKE ('%$search_name%')";

    $result = $con->query($sql);

    // Query to get the courses the student has passed
    $passed = "SELECT course_id FROM {$major}_enrollments WHERE student_id = {$_SESSION['std_id']} AND grade >= 50";
    $passed_result = $con->query($passed);
    
    // Store passed course IDs in an array
    $passed_courses = [];
    while ($row = $passed_result->fetch_assoc()) {
        $passed_courses[] = $row['course_id'];
    }
    $passed_courses = array_flip($passed_courses); // Use flip for easier checking
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
    <title>Academic Advisor MU</title>
    <script src="script.js"></script>

    <link  rel="icon" href="img/mu_logo.jpg">
        <style>
        .tables-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 50px;
            gap: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
            padding: 15px;
        }
        th, td {
            text-align: center;
            padding: 8px;
            border: 2px solid black;
        }
        th {
            background-color: #ef4565;
            color: #eff6f5;
        }    
        
        #btn {
            padding: 10px;
            background-color: #ef4565;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
            transition: 0.5s;
            width: 120px;
            height: 50px;
            margin-left: 60px;
            margin-top: 20px;
        }
        #btn:hover {
            background-color: #cd052b;
            transition: .6s;
            width: 115px;
        }
        body {
            background-color: #fffffe;
        }
        footer {
          background-color:#094067; 
          color: aliceblue;
           width: 100%; 
          padding-top: 10px;
          margin-top: 50px;
        }
        .footer-link{
    color: white;
    margin-left: 100px;
    font-size: 20px;
    text-decoration: underline !important;
}
.follw{
  cursor: pointer;
  text-decoration: none;
}
    </style>
</head>

<body>
    <button id="btn" onclick="location.href='remaining courses.php'"><i class="bi bi-arrow-left-short"></i>Back</button>
    <div class="container-fluid">
        <h3 style="text-align: center; padding: 10px">تفاصيل المادة</h3>
        <table>
            <thead>
                <tr>
                    <th>Course ID</th>
                    <th>Course Name</th>
                    <th>Num Hours</th>
                    <th>Have a prerequisite</th>
                    <th>Academic Year</th>
                    <th>Status</th>

                </tr>
            </thead>
            <tbody>
            <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $course_id = htmlspecialchars($row["course_id"]);
                 // Check if the course has been passed
               if (isset($passed_courses[$course_id])) {
                   $status = "<i class='bi bi-check-circle' style='color: green;'></i>"; // Green check if taken
                } else {
                    $status = "<h6 style='color: red;'>لم تأخذها بعد</h6>"; // Message if not taken
                   }                        
                        echo "<tr>
                        <td><b>" . $course_id . "</b></td>
                        <td><b>" . htmlspecialchars($row["course_name"]) . "</b></td>
                        <td>" . htmlspecialchars($row["num_hour"]) . "</td>
                        <td>" . htmlspecialchars($row["have_prerequisite"]) . "</td>
                        <td><b>Year :</b>"  . htmlspecialchars($row["academic_year"]) . "</td>
                        <td>" . $status . "</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td style='color:red;' colspan='6'><b> لا توجد مادة مطابقة (المادة غير موجودة في خطتك الدراسية).</b></td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
<br><br><br><br><br><br><br><br><br>




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
                <a  href="https://www.linkedin.com/school/mutahuniversity/"><img style="border-radius: 25px;border:none" src="img/ll.png" alt="LinkedIn" width="50" height="50"></a>
                <a href="https://www.instagram.com/mohamadebadawi?igsh=MTBvMjA0cjhwNzM1dg=="><img style="border-radius: 25px;border:none" src="img/in.jfif" alt="Instagram" width="50" height="50"></a>
            </div>

            <div class="col">
                <h2 style="color:#ef4565;">Contact with us:</h2>
                <p><b>الاردن-الكرك | الرمز البريدي(61710)</b></p>
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


    <script>
      
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
         
</body>
</html>