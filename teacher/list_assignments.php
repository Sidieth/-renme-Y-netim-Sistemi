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


$sql = "SELECT a.id, a.assignment_title, a.file_path, a.description, a.start_date, a.end_date, c.course_name 
        FROM assignments a
        JOIN courses c ON a.course_id = c.id
        WHERE a.teacher_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="content">
    <div class="container mt-5">
        <h2>Ödev Listeleme</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Ödev Adı</th>
                    <th>Açıklanmasi</th>
                    <th>Başlama Tarihi</th>
                    <th>Bitiş Tarihi</th>
                    <th>Dosya</th>
                    <th>Ders</th>
                    <th>Hareket</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td><a href='view_submissions.php?assignment_id=" . $row["id"] . "'>" . htmlspecialchars($row["assignment_title"]) . "</a></td>";
                        echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["start_date"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["end_date"]) . "</td>";
                        echo "<td><a href='" . htmlspecialchars($row["file_path"]) . "' download>Download</a></td>";
                        echo "<td>" . htmlspecialchars($row["course_name"]) . "</td>";
                        echo "<td>
                        <a href='edit_assignment.php?id=" . $row['id'] . "' class='btn btn-warning'>Güncelle</a>
                        <a href='delete_assignment.php?id=" . $row['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this assignment?\")'>Sil</a>
                      </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No assignments found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
<?php
$stmt->close();
$conn->close();
?>






















