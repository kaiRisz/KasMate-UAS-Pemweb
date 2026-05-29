<?php
require_once '../../../config/auth_check.php';
require_once '../../model/user/RiwayatUserModel.php';

cekRole('user');

$riwayatModel = new RiwayatUserModel($conn);
$riwayat_pembayaran = $riwayatModel->getRiwayatLunas($user_login['id_user']);

require_once '../../view/user/riwayat-pembayaran.php';
?>