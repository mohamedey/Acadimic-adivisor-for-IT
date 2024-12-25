<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Advisor MU</title>
    <link rel="icon" href="img/mu_logo.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="Style.css">
    <style>
        @import url(https://fonts.googleapis.com/css?family=Roboto:300);
        body {
            background: linear-gradient(135deg, #f8f9fa, #e2e6ea);
            font-family: 'Roboto', sans-serif;
        }
        .message {
            color: #777;
            font-size: 15px;
        }
        .message a {
            color: #a9120b;
            text-decoration: none;
        }
        h3 {
            text-align: center;
            font-family: 'Franklin Gothic Medium';
            padding: 10px;
            color: #a9120b;
            text-transform: uppercase;
        }
        #errorMessage {
            color: red;
            font-size: 14px;
        }
        .input-group {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: gray;
            background-color: transparent;
            border: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-page">
            <div class="form animate__animated animate__fadeInDown">
                <h3>Academic advisor login page</h3>
                <form class="login-form" id="loginForm" method="post">
                    <input class="st1" type="text" id="studentId" placeholder="Student ID" name="in1" required>
                    <div class="input-group mb-3">
                        <input class="ps1" type="password" id="password" placeholder="Password" name="in2" required>
                        <button type="button" class="input-group-text toggle-password" onclick="togglePassword('password')">
                            <i class="bi bi-eye" id="eye2"></i>
                        </button>
                    </div>
                    <input id="button" type="submit" value="Login">
                    <p id="errorMessage"></p>
                    <p class="message">Forget Password? <a id="line" href="Restpass.php"><b>Reset your Password!</b></a></p>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault(); 

            let stdclass = document.getElementsByClassName('st1')[0];
            let psclass = document.getElementsByClassName('ps1')[0];

            let studentId = document.getElementById('studentId').value;
            let password = document.getElementById('password').value;
            let errorMessage = document.getElementById('errorMessage');

            errorMessage.textContent = '';

            fetch('loginserver.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    'in1': studentId,
                    'in2': password
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    errorMessage.textContent = data.error;
                    stdclass.style.border = "1px solid red";
                    psclass.style.border = "1px solid red";
                    stdclass.value = '';
                    psclass.value = '';
                    stdclass.focus();
                } else {
                    if (data.user_type == 'student') {
                        window.location.href = 'main page.php'; 
                        
                    }else{
                        window.location.href = 'admin_dashboard.php';
                        
                    }
                }
            });
        });

        function togglePassword(passwordId) {
            const passwordField = document.getElementById(passwordId);
            const eyeIcon = document.getElementById('eye2');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            }
        }
    </script>
</body>
</html>