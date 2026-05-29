<?php
require_once '../../../config/auth_check.php';
require_once '../../model/admin/UserModel.php';

cekRole('admin');

$userModel = new UserModel($conn);

if (isset($_GET['hapus'])) {
    $hasil = $userModel->hapusUser($_GET['hapus'], $user_login['id_user']);
    
    if ($hasil['status'] === true) {
        $_SESSION['notif_sukses'] = $hasil['pesan'];
    } else {
        $_SESSION['notif_error'] = $hasil['pesan'];
    }
    
    header("Location: ManajemenUserController.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi'])) {
    if ($_POST['aksi'] === 'tambah') {
        $userModel->tambahUser($_POST['nama'], $_POST['email'], $_POST['password'], $_POST['role']);
    } elseif ($_POST['aksi'] === 'edit') {
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $userModel->editUser($_POST['id_user'], $_POST['nama'], $_POST['email'], $_POST['role'], $password);
    }
    header("Location: ManajemenUserController.php");
    exit();
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter_role = isset($_GET['role']) ? $_GET['role'] : '';

$per_page = 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $per_page;

$total_data = $userModel->getTotalUsers($search, $filter_role);
$total_pages = max(1, ceil($total_data / $per_page));

$users = $userModel->getUsers($search, $filter_role, $per_page, $offset);

require_once '../../view/admin/manajemen-user.php';
?>