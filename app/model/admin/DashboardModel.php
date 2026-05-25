<?php

class DashboardModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function getTotalUser() {
        $query = mysqli_query($this->conn, "SELECT COUNT(*) as total FROM users");
        return mysqli_fetch_assoc($query)['total'];
    }

    public function getTotalGrup() {
        $query = mysqli_query($this->conn, "SELECT COUNT(*) as total FROM grup");
        return mysqli_fetch_assoc($query)['total'];
    }

    public function getTotalPemasukan() {
        $q_masuk_iuran = mysqli_query($this->conn, "SELECT COALESCE(SUM(i.nominal), 0) as total FROM pembayaran p JOIN iuran i ON p.id_iuran = i.id_iuran WHERE p.status = 'Lunas'");
        $total_masuk_iuran = mysqli_fetch_assoc($q_masuk_iuran)['total'];

        $q_masuk_manual = mysqli_query($this->conn, "SELECT COALESCE(SUM(nominal), 0) as total FROM pemasukan_kas");
        $total_masuk_manual = mysqli_fetch_assoc($q_masuk_manual)['total'];

        return $total_masuk_iuran + $total_masuk_manual;
    }

    public function getTotalPengeluaran() {
        $query = mysqli_query($this->conn, "SELECT COALESCE(SUM(nominal_keluar), 0) as total FROM pengeluaran");
        return mysqli_fetch_assoc($query)['total'];
    }

    public function getTotalSaldo() {
        return $this->getTotalPemasukan() - $this->getTotalPengeluaran();
    }

    public function getTotalTransaksi() {
        $q_trx1 = mysqli_query($this->conn, "SELECT COUNT(*) as total FROM pembayaran WHERE status = 'Lunas'");
        $q_trx2 = mysqli_query($this->conn, "SELECT COUNT(*) as total FROM pemasukan_kas");
        $q_trx3 = mysqli_query($this->conn, "SELECT COUNT(*) as total FROM pengeluaran");
        return mysqli_fetch_assoc($q_trx1)['total'] + mysqli_fetch_assoc($q_trx2)['total'] + mysqli_fetch_assoc($q_trx3)['total'];
    }

    public function getAktivitasTerbaru() {
        $query = mysqli_query($this->conn, "
            (SELECT 'Pembayaran Iuran' as aktivitas, u.nama as nama_user, i.nominal as jumlah, p.tanggal_bayar as tanggal
             FROM pembayaran p 
             JOIN users u ON p.id_user = u.id_user 
             JOIN iuran i ON p.id_iuran = i.id_iuran 
             WHERE p.status = 'Lunas'
             ORDER BY p.tanggal_bayar DESC LIMIT 5)
            UNION ALL
            (SELECT 'Pemasukan Manual' as aktivitas, COALESCE(u.nama, 'Umum') as nama_user, pk.nominal as jumlah, pk.tanggal
             FROM pemasukan_kas pk 
             LEFT JOIN users u ON pk.id_user = u.id_user 
             ORDER BY pk.tanggal DESC LIMIT 5)
            UNION ALL
            (SELECT CONCAT('Pengeluaran: ', pe.deskripsi) as aktivitas, g.nama_grup as nama_user, pe.nominal_keluar as jumlah, pe.tanggal_keluar as tanggal
             FROM pengeluaran pe 
             JOIN grup g ON pe.id_grup = g.id_grup 
             ORDER BY pe.tanggal_keluar DESC LIMIT 5)
            ORDER BY tanggal DESC
            LIMIT 5
        ");
        
        $aktivitas = [];
        if ($query && mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $aktivitas[] = $row;
            }
        }
        return $aktivitas;
    }
}
?>
