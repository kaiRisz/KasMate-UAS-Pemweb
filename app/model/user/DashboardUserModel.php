<?php

class DashboardUserModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function getUserById($id_user) {
        $id_user = (int)$id_user;
        $query = mysqli_query($this->conn, "SELECT id_user, nama, email, role FROM users WHERE id_user = $id_user");
        return mysqli_fetch_assoc($query);
    }

    public function updateProfil($id_user, $nama, $email, $password = '') {
        $id_user = (int)$id_user;
        $nama = mysqli_real_escape_string($this->conn, $nama);
        $email = mysqli_real_escape_string($this->conn, $email);

        $query_update = "UPDATE users SET nama='$nama', email='$email'";
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query_update .= ", password='$hashed_password'";
        }
        $query_update .= " WHERE id_user = $id_user";
        
        return mysqli_query($this->conn, $query_update);
    }

    public function getTotalPemasukan() {
        $query = mysqli_query($this->conn, "SELECT SUM(nominal) as total FROM pemasukan_kas");
        $data = mysqli_fetch_assoc($query);
        return $data['total'] ?? 0;
    }

    public function getTotalPengeluaran() {
        $query = mysqli_query($this->conn, "SELECT SUM(nominal_keluar) as total FROM pengeluaran");
        $data = mysqli_fetch_assoc($query);
        return $data['total'] ?? 0;
    }

    public function getRiwayatPembayaranUser($id_user) {
        $id_user = (int)$id_user;
        $sql = "SELECT p.*, i.nama_iuran, i.nominal as nominal_iuran
                FROM pembayaran p
                JOIN iuran i ON p.id_iuran = i.id_iuran
                WHERE p.id_user = $id_user
                ORDER BY p.tanggal_bayar DESC";
                
        $query = mysqli_query($this->conn, $sql);
        $riwayat = [];
        if ($query && mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $riwayat[] = $row;
            }
        }
        return $riwayat;
    }
}
?>