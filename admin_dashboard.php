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

$sql = "SELECT * FROM question WHERE id NOT IN (SELECT question_id FROM answers )";
$result = $con->query($sql);
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
            background-color: #fffffe;
            font-family: Arial;
            display: flex;
            justify-content: center;
            align-items: flex-start; 
            flex-direction: column; 
            height: auto; 
            padding: 20px; 
        }
        .card {
            width: 100%; 
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            margin-bottom: 40px; 
            padding: 20px;
            height: auto; 
        }
        .card h5 {
            margin-left: 15px;
            text-align: left;
            font-family: 'Franklin Gothic Medium';
            padding: 10px; 
            color: white; 
        }
        .answer-area {
            display: none; 
            margin-top: 10px;
        }
        #send {
            background-color: #35c80a;
            margin-left: 15px;
            color: white;
            border: 2px solid black;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            margin: 5px;
        }
        #answer {
            background-color: darkblue;
            color: white;
            border: 2px solid black;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            margin-left: 15px;
            margin: 5px;
        }
        #send:hover {
            background-color: green;
            color: white;
            border-radius: 7px;
            cursor: pointer;
        }
        #answer:hover {
            background-color: blue;
            color: white;
            border-radius: 7px;
            cursor: pointer;
        }
        
    </style>
</head>

<body>
<div class="container-fluid">
 <nav style="background-color: #094067;" class="navbar bg-body-tertiary fixed-top">
    <div class="container-fluid">
      <h2 style="color: #eff6f5; margin-left: 30px; font-size: 25px ;" class="navbar-brand "><b>Academic Advisor for <span style="color: #ef4565" >IT</span></b></h2>
      <h5 style="color:#ef4565 ;"><b> Welcome Admin :<span style="color:white ;"> <?php echo $_SESSION['admin_name']; ?></span>  </b></h5>
     <div class="group ">
      <button id="button1" style="float: right; border:#ef4565 2px solid; border-radius: 5px;" onclick="document.location='login.php'"><b> <i class="bi bi-box-arrow-right"></i>  Logout</b></button>



     </div>
     
      
    </div>
  </nav>
    </div>

    <br><br><br>
    <div class="container mt-5">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "
                <div class='card'>
                    <div class='content'>
                        <div style='background-color: #ef4565; border-radius: 10px;'>
                            <h5>Student Name : <b>" . htmlspecialchars($row["std_name"]) . "</b></h5>
                            <h5>Student ID : <b>" . htmlspecialchars($row["std_id"]) . "</b></h5>
                            <h5>Student Email : <b>" . htmlspecialchars($row["std_email"]) . "</b></h5>
                            <h5 style='color: black'>Question: <b>" . htmlspecialchars($row["msg"]) . "</b></h5>
                            <hr>

                            <button id='answer' type='button' onclick='answerfunction(this)'>answer</button>

                            <div class='answer-area'>
                                <textarea class='form-control' rows='5' placeholder='answer here'></textarea>
                                <button id='send' onclick='sendAnswer(this, " . htmlspecialchars($row["std_id"]) . ", " . htmlspecialchars($row["id"]) . ")'><i class='bi bi-send-check'></i> Send Answer</button>
                            </div>
                        </div>
                    </div>
                </div>
                ";           
            }
        } else {
            echo "<h1 style='text-align: center;'>لا توجد استفسارات.</h1>";
        }
        ?>
        
<button id="myBtn"><b><i class="bi bi-arrow-up"></i></b></button>

    </div>


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



        function answerfunction(button) {
            const answerArea = button.nextElementSibling;
            if (answerArea.style.display === "none" || answerArea.style.display === "") {
                answerArea.style.display = "block";
                button.textContent = "Hide";
                answerArea.focus();
            } else {
                answerArea.style.display = "none";
                button.textContent = "answer";
            }
        }

        function sendAnswer(button, studentId, questionId) {
            const textarea = button.previousElementSibling;
            const answer = textarea.value;

            if (!answer) {
                alert("يرجى إدخال إجابة.");
                return;
            }

            fetch('answerServer.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    'student_id': studentId,
                    'question_id': questionId,
                    'answer': answer,
                    'admin_id': <?php echo $_SESSION['admin_id']; ?> // تأكد من أن لديك admin_id في الجلسة
                })
            })
            .then(response => response.text())
            .then(data => {
                alert(data); // عرض رسالة النجاح أو الخطأ
                textarea.value = ''; // مسح النص بعد الإرسال

                // إزالة البطاقة من الصفحة
                const card = button.closest('.card'); // إيجاد البطاقة الأبوية
                card.remove(); // إزالة البطاقة
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
</body>
</html>