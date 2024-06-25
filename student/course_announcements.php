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


$announcements_query = "
    SELECT a.title, a.content, a.created_at, u.username as teacher_name, c.course_name
    FROM announcements a
    JOIN courses c ON a.course_id = c.id
    JOIN teacher_courses tc ON c.id = tc.course_id
    JOIN users u ON tc.teacher_id = u.id
    WHERE a.course_id IN (
        SELECT course_id 
        FROM student_courses 
        WHERE student_id = ? AND status = 'approved'
    )
    ORDER BY a.created_at DESC
";
$stmt = $conn->prepare($announcements_query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="content">
    <div class="container mt-5">
        <h2>Duyuru Listesi</h2>
        <div class="list-group">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='list-group-item'>";
                    echo "<h5 class='mb-1'>" . $row['title'] . "</h5>";
                    echo "<p class='mb-1'>" . $row['content'] . "</p>";
                    echo "<small>Posted by " . $row['teacher_name'] . " for course " . $row['course_name'] . " on " . $row['created_at'] . "</small>";
                    echo "</div>";
                }
            } else {
                echo "<p>Duyuru bulanmamaktadır</p>";
            }
            ?>
        </div>
    </div>
</div>

<?php
$stmt->close();
$conn->close();
include('../includes/footer.php');
?>

