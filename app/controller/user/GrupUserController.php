<?php
require_once '../../../config/auth_check.php';
cekRole('user');

$id_user = $_SESSION['id_user'];
$nama_user = $user_login['nama'] ?? 'User';

// Perbaikan: Pakai LEFT JOIN untuk users dan COALESCE
$query_grup = mysqli_query($conn, "
    SELECT g.id_grup, g.nama_grup, g.deskripsi, COALESCE(u.nama, 'Belum Ada') AS nama_bendahara 
    FROM grup_anggota ga 
    JOIN grup g ON ga.id_grup = g.id_grup 
    LEFT JOIN users u ON g.id_bendahara = u.id_user 
    WHERE ga.id_user = $id_user
");

$grup_list = [];
while ($row = mysqli_fetch_assoc($query_grup)) {
    $grup_list[] = $row;
}

$selected_grup_id = isset($_GET['id_grup']) ? (int)$_GET['id_grup'] : (!empty($grup_list) ? $grup_list[0]['id_grup'] : 0);

$detail_grup = null;
$grup_tagihan_list = [];

if ($selected_grup_id > 0) {
    // Perbaikan: Pakai LEFT JOIN untuk detail grup juga
    $query_detail = mysqli_query($conn, "
        SELECT g.nama_grup, g.deskripsi, COALESCE(u.nama, 'Belum Ada') AS nama_bendahara, 
        (SELECT COUNT(*) FROM grup_anggota WHERE id_grup = g.id_grup) AS jml_anggota 
        FROM grup g 
        LEFT JOIN users u ON g.id_bendahara = u.id_user 
        WHERE g.id_grup = $selected_grup_id
    ");
    $detail_grup = mysqli_fetch_assoc($query_detail);

    $query_grup_tagihan = mysqli_query($conn, "SELECT i.nama_iuran, i.nominal, COALESCE(p.status, 'Belum Lunas') AS status_bayar FROM iuran i LEFT JOIN pembayaran p ON i.id_iuran = p.id_iuran AND p.id_user = $id_user WHERE i.id_grup = $selected_grup_id");
    while ($t = mysqli_fetch_assoc($query_grup_tagihan)) {
        $grup_tagihan_list[] = $t;
    }
}

require_once '../../view/user/grup-saya.php';
?>