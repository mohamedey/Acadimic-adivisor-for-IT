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

$st_id = htmlspecialchars(trim($_POST['in1'])); 
$pass = htmlspecialchars(trim($_POST['in2'])); 


$admin_query = "SELECT * FROM admin_data WHERE admin_id = '$st_id' AND admin_password = '$pass'";
$admin_res = $con->query($admin_query);


$student_query = "SELECT * FROM student WHERE std_id = '$st_id'";
$student_res = $con->query($student_query);

if ($student_res->num_rows == 1) {
    $student_data = $student_res->fetch_assoc();

    if (password_verify($pass, $student_data['password'])) {

        $_SESSION['major'] = $student_data['major']; 
        $_SESSION['std_id'] = $st_id; 
        echo json_encode(['success' => true, 'user_type' => 'student', 'data' => $student_data]);
    } else {
        echo json_encode(['error' => 'رقم الطالب أو كلمة المرور غير صحيحة.']);
    }

} else if ($admin_res->num_rows == 1) {
    $admin_data = $admin_res->fetch_assoc();


    if ($admin_data['admin_password'] == $pass) {

        $_SESSION['admin_name'] = $admin_data['admin_name']; 
        $_SESSION['admin_id'] = $st_id; 
        echo json_encode(['success' => true, 'user_type' => 'admin', 'data' => $admin_data]);
    } else {
        echo json_encode(['error' => 'يوجد خطأ في رقم المشرف أو كلمة المرور']);
    }
} else {
    echo json_encode(['error' => 'رقم الطالب أو المشرف غير صحيح']);
}

$con->close();
?>