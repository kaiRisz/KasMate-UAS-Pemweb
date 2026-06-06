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
    $grupModel->tambahTagihan($id_grup, $_POST['nama_iuran'], $_POST['nominal'], $_POST['deadline']);
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
    header("Location: DetailGrupController.php?id=$id_grup&tab=pembayaran");
    exit();
}

if (isset($_GET['setujui_pembayaran'])) {
    $grupModel->verifikasiPembayaran($_GET['setujui_pembayaran'], 'Lunas');
    header("Location: DetailGrupController.php?id=$id_grup&tab=pembayaran");
    exit();
}

if (isset($_GET['tolak_pembayaran'])) {
    $grupModel->verifikasiPembayaran($_GET['tolak_pembayaran'], 'Ditolak');
    header("Location: DetailGrupController.php?id=$id_grup&tab=pembayaran");
    exit();
}

if (isset($_POST['tambah_pemasukan'])) {
    $grupModel->tambahPemasukanGrup($id_grup, $_POST['tanggal'], $_POST['deskripsi'], $_POST['nominal'], $_POST['metode'], $_POST['id_user']);
    header("Location: DetailGrupController.php?id=$id_grup&tab=pemasukan");
    exit();
}

if (isset($_GET['hapus_pemasukan'])) {
    $grupModel->hapusPemasukanGrup($id_grup, $_GET['hapus_pemasukan']);
    header("Location: DetailGrupController.php?id=$id_grup&tab=pemasukan");
    exit();
}

if (isset($_POST['tambah_pengeluaran'])) {
    $grupModel->tambahPengeluaranGrup($id_grup, $_POST['deskripsi'], $_POST['nominal_keluar'], $_POST['tanggal_keluar']);
    header("Location: DetailGrupController.php?id=$id_grup&tab=pengeluaran");
    exit();
}

if (isset($_GET['hapus_pengeluaran'])) {
    $grupModel->hapusPengeluaranGrup($id_grup, $_GET['hapus_pengeluaran']);
    header("Location: DetailGrupController.php?id=$id_grup&tab=pengeluaran");
    exit();
}

if (isset($_POST['simpan_pengaturan_pembayaran'])) {
    $bank = $_POST['rekening_bank'];
    $nomor = $_POST['rekening_nomor'];
    $nama = $_POST['rekening_nama'];
    $qris_image = null;

    if (isset($_FILES['qris_image']) && $_FILES['qris_image']['error'] == 0) {
        $target_dir = "../../../public/assets/uploads/qris/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_extension = pathinfo($_FILES["qris_image"]["name"], PATHINFO_EXTENSION);
        $file_name = "qris_" . $id_grup . "_" . time() . "." . $file_extension;
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["qris_image"]["tmp_name"], $target_file)) {
            $qris_image = $file_name;
        }
    }

    $grupModel->updatePengaturanPembayaran($id_grup, $bank, $nomor, $nama, $qris_image);
    header("Location: DetailGrupController.php?id=$id_grup&tab=pengaturan_pembayaran");
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
$pemasukan_grup = $grupModel->getPemasukanGrup($id_grup);
$pengeluaran_grup = $grupModel->getPengeluaranGrup($id_grup);

// Menghitung Saldo Kas Tersedia
$ringkasan_kas = $grupModel->getRingkasanKas($id_grup);
$total_pemasukan_lain = $ringkasan_kas['total_pemasukan_lain'];
$total_pengeluaran_kas = $ringkasan_kas['total_pengeluaran'];
$total_kas_masuk = $total_lunas + $total_pemasukan_lain;
$saldo_tersedia = $total_kas_masuk - $total_pengeluaran_kas;

require_once '../../view/bendahara/detail-grup.php';
?>