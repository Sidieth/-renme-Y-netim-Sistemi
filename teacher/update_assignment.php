<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../index.php");
    exit();
}

include('../config.php');

$assignment_id = $_POST['id'];
$assignment_title = $_POST['assignment_title'];
$description = $_POST['description'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];


$target_dir = "../uploads/";
$uploadOk = 1;
$file_path = "";

if ($_FILES["assignment"]["name"]) {
    $target_file = $target_dir . basename($_FILES["assignment"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    
    if ($_FILES["assignment"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    
    $allowed_formats = array("pdf", "doc", "docx", "txt");
    if (!in_array($imageFileType, $allowed_formats)) {
        echo "Sorry, only PDF, DOC, DOCX & TXT files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        exit();
    } else {
        if (move_uploaded_file($_FILES["assignment"]["tmp_name"], $target_file)) {
            $file_path = $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit();
        }
    }
}


if ($file_path) {
    $sql = "UPDATE assignments SET assignment_title = ?, file_path = ?, description = ?, start_date = ?, end_date = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $assignment_title, $file_path, $description, $start_date, $end_date, $assignment_id);
} else {
    $sql = "UPDATE assignments SET assignment_title = ?, description = ?, start_date = ?, end_date = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $assignment_title, $description, $start_date, $end_date, $assignment_id);
}

if ($stmt->execute()) {
    echo "Assignment updated successfully.";
    header("Location: list_assignments.php");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
