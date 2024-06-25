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
?>

<div class="content">
    <div class="container mt-5">
        <h2>Ana Sayfa</h2>
        <p>Öğrenci kontrol paneline hoşgeldiniz burda kayıtlı dersleriniz .</p>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ders kayıtlı</h5>
                        <p class="card-text">kayıtlı dersleriniz görüntüleyin ve yönetin.</p>
                        <a href="enrolled_courses.php" class="btn btn-primary">kayıt yap</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include('../includes/footer.php'); ?>
