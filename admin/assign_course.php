<?php
include('../config.php');

$teacher_id = $_POST['teacher_id'];
$course_id = $_POST['course_id'];

$sql = "INSERT INTO teacher_courses (teacher_id, course_id) VALUES ('$teacher_id', '$course_id')";

if (mysqli_query($conn, $sql)) {
    echo "Course assigned successfully";
    header("Location: manage_teacher_courses.php"); 
} else {
    echo "Error assigning course: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
