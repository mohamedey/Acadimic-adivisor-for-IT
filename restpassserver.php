<?php
session_start(); 

$user_name = "root";
$password = "";
$database = "acadmicproject";
$server = "localhost";

$con = new mysqli($server, $user_name, $password, $database);

if ($con->connect_error) {
    die("Connection failed " . $con->connect_error);
}

$st_id = trim($_POST['rest1']);
$email = trim($_POST['rest2']);
$password1 = trim($_POST['rest3']);
$password2 =trim($_POST['rest4']);

if ($password1 !== $password2) {
echo'<script>alert("كلمة المرور غير متطابقة");
        window.location.href = "Restpass.php";;

</script>';

    exit;
}
$pass=$password1;

$hashedPassword = password_hash($password1, PASSWORD_DEFAULT);

$update1 = "UPDATE admin_for_std SET password='$password1' WHERE std_id='$st_id' ";
$resl = $con->query($update1);

$update2 = "UPDATE student SET password='$hashedPassword' WHERE std_id='$st_id' AND email='$email'";
$res = $con->query($update2);

if ($res) {
    if ($con->affected_rows > 0) {
        echo'<script>
        alert("!! تم تغيير كلمة المرور بنجاح");
        window.location.href = "login.php";</script>';
    } else {
        echo'<script>
        alert("!رقم الطالب أو البريد الالكتروني غير صحيح");
        window.location.href = "Restpass.php";</script>';
    }
} else {
    echo json_encode(['error' => 'حدث خطأ أثناء تحديث كلمة المرور: ' . $con->error]);
}

$con->close();
?>