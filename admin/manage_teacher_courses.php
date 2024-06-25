<?php include('../includes/header.php'); ?>
<?php include('../includes/sidebar.php'); ?>
<?php include('../includes/navbar.php'); ?>

<div class="content">
    <div class="container mt-5">
        <h2>Öğretmen Derslerini</h2>
        <form action="assign_course.php" method="post">
            <div class="form-group">
                <label for="teacher">Öğretmen Seç</label>
                <select class="form-control" id="teacher" name="teacher_id" required>
                    <?php
                    include('../config.php');
                    $sql = "SELECT id, username FROM users WHERE role='teacher'";
                    $result = mysqli_query($conn, $sql);

                    if ($result === false) {
                        die("Error: " . mysqli_error($conn));
                    }

                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row["id"] . "'>" . $row["username"] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No teachers available</option>";
                    }

                    $conn->close();
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="course">Ders Seç</label>
                <select class="form-control" id="course" name="course_id" required>
                    <?php
                    include('../config.php');
                    $sql = "SELECT id, course_name FROM courses";
                    $result = mysqli_query($conn, $sql);

                    if ($result === false) {
                        die("Error: " . mysqli_error($conn));
                    }

                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row["id"] . "'>" . $row["course_name"] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No courses available</option>";
                    }

                    $conn->close();
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">kayıt yap</button>
        </form>

        <h3 class="mt-5">Atanan Dersler</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Öğretmen</th>
                    <th>Dersler</th>
                    <th>Haraket</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('../config.php');
                $sql = "SELECT tc.id, u.username as teacher, c.course_name as course
                        FROM teacher_courses tc
                        JOIN users u ON tc.teacher_id = u.id
                        JOIN courses c ON tc.course_id = c.id";
                $result = mysqli_query($conn, $sql);

                if ($result === false) {
                    die("Error: " . mysqli_error($conn));
                }

                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row["teacher"] . "</td>";
                        echo "<td>" . $row["course"] . "</td>";
                        echo "<td>";
                        echo "<a href='delete_teacher_course.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm'>Sil</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No courses assigned</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('../includes/footer.php'); ?>

