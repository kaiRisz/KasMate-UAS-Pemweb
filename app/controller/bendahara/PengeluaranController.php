<?php
require_once '../../../config/auth_check.php';
require_once '../../model/bendahara/KeuanganModel.php';

cekRole('bendahara');

$id_user = $_SESSION['id_user'];
$keuanganModel = new KeuanganModel($conn);

$nama_bendahara = $_SESSION['user_login']['nama'] ?? 'Bendahara';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah_pengeluaran'])) {
    if(!empty($_POST['id_grup']) && !empty($_POST['tanggal']) && !empty($_POST['keterangan']) && !empty($_POST['jumlah'])) {
        $keuanganModel->tambahPengeluaran(
            $_POST['id_grup'],
            $_POST['tanggal'],
            $_POST['keterangan'],
            $_POST['jumlah']
        );
        header("Location: PengeluaranController.php");
        exit();
    }
}

$statistik = $keuanganModel->getStatistikPengeluaran();
$total_keluar = $statistik['total'] ?? 0;
$total_trx = $statistik['jml'] ?? 0;
$pengeluaran_terbesar = $statistik['terbesar'] ?? 0;
$rata_rata = $statistik['rata'] ?? 0;

$tabel_pengeluaran = $keuanganModel->getTabelPengeluaran();
$daftar_grup = $keuanganModel->getDaftarGrup();

require_once '../../view/bendahara/pengeluaran.php';
?>
