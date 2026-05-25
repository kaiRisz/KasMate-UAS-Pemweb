<?php

class PengaturanModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function updateProfil($id_user, $nama, $email) {
        $id_user = (int)$id_user;
        $nama = mysqli_real_escape_string($this->conn, $nama);
        $email = mysqli_real_escape_string($this->conn, $email);

        $q_cek = mysqli_query($this->conn, "SELECT id_user FROM users WHERE email='$email' AND id_user != $id_user");
        if (mysqli_num_rows($q_cek) > 0) {
            return ['sukses' => false, 'error' => 'Email sudah digunakan oleh user lain.'];
        }

        mysqli_query($this->conn, "UPDATE users SET nama='$nama', email='$email' WHERE id_user = $id_user");
        return ['sukses' => true, 'error' => ''];
    }

    public function updatePassword($id_user, $password_lama, $password_baru, $konfirmasi, $hash_password_sekarang) {
        if (!password_verify($password_lama, $hash_password_sekarang)) {
            return ['sukses' => false, 'error' => 'Password lama tidak sesuai.'];
        } elseif ($password_baru !== $konfirmasi) {
            return ['sukses' => false, 'error' => 'Konfirmasi password tidak cocok.'];
        } elseif (strlen($password_baru) < 6) {
            return ['sukses' => false, 'error' => 'Password baru minimal 6 karakter.'];
        }

        $hash = password_hash($password_baru, PASSWORD_DEFAULT);
        $id_user = (int)$id_user;
        mysqli_query($this->conn, "UPDATE users SET password='$hash' WHERE id_user = $id_user");
        return ['sukses' => true, 'error' => ''];
    }

    public function getStatistikSistem() {
        $q_total_user = mysqli_query($this->conn, "SELECT COUNT(*) as t FROM users");
        $total_user = mysqli_fetch_assoc($q_total_user)['t'];

        $q_total_grup = mysqli_query($this->conn, "SELECT COUNT(*) as t FROM grup");
        $total_grup = mysqli_fetch_assoc($q_total_grup)['t'];

        $q_trx1 = mysqli_query($this->conn, "SELECT COUNT(*) as t FROM pembayaran WHERE status = 'Lunas'");
        $q_trx2 = mysqli_query($this->conn, "SELECT COUNT(*) as t FROM pemasukan_kas");
        $q_trx3 = mysqli_query($this->conn, "SELECT COUNT(*) as t FROM pengeluaran");
        $total_trx = mysqli_fetch_assoc($q_trx1)['t'] + mysqli_fetch_assoc($q_trx2)['t'] + mysqli_fetch_assoc($q_trx3)['t'];

        return [
            'total_user' => $total_user,
            'total_grup' => $total_grup,
            'total_trx' => $total_trx
        ];
    }
}
?>
