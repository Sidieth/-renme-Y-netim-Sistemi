<?php
session_start();
include('../config.php');
include('../includes/header.php'); 
include('../includes/sidebar.php'); 
include('../includes/navbar.php'); 

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}


$pending_courses_query = "SELECT sc.id, u.username, c.course_name, c.course_description 
                         FROM student_courses sc 
                         JOIN users u ON sc.student_id = u.id 
                         JOIN courses c ON sc.course_id = c.id 
                         WHERE sc.status = 'pending'";
$pending_courses_result = mysqli_query($conn, $pending_courses_query);
?>

<div class = content >
    <div class="container mt-5">
        <h2>Bekleyen Ders kayıt talepleri</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Öğrenci Kullanıcı Adı</th>
                    <th>Ders Adı</th>
                    <th>Ders Açıklamaları</th>
                    <th>Haraket</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($pending_courses_result)): ?>
                    <tr>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['course_name']; ?></td>
                        <td><?php echo $row['course_description']; ?></td>
                        <td>
                            <form action="process_approval.php" method="POST">
                                <input type="hidden" name="student_course_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn btn-success">Onaylama</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        
    </div>
</div>
<?php mysqli_close($conn); ?>
<?php include('../includes/footer.php'); ?>
