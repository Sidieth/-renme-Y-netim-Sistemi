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


if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$assignment_id = $_GET['assignment_id'];


$assignment_query = "
    SELECT a.assignment_title, c.course_name 
    FROM assignments a
    JOIN courses c ON a.course_id = c.id
    WHERE a.id = ?
";
$stmt = $conn->prepare($assignment_query);
if ($stmt === false) {
    die('Assignment Query Prepare Error: ' . $conn->error);
}
$stmt->bind_param("i", $assignment_id);
$stmt->execute();
$assignment_result = $stmt->get_result();

if ($assignment_result->num_rows == 1) {
    $assignment = $assignment_result->fetch_assoc();
} else {
    echo "Assignment not found.<br>";
    exit();
}


$submissions_query = "
    SELECT s.id, u.username AS student_name, s.file_path, s.submitted_at 
    FROM assignment_submissions s
    JOIN users u ON s.student_id = u.id
    WHERE s.assignment_id = ?
";
$stmt = $conn->prepare($submissions_query);
if ($stmt === false) {
    die('Submissions Query Prepare Error: ' . $conn->error);
}
$stmt->bind_param("i", $assignment_id);
$stmt->execute();
$submissions_result = $stmt->get_result();
?>

<div class="content">
    <div class="container mt-5">
        <h2>Submissions for <?php echo htmlspecialchars($assignment['course_name']); ?> - <?php echo htmlspecialchars($assignment['assignment_title']); ?></h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>File</th>
                    <th>Submitted At</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($submissions_result->num_rows > 0) {
                    while ($row = $submissions_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["student_name"]) . "</td>";
                        echo "<td><a href='" . htmlspecialchars($row["file_path"]) . "' download>Download</a></td>";
                        echo "<td>" . htmlspecialchars($row["submitted_at"]) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No submissions found</td></tr>";
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





