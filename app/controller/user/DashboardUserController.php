<?php
require_once '../../../config/auth_check.php';
cekRole('user');

$id_user = $_SESSION['id_user'];
$nama_user = $user_login['nama'] ?? 'User';

$query_total = mysqli_query($conn, "
    SELECT SUM(i.nominal) AS total 
    FROM iuran i 
    JOIN grup_anggota ga ON i.id_grup = ga.id_grup 
    WHERE ga.id_user = $id_user
");
$total_tagihan = mysqli_fetch_assoc($query_total)['total'] ?? 0;

$query_lunas = mysqli_query($conn, "
    SELECT SUM(i.nominal) AS total 
    FROM pembayaran p 
    JOIN iuran i ON p.id_iuran = i.id_iuran 
    WHERE p.id_user = $id_user AND p.status = 'Lunas'
");
$sudah_bayar = mysqli_fetch_assoc($query_lunas)['total'] ?? 0;

$belum_bayar = $total_tagihan - $sudah_bayar;

$query_tagihan = mysqli_query($conn, "
    SELECT g.nama_grup, i.nama_iuran, i.nominal,
    COALESCE(p.status, 'Belum Lunas') AS status_bayar
    FROM iuran i
    JOIN grup g ON i.id_grup = g.id_grup
    JOIN grup_anggota ga ON g.id_grup = ga.id_grup
    LEFT JOIN pembayaran p 
        ON i.id_iuran = p.id_iuran AND p.id_user = ga.id_user
    WHERE ga.id_user = $id_user
    LIMIT 4
");

$tagihan_list = [];
if ($query_tagihan) {
    while ($row = mysqli_fetch_assoc($query_tagihan)) {
        $tagihan_list[] = $row;
    }
}

require_once '../../view/user/dashboard-user.php';
?>