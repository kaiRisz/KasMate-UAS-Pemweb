<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/database.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0"); 

if (!isset($_SESSION['id_user'])) {
    header("Location: /KasMate-UAS-Pemweb/app/view/auth/login.php");
    exit();
}

$durasi_maksimal = 86400; 

if (isset($_SESSION['terakhir_aktif'])) {
    $selisih_waktu = time() - $_SESSION['terakhir_aktif'];
    if ($selisih_waktu > $durasi_maksimal) {
        session_unset();
        session_destroy();
        header("Location: /KasMate-UAS-Pemweb/app/view/auth/login.php?pesan=sesi_habis");
        exit();
    }
}
$_SESSION['terakhir_aktif'] = time();

function cekRole($role_dibutuhkan) {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role_dibutuhkan) {
        switch ($_SESSION['role']) {
            case 'admin':
                header("Location: /KasMate-UAS-Pemweb/app/controller/admin/DashboardAdminController.php");
                break;
            case 'bendahara':
                header("Location: /KasMate-UAS-Pemweb/app/controller/bendahara/DashboardBendaharaController.php");
                break;
            default:
                header("Location: /KasMate-UAS-Pemweb/app/controller/user/DashboardUserController.php");
                break;
        }
        exit();
    }
}

$id_user_login = $_SESSION['id_user'];
$query_user_login = "SELECT * FROM users WHERE id_user = $id_user_login";
$result_user_login = mysqli_query($conn, $query_user_login);
$user_login = mysqli_fetch_assoc($result_user_login);
?>