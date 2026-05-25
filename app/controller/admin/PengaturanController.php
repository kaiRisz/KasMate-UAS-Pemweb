<?php
require_once '../../../config/auth_check.php';
require_once '../../model/admin/PengaturanModel.php';

cekRole('admin');

$pengaturanModel = new PengaturanModel($conn);
$sukses = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi'])) {
    
    if ($_POST['aksi'] === 'update_profil') {
        $result = $pengaturanModel->updateProfil($user_login['id_user'], $_POST['nama'], $_POST['email']);
        if ($result['sukses']) {
            
            $result_user_login = mysqli_query($conn, "SELECT * FROM users WHERE id_user = {$user_login['id_user']}");
            $user_login = mysqli_fetch_assoc($result_user_login);
            $_SESSION['user_login'] = $user_login;
            $sukses = true;
        } else {
            $error = $result['error'];
        }
    }
    
    if ($_POST['aksi'] === 'update_password') {
        $result = $pengaturanModel->updatePassword(
            $user_login['id_user'], 
            $_POST['password_lama'], 
            $_POST['password_baru'], 
            $_POST['konfirmasi_password'], 
            $user_login['password']
        );
        
        if ($result['sukses']) {
            
            $result_user_login = mysqli_query($conn, "SELECT * FROM users WHERE id_user = {$user_login['id_user']}");
            $user_login = mysqli_fetch_assoc($result_user_login);
            $_SESSION['user_login'] = $user_login;
            $sukses = true;
        } else {
            $error = $result['error'];
        }
    }
}

$statistik = $pengaturanModel->getStatistikSistem();
$total_user = $statistik['total_user'];
$total_grup = $statistik['total_grup'];
$total_trx = $statistik['total_trx'];

require_once '../../view/admin/pengaturan.php';
?>
