<?php
include('../config.php');

$id = $_GET['id'];

$sql = "DELETE FROM courses WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    echo "Course deleted successfully";
    header("Location: manage_courses.php"); 
} else {
    echo "Error deleting course: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
