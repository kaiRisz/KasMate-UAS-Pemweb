<?php
require_once '../../../config/auth_check.php';
require_once '../../model/bendahara/KeuanganModel.php';

cekRole('bendahara');

$id_user = $_SESSION['id_user'];
$keuanganModel = new KeuanganModel($conn);

$nama_bendahara = $_SESSION['user_login']['nama'] ?? 'Bendahara';

if (isset($_GET['hapus_manual'])) {
    $keuanganModel->hapusPemasukanManual($_GET['hapus_manual']);
    header("Location: PemasukanController.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah_pemasukan'])) {
    $keuanganModel->tambahPemasukanManual(
        $_POST['id_grup'],
        $_POST['id_user_pembayar'],
        $_POST['tanggal'],
        $_POST['deskripsi'],
        $_POST['nominal'],
        $_POST['metode']
    );
    header("Location: PemasukanController.php");
    exit();
}

$statistik = $keuanganModel->getStatistikPemasukan();
$total_masuk = $statistik['total_iuran'] + $statistik['total_manual'];
$total_trx = $statistik['jml_iuran'] + $statistik['jml_manual'];
$total_tunai = $statistik['total_iuran'] + $statistik['tunai_manual'];
$total_tf = $statistik['tf_manual'];

$tabel_pemasukan = $keuanganModel->getTabelPemasukan($id_user);
$daftar_grup = $keuanganModel->getDaftarGrup($id_user);
$daftar_anggota = $keuanganModel->getDaftarAnggotaGrup($id_user);

require_once '../../view/bendahara/pemasukan.php';
?>
