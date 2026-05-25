<?php
session_start();
require_once '../../../config/database.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'bendahara') {
    header("Location: ../auth/login.php");
    exit();
}

$id_user = $_SESSION['id_user'];

$user_q = mysqli_query($conn, "SELECT nama FROM users WHERE id_user = '$id_user'");
$nama_bendahara = mysqli_fetch_assoc($user_q)['nama'];

$masuk_query = mysqli_query($conn, "SELECT SUM(i.nominal) as total, COUNT(*) as jml_transaksi FROM pembayaran p JOIN iuran i ON p.id_iuran = i.id_iuran JOIN grup g ON i.id_grup = g.id_grup WHERE g.id_bendahara = '$id_user' AND p.status = 'Lunas'");
$data_masuk = mysqli_fetch_assoc($masuk_query);
$total_masuk = $data_masuk['total'] ?? 0;
$trx_masuk = $data_masuk['jml_transaksi'] ?? 0;

$keluar_query = mysqli_query($conn, "SELECT SUM(pe.nominal_keluar) as total, COUNT(*) as jml_transaksi FROM pengeluaran pe JOIN grup g ON pe.id_grup = g.id_grup WHERE g.id_bendahara = '$id_user'");
$data_keluar = mysqli_fetch_assoc($keluar_query);
$total_keluar = $data_keluar['total'] ?? 0;
$trx_keluar = $data_keluar['jml_transaksi'] ?? 0;

$saldo_akhir = $total_masuk - $total_keluar;
$total_transaksi = $trx_masuk + $trx_keluar;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KasMate - Laporan Keuangan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../../public/assets/css/style.css">
</head>
<body>
    <div class="dashboard-layout">
        <aside class="sidebar">
            <div class="logo">
                <i class="fa-solid fa-cube"></i>
                <span>KasMate</span>
            </div>
            <div class="sidebar-menu">
                <a href="dashboard-bendahara.php" class="menu-item"><i class="fa-solid fa-border-all"></i> Dashboard</a>
                <div class="menu-section">
                    <p class="section-title">KELOLA IURAN</p>
                    <a href="grup-iuran.php" class="menu-item"><i class="fa-solid fa-users-line"></i> Grup Iuran</a>
                    <a href="detail-grup.php" class="menu-item"><i class="fa-solid fa-user-group"></i> Detail Grup</a>
                </div>
                <div class="menu-section">
                    <p class="section-title">KEUANGAN</p>
                    <a href="pemasukan.php" class="menu-item"><i class="fa-solid fa-clock-rotate-left"></i> Pemasukan</a>
                    <a href="pengeluaran.php" class="menu-item"><i class="fa-regular fa-eye"></i> Pengeluaran</a>
                </div>
                <div class="menu-section">
                    <p class="section-title">LAPORAN</p>
                    <a href="laporan-keuangan.php" class="menu-item active"><i class="fa-regular fa-file-lines"></i> Laporan Keuangan</a>
                </div>
                <div class="sidebar-bottom">
                    <a href="logout.php" class="menu-item">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </a>
                </div>
            </div>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <div class="header-text">
                    <h1>Laporan Keuangan</h1>
                    <p class="subtitle">Ringkasan pemasukan dan pengeluaran kas.</p>
                </div>
                <div class="header-right">
                    <button class="btn-notification"><i class="fa-regular fa-bell"></i></button>
                    <div class="user-profile">
                        <img src="../../../public/assets/image/user_pict.jpg" alt="Profile" style="width: 32px; height: 32px; border-radius: 50%;">
                        <div class="user-info">
                            <span class="user-name"><?php echo htmlspecialchars($nama_bendahara); ?></span>
                            <span class="user-role">Bendahara Utama</span>
                        </div>
                    </div>
                </div>
            </header>

            <section class="overview-cards">
                <div class="card stat-card">
                    <div><i class="fa-solid fa-arrow-trend-up"></i></div>
                    <div>
                        <p>Total Pemasukan</p>
                        <h2 class="text-green">Rp <?php echo number_format($total_masuk, 0, ',', '.'); ?></h2>
                    </div>
                </div>
                <div class="card stat-card">
                    <div><i class="fa-solid fa-arrow-trend-down"></i></div>
                    <div>
                        <p>Total Pengeluaran</p>
                        <h2 class="text-red">Rp <?php echo number_format($total_keluar, 0, ',', '.'); ?></h2>
                    </div>
                </div>
                <div class="card stat-card">
                    <div><i class="fa-solid fa-wallet"></i></div>
                    <div>
                        <p>Saldo Akhir</p>
                        <h2>Rp <?php echo number_format($saldo_akhir, 0, ',', '.'); ?></h2>
                    </div>
                </div>
                <div class="card stat-card">
                    <div><i class="fa-solid fa-file-invoice"></i></div>
                    <div>
                        <p>Total Transaksi</p>
                        <h2><?php echo $total_transaksi; ?></h2>
                    </div>
                </div>
            </section>

            <section class="card table-card">
                <div class="table-controls">
                    <h3 class="card-title" style="margin-bottom: 0;">Rincian Laporan (Keseluruhan)</h3>
                    <button class="btn-action"><i class="fa-solid fa-download"></i> Unduh PDF</button>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Keterangan</th>
                            <th>Masuk</th>
                            <th>Keluar</th>
                            <th>Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-500">Total Pemasukan Iuran</td>
                            <td class="text-green fw-500">Rp <?php echo number_format($total_masuk, 0, ',', '.'); ?></td>
                            <td>-</td>
                            <td class="fw-500">Rp <?php echo number_format($total_masuk, 0, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <td class="fw-500">Total Pengeluaran Operasional</td>
                            <td>-</td>
                            <td class="text-red fw-500">Rp <?php echo number_format($total_keluar, 0, ',', '.'); ?></td>
                            <td class="fw-500">Rp <?php echo number_format($saldo_akhir, 0, ',', '.'); ?></td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>