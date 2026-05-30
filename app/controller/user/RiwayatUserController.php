<?php
require_once '../../../config/auth_check.php';

cekRole('user');
$id_user = $_SESSION['id_user'];
$nama_user = $user_login['nama'] ?? 'User';

$query_riwayat = mysqli_query($conn, "SELECT p.tanggal_bayar, g.nama_grup, i.nama_iuran, i.nominal, p.status FROM pembayaran p JOIN iuran i ON p.id_iuran = i.id_iuran JOIN grup g ON i.id_grup = g.id_grup WHERE p.id_user = $id_user AND p.status = 'Lunas' ORDER BY p.tanggal_bayar DESC");
$riwayat_list = [];
while ($row = mysqli_fetch_assoc($query_riwayat)) {
    $riwayat_list[] = $row;
}

require_once '../../view/user/riwayat-pembayaran.php';
?>