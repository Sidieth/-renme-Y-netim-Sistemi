<?php
session_start();
include('../config.php');


if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['student_course_id'])) {
    $student_course_id = $_POST['student_course_id'];

    
    $approve_query = "UPDATE student_courses SET status = 'approved' WHERE id = $student_course_id";
    if (mysqli_query($conn, $approve_query)) {
        $message = "Enrollment request approved successfully.";
    } else {
        $error_message = "Error: " . mysqli_error($conn);
    }
}


header("Location: courses_approval.php");
exit();
?>
