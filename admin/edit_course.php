<?php
include('../config.php');

$id = $_GET['id'];

$sql = "SELECT * FROM courses WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    echo "Course not found.";
    exit();
}
?>

<?php include('../includes/header.php'); ?>
<?php include('../includes/sidebar.php'); ?>
<?php include('../includes/navbar.php'); ?>

<div class="content">
    <div class="container mt-5">
        <h2>Ders Güncelle</h2>
        <form action="update_course.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="form-group">
                <label for="course_name">Ders Adı</label>
                <input type="text" class="form-control" id="course_name" name="course_name" value="<?php echo $row['course_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="course_description">Açıklanması</label>
                <textarea class="form-control" id="course_description" name="course_description" rows="3" required><?php echo $row['course_description']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Güncelle</button>
        </form>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
