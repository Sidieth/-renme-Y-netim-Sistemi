<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: ../index.php");
    exit();
}
include('../config.php');

$student_id = $_SESSION['user_id'];
$assignment_id = $_POST['assignment_id'];


$target_dir = "../uploads/"; 
$target_file = $target_dir . basename($_FILES["assignment_file"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}


if ($_FILES["assignment_file"]["size"] > 5000000) { 
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}


$allowed_formats = array("pdf", "doc", "docx", "txt");
if (!in_array($fileType, $allowed_formats)) {
    echo "Sorry, only PDF, DOC, DOCX & TXT files are allowed.";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    if (move_uploaded_file($_FILES["assignment_file"]["tmp_name"], $target_file)) {
        $file_path = basename($_FILES["assignment_file"]["name"]);

        
        $sql = "INSERT INTO assignment_submissions (assignment_id, student_id, file_path, submitted_at) 
                VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $assignment_id, $student_id, $file_path);

        if ($stmt->execute()) {
            echo "The assignment has been submitted.";
            header("Location: assignments.php");
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$conn->close();
?>
