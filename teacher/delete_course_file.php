<?php
include('../config.php');

if (isset($_GET['id']) && isset($_GET['course_id'])) {
    $file_id = $_GET['id'];
    $course_id = $_GET['course_id'];

    
    echo "File ID: " . htmlspecialchars($file_id) . "<br>";
    echo "Course ID: " . htmlspecialchars($course_id) . "<br>";

    
    $sql = "SELECT file_path FROM course_files WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }
    $stmt->bind_param("i", $file_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $file = $result->fetch_assoc();
    $stmt->close();

    
    if ($file) {
        if (unlink($file['file_path'])) {
            $sql = "DELETE FROM course_files WHERE id = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die("Error preparing the statement: " . $conn->error);
            }
            $stmt->bind_param("i", $file_id);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                
                header("Location: manage_course_content.php?course_id=" . urlencode($course_id));
                exit;
            } else {
                echo "Error deleting record from database.";
            }
            $stmt->close();
        } else {
            echo "Error deleting file from the filesystem.";
        }
    } else {
        echo "File not found.";
    }
    $conn->close();
} else {
    echo "Invalid file ID or course ID.";
}
?>


