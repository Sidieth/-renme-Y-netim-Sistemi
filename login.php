<?php
session_start();
include 'config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("SELECT id, role, password FROM users WHERE username = ? AND role = ?");
    $stmt->bind_param("ss", $username, $role);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $db_role, $hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows == 1 && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['role'] = $db_role;

        if ($db_role == 'admin') {
            header("Location: admin/dashboard.php");
        } elseif ($db_role == 'teacher') {
            header("Location: teacher/teacher_dashboard.php");
        } elseif ($db_role == 'student') {
            header("Location: student/dashboard.php");
        }
        exit();
    } else {
        echo "Invalid username, password, or role";
    }
    $stmt->close();
}
$conn->close();
?>
