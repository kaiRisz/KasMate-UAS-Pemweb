<?php
require_once '../../../config/auth_check.php';
require_once '../../model/admin/DashboardModel.php';

cekRole('admin');


$q_user = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
$total_user = mysqli_fetch_assoc($q_user)['total'] ?? 0;

$q_admin = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role = 'admin'");
$total_admin = mysqli_fetch_assoc($q_admin)['total'] ?? 0;

$q_bendahara = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role = 'bendahara'");
$total_bendahara = mysqli_fetch_assoc($q_bendahara)['total'] ?? 0;

$q_biasa = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role = 'user'");
$total_biasa = mysqli_fetch_assoc($q_biasa)['total'] ?? 0;


$dashboardModel = new DashboardModel($conn);
$q_aktivitas = $dashboardModel->getAktivitasTerbaru(); 

require_once '../../view/admin/dashboard-admin.php';
?>