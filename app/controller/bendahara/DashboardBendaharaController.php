<?php
require_once '../../../config/auth_check.php';
require_once '../../model/bendahara/DashboardBendaharaModel.php';

cekRole('bendahara');

$dashboardModel = new DashboardBendaharaModel($conn);
$nama_bendahara = $_SESSION['user_login']['nama'] ?? 'Bendahara';

$total_grup = $dashboardModel->getTotalGrup();
$total_anggota = $dashboardModel->getTotalAnggota();
$total_masuk = $dashboardModel->getTotalPemasukan();
$total_keluar = $dashboardModel->getTotalPengeluaran();

$status_tagihan = $dashboardModel->getStatusTagihan();
$count_lunas = $status_tagihan['lunas'];
$count_belum = $status_tagihan['belum'];

$total_tagihan = $count_lunas + $count_belum;
$persen_lunas = ($total_tagihan > 0) ? round(($count_lunas / $total_tagihan) * 100, 1) : 0;
$persen_belum = ($total_tagihan > 0) ? round(($count_belum / $total_tagihan) * 100, 1) : 0;

$saldo = $total_masuk - $total_keluar;

$tabel_grup = $dashboardModel->getGrupTerbaru(5);

require_once '../../view/bendahara/dashboard-bendahara.php';
?>