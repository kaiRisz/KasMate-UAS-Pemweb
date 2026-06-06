<?php
require_once '../../../config/auth_check.php';
require_once '../../model/bendahara/BendaharaGrupModel.php';

cekRole('bendahara');

$id_user = $_SESSION['id_user'];
$nama_bendahara = $_SESSION['user_login']['nama'] ?? 'Bendahara';
$grupModel = new BendaharaGrupModel($conn);

$daftar_grup = $grupModel->getGrupByBendahara($id_user);
$selected_grup = isset($_GET['id_grup']) ? $_GET['id_grup'] : (!empty($daftar_grup) ? $daftar_grup[0]['id_grup'] : null);

$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

$buku_besar = [];
$nama_grup_terpilih = "";
$total_masuk = 0;
$total_keluar = 0;
$saldo_awal = 0;

if ($selected_grup) {
    $grup_info = $grupModel->getGrupById($selected_grup);
    if($grup_info) {
        $nama_grup_terpilih = $grup_info['nama_grup'];
        $buku_besar = $grupModel->getBukuBesar($selected_grup, $start_date, $end_date);
        
        if (!empty($start_date)) {
            $saldo_awal = $grupModel->getSaldoAwal($selected_grup, $start_date);
        }
    }
}

require_once '../../view/bendahara/laporan-keuangan.php';
?>