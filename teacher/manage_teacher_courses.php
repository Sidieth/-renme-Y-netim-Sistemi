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
$sql = "SELECT tc.course_id, c.course_name, c.course_description 
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

        <h3 class="mt-5">Derslerim</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Ders Adı</th>
                    <th>Ders Açıklanması</th>
                    <th>Hareket</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["course_id"]) . "</td>";
                        echo "<td><a href='manage_course_content.php?course_id=" . urlencode($row["course_id"]) . "'>" . htmlspecialchars($row["course_name"]) . "</a></td>";
                        echo "<td>" . htmlspecialchars($row["course_description"]) . "</td>";
                        echo "<td>";
                        echo "<a href='edit_course.php?id=" . urlencode($row["course_id"]) . "' class='btn btn-warning btn-sm'>Güncelle</a> ";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No courses assigned</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
include('../includes/footer.php'); 
$stmt->close();
$conn->close();
?>










