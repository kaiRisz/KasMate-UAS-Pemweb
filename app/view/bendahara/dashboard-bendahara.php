<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KasMate - Dashboard Bendahara</title>
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
                <a href="../../controller/bendahara/DashboardBendaharaController.php" class="menu-item active">
                    <i class="fa-solid fa-border-all"></i> Dashboard
                </a>
                <div class="menu-section">
                    <p class="section-title">KELOLA IURAN</p>
                    <a href="../../controller/bendahara/GrupIuranController.php" class="menu-item"><i class="fa-solid fa-users-line"></i> Grup Iuran</a>
                </div>
                
                <div class="menu-section">
                    <p class="section-title">LAPORAN</p>
                    <a href="../../controller/bendahara/LaporanKeuanganController.php" class="menu-item"><i class="fa-regular fa-file-lines"></i> Laporan Keuangan</a>
                </div>
                <div class="sidebar-bottom sidebar-footer-menu">
                    <a href="../../controller/auth/LogoutController.php" class="menu-item">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </a>
                </div>
            </div>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <div class="header-text">
                    <h1>Dashboard Bendahara</h1>
                    <p class="welcome-text">Halo, <?php echo htmlspecialchars($nama_bendahara); ?> 👋</p>
                    <p class="subtitle">Pantau aktivitas dan tugas Anda hari ini.</p>
                </div>
                <div class="header-right">
                    <button class="btn-notification"><i class="fa-regular fa-bell"></i></button>
                    <div class="user-profile">
                        <img src="../../../public/assets/image/user_pict.jpg" alt="Profile">
                        <div class="user-info">
                            <span class="user-name"><?php echo htmlspecialchars($nama_bendahara); ?></span>
                            <span class="user-role">Bendahara Utama</span>
                        </div>
                    </div>
                </div>
            </header>

            <section class="overview-cards">
                <div class="card stat-card">
                    <div><i class="fa-solid fa-users-rectangle text-blue"></i></div>
                    <div>
                        <p>Grup Dikelola</p>
                        <h2><?php echo $total_grup; ?></h2>
                    </div>
                </div>
                <div class="card stat-card">
                    <div><i class="fa-solid fa-user-group text-green"></i></div>
                    <div>
                        <p>Total Anggota</p>
                        <h2><?php echo $total_anggota; ?></h2>
                    </div>
                </div>
                <div class="card stat-card">
                    <div><i class="fa-solid fa-clock-rotate-left text-orange"></i></div>
                    <div>
                        <p>Perlu Verifikasi</p>
                        <h2><?php echo $total_pending; ?></h2>
                    </div>
                </div>
                <div class="card stat-card">
                    <div><i class="fa-solid fa-file-invoice text-red"></i></div>
                    <div>
                        <p>Transaksi Selesai</p>
                        <h2><?php echo $total_trx; ?></h2>
                    </div>
                </div>
            </section>

            <section class="charts-section">
                <div class="card flex-2">
                    <h3 class="card-title">Tugas Menunggu Verifikasi</h3>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Grup</th>
                                <th>Anggota</th>
                                <th>Iuran</th>
                                <th>Nominal</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($list_pending) > 0): ?>
                                <?php foreach($list_pending as $p): ?>
                                <tr>
                                    <td class="fw-500"><?php echo htmlspecialchars($p['nama_grup']); ?></td>
                                    <td><?php echo htmlspecialchars($p['nama_user']); ?></td>
                                    <td><?php echo htmlspecialchars($p['nama_iuran']); ?></td>
                                    <td class="text-green fw-500">Rp <?php echo number_format($p['nominal'], 0, ',', '.'); ?></td>
                                    <td class="text-center">
                                        <a href="../../controller/bendahara/DetailGrupController.php?id=<?php echo $p['id_grup']; ?>&tab=pembayaran" class="btn-action btn-kelola">Cek Bukti</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada pembayaran yang perlu diverifikasi saat ini.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="card flex-1">
                    <h3 class="card-title">Riwayat Transaksi Terbaru</h3>
                    <div class="activity-list">
                        <?php if (count($list_riwayat) > 0): ?>
                            <?php foreach ($list_riwayat as $r): ?>
                                <div class="activity-item">
                                    <div class="activity-user">
                                        <strong><?php echo htmlspecialchars($r['nama_user'] ?? 'Pemasukan Kas'); ?></strong>
                                        <span><?php echo htmlspecialchars($r['deskripsi']); ?> (<?php echo htmlspecialchars($r['nama_grup']); ?>)</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-green fw-600 block-element mb-5">+<?php echo number_format($r['nominal'], 0, ',', '.'); ?></span>
                                        <span class="activity-time"><?php echo date('d M', strtotime($r['tanggal'])); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="stat-desc empty-state-msg">Belum ada transaksi</p>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>