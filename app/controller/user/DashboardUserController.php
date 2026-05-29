<?php
require_once '../../../config/auth_check.php';
require_once '../../model/user/DashboardUserModel.php';

cekRole('user');

$dashboardUserModel = new DashboardUserModel($conn);
$data_user = $dashboardUserModel->getUserById($user_login['id_user']);

$pesan_sukses = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi']) && $_POST['aksi'] === 'update_profil') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $update = $dashboardUserModel->updateProfil($user_login['id_user'], $nama, $email, $password);
    if ($update) {
        $data_user = $dashboardUserModel->getUserById($user_login['id_user']);
        $pesan_sukses = "Profil berhasil diperbarui!";
    }
}

$total_pemasukan = $dashboardUserModel->getTotalPemasukan();
$total_pengeluaran = $dashboardUserModel->getTotalPengeluaran();
$saldo_kas_saat_ini = $total_pemasukan - $total_pengeluaran;

$riwayat_pembayaran = $dashboardUserModel->getRiwayatPembayaranUser($user_login['id_user']);

require_once '../../view/user/dashboard-user.php';
?>