<?php
session_start();
require_once __DIR__ . '/database.php';

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Cek apakah role sesuai (opsional, bisa dipakai per halaman)
function cekRole($role_dibutuhkan) {
    if ($_SESSION['role'] !== $role_dibutuhkan) {
        // Redirect ke dashboard sesuai role
        switch ($_SESSION['role']) {
            case 'admin':
                header("Location: ../admin/dashboard-admin.php");
                break;
            case 'bendahara':
                header("Location: ../bendahara/dashboard-bendahara.php");
                break;
            default:
                header("Location: ../user/dashboard-user.php");
                break;
        }
        exit();
    }
}

// Ambil data user yang sedang login
$id_user_login = $_SESSION['id_user'];
$query_user_login = "SELECT * FROM users WHERE id_user = $id_user_login";
$result_user_login = mysqli_query($conn, $query_user_login);
$user_login = mysqli_fetch_assoc($result_user_login);
?>
