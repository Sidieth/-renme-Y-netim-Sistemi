<?php include('../includes/header.php'); ?>
<?php include('../includes/sidebar.php'); ?>
<?php include('../includes/navbar.php'); ?>

<?php


include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);

    if ($stmt->execute()) {
        echo "User added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>


<div class="content">
    <div class="container mt-5">
        <h2>Yeni Kullancı Ekle</h2>
        <form action="add_user.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Kullancı Adı</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Şifre</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Kullanıcı Türünü Seçin</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="admin">Danışman</option>
                    <option value="teacher">Öğretmen</option>
                    <option value="student">Öğrenci</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">kayıt yap</button>
        </form>
    </div>
</div>


<div class="content">
    <div class="container mt-3">
        <h2>Kullancıları Yönet</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Kullanci Adı</th>
                    <th>Kullanıcı Türünü</th>
                    <th>hareket</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('../config.php');
                $sql = "SELECT id, username, role FROM users";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["username"] . "</td>";
                        echo "<td>" . $row["role"] . "</td>";
                        echo "<td>";
                        echo "<a href='edit_user.php?id=" . $row["id"] . "' class='btn btn-warning btn-sm'>Güncelle</a> ";
                        echo "<a href='delete_user.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm'>Sil</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No users found</td></tr>";
                }

                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>
</div>
    
<?php include('../includes/footer.php'); ?>