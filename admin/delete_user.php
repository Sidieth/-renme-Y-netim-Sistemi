<?php
include('../config.php');

$id = $_GET['id'];

$sql = "DELETE FROM users WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    echo "User deleted successfully";
    header("Location: add_user.php"); 
} else {
    echo "Error deleting user: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
