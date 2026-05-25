<?php
require_once '../../../config/auth_check.php';
require_once '../../model/bendahara/KeuanganModel.php';

cekRole('bendahara');

$keuanganModel = new KeuanganModel($conn);

$nama_bendahara = $_SESSION['user_login']['nama'] ?? 'Bendahara';

$data_ringkasan = $keuanganModel->getRingkasanKeuangan();

$total_masuk = $data_ringkasan['total_masuk'];
$trx_masuk = $data_ringkasan['trx_masuk'];
$total_keluar = $data_ringkasan['total_keluar'];
$trx_keluar = $data_ringkasan['trx_keluar'];
$saldo_akhir = $data_ringkasan['saldo_akhir'];
$total_transaksi = $data_ringkasan['total_transaksi'];

require_once '../../view/bendahara/laporan-keuangan.php';
?>
