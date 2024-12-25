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

$student_id = $_POST['student_id'];
$question_id = $_POST['question_id'];
$answer = $_POST['answer'];
$admin_id = $_POST['admin_id'];


$sql = "INSERT INTO answers (student_id, question_id, answer, admin_id) VALUES ($student_id, $question_id, '$answer', $admin_id)";

if ($con->query($sql) === TRUE) {
    echo "تمت إضافة الإجابة بنجاح.";
} else {
    echo "حدث خطأ: " . $con->error;
}

$con->close();
?>