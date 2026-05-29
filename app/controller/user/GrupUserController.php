<?php
require_once '../../../config/auth_check.php';
require_once '../../model/user/GrupUserModel.php';

cekRole('user');

$grupModel = new GrupUserModel($conn);
$grup = $grupModel->getGrupUser($user_login['id_user']);

$anggota_grup = [];
if ($grup) {
    $anggota_grup = $grupModel->getAnggotaGrup($grup['id_grup']);
}

require_once '../../view/user/grup-saya.php';
?>