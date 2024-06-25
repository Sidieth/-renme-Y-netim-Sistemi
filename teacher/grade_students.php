<?php include('../includes/header.php'); ?>
<?php include('../includes/sidebartch.php'); ?>
<?php include('../includes/navbartch.php'); ?>

<div class="content">
    <div class="container mt-5">
        <h2>Grade Students</h2>
        <form action="assign_grade.php" method="post">
            <div class="form-group">
                <label for="course">Select Course</label>
                <select class="form-control" id="course" name="course_id" required>
                    <?php
                    include('../db_config.php');
                    $teacher_id = $_SESSION['user_id']; 
                    $sql = "SELECT id, course_name FROM courses WHERE teacher_id='$teacher_id'";
                    $result = mysqli_query($conn, $sql);

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
            <div class="form-group">
                <label for="student">Select Student</label>
                <select class="form-control" id="student" name="student_id" required>
                    <?php
                    include('../db_config.php');
                    $sql = "SELECT id, username FROM users WHERE role='student'";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row["id"] . "'>" . $row["username"] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No students available</option>";
                    }

                    $conn->close();
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="grade">Grade</label>
                <input type="text" class="form-control" id="grade" name="grade" required>
            </div>
            <button type="submit" class="btn btn-primary">Assign Grade</button>
        </form>

        <h3 class="mt-5">Assigned Grades</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Course</th>
                    <th>Grade</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('../db_config.php');
                $sql = "SELECT g.id, u.username as student, c.course_name as course, g.grade
                        FROM grades g
                        JOIN users u ON g.student_id = u.id
                        JOIN courses c ON g.course_id = c.id
                        WHERE c.teacher_id='$teacher_id'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row["student"] . "</td>";
                        echo "<td>" . $row["course"] . "</td>";
                        echo "<td>" . $row["grade"] . "</td>";
                        echo "<td>";
                        echo "<a href='edit_grade.php?id=" . $row["id"] . "' class='btn btn-warning btn-sm'>Edit</a> ";
                        echo "<a href='delete_grade.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No grades assigned</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
