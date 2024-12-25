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

if (isset($_SESSION['std_id'])) {
    $std_id = $_SESSION['std_id'];

    $sql = "SELECT q.std_id, q.msg AS question, ad.admin_name, a.answer, a.id AS answer_id 
            FROM question q 
            JOIN answers a ON q.id = a.question_id 
            JOIN admin_data ad ON a.admin_id = ad.admin_id 
            WHERE q.std_id = $std_id"; 

    $result = $con->query($sql);
} else {
    die("يرجى تسجيل الدخول لعرض الإجابات.");
}

// التعامل مع طلب الحذف
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_sql = "DELETE FROM answers WHERE id = $delete_id";
    $delete_sql2 = "DELETE FROM question WHERE id = $delete_id";
    $result = $con->query($delete_sql2);

    if ($con->query($delete_sql) === TRUE && $con->query($delete_sql2) === TRUE) {
        echo "<script>
        alert('تم حذف الإجابة بنجاح.');
        window.location.href='show answer.php';
        </script>";
    } else {
        echo "<script>
        alert('حدث خطأ أثناء حذف الإجابة.');
        </script>";
    }
}
?> 

<!DOCTYPE html>
<html lang="ar">
<head>
    <title>Academic Advisor MU</title>
    <link rel="icon" href="img/mu_logo.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="Style.css">  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .card {
            margin-bottom: 20px;
            border: 1px solid black;
            border-radius: 5px;
            box-shadow: 0 5px 10px black;
        }
        #delete {
            float: right;
            width: 40px;
            height: 40px;
            background-color:#ef4565;
            border-radius:5px;
            border: none;
            box-shadow: 0 4px 5px black;
        }
        #delete:hover {
            background-color: #a40c28;
            transition: .6s;
            box-shadow: 0 4px 10px black;
            width: 45px;
        }
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
     <div class="group ">
      <button id="button1"  onclick="document.location='plane tree.php'" ><b>Plane Tree</b></button>
      <button id="button1" onclick="document.location='remaining courses.php'"><b>Remaining courses</b></button>
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
<br><br><br>

<div class="container mt-5">
    <h1 class="text-center">الإجابة على استفساراتك السابقة</h1>
    <br>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='card p-3 m-3'>";
            $answer_id = htmlspecialchars($row["answer_id"]);
            echo "<button id='delete' onclick='window.location.href=\"show answer.php?delete_id=$answer_id\"'><i class='bi bi-x-lg'></i></button>";
            echo"<br>";
            echo "<h5>Student ID: <b>" . htmlspecialchars($row["std_id"]) . "</b></h5>";
            echo "<h5>Question: <b>" . htmlspecialchars($row["question"]) . "</b></h5>";
            echo "<hr>";
            echo "<h5>Admin Name: <b>" . htmlspecialchars($row["admin_name"]) . "</b></h5>";
            echo "<h5><span style='color: green'>Answer:</span> <b>" . htmlspecialchars($row["answer"]) . "</b></h5>";
            echo "</div>";
        }
    } else {
        echo "<h3 class='text-center'>لا توجد إجابات متاحة.</h3>";
        echo "<button class='btn btn-danger' style='margin: 0 auto; display: block;' onclick='window.location.href = \"ask page.php\";'>
        <i class='bi bi-skip-backward'></i><b>Back</b>
        </button>";
    }
    ?>
</div>

<br><br><br><br>


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


</body>
</html>

<?php
$con->close();
?>