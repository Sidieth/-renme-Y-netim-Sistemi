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

$assignment_id = $_GET['id'];


$sql = "SELECT * FROM assignments WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $assignment_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $assignment = $result->fetch_assoc();
} else {
    echo "Assignment not found.";
    exit();
}
?>

<div class="content">
    <div class="container mt-5">
        <h2>Ödev Güncelle</h2>
        <form action="update_assignment.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $assignment['id']; ?>">
            <div class="form-group">
                <label for="assignment_title">Ödev Adı</label>
                <input type="text" class="form-control" id="assignment_title" name="assignment_title" value="<?php echo $assignment['assignment_title']; ?>" required>
            </div>
            <div class="form-group">
                <label for="assignment">Dosya</label>
                <input type="file" class="form-control" id="assignment" name="assignment">
                <p>geçerli dosya: <a href="<?php echo $assignment['file_path']; ?>">indir</a></p>
            </div>
            <div class="form-group">
                <label for="description">Açıklanması</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $assignment['description']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="start_date">Başlama Tarihi</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo $assignment['start_date']; ?>" required>
            </div>
            <div class="form-group">
                <label for="end_date">Bitiş Tarihi</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo $assignment['end_date']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Güncelle</button>
        </form>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
<?php
$stmt->close();
$conn->close();
?>
