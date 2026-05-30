<?php
session_start();
require_once '../../../config/database.php';
require_once '../../model/auth/AuthModel.php';

if (isset($_SESSION['id_user']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: ../admin/DashboardAdminController.php");
        exit();
    } elseif ($_SESSION['role'] == 'bendahara') {
        header("Location: ../bendahara/DashboardBendaharaController.php");
        exit();
    } else {
        header("Location: ../user/DashboardUserController.php");
        exit();
    }
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$authModel = new AuthModel($conn);
$error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $authModel->getUserByEmail($email);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'admin') {
                header("Location: ../admin/DashboardAdminController.php");
            } elseif ($user['role'] == 'bendahara') {
                header("Location: ../bendahara/DashboardBendaharaController.php");
            } else {
                header("Location: ../user/DashboardUserController.php");
            }
            exit();
        } else {
            $error = true;
        }
    } else {
        $error = true;
    }
}

require_once '../../view/auth/login.php';
?>
