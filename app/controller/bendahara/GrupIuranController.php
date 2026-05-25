<?php
require_once '../../../config/auth_check.php';
require_once '../../model/bendahara/BendaharaGrupModel.php';

cekRole('bendahara');

$id_user = $_SESSION['id_user'];
$grupModel = new BendaharaGrupModel($conn);

if (isset($_GET['hapus'])) {
    $grupModel->hapusGrup($_GET['hapus'], $id_user);
    header("Location: GrupIuranController.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_grup'])) {
    $grupModel->editGrup($_POST['id_grup'], $_POST['nama_grup'], $_POST['deskripsi'], $id_user);
    header("Location: GrupIuranController.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah_grup'])) {
    $grupModel->tambahGrup($_POST['nama_grup'], $_POST['deskripsi'], $id_user);
    header("Location: GrupIuranController.php");
    exit();
}

$total_grup = $grupModel->getTotalGrup();
$total_anggota = $grupModel->getTotalAnggotaSeluruhGrup();
$avg_iuran = $grupModel->getAvgIuran();
$max_grup = $grupModel->getMaxAnggotaGrup();

$tabel_grup = $grupModel->getDaftarGrup();

require_once '../../view/bendahara/grup-iuran.php';
?>
