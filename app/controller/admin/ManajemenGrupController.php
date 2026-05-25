<?php
require_once '../../../config/auth_check.php';
require_once '../../model/admin/GrupModel.php';

cekRole('admin');

$grupModel = new GrupModel($conn);

if (isset($_GET['hapus'])) {
    $grupModel->hapusGrup($_GET['hapus']);
    header("Location: ManajemenGrupController.php");
    exit();
}

$search = isset($_GET['search']) ? $_GET['search'] : '';

$per_page = 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $per_page;

$total_data = $grupModel->getTotalGrup($search);
$total_pages = max(1, ceil($total_data / $per_page));

$q_groups = $grupModel->getGrup($search, $per_page, $offset);

require_once '../../view/admin/manajemen-grup.php';
?>
