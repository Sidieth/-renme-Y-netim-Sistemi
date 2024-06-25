<?php
include('../config.php');

$id = $_POST['id'];
$username = $_POST['username'];
$role = $_POST['role'];

$sql = "UPDATE users SET username='$username', role='$role' WHERE id=$id";

if (mysqli_query($conn, $sql)) {
    echo "User updated successfully";
    header("Location: add_user.php"); 
} else {
    echo "Error updating user: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
