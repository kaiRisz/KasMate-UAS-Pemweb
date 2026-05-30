<?php

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
    <input type="checkbox" id="menu-toggle" class="menu-checkbox">
    <div class="topbar-mobile">
        <label for="menu-toggle" class="hamburger-btn">
            <i class="fa-solid fa-bars"></i>
        </label>
        <div class="logo-mobile">
            <i class="fa-solid fa-cube"></i> KasMate
        </div>
    </div>
    <label for="menu-toggle" class="sidebar-overlay"></label>

    <div class="dashboard-layout">
        <aside class="sidebar">
            <div class="logo">
                <i class="fa-solid fa-cube"></i>
                <span>KasMate</span>
            </div>
            <div class="sidebar-menu">
                <a href="../../controller/bendahara/DashboardBendaharaController.php" class="menu-item"><i class="fa-solid fa-border-all"></i> Dashboard</a>
                <div class="menu-section">
                    <p class="section-title">KELOLA IURAN</p>
                    <a href="../../controller/bendahara/GrupIuranController.php" class="menu-item"><i class="fa-solid fa-users-line"></i> Grup Iuran</a>
                </div>
                <div class="menu-section">
                    <p class="section-title">KEUANGAN</p>
                    <a href="../../controller/bendahara/PemasukanController.php" class="menu-item"><i class="fa-solid fa-clock-rotate-left"></i> Pemasukan</a>
                    <a href="../../controller/bendahara/PengeluaranController.php" class="menu-item"><i class="fa-regular fa-eye"></i> Pengeluaran</a>
                </div>
                <div class="menu-section">
                    <p class="section-title">LAPORAN</p>
                    <a href="../../controller/bendahara/LaporanKeuanganController.php" class="menu-item active"><i class="fa-regular fa-file-lines"></i> Laporan Keuangan</a>
                </div>
                <div class="sidebar-bottom">
                    <a href="../../controller/bendahara/LogoutController.php" class="menu-item">
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