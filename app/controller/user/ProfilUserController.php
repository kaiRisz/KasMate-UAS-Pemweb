<?php

require_once __DIR__ . '/../../../config/auth_check.php';

require_once __DIR__ . '/../../model/user/ProfilUserModel.php';

cekRole('user');

$profilModel = new ProfilUserModel($conn);
$pesan_sukses = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi']) && $_POST['aksi'] === 'update') {
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $update = $profilModel->updateProfil($user_login['id_user'], $_POST['nama'], $_POST['email'], $password);
    if ($update) {
        $pesan_sukses = "Profil berhasil diubah!";
        $query_user_login = "SELECT * FROM users WHERE id_user = " . $user_login['id_user'];
        $result_user_login = mysqli_query($conn, $query_user_login);
        $user_login = mysqli_fetch_assoc($result_user_login);
    }
}

require_once __DIR__ . '/../../view/user/profil.php';
?>