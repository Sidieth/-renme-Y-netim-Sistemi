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


$student_courses_query = "SELECT c.id, c.course_name, c.course_description, u.username as teacher_name
                          FROM student_courses sc
                          JOIN courses c ON sc.course_id = c.id
                          JOIN teacher_courses tc ON c.id = tc.course_id
                          JOIN users u ON tc.teacher_id = u.id
                          WHERE sc.student_id = ? AND sc.status = 'approved'";
$stmt = $conn->prepare($student_courses_query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$student_courses_result = $stmt->get_result();
?>

<div class="content">
    <div class="container mt-5">
        <h2>Onaylanan Derslerim</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Ders Adı</th>
                    <th>Öğretmen</th>
                    <th>Ders Açıklaması</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $student_courses_result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <a href="course_content.php?course_id=<?php echo $row['id']; ?>" class="text-success">
                                <?php echo $row['course_name']; ?>
                            </a>
                        </td>
                        <td><?php echo $row['teacher_name']; ?></td>
                        <td><?php echo $row['course_description']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
<?php
$stmt->close();
$conn->close();
?>



