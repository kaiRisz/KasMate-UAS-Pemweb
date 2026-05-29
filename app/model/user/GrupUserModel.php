<?php
class GrupUserModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function getGrupUser($id_user) {
        $id_user = (int)$id_user;
        $sql = "SELECT g.* FROM grup_anggota ga 
                JOIN grup g ON ga.id_grup = g.id_grup 
                WHERE ga.id_user = $id_user";
        $query = mysqli_query($this->conn, $sql);
        return mysqli_fetch_assoc($query);
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