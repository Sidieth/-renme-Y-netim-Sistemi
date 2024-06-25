<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../index.php");
    exit();
}

include('../config.php');

$teacher_id = $_SESSION['user_id'];
$course_id = $_POST['course_id'];
$assignment_title = $_POST['assignment_title'];
$description = $_POST['description'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];


$target_dir = "../uploads/";
$target_file = $target_dir . basename($_FILES["assignment"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}


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
} else {
    if (move_uploaded_file($_FILES["assignment"]["tmp_name"], $target_file)) {
        $file_path = $target_file;

        
        $sql = "INSERT INTO assignments (course_id, teacher_id, assignment_title, file_path, description, start_date, end_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisssss", $course_id, $teacher_id, $assignment_title, $file_path, $description, $start_date, $end_date);

        if ($stmt->execute()) {
            echo "The assignment has been uploaded.";
            header("Location: list_assignments.php");
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

mysqli_close($conn);
?>
