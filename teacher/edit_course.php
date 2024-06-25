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

if (!isset($_GET['id'])) {
    header("Location: manage_teacher_courses.php");
    exit();
}

$course_id = $_GET['id'];


$sql = "SELECT * FROM courses WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<div class='alert alert-danger'>Ders bulunamadı.</div>";
    exit();
}

$course = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_name = $_POST['course_name'];
    $course_description = $_POST['course_description'];

    
    $sql = "UPDATE courses SET course_name = ?, course_description = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $course_name, $course_description, $course_id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Ders başarıyla güncellendi.</div>";
        header("Location: manage_teacher_courses.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Ders güncellenirken bir hata oluştu. Lütfen tekrar deneyin.</div>";
    }
}
?>

<div class="content">
    <div class="container mt-5">
        <h3>Ders Güncelle</h3>
        <form method="post" action="">
            <div class="form-group">
                <label for="course_name">Ders Adı</label>
                <input type="text" class="form-control" id="course_name" name="course_name" value="<?php echo htmlspecialchars($course['course_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="course_description">Açıklanması</label>
                <textarea class="form-control" id="course_description" name="course_description" rows="3" required><?php echo htmlspecialchars($course['course_description']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Güncelle</button>
        </form>
    </div>
</div>

<?php 
include('../includes/footer.php'); 
$stmt->close();
$conn->close();
?>
