<?php
require_once __DIR__ . '/../../../config/auth_check.php';

cekRole('user');

$id_user = $_SESSION['user_login']['id_user'];
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi']) && $_POST['aksi'] === 'update') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password_baru = $_POST['password_baru'] ?? '';
    $konfirmasi_password = $_POST['konfirmasi_password'] ?? '';

    if (!empty($password_baru)) {
        if ($password_baru === $konfirmasi_password) {
            $password_hashed = password_hash($password_baru, PASSWORD_BCRYPT);
            mysqli_query($conn, "UPDATE users SET nama='$nama', email='$email', password='$password_hashed' WHERE id_user=$id_user");
            $message = "Profil dan password berhasil diperbarui.";
            $_SESSION['user_login']['nama'] = $nama;
        } else {
            $message = "Konfirmasi password tidak cocok.";
        }
    } else {
        mysqli_query($conn, "UPDATE users SET nama='$nama', email='$email' WHERE id_user=$id_user");
        $message = "Profil berhasil diperbarui.";
        $_SESSION['user_login']['nama'] = $nama;
    }
}

$query_user = mysqli_query($conn, "SELECT nama, email FROM users WHERE id_user = $id_user");
$data_user = mysqli_fetch_assoc($query_user);

require_once __DIR__ . '/../../view/user/profil.php';
?>