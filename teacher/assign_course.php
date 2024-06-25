<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../index.php");
    exit();
}
include('../config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $teacher_id = $_SESSION['user_id'];
    $course_id = $_POST['course_id'];

    $sql = "INSERT INTO teacher_courses (teacher_id, course_id) VALUES ($teacher_id, $course_id)";
    if (mysqli_query($conn, $sql)) {
        header("Location: manage_teacher_courses.php?success=1");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
