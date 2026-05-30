<?php
require_once '../../../config/auth_check.php';
require_once '../../model/user/TagihanUserModel.php';

cekRole('user');

$id_user = $_SESSION['id_user'];
$nama_user = $user_login['nama'] ?? 'User';

$tagihanModel = new TagihanUserModel($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi']) && $_POST['aksi'] === 'bayar') {
    $tagihanModel->bayarIuran($_POST['id_pembayaran']);
    header("Location: TagihanUserController.php");
    exit();
}

$query_all_tagihan = mysqli_query($conn, "SELECT g.nama_grup, i.nama_iuran, i.nominal, COALESCE(p.status, 'Belum Lunas') AS status_bayar FROM iuran i JOIN grup g ON i.id_grup = g.id_grup JOIN grup_anggota ga ON g.id_grup = ga.id_grup LEFT JOIN pembayaran p ON i.id_iuran = p.id_iuran AND p.id_user = ga.id_user WHERE ga.id_user = $id_user");
$tagihan_list = [];
while ($row = mysqli_fetch_assoc($query_all_tagihan)) {
    $tagihan_list[] = $row;
}

require_once '../../view/user/tagihan-saya.php';
?>