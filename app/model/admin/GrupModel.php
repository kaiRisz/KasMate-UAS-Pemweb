<?php

class GrupModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function hapusGrup($id_hapus) {
        $id_hapus = (int)$id_hapus;
        mysqli_query($this->conn, "DELETE FROM grup WHERE id_grup = $id_hapus");
    }

    public function getTotalGrup($search = '') {
        $where = "WHERE 1=1";
        if ($search !== '') {
            $search = mysqli_real_escape_string($this->conn, $search);
            $where .= " AND (g.nama_grup LIKE '%$search%' OR u.nama LIKE '%$search%')";
        }

        $q_count = mysqli_query($this->conn, "
            SELECT COUNT(*) as total 
            FROM grup g 
            JOIN users u ON g.id_bendahara = u.id_user 
            $where
        ");
        return mysqli_fetch_assoc($q_count)['total'];
    }

    public function getGrup($search = '', $per_page = 10, $offset = 0) {
        $where = "WHERE 1=1";
        if ($search !== '') {
            $search = mysqli_real_escape_string($this->conn, $search);
            $where .= " AND (g.nama_grup LIKE '%$search%' OR u.nama LIKE '%$search%')";
        }

        $per_page = (int)$per_page;
        $offset = (int)$offset;

        $query = mysqli_query($this->conn, "
            SELECT g.*, u.nama as nama_bendahara,
                (SELECT COUNT(*) FROM grup_anggota ga WHERE ga.id_grup = g.id_grup) as jumlah_anggota
            FROM grup g 
            JOIN users u ON g.id_bendahara = u.id_user 
            $where 
            ORDER BY g.id_grup DESC 
            LIMIT $per_page OFFSET $offset
        ");

        $groups = [];
        if ($query && mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $groups[] = $row;
            }
        }
        return $groups;
    }
}
?>
