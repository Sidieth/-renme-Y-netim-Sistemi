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


$assignments_query = "
    SELECT a.id, c.course_name, a.assignment_title, a.description, a.start_date, a.end_date, a.created_at 
    FROM assignments a
    JOIN courses c ON a.course_id = c.id
    JOIN student_courses sc ON c.id = sc.course_id
    WHERE sc.student_id = ? AND sc.status = 'approved'
";
$stmt = $conn->prepare($assignments_query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="content">
    <div class="container mt-5">
        <h2>Ödevler</h2>
        <table class="table">
            <thead>
                <tr>
                    
                    <th>Ders</th>
                    <th>Adı</th>
                    <th>Açıklaması</th>
                    <th>Başlama Tarihi</th>
                    <th>Bitiş tarihi</th>
                    <th>Oluşturuldu</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                       
                        echo "<td>" . $row['course_name'] . "</td>";
                        echo "<td><a href='submit_assignment.php?assignment_id=" . $row['id'] . "'>" . $row['assignment_title'] . "</a></td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['start_date'] . "</td>";
                        echo "<td>" . $row['end_date'] . "</td>";
                        echo "<td>" . $row['created_at'] . "</td>";
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

<?php
$stmt->close();
$conn->close();
include('../includes/footer.php');
?>


