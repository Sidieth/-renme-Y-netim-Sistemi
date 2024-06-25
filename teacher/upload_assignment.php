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


$teacher_id = $_SESSION['user_id'];
$sql = "SELECT c.id, c.course_name 
        FROM teacher_courses tc 
        JOIN courses c ON tc.course_id = c.id 
        WHERE tc.teacher_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="content">
    <div class="container mt-5">
        <h2>Ödev Yükleme</h2>
        <form action="process_assignment.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="course">Ders Seç</label>
                <select class="form-control" id="course" name="course_id" required>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["id"] . "'>" . $row["course_name"] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No courses available</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="assignment_title">Ödev Adı</label>
                <input type="text" class="form-control" id="assignment_title" name="assignment_title" required>
            </div>
            <div class="form-group">
                <label for="assignment">Ödeve Dosya</label>
                <input type="file" class="form-control" id="assignment" name="assignment" required>
            </div>
            <div class="form-group">
                <label for="description">Ödev Açıklanması</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="start_date">Başlama Tarihi</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>
            <div class="form-group">
                <label for="end_date">Bitiş Tarihi</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required>
            </div>
            <button type="submit" class="btn btn-primary">kaydet</button>
        </form>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
<?php
$stmt->close();
$conn->close();
?>







