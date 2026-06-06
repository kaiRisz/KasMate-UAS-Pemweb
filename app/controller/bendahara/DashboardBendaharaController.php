<?php
require_once '../../../config/auth_check.php';
require_once '../../model/bendahara/BendaharaGrupModel.php';

cekRole('bendahara');

$id_user = $_SESSION['id_user'];
$nama_bendahara = $_SESSION['user_login']['nama'] ?? 'Bendahara';

$q_grup = mysqli_query($conn, "SELECT COUNT(*) as total FROM grup WHERE id_bendahara = '$id_user'");
$total_grup = mysqli_fetch_assoc($q_grup)['total'] ?? 0;

$q_anggota = mysqli_query($conn, "SELECT COUNT(DISTINCT ga.id_user) as total FROM grup_anggota ga JOIN grup g ON ga.id_grup = g.id_grup WHERE g.id_bendahara = '$id_user'");
$total_anggota = mysqli_fetch_assoc($q_anggota)['total'] ?? 0;

$q_pending_count = mysqli_query($conn, "SELECT COUNT(*) as total FROM pembayaran p JOIN iuran i ON p.id_iuran = i.id_iuran JOIN grup g ON i.id_grup = g.id_grup WHERE g.id_bendahara = '$id_user' AND p.status = 'Menunggu Verifikasi'");
$total_pending = mysqli_fetch_assoc($q_pending_count)['total'] ?? 0;

$q_trx = mysqli_query($conn, "
    SELECT SUM(jml) as total FROM (
        SELECT COUNT(*) as jml FROM pembayaran p JOIN iuran i ON p.id_iuran = i.id_iuran JOIN grup g ON i.id_grup = g.id_grup WHERE g.id_bendahara = '$id_user' AND p.status = 'Lunas'
        UNION ALL
        SELECT COUNT(*) as jml FROM pemasukan_kas pk JOIN grup g ON pk.id_grup = g.id_grup WHERE g.id_bendahara = '$id_user'
    ) as trx
");
$total_trx = mysqli_fetch_assoc($q_trx)['total'] ?? 0;

$q_pending_list = mysqli_query($conn, "SELECT p.id_pembayaran, u.nama as nama_user, i.nama_iuran, i.nominal, g.nama_grup, g.id_grup, p.tanggal_bayar, p.metode_pembayaran FROM pembayaran p JOIN users u ON p.id_user = u.id_user JOIN iuran i ON p.id_iuran = i.id_iuran JOIN grup g ON i.id_grup = g.id_grup WHERE g.id_bendahara = '$id_user' AND p.status = 'Menunggu Verifikasi' ORDER BY p.tanggal_bayar ASC LIMIT 5");
$list_pending = [];
if($q_pending_list) {
    while($r = mysqli_fetch_assoc($q_pending_list)) {
        $list_pending[] = $r;
    }
}

$q_riwayat = mysqli_query($conn, "
    SELECT u.nama as nama_user, CONCAT('Iuran: ', i.nama_iuran) as deskripsi, i.nominal, p.tanggal_bayar as tanggal, g.nama_grup 
    FROM pembayaran p 
    JOIN users u ON p.id_user = u.id_user 
    JOIN iuran i ON p.id_iuran = i.id_iuran 
    JOIN grup g ON i.id_grup = g.id_grup 
    WHERE g.id_bendahara = '$id_user' AND p.status = 'Lunas'
    UNION ALL
    SELECT u.nama as nama_user, CONCAT('Kas: ', pk.deskripsi) as deskripsi, pk.nominal, pk.tanggal as tanggal, g.nama_grup 
    FROM pemasukan_kas pk 
    LEFT JOIN users u ON pk.id_user = u.id_user 
    JOIN grup g ON pk.id_grup = g.id_grup 
    WHERE g.id_bendahara = '$id_user'
    ORDER BY tanggal DESC LIMIT 6
");
$list_riwayat = [];
if($q_riwayat) {
    while($r = mysqli_fetch_assoc($q_riwayat)) {
        $list_riwayat[] = $r;
    }
}

require_once '../../view/bendahara/dashboard-bendahara.php';
?>