<?php

session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "acadmicproject";

$con = mysqli_connect($servername, $username, $password, $dbname);
if (!$con) { 
  die("Connection failed: " . mysqli_connect_error()); 
}
$user_id=$_SESSION["std_id"];
$sql = "SELECT * FROM student WHERE std_id = $user_id";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);


$sql2 = "SELECT password FROM admin_for_std WHERE std_id = $user_id";
$result2 = mysqli_query($con, $sql2);
$row2 = mysqli_fetch_assoc($result2);


?>


<!DOCTYPE html>
<head>
<title>Academic Advisor MU</title>
<link  rel="icon" href="img/mu_logo.jpg">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="script.js"></script>

<link rel="stylesheet" href="Style.css">  
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
 body {
  background-color: #fffffe;
  font-family: Arial;
  background-size: 50%;
  background-image: url('img/mu_logo.jpg');
  background-position: center;
  background-repeat: no-repeat;
  background-attachment: fixed;


}

h3{
  color: black;
  text-transform: none;
  text-align: left;
  font-size: 25px;
  padding: 10px;
}
.but {
  background-color: #094067;
  color: #fffffe;
  padding: 20px 30px;
  font-size: 1.4em;
  margin: 40px 0; 
  border-radius: 13px;
  width: 250px;
  display: block;
  margin-left: auto;
  margin-right: auto; 
  box-shadow: 0 5px 9px black;
}
.but:hover{
  background-color: #3d85c6;
  transition: .5s;
  
}

.vi{
  font-size: 1.3em;
}
#button {
  font-family: "Roboto", sans-serif;
  color: #fffffe;
  background: #ef4565;
  padding: 20px 30px;
  font-size: 1.4em;
  margin: 40px 0; 
  border-radius: 13px;
  width: 250px;
  display: block;
  margin-left: auto;
  margin-right: auto; 
  box-shadow: 0 5px 9px black;
}
#button1::after{
    content: " ";
    display: block;
    height: 4px;
    width: 100%;
    transform: scale(0);
    transform-origin: left;
  }
  #button1:hover{
    border: #ef4565 1px solid;
    border-radius: 2px;
    color: #ef4565;
    transition: .4s;
    box-shadow: black 3px 4px 7px;
  }
  #button1:hover::after{
    transform: scale(1);
    background-color: #ef4565;
    transition: .5s;
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
      

<div class="container" style="margin-top: 140px;">
<img src="img/pl.gif" alt="palestine flag"  width="100px" height="50px">
<span style="color:red;font-size: 50px;">&#10084;</span>

      <img src="img/jo.gif" alt="Jordan flag"  width="100px" height="50px"><br><br>

<h3>Your Name : <span style="color:#ef4565;"><?php echo $row["std_name"]; ?></span></h3>
<h3>Your ID  : <span style="color:#ef4565;"><?php echo $row["std_id"]; ?></span></h3>
<h3>Your Email  : <span style="color:#ef4565;"><?php echo $row["email"]; ?></span></h3>
<h3>Your Password  : <span style="color:#ef4565;"><?php echo $row2["password"]; ?></span></h3>
<h3>Your Major  : <span style="color:#ef4565;"><?php echo $row["major"]; ?></span></h3>
<h3>Your GPA  : <span style="color:#ef4565;"><?php echo $row["GPA"]; ?></span></h3>
<h3>Academic year  : <span style="color:#ef4565;"><?php echo $row["years"]; ?></span></h3>

</div>
<br><br><br><rb><br><br><br><br><br>


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







