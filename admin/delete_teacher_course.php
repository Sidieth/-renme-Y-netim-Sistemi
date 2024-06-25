<?php
include('../config.php');

$id = $_GET['id'];

$sql = "DELETE FROM teacher_courses WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    echo "Course unassigned successfully";
    header("Location: manage_teacher_courses.php"); 
} else {
    echo "Error unassigning course: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
