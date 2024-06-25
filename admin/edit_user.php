<?php
include('../config.php');

$id = $_GET['id'];

$sql = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    echo "User not found.";
    exit();
}
?>

<?php include('../includes/header.php'); ?>
<?php include('../includes/sidebar.php'); ?>
<?php include('../includes/navbar.php'); ?>

<div class="content">
    <div class="container mt-5">
        <h2>Kullancı Güncelle</h2>
        <form action="update_user.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="form-group">
                <label for="username">Kullancı Adı</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $row['username']; ?>" required>
            </div>
            <div class="form-group">
                <label for="role">Kullanıcı Türünü Seç</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="admin" <?php if($row['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                    <option value="teacher" <?php if($row['role'] == 'teacher') echo 'selected'; ?>>Teacher</option>
                    <option value="student" <?php if($row['role'] == 'student') echo 'selected'; ?>>Student</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Güncelle</button>
        </form>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
