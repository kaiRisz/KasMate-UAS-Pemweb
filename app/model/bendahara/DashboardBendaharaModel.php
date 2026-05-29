<?php

class DashboardBendaharaModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function getTotalGrup() {
        $query = mysqli_query($this->conn, "SELECT COUNT(*) as total FROM grup");
        return mysqli_fetch_assoc($query)['total'] ?? 0;
    }

    public function getTotalAnggota() {
        $query = mysqli_query($this->conn, "SELECT COUNT(*) as total FROM users");
        return mysqli_fetch_assoc($query)['total'] ?? 0;
    }

    public function getTotalPemasukan() {
        $query = mysqli_query($this->conn, "SELECT SUM(i.nominal) as total FROM pembayaran p JOIN iuran i ON p.id_iuran = i.id_iuran WHERE p.status = 'Lunas'");
        return mysqli_fetch_assoc($query)['total'] ?? 0;
    }

    public function getTotalPengeluaran() {
        $query = mysqli_query($this->conn, "SELECT SUM(nominal_keluar) as total FROM pengeluaran");
        return mysqli_fetch_assoc($query)['total'] ?? 0;
    }

    public function getStatusTagihan() {
        $status_lunas_q = mysqli_query($this->conn, "SELECT COUNT(*) as total FROM pembayaran WHERE status = 'Lunas'");
        $count_lunas = mysqli_fetch_assoc($status_lunas_q)['total'] ?? 0;

        $status_belum_q = mysqli_query($this->conn, "SELECT COUNT(*) as total FROM pembayaran WHERE status = 'Belum Lunas'");
        $count_belum = mysqli_fetch_assoc($status_belum_q)['total'] ?? 0;

        return [
            'lunas' => $count_lunas,
            'belum' => $count_belum
        ];
    }

    public function getGrupTerbaru($limit = 5) {
        $limit = (int)$limit;
        $query = mysqli_query($this->conn, "SELECT * FROM grup ORDER BY id_grup DESC LIMIT $limit");
        
        $grup = [];
        if ($query && mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $grup[] = $row;
            }
        }
        return $grup;
    }
}
?>