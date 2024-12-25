<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
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
        .login-page {
            width: 360px;
            margin-top: 120px;
        }
        .form {
            position: relative;
            background: #FFFFFF;
            max-width: 360px;
            margin: 0 auto 100px;
            padding: 45px;
            text-align: center;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
        }
        .form input {
            font-family: sans-serif;
            outline: 0;
            background: #f2f2f2;
            width: 100%;
            border: 0;
            margin: 0 0 15px;
            padding: 15px;
            box-sizing: border-box;
            font-size: 14px;
        }
        h3 {
            text-align: center;
            font-family: 'Franklin Gothic Medium';
            padding: 10px;
            color: #a9120b;
        }
        body {
            background-color: #fffffe;
        }
        .input-group {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 40%;
            transform: translateY(-50%);
            cursor: pointer;
            color: gray ;
            background-color:#49484800;
            border: none;
        }
      
    </style>
</head>
<body>
<div class="container">
    <div class="login-page">
        <div class="form animate__animated animate__backInRight">
            <h3>Reset Password</h3>
            <form class="login-form" action="restpassserver.php" method="post" id="RestForm">
                <input id="studentId" type="text" placeholder="Student ID" name="rest1" required/>
                <input id="email" type="text" placeholder="Email" name="rest2" required/>
                <hr>
                <div class="input-group mb-3">
                    <input id="password1" type="password" class="form-control" placeholder="New Password" name="rest3" required/>
                    <span class="input-group-text toggle-password" onclick="togglePassword('password1')">
                        <i class="bi bi-eye" id="eye1"></i>
                    </span>
                </div>
                <div class="input-group mb-3">
                    <input id="password2" type="password" class="form-control" placeholder="Confirm Password" name="rest4" required/>
                    <span class="input-group-text toggle-password" onclick="togglePassword('password2')">
                        <i class="bi bi-eye" id="eye2"></i>
                    </span>
                </div>
                <input id="checkbox" style="width: 20px;height: 15px;" type="checkbox" name="remember" required/>
                <label style="color:grey;">I am the owner of this account!</label>
                <input id="button" type="submit" value="Reset Password" required>
                <p class="message">I want to? <a id="line" href="login.php"><b>Back to login page!</b></a></p>
            </form>
        </div>
    </div>
</div>
<script>
    let s = document.getElementById("studentId");
    let p1 = document.getElementById("password1");
    let p2 = document.getElementById("password2");
    let e = document.getElementById("email");
    let x = document.getElementById("checkbox");
    let b = document.getElementById("button");
    
    window.onload = function() {
        b.style.backgroundColor = "#978b8b";
        b.style.color = "#c7bbbb";
        b.disabled = true;
    }

    x.addEventListener("change", function() {
        if (x.checked && s.value && p1.value && p2.value && e.value) {
            b.disabled = false;
            b.style.backgroundColor = "#a9120b";
            b.style.color = "white";
        } else {
            b.style.backgroundColor = "#978b8b";
            b.style.color = "#c7bbbb";
            b.disabled = true;
        }
    });

    function togglePassword(pass) {
        const passwordField = document.getElementById(pass);
        const eyeIcon = document.getElementById('eye' + pass.charAt(pass.length - 1));
        if (passwordField.type === "password") {
            passwordField.type = "text";
            eyeIcon.classList.remove("bi-eye");
            eyeIcon.classList.add("bi-eye-slash");
        } else {
            passwordField.type = "password";
            eyeIcon.classList.remove("bi-eye-slash");
            eyeIcon.classList.add("bi-eye");
        }
    }
</script>
</body>
</html>