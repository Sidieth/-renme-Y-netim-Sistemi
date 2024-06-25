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
$course_id = $_GET['course_id']; 

$sql = "SELECT tc.id, c.course_name, c.course_description 
        FROM teacher_courses tc 
        JOIN courses c ON tc.course_id = c.id 
        WHERE tc.teacher_id = $teacher_id AND c.id = $course_id";
$result = mysqli_query($conn, $sql);

// Formu işlemek için eklenen kod
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['course_file']) && isset($_POST['week']) && isset($_POST['description'])) {
        $week = $_POST['week'];
        $description = $_POST['description'];
        $file_name = $_FILES['course_file']['name'];
        $file_tmp = $_FILES['course_file']['tmp_name'];
        $file_path = "../uploads/course_" . $course_id . "_week_" . $week . "_" . $file_name;

        if (move_uploaded_file($file_tmp, $file_path)) {
            $sql = "INSERT INTO course_files (course_id, week, file_path, description) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iiss", $course_id, $week, $file_path, $description);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "Error uploading file.";
        }
    }
}

?>

<div class="content">
    <div class="container mt-5">
        <h2>Haftalık Ders Detayları</h2>
        <form action="manage_course_content.php?course_id=<?php echo $course_id; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="week">Haftalık</label>
                <input type="number" class="form-control" id="week" name="week" required>
            </div>
            <div class="form-group">
                <label for="description">Açıklaması</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="course_file">Dosya</label>
                <input type="file" class="form-control-file" id="course_file" name="course_file" required>
            </div>
            <button type="submit" class="btn btn-primary">kaydet</button>
        </form>

        <h3 class="mt-5">Yüklenmiş dosyalar</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Hafta</th>
                    <th>Açıklaması</th>
                    <th>Dosya</th>
                    <th>Hareket</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT id, week, description, file_path FROM course_files WHERE course_id = $course_id";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row["week"] . "</td>";
                        echo "<td>" . $row["description"] . "</td>";
                        echo "<td><a href='" . $row["file_path"] . "' target='_blank'>View File</a></td>";
                        echo "<td>";
                        echo "<a href='delete_course_file.php?id=" . $row["id"] . "&course_id=" . $course_id . "' class='btn btn-danger btn-sm'>Sil</a> ";
                        echo "<a href='edit_course_file.php?id=" . $row["id"] . "&course_id=" . $course_id . "' class='btn btn-warning btn-sm'>Güncelle</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No files uploaded</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
<?php mysqli_close($conn); ?>



