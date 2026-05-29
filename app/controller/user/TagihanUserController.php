<?php
require_once '../../../config/auth_check.php';
require_once '../../model/user/TagihanUserModel.php';

cekRole('user');

$tagihanModel = new TagihanUserModel($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi']) && $_POST['aksi'] === 'bayar') {
    $tagihanModel->bayarIuran($_POST['id_pembayaran']);
    header("Location: TagihanUserController.php");
    exit();
}

$tagihan_user = $tagihanModel->getTagihanBelumLunas($user_login['id_user']);

require_once '../../view/user/tagihan-saya.php';
?>