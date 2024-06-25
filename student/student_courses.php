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


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['course_id'])) {
    $student_id = $_SESSION['user_id'];
    $course_id = $_POST['course_id'];

    
    $check_query = "SELECT * FROM student_courses WHERE student_id = $student_id AND course_id = $course_id";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $message = "You are already enrolled in this course.";
    } else {
        
        $enroll_query = "INSERT INTO student_courses (student_id, course_id, status) VALUES ($student_id, $course_id, 'pending')";
        if (mysqli_query($conn, $enroll_query)) {
            $message = "Enrollment request sent. Waiting for admin approval.";
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }
    }
}


$student_id = $_SESSION['user_id'];
$enrolled_courses_query = "SELECT course_id, status FROM student_courses WHERE student_id = $student_id";
$enrolled_courses_result = mysqli_query($conn, $enrolled_courses_query);
$enrolled_courses = [];
$course_status = [];


while ($row = mysqli_fetch_assoc($enrolled_courses_result)) {
    $enrolled_courses[] = $row['course_id'];
    $course_status[$row['course_id']] = $row['status'];
}


$courses_query = "SELECT * FROM courses";
$courses_result = mysqli_query($conn, $courses_query);
?>

<div class="content">
    <div class="container mt-5">
        <h2>Mevcut Dersler</h2>
        <?php if (isset($message)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Ders Adı</th>
                    <th>Ders Açıklaması</th>
                    <th>Hareket</th>
                    <th>Durum</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($courses_result)): ?>
                    <?php if (!in_array($row['id'], $enrolled_courses)): ?>
                        <tr>
                            <td><?php echo $row['course_name']; ?></td>
                            <td><?php echo $row['course_description']; ?></td>
                            <td>
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                    <input type="hidden" name="course_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-primary">kayıt</button>
                                </form>
                            </td>
                            <td>kayıdedilmemiş</td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td><?php echo $row['course_name']; ?></td>
                            <td><?php echo $row['course_description']; ?></td>
                            <td>Zaten Kayıtlı</td>
                            <td class="<?php 
                                switch ($course_status[$row['id']]) {
                                    case 'pending':
                                        echo 'text-warning';
                                        break;
                                    case 'approved':
                                        echo 'text-success';
                                        break;
                                    case 'rejected':
                                        echo 'text-danger';
                                        break;
                                }
                                ?>">
                                <?php 
                                switch ($course_status[$row['id']]) {
                                    case 'pending':
                                        echo 'Pending';
                                        break;
                                    case 'approved':
                                        echo 'Approved';
                                        break;
                                    case 'rejected':
                                        echo 'Rejected';
                                        break;
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endwhile; ?>
            </tbody>
        </table>
        
    </div>
</div>

<?php include('../includes/footer.php'); ?>
<?php mysqli_close($conn); ?>



