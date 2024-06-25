<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: ../index.php");
    exit();
}
include('../includes/header.php');
include('../includes/sidebarstd.php');
include('../includes/navbarstd.php');
include('../config.php');

$student_id = $_SESSION['user_id'];
$assignment_id = $_GET['assignment_id'];


$assignment_query = "
    SELECT a.id, c.course_name, a.assignment_title, a.file_path, a.description, a.start_date, a.end_date
    FROM assignments a
    JOIN courses c ON a.course_id = c.id
    WHERE a.id = ?
";
$stmt = $conn->prepare($assignment_query);
$stmt->bind_param("i", $assignment_id);
$stmt->execute();
$assignment_result = $stmt->get_result();

if ($assignment_result->num_rows == 1) {
    $assignment = $assignment_result->fetch_assoc();
} else {
    echo "Ödev Bulanmadı.";
    exit();
}

?>

<div class="content">
    <div class="container mt-5">
        <h2>Ödev Detayları <?php echo $assignment['course_name']; ?></h2>
        <p><strong>Adı:</strong><?php echo $assignment['assignment_title']; ?></p>
        <p><strong>Açıklaması:</strong><?php echo $assignment['description']; ?></p>
        <p><strong>Başlama Tarihi:</strong> <?php echo $assignment['start_date']; ?></p>
        <p><strong>Bitiş Tarihi:</strong> <?php echo $assignment['end_date']; ?></p>
        <p><strong>Yüklenen Dosya:</strong> <a href="<?php echo $assignment['file_path']; ?>" target="_blank">Download</a></p>
        
        <form action="process_submit_assignment.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="assignment_id" value="<?php echo $assignment_id; ?>">
            <div class="form-group">
                <label for="assignment_file">Ödeviniz Yükleme</label>
                <input type="file" class="form-control" id="assignment_file" name="assignment_file" required>
            </div>
            <button type="submit" class="btn btn-primary">kaydet</button>
        </form>
    </div>
</div>

<?php
$stmt->close();
$conn->close();
include('../includes/footer.php');
?>



