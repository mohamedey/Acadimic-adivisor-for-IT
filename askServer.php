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

$user_id = $_SESSION["std_id"];

$user = trim($_POST['ask2']);
$user_email = trim($_POST['ask3']);
$question = trim($_POST['ask4']);

if (empty($user) || empty($user_email) || empty($question)) {
    echo "<script>
    alert('الرجاء ادخال جميع البيانات المطلوبة');
    window.location.href = 'ask page.php';
    </script>";
    exit;
}

$sql = "SELECT * FROM student WHERE std_id = '$user' AND email = '$user_email'";
$result = $con->query($sql);

if ($result->num_rows == 1) {
    
    $student = $result->fetch_assoc();
    $std_name = $student['std_name'];

    $insert = "INSERT INTO question (std_id, std_name, std_email, msg) VALUES ('$user', '$std_name', '$user_email', '$question')";
    
    if ($con->query($insert) === TRUE) {
        echo "<script>
        alert('Message Sent Successfully ✓');
        window.location.href = 'ask page.php';
        </script>";
    } else {
        echo "<script>
        alert('Error: Could not send message. Please try again.');
        window.location.href = 'ask page.php';
        </script>";
    }
} else {
    echo "<script>
    alert('رقم الطالب أو البريد الالكتروني غير صحيح, الرجاء ادخال البيانات المطلوبة بشكل صحيح لكي يتم ارسال الرسالة'); 
    window.location.href = 'ask page.php';
    </script>";
}

$con->close();
?>