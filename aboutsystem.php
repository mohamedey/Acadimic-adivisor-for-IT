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
<link  rel="icon" href="img/mu_logo.jpg">
<script src="script.js"></script>
<link rel="stylesheet" href="Style.css">

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
    <div class="container-fluid">
    <div>

<div style="text-align: center;padding:20px; width: 100%; height: 60px" class="alert alert-success">
<button style="float: left;" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

  <span style="float: right;color:green">تستطيع معرفة كيفية استخدام النظام عبرة مشاهدةالفيديو<span> <strong>
    ,  <a style="color: green;" href="#video">اضغط هنا للمشاهدة </a></strong>

</div>
        <div style="background-color:#eae6e6; width: 100%; height: auto;">
            <p style="color: #094067; font-size: 20px; margin-left: 50px; margin-top: 50px; text-align: center;border-radius: 30px;padding: 10px">
            النظام هو عبارة عن مرشد أكاديمي مخصص لكلية تكنولوجيا المعلومات في جامعة مؤتة،
             يتيح للطلاب رؤية الخطة الشجرية لتخصصهم والمواد التي أنهوا دراستها مع العلامات التي حصلوا عليها، 
             بالإضافة إلى المواد التي لم ينجحوا فيها.
              كما يعرض النظام المواد المتبقية للطالب ويقدم اقتراحات بشأن المواد التي يمكنه تسجيلها اعتمادًا على عدد الساعات المكتسبة والسنة الدراسية،
               مما يساعده على الالتزام بالخطة الدراسية والتخرج في الموعد المحدد. بالإضافة إلى ذلك،
                يوفر النظام وسيلة للطلاب لطرح أسئلتهم على أعضاء هيئة التدريس، المعروفين بالأدمن، الذين يقومون بالإجابة على هذه الأسئلة،
                مما يعزز من تفاعل الطلاب مع العملية التعليمية ويدعم فهمهم للمواد الدراسية.
            </p>
            <br><br> <hr style="background-color: #094067;">

            <p style="color: #094067; font-size: 20px; margin-left: 50px; margin-top: 50px; text-align: center;border-radius: 30px;padding: 10px">
            The system is an academic advisor dedicated to the College of Information Technology at Mu'tah University.
             It allows students to view the curricular tree for their major, along with the courses they have completed 
             and the grades they have received, as well as the courses they have not passed. 
             The system also displays the remaining courses for the student and provides suggestions for courses they can register
              for based on the number of credit hours they have earned and their academic year, helping them stay on track with their
               study plan and graduate on time. Additionally, the system offers a way for students to ask questions to faculty members,
                known as admins, who respond to these inquiries, thereby enhancing student engagement with the educational 
                process and supporting their understanding of the course material.
                
            </p>

        </div>

    </div>
    <br><br><br><br> 
    <video class="form animate__animated animate__backInRight" id="video" src="img/ved.mp4" width="100%" height="600px" controls></video>

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