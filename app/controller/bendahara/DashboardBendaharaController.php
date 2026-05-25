<?php
require_once '../../../config/auth_check.php';
require_once '../../model/bendahara/DashboardBendaharaModel.php';

cekRole('bendahara');

$dashboardModel = new DashboardBendaharaModel($conn);

$nama_bendahara = $user_login['nama'] ?? 'Bendahara';

$total_grup = $dashboardModel->getTotalGrup();
$total_anggota = $dashboardModel->getTotalAnggota();
$total_masuk = $dashboardModel->getTotalPemasukan();
$total_keluar = $dashboardModel->getTotalPengeluaran();
$saldo = $total_masuk - $total_keluar;

$statusTagihan = $dashboardModel->getStatusTagihan();
$count_lunas = $statusTagihan['lunas'];
$count_belum = $statusTagihan['belum'];

$total_tagihan_semua = $count_lunas + $count_belum;
$persen_lunas = $total_tagihan_semua > 0 ? round(($count_lunas / $total_tagihan_semua) * 100, 1) : 0;
$persen_belum = $total_tagihan_semua > 0 ? round(($count_belum / $total_tagihan_semua) * 100, 1) : 0;

$tabel_grup = $dashboardModel->getGrupTerbaru(5);

require_once '../../view/bendahara/dashboard-bendahara.php';
?>
