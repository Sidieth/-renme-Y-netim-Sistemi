<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../index.php");
    exit();
}
include('../includes/header.php');
include('../includes/sidebartch.php');
include('../includes/navbartch.php');
include('../config.php');

$file_id = $_GET['id'];
$course_id = $_GET['course_id'];


$sql = "SELECT week, description, file_path FROM course_files WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $file_id);
$stmt->execute();
$result = $stmt->get_result();
$file = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $week = $_POST['week'];
    $description = $_POST['description'];
    $file_path = $file['file_path'];

    
    if (isset($_FILES['course_file']) && $_FILES['course_file']['size'] > 0) {
        $file_name = $_FILES['course_file']['name'];
        $file_tmp = $_FILES['course_file']['tmp_name'];
        $file_path = "../uploads/course_" . $course_id . "_week_" . $week . "_" . $file_name;

        if (move_uploaded_file($file_tmp, $file_path)) {
            unlink($file['file_path']); 
        } else {
            echo "Error uploading file.";
        }
    }

    
    $sql = "UPDATE course_files SET week = ?, description = ?, file_path = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issi", $week, $description, $file_path, $file_id);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_course_content.php?course_id=" . urlencode($course_id));
    exit();
}

?>

<div class="content">
    <div class="container mt-5">
        <h2>Ders Dosayasını Güncelle</h2>
        <form action="edit_course_file.php?id=<?php echo $file_id; ?>&course_id=<?php echo $course_id; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="week">Haftalık</label>
                <input type="number" class="form-control" id="week" name="week" value="<?php echo $file['week']; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Açıklanması</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $file['description']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="course_file">Ders Dosya (Seçmeli)</label>
                <input type="file" class="form-control-file" id="course_file" name="course_file">
            </div>
            <button type="submit" class="btn btn-primary">Güncelle</button>
        </form>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
<?php mysqli_close($conn); ?>
