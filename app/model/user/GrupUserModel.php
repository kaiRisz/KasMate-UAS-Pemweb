<?php
class GrupUserModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function getGrupUser($id_user) {
        $id_user = (int)$id_user;
        
        // Tambahkan LEFT JOIN ke tabel users untuk mengambil nama_bendahara
        $sql = "SELECT g.*, COALESCE(u.nama, 'Belum Ada') as nama_bendahara 
                FROM grup_anggota ga 
                JOIN grup g ON ga.id_grup = g.id_grup 
                LEFT JOIN users u ON g.id_bendahara = u.id_user 
                WHERE ga.id_user = $id_user";
                
        $query = mysqli_query($this->conn, $sql);
        
        // Gunakan array dan while loop untuk mengambil SEMUA grup, bukan cuma 1
        $data = [];
        if ($query && mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getAnggotaGrup($id_grup) {
        $id_grup = (int)$id_grup;
        $sql = "SELECT u.nama, u.email, u.role FROM grup_anggota ga 
                JOIN users u ON ga.id_user = u.id_user 
                WHERE ga.id_grup = $id_grup";
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