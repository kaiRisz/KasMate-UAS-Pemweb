<?php
session_start();
require_once __DIR__ . '/database.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: ../auth/login.php");
    exit();
}

function cekRole($role_dibutuhkan) {
    if ($_SESSION['role'] !== $role_dibutuhkan) {
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

$id_user_login = $_SESSION['id_user'];
$query_user_login = "SELECT * FROM users WHERE id_user = $id_user_login";
$result_user_login = mysqli_query($conn, $query_user_login);
$user_login = mysqli_fetch_assoc($result_user_login);
?>
