<?php
require_once '../../../config/auth_check.php';
require_once '../../model/user/TagihanUserModel.php';

cekRole('user');

$id_user = $_SESSION['id_user'];
$nama_user = $_SESSION['user_login']['nama'] ?? 'User';

$tagihanModel = new TagihanUserModel($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['proses_bayar'])) {
    $id_iuran = (int)$_POST['id_iuran'];
    $metode = $_POST['metode_pembayaran']; 
    $bukti_nama = null;

    if ($metode === 'Transfer' && isset($_FILES['bukti_pembayaran']) && $_FILES['bukti_pembayaran']['error'] === 0) {
        $target_dir = "../../../public/assets/uploads/bukti_tf/";
        
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_extension = pathinfo($_FILES["bukti_pembayaran"]["name"], PATHINFO_EXTENSION);
        $bukti_nama = "tf_" . $id_user . "_" . $id_iuran . "_" . time() . "." . $file_extension;
        move_uploaded_file($_FILES["bukti_pembayaran"]["tmp_name"], $target_dir . $bukti_nama);
    }

    $tagihanModel->prosesPembayaran($id_user, $id_iuran, $metode, $bukti_nama);
    header("Location: TagihanUserController.php");
    exit();
}

$query_all_tagihan = mysqli_query($conn, "
    SELECT g.id_grup, g.nama_grup, g.rekening_bank, g.rekening_nomor, g.rekening_nama, g.qris_image, 
           i.id_iuran, i.nama_iuran, i.nominal, i.deadline,
           COALESCE(p.status, 'Belum Lunas') AS status_bayar 
    FROM iuran i 
    JOIN grup g ON i.id_grup = g.id_grup 
    JOIN grup_anggota ga ON g.id_grup = ga.id_grup 
    LEFT JOIN pembayaran p ON i.id_iuran = p.id_iuran AND p.id_user = ga.id_user 
    WHERE ga.id_user = $id_user
    ORDER BY i.id_iuran DESC
");

$tagihan_list = [];
$total_tagihan = 0;
$sudah_bayar = 0;
$belum_bayar = 0;

while ($row = mysqli_fetch_assoc($query_all_tagihan)) {
    $tagihan_list[] = $row;
    $total_tagihan += $row['nominal'];
    
    if ($row['status_bayar'] === 'Lunas') {
        $sudah_bayar += $row['nominal'];
    } else {
        $belum_bayar += $row['nominal'];
    }
}

require_once '../../view/user/tagihan-saya.php';
?>