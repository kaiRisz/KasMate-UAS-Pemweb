<?php

class BendaharaGrupModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function hapusGrup($id_hapus, $id_bendahara) {
        $id_hapus = mysqli_real_escape_string($this->conn, $id_hapus);
        $id_bendahara = mysqli_real_escape_string($this->conn, $id_bendahara);
        
        mysqli_query($this->conn, "DELETE FROM pembayaran WHERE id_iuran IN (SELECT id_iuran FROM iuran WHERE id_grup='$id_hapus')");
        mysqli_query($this->conn, "DELETE FROM iuran WHERE id_grup='$id_hapus'");
        mysqli_query($this->conn, "DELETE FROM pengeluaran WHERE id_grup='$id_hapus'");
        mysqli_query($this->conn, "DELETE FROM pemasukan_kas WHERE id_grup='$id_hapus'");
        mysqli_query($this->conn, "DELETE FROM grup_anggota WHERE id_grup='$id_hapus'");
        mysqli_query($this->conn, "DELETE FROM grup WHERE id_grup='$id_hapus' AND id_bendahara='$id_bendahara'");
    }

    public function editGrup($id_grup, $nama_grup, $deskripsi, $id_bendahara) {
        $id_grup = mysqli_real_escape_string($this->conn, $id_grup);
        $nama_grup = mysqli_real_escape_string($this->conn, $nama_grup);
        $deskripsi = mysqli_real_escape_string($this->conn, $deskripsi);
        $id_bendahara = mysqli_real_escape_string($this->conn, $id_bendahara);
        
        mysqli_query($this->conn, "UPDATE grup SET nama_grup='$nama_grup', deskripsi='$deskripsi' WHERE id_grup='$id_grup' AND id_bendahara='$id_bendahara'");
    }

    public function tambahGrup($nama_grup, $deskripsi, $id_bendahara) {
        $nama_grup = mysqli_real_escape_string($this->conn, $nama_grup);
        $deskripsi = mysqli_real_escape_string($this->conn, $deskripsi);
        $id_bendahara = mysqli_real_escape_string($this->conn, $id_bendahara);
        
        mysqli_query($this->conn, "INSERT INTO grup (nama_grup, deskripsi, id_bendahara) VALUES ('$nama_grup', '$deskripsi', '$id_bendahara')");
    }

    public function getTotalGrup() {
        $q = mysqli_query($this->conn, "SELECT COUNT(*) as total FROM grup");
        return mysqli_fetch_assoc($q)['total'] ?? 0;
    }

    public function getTotalAnggotaSeluruhGrup() {
        $q = mysqli_query($this->conn, "SELECT COUNT(DISTINCT ga.id_user) as total FROM grup_anggota ga JOIN grup g ON ga.id_grup = g.id_grup");
        return mysqli_fetch_assoc($q)['total'] ?? 0;
    }

    public function getAvgIuran() {
        $q = mysqli_query($this->conn, "SELECT AVG(i.nominal) as avg_nominal FROM iuran i JOIN grup g ON i.id_grup = g.id_grup");
        return mysqli_fetch_assoc($q)['avg_nominal'] ?? 0;
    }

    public function getMaxAnggotaGrup() {
        $q = mysqli_query($this->conn, "SELECT MAX(member_count) as max_member FROM (SELECT COUNT(ga.id_user) as member_count FROM grup g LEFT JOIN grup_anggota ga ON g.id_grup = ga.id_grup GROUP BY g.id_grup) as counts");
        return mysqli_fetch_assoc($q)['max_member'] ?? 0;
    }

    public function getDaftarGrup() {
        $q = mysqli_query($this->conn, "
            SELECT g.id_grup, g.nama_grup, g.deskripsi, 
            (SELECT COUNT(*) FROM grup_anggota WHERE id_grup = g.id_grup) as jml_anggota,
            (SELECT AVG(nominal) FROM iuran WHERE id_grup = g.id_grup) as avg_nominal
            FROM grup g 
            ORDER BY g.id_grup DESC
        ");
        
        $result = [];
        if($q && mysqli_num_rows($q) > 0) {
            while($row = mysqli_fetch_assoc($q)) {
                $result[] = $row;
            }
        }
        return $result;
    }

    public function getGrupById($id_grup) {
        $id_grup = mysqli_real_escape_string($this->conn, $id_grup);
        $q = mysqli_query($this->conn, "SELECT * FROM grup WHERE id_grup = '$id_grup'");
        return mysqli_fetch_assoc($q);
    }

    public function getLastGrupId() {
        $cek_grup = mysqli_query($this->conn, "SELECT id_grup FROM grup ORDER BY id_grup DESC LIMIT 1");
        if ($cek_grup && mysqli_num_rows($cek_grup) > 0) {
            return mysqli_fetch_assoc($cek_grup)['id_grup'];
        }
        return null;
    }

    public function tambahAnggota($id_grup, $id_user) {
        $id_grup = mysqli_real_escape_string($this->conn, $id_grup);
        $id_user = mysqli_real_escape_string($this->conn, $id_user);
        mysqli_query($this->conn, "INSERT INTO grup_anggota (id_grup, id_user) VALUES ('$id_grup', '$id_user')");
    }

    public function hapusAnggota($id_grup, $id_user) {
        $id_grup = mysqli_real_escape_string($this->conn, $id_grup);
        $id_user = mysqli_real_escape_string($this->conn, $id_user);
        mysqli_query($this->conn, "DELETE FROM grup_anggota WHERE id_grup='$id_grup' AND id_user='$id_user'");
    }

    public function tambahTagihan($id_grup, $nama_iuran, $nominal, $deadline) {
        $id_grup = mysqli_real_escape_string($this->conn, $id_grup);
        $nama_iuran = mysqli_real_escape_string($this->conn, $nama_iuran);
        $nominal = mysqli_real_escape_string($this->conn, $nominal);
        $deadline = !empty($deadline) ? "'" . mysqli_real_escape_string($this->conn, $deadline) . "'" : "NULL";
        mysqli_query($this->conn, "INSERT INTO iuran (id_grup, nama_iuran, nominal, deadline) VALUES ('$id_grup', '$nama_iuran', '$nominal', $deadline)");
    }

    public function hapusTagihan($id_grup, $id_iuran) {
        $id_grup = mysqli_real_escape_string($this->conn, $id_grup);
        $id_iuran = mysqli_real_escape_string($this->conn, $id_iuran);
        mysqli_query($this->conn, "DELETE FROM pembayaran WHERE id_iuran='$id_iuran'");
        mysqli_query($this->conn, "DELETE FROM iuran WHERE id_iuran='$id_iuran' AND id_grup='$id_grup'");
    }

    public function bayarTagihan($id_user_bayar, $id_iuran_bayar) {
        $id_user_bayar = mysqli_real_escape_string($this->conn, $id_user_bayar);
        $id_iuran_bayar = mysqli_real_escape_string($this->conn, $id_iuran_bayar);
        $tanggal_bayar = date('Y-m-d');
        
        $cek = mysqli_query($this->conn, "SELECT * FROM pembayaran WHERE id_user='$id_user_bayar' AND id_iuran='$id_iuran_bayar'");
        if(mysqli_num_rows($cek) > 0) {
            mysqli_query($this->conn, "UPDATE pembayaran SET status='Lunas', tanggal_bayar='$tanggal_bayar' WHERE id_user='$id_user_bayar' AND id_iuran='$id_iuran_bayar'");
        } else {
            mysqli_query($this->conn, "INSERT INTO pembayaran (id_iuran, id_user, tanggal_bayar, status) VALUES ('$id_iuran_bayar', '$id_user_bayar', '$tanggal_bayar', 'Lunas')");
        }
    }

    public function verifikasiPembayaran($id_pembayaran, $status) {
        $id_pembayaran = (int)$id_pembayaran;
        $status = mysqli_real_escape_string($this->conn, $status);
        return mysqli_query($this->conn, "UPDATE pembayaran SET status='$status' WHERE id_pembayaran=$id_pembayaran");
    }

    public function updatePengaturanPembayaran($id_grup, $bank, $nomor, $nama, $qris_image = null) {
        $id_grup = mysqli_real_escape_string($this->conn, $id_grup);
        $bank = mysqli_real_escape_string($this->conn, $bank);
        $nomor = mysqli_real_escape_string($this->conn, $nomor);
        $nama = mysqli_real_escape_string($this->conn, $nama);

        if ($qris_image) {
            $qris_image = mysqli_real_escape_string($this->conn, $qris_image);
            mysqli_query($this->conn, "UPDATE grup SET rekening_bank='$bank', rekening_nomor='$nomor', rekening_nama='$nama', qris_image='$qris_image' WHERE id_grup='$id_grup'");
        } else {
            mysqli_query($this->conn, "UPDATE grup SET rekening_bank='$bank', rekening_nomor='$nomor', rekening_nama='$nama' WHERE id_grup='$id_grup'");
        }
    }

    public function getRingkasanTagihan($id_grup) {
        $id_grup = mysqli_real_escape_string($this->conn, $id_grup);
        $q = mysqli_query($this->conn, "SELECT 
            SUM(i.nominal) as total_tagihan,
            SUM(CASE WHEN p.status = 'Lunas' THEN i.nominal ELSE 0 END) as total_lunas,
            SUM(CASE WHEN p.status = 'Belum Lunas' THEN i.nominal ELSE 0 END) as total_belum
            FROM pembayaran p 
            JOIN iuran i ON p.id_iuran = i.id_iuran 
            WHERE i.id_grup = '$id_grup'");
        return mysqli_fetch_assoc($q);
    }

    public function getAnggotaGrup($id_grup) {
        $id_grup = mysqli_real_escape_string($this->conn, $id_grup);
        $q = mysqli_query($this->conn, "SELECT ga.*, u.nama, u.email FROM grup_anggota ga JOIN users u ON ga.id_user = u.id_user WHERE ga.id_grup = '$id_grup'");
        $result = [];
        if($q && mysqli_num_rows($q) > 0) {
            while($row = mysqli_fetch_assoc($q)) {
                $result[] = $row;
            }
        }
        return $result;
    }

    public function getTagihanGrup($id_grup) {
        $id_grup = mysqli_real_escape_string($this->conn, $id_grup);
        $q = mysqli_query($this->conn, "SELECT i.*, 
            (SELECT COUNT(*) FROM pembayaran WHERE id_iuran = i.id_iuran AND status = 'Lunas') as jml_lunas,
            (SELECT COUNT(*) FROM grup_anggota WHERE id_grup = i.id_grup) as jml_anggota
            FROM iuran i WHERE i.id_grup = '$id_grup' ORDER BY i.id_iuran DESC");
        $result = [];
        if($q && mysqli_num_rows($q) > 0) {
            while($row = mysqli_fetch_assoc($q)) {
                $result[] = $row;
            }
        }
        return $result;
    }

    public function getPembayaranGrup($id_grup) {
        $id_grup = mysqli_real_escape_string($this->conn, $id_grup);
        $q = mysqli_query($this->conn, "SELECT p.*, u.nama, i.nama_iuran, i.nominal 
            FROM pembayaran p 
            JOIN users u ON p.id_user = u.id_user 
            JOIN iuran i ON p.id_iuran = i.id_iuran 
            WHERE i.id_grup = '$id_grup' ORDER BY p.status = 'Menunggu Verifikasi' DESC, p.id_pembayaran DESC");
        $result = [];
        if($q && mysqli_num_rows($q) > 0) {
            while($row = mysqli_fetch_assoc($q)) {
                $result[] = $row;
            }
        }
        return $result;
    }

    public function getStatusPembayaranAnggota($id_grup) {
        $id_grup = mysqli_real_escape_string($this->conn, $id_grup);
        $q = mysqli_query($this->conn, "
            SELECT u.id_user, u.nama, 
               SUM(CASE WHEN p.status = 'Lunas' THEN i.nominal ELSE 0 END) as dibayar,
               SUM(i.nominal) as total_beban,
               MAX(CASE WHEN p.status = 'Lunas' THEN p.tanggal_bayar ELSE NULL END) as tgl_bayar
            FROM grup_anggota ga
            JOIN users u ON ga.id_user = u.id_user
            LEFT JOIN iuran i ON i.id_grup = ga.id_grup
            LEFT JOIN pembayaran p ON p.id_iuran = i.id_iuran AND p.id_user = u.id_user
            WHERE ga.id_grup = '$id_grup'
            GROUP BY u.id_user
        ");
        $result = [];
        if($q && mysqli_num_rows($q) > 0) {
            while($row = mysqli_fetch_assoc($q)) {
                $result[] = $row;
            }
        }
        return $result;
    }

    public function getUsersNotInGrup($id_grup) {
        $id_grup = mysqli_real_escape_string($this->conn, $id_grup);
        $q = mysqli_query($this->conn, "SELECT id_user, nama FROM users WHERE id_user NOT IN (SELECT id_user FROM grup_anggota WHERE id_grup = '$id_grup')");
        $result = [];
        if($q && mysqli_num_rows($q) > 0) {
            while($row = mysqli_fetch_assoc($q)) {
                $result[] = $row;
            }
        }
        return $result;
    }

    public function getPemasukanGrup($id_grup) {
        $id_grup = mysqli_real_escape_string($this->conn, $id_grup);
        $q = mysqli_query($this->conn, "SELECT p.*, u.nama as nama_user FROM pemasukan_kas p LEFT JOIN users u ON p.id_user = u.id_user WHERE p.id_grup = '$id_grup' ORDER BY p.tanggal DESC");
        $result = [];
        if($q && mysqli_num_rows($q) > 0) {
            while($row = mysqli_fetch_assoc($q)) {
                $result[] = $row;
            }
        }
        return $result;
    }

    public function tambahPemasukanGrup($id_grup, $tanggal, $deskripsi, $nominal, $metode, $id_user) {
        $id_grup = mysqli_real_escape_string($this->conn, $id_grup);
        $tanggal = mysqli_real_escape_string($this->conn, $tanggal);
        $deskripsi = mysqli_real_escape_string($this->conn, $deskripsi);
        $nominal = mysqli_real_escape_string($this->conn, $nominal);
        $metode = mysqli_real_escape_string($this->conn, $metode);
        $id_user = !empty($id_user) ? "'" . mysqli_real_escape_string($this->conn, $id_user) . "'" : "NULL";
        
        mysqli_query($this->conn, "INSERT INTO pemasukan_kas (id_grup, tanggal, deskripsi, nominal, metode, id_user) VALUES ('$id_grup', '$tanggal', '$deskripsi', '$nominal', '$metode', $id_user)");
    }

    public function hapusPemasukanGrup($id_grup, $id_pemasukan) {
        $id_grup = mysqli_real_escape_string($this->conn, $id_grup);
        $id_pemasukan = mysqli_real_escape_string($this->conn, $id_pemasukan);
        mysqli_query($this->conn, "DELETE FROM pemasukan_kas WHERE id_pemasukan='$id_pemasukan' AND id_grup='$id_grup'");
    }

    public function getPengeluaranGrup($id_grup) {
        $id_grup = mysqli_real_escape_string($this->conn, $id_grup);
        $q = mysqli_query($this->conn, "SELECT * FROM pengeluaran WHERE id_grup = '$id_grup' ORDER BY tanggal_keluar DESC");
        $result = [];
        if($q && mysqli_num_rows($q) > 0) {
            while($row = mysqli_fetch_assoc($q)) {
                $result[] = $row;
            }
        }
        return $result;
    }

    public function tambahPengeluaranGrup($id_grup, $deskripsi, $nominal_keluar, $tanggal_keluar) {
        $id_grup = mysqli_real_escape_string($this->conn, $id_grup);
        $deskripsi = mysqli_real_escape_string($this->conn, $deskripsi);
        $nominal_keluar = mysqli_real_escape_string($this->conn, $nominal_keluar);
        $tanggal_keluar = mysqli_real_escape_string($this->conn, $tanggal_keluar);
        
        mysqli_query($this->conn, "INSERT INTO pengeluaran (id_grup, deskripsi, nominal_keluar, tanggal_keluar) VALUES ('$id_grup', '$deskripsi', '$nominal_keluar', '$tanggal_keluar')");
    }

    public function hapusPengeluaranGrup($id_grup, $id_pengeluaran) {
        $id_grup = mysqli_real_escape_string($this->conn, $id_grup);
        $id_pengeluaran = mysqli_real_escape_string($this->conn, $id_pengeluaran);
        mysqli_query($this->conn, "DELETE FROM pengeluaran WHERE id_pengeluaran='$id_pengeluaran' AND id_grup='$id_grup'");
    }

    public function getRingkasanKas($id_grup) {
        $id_grup = mysqli_real_escape_string($this->conn, $id_grup);
        
        $q1 = mysqli_query($this->conn, "SELECT SUM(nominal) as total FROM pemasukan_kas WHERE id_grup = '$id_grup'");
        $pemasukan_lain = mysqli_fetch_assoc($q1)['total'] ?? 0;

        $q2 = mysqli_query($this->conn, "SELECT SUM(nominal_keluar) as total FROM pengeluaran WHERE id_grup = '$id_grup'");
        $pengeluaran = mysqli_fetch_assoc($q2)['total'] ?? 0;

        return [
            'total_pemasukan_lain' => $pemasukan_lain,
            'total_pengeluaran' => $pengeluaran
        ];
    }

    public function getGrupByBendahara($id_bendahara) {
        $id_bendahara = mysqli_real_escape_string($this->conn, $id_bendahara);
        $q = mysqli_query($this->conn, "SELECT id_grup, nama_grup FROM grup WHERE id_bendahara = '$id_bendahara' ORDER BY id_grup DESC");
        $result = [];
        if($q && mysqli_num_rows($q) > 0) {
            while($row = mysqli_fetch_assoc($q)) {
                $result[] = $row;
            }
        }
        return $result;
    }

    public function getSaldoAwal($id_grup, $start_date) {
        $id_grup = mysqli_real_escape_string($this->conn, $id_grup);
        $start = mysqli_real_escape_string($this->conn, $start_date);
        
        $q1 = mysqli_query($this->conn, "SELECT SUM(i.nominal) as total FROM pembayaran p JOIN iuran i ON p.id_iuran = i.id_iuran WHERE i.id_grup = '$id_grup' AND p.status = 'Lunas' AND p.tanggal_bayar < '$start'");
        $masuk_iuran = mysqli_fetch_assoc($q1)['total'] ?? 0;
        
        $q2 = mysqli_query($this->conn, "SELECT SUM(nominal) as total FROM pemasukan_kas WHERE id_grup = '$id_grup' AND tanggal < '$start'");
        $masuk_lain = mysqli_fetch_assoc($q2)['total'] ?? 0;
        
        $q3 = mysqli_query($this->conn, "SELECT SUM(nominal_keluar) as total FROM pengeluaran WHERE id_grup = '$id_grup' AND tanggal_keluar < '$start'");
        $keluar = mysqli_fetch_assoc($q3)['total'] ?? 0;
        
        return ($masuk_iuran + $masuk_lain) - $keluar;
    }

    public function getBukuBesar($id_grup, $start_date = null, $end_date = null) {
        $id_grup = mysqli_real_escape_string($this->conn, $id_grup);
        
        $date_filter_pembayaran = "";
        $date_filter_pemasukan = "";
        $date_filter_pengeluaran = "";

        if (!empty($start_date) && !empty($end_date)) {
            $start = mysqli_real_escape_string($this->conn, $start_date);
            $end = mysqli_real_escape_string($this->conn, $end_date);
            $date_filter_pembayaran = " AND p.tanggal_bayar BETWEEN '$start' AND '$end'";
            $date_filter_pemasukan = " AND tanggal BETWEEN '$start' AND '$end'";
            $date_filter_pengeluaran = " AND tanggal_keluar BETWEEN '$start' AND '$end'";
        }

        $sql = "
            SELECT p.tanggal_bayar as tanggal, CONCAT('Iuran: ', i.nama_iuran, ' (', u.nama, ')') as deskripsi, i.nominal as masuk, 0 as keluar 
            FROM pembayaran p 
            JOIN iuran i ON p.id_iuran = i.id_iuran 
            JOIN users u ON p.id_user = u.id_user 
            WHERE i.id_grup = '$id_grup' AND p.status = 'Lunas' $date_filter_pembayaran
            
            UNION ALL
            
            SELECT tanggal, CONCAT('Pemasukan: ', deskripsi) as deskripsi, nominal as masuk, 0 as keluar 
            FROM pemasukan_kas 
            WHERE id_grup = '$id_grup' $date_filter_pemasukan
            
            UNION ALL
            
            SELECT tanggal_keluar as tanggal, CONCAT('Pengeluaran: ', deskripsi) as deskripsi, 0 as masuk, nominal_keluar as keluar 
            FROM pengeluaran 
            WHERE id_grup = '$id_grup' $date_filter_pengeluaran
            
            ORDER BY tanggal ASC
        ";
        $q = mysqli_query($this->conn, $sql);
        $result = [];
        if($q && mysqli_num_rows($q) > 0) {
            while($row = mysqli_fetch_assoc($q)) {
                $result[] = $row;
            }
        }
        return $result;
    }
}
?>