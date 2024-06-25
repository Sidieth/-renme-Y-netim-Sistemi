<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../index.php");
    exit();
}

include('../config.php');

$assignment_id = $_GET['id'];


$sql = "DELETE FROM assignments WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $assignment_id);

if ($stmt->execute()) {
    echo "Assignment deleted successfully.";
    header("Location: list_assignments.php");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
