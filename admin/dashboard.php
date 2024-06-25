<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}
?>

<?php include('../includes/header.php'); ?>
<?php include('../includes/sidebar.php'); ?>
<?php include('../includes/navbar.php'); ?>


<div class="content">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Toplam Kullancı</h5>
                        <p class="card-text">Tüm kullancıları Yönet</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Toplam Dersler</h5>
                        <p class="card-text">Tüm Dersler Yönet</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Sistem ayarları</h5>
                        <p class="card-text">sistem ayarlarını Yönet</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                Son Aktif
            </div>
            <div class="card-body">
                <h5 class="card-title">hayır Actif</h5>
                <p class="card-text">Tüm son etkinlikler burda görüntülenecek.</p>
            </div>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
