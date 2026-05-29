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
                WHERE p.status = 'Belum Lunas' OR p.id_pembayaran IS NULL";
        $query = mysqli_query($this->conn, $sql);
        $data = [];
        if ($query && mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function bayarIuran($id_pembayaran) {
        $id_pembayaran = (int)$id_pembayaran;
        $tanggal = date('Y-m-d');
        return mysqli_query($this->conn, "UPDATE pembayaran SET status = 'Lunas', tanggal_bayar = '$tanggal' WHERE id_pembayaran = $id_pembayaran");
    }
}
?>