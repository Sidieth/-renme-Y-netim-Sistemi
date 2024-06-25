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

if (!isset($_GET['course_id'])) {
    echo "Course ID not provided.";
    exit();
}

$course_id = $_GET['course_id'];
$student_id = $_SESSION['user_id'];


$sql = "SELECT c.course_name, cf.id AS file_id, cf.week, cf.file_path, cf.description 
        FROM courses c
        JOIN course_files cf ON c.id = cf.course_id
        JOIN student_courses sc ON sc.course_id = c.id
        WHERE sc.student_id = ? AND sc.course_id = ? AND sc.status = 'approved'
        ORDER BY cf.week";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $student_id, $course_id);
$stmt->execute();
$result = $stmt->get_result();

$course_contents = [];

while ($row = $result->fetch_assoc()) {
    $course_name = $row['course_name'];
    $course_contents[] = [
        'file_id' => $row['file_id'],
        'week' => $row['week'],
        'file_path' => $row['file_path'],
        'description' => $row['description']
    ];
}
?>

<div class="content">
    <div class="container mt-5">
        <?php
        if (!empty($course_contents)) {
            echo "<h2>" . $course_name . "</h2>";
            echo "<table class='table'>";
            echo "<thead>";
            echo "<tr>";
            
            echo "<th>Week</th>";
            echo "<th>File</th>";
            echo "<th>Description</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($course_contents as $content) {
                echo "<tr>";
                
                echo "<td>" . $content['week'] . "</td>";
                echo "<td><a href='" . $content['file_path'] . "'>Download</a></td>";
                echo "<td>" . $content['description'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>No content found for this course.</p>";
        }
        ?>
    </div>
</div>

<?php
$stmt->close();
$conn->close();
include('../includes/footer.php');
?>


