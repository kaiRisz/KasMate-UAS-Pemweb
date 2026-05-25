<?php
require_once '../../../config/auth_check.php';
require_once '../../model/admin/DashboardModel.php';

cekRole('admin');

$dashboardModel = new DashboardModel($conn);

$total_user = $dashboardModel->getTotalUser();
$total_grup = $dashboardModel->getTotalGrup();
$total_pemasukan = $dashboardModel->getTotalPemasukan();
$total_pengeluaran = $dashboardModel->getTotalPengeluaran();
$total_saldo = $dashboardModel->getTotalSaldo();
$total_trx = $dashboardModel->getTotalTransaksi();
$q_aktivitas = $dashboardModel->getAktivitasTerbaru(); 

require_once '../../view/admin/dashboard-admin.php';
?>
