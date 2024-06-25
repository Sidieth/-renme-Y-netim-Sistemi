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


if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    
    $sql = "DELETE FROM announcements WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        
        header("Location: add_announcement.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}


$courses_query = "
    SELECT c.id, c.course_name 
    FROM teacher_courses tc 
    JOIN courses c ON tc.course_id = c.id 
    WHERE tc.teacher_id = ?
";
$stmt = $conn->prepare($courses_query);
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="content">
    <div class="container mt-5">
        <h2>Yeni Duyuru Ekle</h2>
        <form action="process_add_announcement.php" method="post">
            <div class="form-group">
                <label for="course">Ders Seç</label>
                <select class="form-control" id="course" name="course_id" required>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['course_name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="title">Adı</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="content">içerik</label>
                <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Duyuru Ekle</button>
        </form>
    </div>
</div>

<div class="content">
    <div class="container mt-3">
        <h2>Duyuru Listesi</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Ders</th>
                    <th>Adı</th>
                    <th>içerik</th>
                    <th>Oluşturuldu</th>
                    <th>Hareket</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                $sql = "SELECT a.id, c.course_name, a.title, a.content, a.created_at 
                        FROM announcements a 
                        JOIN courses c ON a.course_id = c.id 
                        WHERE a.teacher_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $teacher_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['course_name'] . "</td>";
                        echo "<td>" . $row['title'] . "</td>";
                        echo "<td>" . $row['content'] . "</td>";
                        echo "<td>" . $row['created_at'] . "</td>";
                        echo "<td>
                                <a href='add_announcement.php?delete_id=" . $row['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this announcement?\")'>Sil</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Duyuru bulunmamaktadır</td></tr>";
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