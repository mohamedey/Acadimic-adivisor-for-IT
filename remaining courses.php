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
    echo "Error: Student ID did not found!";
    exit;
}


$sum_hours = "SELECT SUM(num_hour) AS total_hours FROM {$major}_courses";
$sum_hours_result = $con->query($sum_hours);
$total_hours = $sum_hours_result->fetch_assoc()['total_hours'];

$registered_sum = "SELECT SUM(c.num_hour) AS registered_hours 
                   FROM {$major}_enrollments AS e 
                   JOIN {$major}_courses AS c ON e.course_id = c.course_id 
                   WHERE e.student_id = $student_id AND e.grade >= 50"; 

$registered_result = $con->query($registered_sum);
$registered_hours = $registered_result->fetch_assoc()['registered_hours'];
if (isset($total_hours) && isset($registered_hours)) {
    $remaining_hours = $total_hours - $registered_hours;
} else {
    $remaining_hours = $total_hours; 
}
$courses_query = "SELECT c.course_id, c.course_name, c.num_hour, c.academic_year, c.have_prerequisite
                  FROM {$major}_courses AS c 
                  LEFT JOIN {$major}_enrollments AS e ON c.course_id = e.course_id AND e.student_id = $student_id 
                  WHERE e.course_id IS NULL OR (e.grade < 50 AND e.student_id = $student_id) 
                  ORDER BY c.academic_year ASC";
$courses_result = $con->query($courses_query);


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
    <script src="script.js"></script>
    <style>
        footer {
          background-color:#094067; 
          color: aliceblue;
           width: 100%; 
          padding-top: 10px;
          margin-top: 50px;
        }
        footer {
            background-color: #094067; 
            color: aliceblue;
            padding: 20px 0;
        }
        .footer-link {
            color: white;
            text-decoration: underline !important;
        }

    </style>
</head>

<body>


<div class="container-fluid">
 <nav style="background-color: #094067;" class="navbar bg-body-tertiary fixed-top">
    <div class="container-fluid">
      <h2 style="color: #eff6f5; margin-left: 30px; font-size: 25px ;" class="navbar-brand "><b>Academic Advisor for <span style="color: #ef4565" >IT</span></b></h2>
      <form method="post" action="course_search.php">
        <input style="height: 37px; border-radius: 10px; width: 220px;color: #094067;box-shadow: 0px 5px 10px black"  type="search" placeholder="Search" aria-label="Search" name="search">
        <button style="border: none;border-radius: 8px; box-shadow: 0px 5px 10px black" class="btn btn-danger" type="submit">Search</button>
      </form>
     <div class="group ">
      <button id="button1"  onclick="document.location='plane tree.php'" ><b>Plane Tree</b></button>
      <button style="border: #ef4565 2px solid; border-radius: 5px" id="button1" onclick="document.location='remaining courses.php'"><b>Remaining courses</b></button>
      <button id="button1" onclick="document.location='view courses.php'"><b>View your courses</b></button>
      <button id="button1" onclick="document.location='suggestion page.php'"><b>Suggestion page</b></button>


     </div>
      <button style="width: 60px; height: 40px" class="navbar-toggler bg-danger" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <i class="bi bi-list-ul"></i>
      </button>
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
          <h4 class="offcanvas-title text-danger" id="offcanvasNavbarLabel"><b>Academic Advisor for IT</b> </h4>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a id="abor" style="color: #094067"  class="nav-link active linecolor " aria-current="page" href="main page.php"><i class="bi bi-house-door"></i>   <b>Home</b></a>

              
            </li>

            <li>
            <a id="abor" style="color: #094067"  class="nav-link active linecolor " aria-current="page" href="myinfo page.php"><i class="bi bi-card-checklist"></i>   <b>My info</b></a>
            </li>
            <li class="nav-item">
              <a id="abor" style="color: #094067"  class="nav-link linecolor" href="aboutsystem.php"><i class="bi bi-info-circle"></i>   <b>About System</b></a>
            </li>
            <li class="nav-item dropdown">
              <a id="abor" style="color: #094067; text-decoration: none" class="nav-link dropdown-toggle linecolor" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
             <b> <i class="bi bi-three-dots-vertical"></i>For questions</b>
              </a>
              <ul class="dropdown-menu">
              <li>
              <a id="abor" style="color: #094067"  class="nav-link active linecolor " aria-current="page" href="ask page.php">    <i class="bi bi-patch-question"></i>  <b>Ask a question</b></a>
              
            </li>             
               <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a id="abor" style="color: #094067" class="dropdown-item" href="show answer.php"><i class="bi bi-clipboard-check"></i>  <b>Answer your questions</b></a></li>
              </ul>
            </li>
           
            <li><a id="abor" style="color: #094067"  class="nav-link linecolor" href="login.php"><i class="bi bi-box-arrow-right"></i>   <b>Logout</b></a></li>

          </ul>
         
        </div>
      </div>
    </div>
  </nav>
    </div>

<div class="sumHours">
    <h4 class="sumHours"><b>الساعات المتبقية:</b> <span style="color: #ef4565"><b><?php echo htmlspecialchars($remaining_hours); ?></b></span></h4>
</div>

<div class="tables-container">
    <div class="table-wrapper">
        <h4 style="text-align: center"><b>المواد المتبقية للطالب مواد اجباري تخصص واجباري جامعة</b></h4>
        <table>
            <thead>
                <tr>
                    <th>Course ID</th>
                    <th>Course Name</th>
                    <th>Num Hours</th>
                    <th>Have a prerequisite</th>
                    <th>Academic_ year</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($courses_result->num_rows > 0) {
                    while ($row = $courses_result->fetch_assoc()) {
                        echo "<tr>
                        <td><b>" . htmlspecialchars($row["course_id"]) . "</b></td>
                        <td><b>" . htmlspecialchars($row["course_name"]) . "</b></td>
                        <td>" . htmlspecialchars($row["num_hour"]) . "</td>
                       <td>" . htmlspecialchars($row["have_prerequisite"]) . "</td>

                        <td> <b>Year :</b>"  . htmlspecialchars($row["academic_year"]) . "</td>

                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'><b>لا توجد مواد متاحة.</b></td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<br><br><br><br><br>


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

<button id="myBtn"><b><i class="bi bi-arrow-up"></i></b></button>
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