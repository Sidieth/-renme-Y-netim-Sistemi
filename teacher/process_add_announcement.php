<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../index.php");
    exit();
}
include('../config.php');

$teacher_id = $_SESSION['user_id'];
$course_id = $_POST['course_id'];
$title = $_POST['title'];
$content = $_POST['content'];

// Duyuruyu veritabanına ekle
$sql = "INSERT INTO announcements (course_id, teacher_id, title, content, created_at) 
        VALUES (?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiss", $course_id, $teacher_id, $title, $content);

if ($stmt->execute()) {
    echo "Announcement added successfully.";
    header("Location: add_announcement.php");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
