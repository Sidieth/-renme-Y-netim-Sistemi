<?php
include('../config.php');

$id = $_POST['id'];
$course_name = $_POST['course_name'];
$course_description = $_POST['course_description'];

$sql = "UPDATE courses SET course_name='$course_name', course_description='$course_description' WHERE id=$id";

if (mysqli_query($conn, $sql)) {
    echo "Course updated successfully";
    header("Location: manage_courses.php"); 
} else {
    echo "Error updating course: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
