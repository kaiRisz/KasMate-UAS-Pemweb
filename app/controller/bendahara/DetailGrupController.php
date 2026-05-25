<?php
require_once '../../../config/auth_check.php';
require_once '../../model/bendahara/BendaharaGrupModel.php';

cekRole('bendahara');

$id_user = $_SESSION['id_user'];
$grupModel = new BendaharaGrupModel($conn);

$id_grup = isset($_GET['id']) ? $_GET['id'] : null;
$tab = isset($_GET['tab']) ? $_GET['tab'] : 'pembayaran';

if (!$id_grup) {
    $last_id = $grupModel->getLastGrupId();
    if ($last_id) {
        $id_grup = $last_id;
    } else {
        echo "<script>alert('Anda belum membuat grup iuran apapun!'); window.location.href='GrupIuranController.php';</script>";
        exit();
    }
}

$grup_info = $grupModel->getGrupById($id_grup);
if (!$grup_info) {
    echo "<script>alert('Grup tidak ditemukan!'); window.location.href='GrupIuranController.php';</script>";
    exit();
}
$nama_grup = $grup_info['nama_grup'];

$nama_bendahara = $_SESSION['user_login']['nama'] ?? 'Bendahara';

if (isset($_POST['tambah_anggota'])) {
    $grupModel->tambahAnggota($id_grup, $_POST['id_user_baru']);
    header("Location: DetailGrupController.php?id=$id_grup&tab=anggota");
    exit();
}

if (isset($_GET['hapus_anggota'])) {
    $grupModel->hapusAnggota($id_grup, $_GET['hapus_anggota']);
    header("Location: DetailGrupController.php?id=$id_grup&tab=anggota");
    exit();
}

if (isset($_POST['tambah_tagihan'])) {
    $grupModel->tambahTagihan($id_grup, $_POST['nama_iuran'], $_POST['nominal']);
    header("Location: DetailGrupController.php?id=$id_grup&tab=tagihan");
    exit();
}

if (isset($_GET['hapus_tagihan'])) {
    $grupModel->hapusTagihan($id_grup, $_GET['hapus_tagihan']);
    header("Location: DetailGrupController.php?id=$id_grup&tab=tagihan");
    exit();
}

if (isset($_POST['bayar_tagihan'])) {
    $grupModel->bayarTagihan($_POST['id_user_bayar'], $_POST['id_iuran_bayar']);

mysqli_query($conn, "INSERT INTO p_pemasukan_temp (keterangan) VALUES ('Bayar')"); 
    
    header("Location: DetailGrupController.php?id=$id_grup&tab=pembayaran");
    exit();
}

$data_tagihan = $grupModel->getRingkasanTagihan($id_grup);
$total_tagihan = $data_tagihan['total_tagihan'] ?? 0;
$total_lunas = $data_tagihan['total_lunas'] ?? 0;
$total_belum = $data_tagihan['total_belum'] ?? 0;

$persen_lunas = $total_tagihan > 0 ? round(($total_lunas / $total_tagihan) * 100, 1) : 0;
$persen_belum = $total_tagihan > 0 ? round(($total_belum / $total_tagihan) * 100, 1) : 0;

$anggota_grup = $grupModel->getAnggotaGrup($id_grup);
$tagihan_grup = $grupModel->getTagihanGrup($id_grup);
$pembayaran_grup = $grupModel->getPembayaranGrup($id_grup);
$status_pembayaran_anggota = $grupModel->getStatusPembayaranAnggota($id_grup);
$users_not_in_grup = $grupModel->getUsersNotInGrup($id_grup);

require_once '../../view/bendahara/detail-grup.php';
?>
