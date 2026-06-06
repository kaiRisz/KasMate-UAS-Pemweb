<?php
class TagihanUserModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function getTagihanBelumLunas($id_user) {
        $id_user = (int)$id_user;
        $sql = "SELECT p.*, i.nama_iuran, i.nominal 
                FROM iuran i
                LEFT JOIN pembayaran p ON i.id_iuran = p.id_iuran AND p.id_user = $id_user
                WHERE p.status = 'Belum Lunas' OR p.status = 'Ditolak' OR p.id_pembayaran IS NULL";
        $query = mysqli_query($this->conn, $sql);
        $data = [];
        if ($query && mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function prosesPembayaran($id_user, $id_iuran, $metode, $bukti = null) {
        $id_user = (int)$id_user;
        $id_iuran = (int)$id_iuran;
        $metode = mysqli_real_escape_string($this->conn, $metode);
        $bukti = $bukti ? "'" . mysqli_real_escape_string($this->conn, $bukti) . "'" : "NULL";
        $tanggal = date('Y-m-d');

        
        $cek = mysqli_query($this->conn, "SELECT id_pembayaran FROM pembayaran WHERE id_iuran = $id_iuran AND id_user = $id_user");
        
        if (mysqli_num_rows($cek) > 0) {
            $sql = "UPDATE pembayaran SET status = 'Menunggu Verifikasi', metode_pembayaran = '$metode', bukti_pembayaran = $bukti, tanggal_bayar = '$tanggal' WHERE id_iuran = $id_iuran AND id_user = $id_user";
        } else {
            $sql = "INSERT INTO pembayaran (id_iuran, id_user, tanggal_bayar, status, metode_pembayaran, bukti_pembayaran) VALUES ($id_iuran, $id_user, '$tanggal', 'Menunggu Verifikasi', '$metode', $bukti)";
        }
        
        return mysqli_query($this->conn, $sql);
    }
}
?>