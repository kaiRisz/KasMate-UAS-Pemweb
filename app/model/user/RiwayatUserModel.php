<?php
class RiwayatUserModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function getRiwayatLunas($id_user) {
        $id_user = (int)$id_user;
        $sql = "SELECT p.*, i.nama_iuran, i.nominal 
                FROM pembayaran p
                JOIN iuran i ON p.id_iuran = i.id_iuran
                WHERE p.id_user = $id_user AND p.status = 'Lunas'
                ORDER BY p.tanggal_bayar DESC";
        $query = mysqli_query($this->conn, $sql);
        $data = [];
        if ($query && mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $data[] = $row;
            }
        }
        return $data;
    }
}
?>