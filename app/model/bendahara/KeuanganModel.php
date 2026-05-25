<?php

class KeuanganModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

public function hapusPemasukanManual($id_hapus) {
        $id_hapus = mysqli_real_escape_string($this->conn, $id_hapus);
        mysqli_query($this->conn, "DELETE FROM pemasukan_kas WHERE id_pemasukan='$id_hapus'");
    }

    public function tambahPemasukanManual($id_grup, $id_anggota, $tanggal, $deskripsi, $nominal, $metode) {
        $id_grup = mysqli_real_escape_string($this->conn, $id_grup);
        $tanggal = mysqli_real_escape_string($this->conn, $tanggal);
        $deskripsi = mysqli_real_escape_string($this->conn, $deskripsi);
        $nominal = mysqli_real_escape_string($this->conn, $nominal);
        $metode = mysqli_real_escape_string($this->conn, $metode);
        
        $val_user = empty($id_anggota) ? "NULL" : "'" . mysqli_real_escape_string($this->conn, $id_anggota) . "'";
        
        mysqli_query($this->conn, "INSERT INTO pemasukan_kas (id_grup, id_user, tanggal, deskripsi, nominal, metode) VALUES ('$id_grup', $val_user, '$tanggal', '$deskripsi', '$nominal', '$metode')");
    }

    public function getStatistikPemasukan() {
        $q_masuk_iuran = mysqli_query($this->conn, "SELECT SUM(i.nominal) as total, COUNT(p.id_pembayaran) as jml FROM pembayaran p JOIN iuran i ON p.id_iuran = i.id_iuran WHERE p.status = 'Lunas'");
        $d_iuran = mysqli_fetch_assoc($q_masuk_iuran);
        
        $q_masuk_manual = mysqli_query($this->conn, "SELECT SUM(nominal) as total, COUNT(id_pemasukan) as jml, SUM(CASE WHEN metode='Tunai' THEN nominal ELSE 0 END) as tunai, SUM(CASE WHEN metode='Transfer' THEN nominal ELSE 0 END) as tf FROM pemasukan_kas");
        $d_manual = mysqli_fetch_assoc($q_masuk_manual);
        
        return [
            'total_iuran' => $d_iuran['total'] ?? 0,
            'jml_iuran' => $d_iuran['jml'] ?? 0,
            'total_manual' => $d_manual['total'] ?? 0,
            'jml_manual' => $d_manual['jml'] ?? 0,
            'tunai_manual' => $d_manual['tunai'] ?? 0,
            'tf_manual' => $d_manual['tf'] ?? 0
        ];
    }

    public function getTabelPemasukan($id_bendahara) {
        $id_bendahara = mysqli_real_escape_string($this->conn, $id_bendahara);
        $query_gabungan = "
            SELECT 
                'Iuran' as tipe, p.id_pembayaran as id, p.tanggal_bayar as tanggal, g.nama_grup, 
                CONCAT(i.nama_iuran, ' (', u.nama, ')') as deskripsi, i.nominal, 'Tunai' as metode
            FROM pembayaran p 
            JOIN iuran i ON p.id_iuran = i.id_iuran 
            JOIN grup g ON i.id_grup = g.id_grup 
            JOIN users u ON p.id_user = u.id_user 
            WHERE g.id_bendahara = '$id_bendahara' AND p.status = 'Lunas'
            
            UNION ALL
            
            SELECT 
                'Manual' as tipe, pk.id_pemasukan as id, pk.tanggal, g.nama_grup, 
                IF(pk.id_user IS NOT NULL, CONCAT(pk.deskripsi, ' (', u_man.nama, ')'), pk.deskripsi) as deskripsi, 
                pk.nominal, pk.metode
            FROM pemasukan_kas pk
            JOIN grup g ON pk.id_grup = g.id_grup
            LEFT JOIN users u_man ON pk.id_user = u_man.id_user
            WHERE g.id_bendahara = '$id_bendahara'
            ORDER BY tanggal DESC
        ";
        $q = mysqli_query($this->conn, $query_gabungan);
        $result = [];
        if($q && mysqli_num_rows($q) > 0) {
            while($row = mysqli_fetch_assoc($q)) {
                $result[] = $row;
            }
        }
        return $result;
    }

    public function getDaftarGrup($id_bendahara = null) {
        $where = "";
        if ($id_bendahara !== null) {
            $id_bendahara = mysqli_real_escape_string($this->conn, $id_bendahara);
            $where = "WHERE id_bendahara = '$id_bendahara'";
        }
        $q = mysqli_query($this->conn, "SELECT id_grup, nama_grup FROM grup $where");
        $result = [];
        if($q && mysqli_num_rows($q) > 0) {
            while($row = mysqli_fetch_assoc($q)) {
                $result[] = $row;
            }
        }
        return $result;
    }

    public function getDaftarAnggotaGrup($id_bendahara) {
        $id_bendahara = mysqli_real_escape_string($this->conn, $id_bendahara);
        $q = mysqli_query($this->conn, "SELECT DISTINCT u.id_user, u.nama FROM users u JOIN grup_anggota ga ON u.id_user = ga.id_user JOIN grup g ON ga.id_grup = g.id_grup WHERE g.id_bendahara = '$id_bendahara'");
        $result = [];
        if($q && mysqli_num_rows($q) > 0) {
            while($row = mysqli_fetch_assoc($q)) {
                $result[] = $row;
            }
        }
        return $result;
    }

public function tambahPengeluaran($id_grup, $tanggal, $keterangan, $jumlah) {
        $id_grup = mysqli_real_escape_string($this->conn, $id_grup);
        $tanggal = mysqli_real_escape_string($this->conn, $tanggal);
        $keterangan = mysqli_real_escape_string($this->conn, $keterangan);
        $jumlah = mysqli_real_escape_string($this->conn, $jumlah);
        mysqli_query($this->conn, "INSERT INTO pengeluaran (id_grup, deskripsi, nominal_keluar, tanggal_keluar) VALUES ('$id_grup', '$keterangan', '$jumlah', '$tanggal')");
    }

    public function getStatistikPengeluaran() {
        $q = mysqli_query($this->conn, "SELECT SUM(pe.nominal_keluar) as total, COUNT(pe.id_pengeluaran) as jml, MAX(pe.nominal_keluar) as terbesar, AVG(pe.nominal_keluar) as rata FROM pengeluaran pe JOIN grup g ON pe.id_grup = g.id_grup");
        return mysqli_fetch_assoc($q);
    }

    public function getTabelPengeluaran() {
        $q = mysqli_query($this->conn, "SELECT pe.*, g.nama_grup FROM pengeluaran pe JOIN grup g ON pe.id_grup = g.id_grup ORDER BY pe.tanggal_keluar DESC");
        $result = [];
        if($q && mysqli_num_rows($q) > 0) {
            while($row = mysqli_fetch_assoc($q)) {
                $result[] = $row;
            }
        }
        return $result;
    }

public function getRingkasanKeuangan() {
        $masuk_query = mysqli_query($this->conn, "SELECT SUM(i.nominal) as total, COUNT(*) as jml_transaksi FROM pembayaran p JOIN iuran i ON p.id_iuran = i.id_iuran JOIN grup g ON i.id_grup = g.id_grup AND p.status = 'Lunas'");
        $data_masuk = mysqli_fetch_assoc($masuk_query);
        $total_masuk = $data_masuk['total'] ?? 0;
        $trx_masuk = $data_masuk['jml_transaksi'] ?? 0;
        
        $keluar_query = mysqli_query($this->conn, "SELECT SUM(pe.nominal_keluar) as total, COUNT(*) as jml_transaksi FROM pengeluaran pe JOIN grup g ON pe.id_grup = g.id_grup");
        $data_keluar = mysqli_fetch_assoc($keluar_query);
        $total_keluar = $data_keluar['total'] ?? 0;
        $trx_keluar = $data_keluar['jml_transaksi'] ?? 0;

        return [
            'total_masuk' => $total_masuk,
            'trx_masuk' => $trx_masuk,
            'total_keluar' => $total_keluar,
            'trx_keluar' => $trx_keluar,
            'saldo_akhir' => $total_masuk - $total_keluar,
            'total_transaksi' => $trx_masuk + $trx_keluar
        ];
    }
}
?>
