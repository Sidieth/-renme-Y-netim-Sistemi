<?php include('../includes/header.php'); ?>
<?php include('../includes/sidebar.php'); ?>
<?php include('../includes/navbar.php'); ?>

<?php include('../config.php'); ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_name = $_POST["course_name"];
    $course_description = $_POST["course_description"];

  
    $sql = "INSERT INTO courses (course_name, course_description) VALUES ('$course_name', '$course_description')";
    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success'>Course added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . mysqli_error($conn) . "</div>";
    }
}
?>

<div class="content">
    <div class="container mt-5">
        <h2>Yeni Ders Ekle</h2>
        <form action="manage_courses.php" method="post">
            <div class="form-group">
                <label for="course_name">Ders Adı</label>
                <input type="text" class="form-control" id="course_name" name="course_name" required>
            </div>
            <div class="form-group">
                <label for="course_description">Ders Açıklamalrı</label>
                <textarea class="form-control" id="course_description" name="course_description" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">kayıt yap</button>
        </form>

        <h3 class="mt-5">Ders Liste</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Ders Adı</th>
                    <th>Ders Açıklamalrı</th>
                    <th>Hareket</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('../config.php');
                $sql = "SELECT id, course_name, course_description FROM courses";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["course_name"] . "</td>";
                        echo "<td>" . $row["course_description"] . "</td>";
                        echo "<td>";
                        echo "<a href='edit_course.php?id=" . $row["id"] . "' class='btn btn-warning btn-sm'>Güncelle</a>";
                        echo "<a href='delete_course.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm'>Sil</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Ders Bulanamadı</td></tr>";
                }

                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
