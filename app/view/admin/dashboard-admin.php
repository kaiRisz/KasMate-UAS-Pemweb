<?php

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KasMate - Dashboard Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/assets/css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            <nav class="sidebar-menu">
                <div class="menu-section">
                    <a href="../../controller/admin/DashboardAdminController.php" class="menu-item active">
                        <i class='bx bxs-dashboard'></i> Dashboard
                    </a>
                    <a href="../../controller/admin/ManajemenUserController.php" class="menu-item">
                        <i class='bx bxs-user-account'></i> Manajemen User
                    </a>
                    <a href="../../controller/admin/ManajemenGrupController.php" class="menu-item">
                        <i class='bx bxs-group'></i> Manajemen Grup
                    </a>
                    <a href="../../controller/admin/PengaturanController.php" class="menu-item">
                        <i class='bx bxs-cog'></i> Pengaturan Sistem
                    </a>
                </div>
                <div class="sidebar-bottom">
                    <a href="../../controller/auth/LogoutController.php" class="menu-item">
                        <i class='bx bx-log-out'></i> Logout
                    </a>
                </div>
            </nav>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <div class="header-text">
                    <h1>Dashboard Admin</h1>
                    <p class="subtitle">Ringkasan informasi sistem secara keseluruhan</p>
                </div>
                <div class="header-right">
                    <button class="btn-notification"><i class='bx bx-bell'></i></button>
                    <div class="user-profile">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($user_login['nama']) ?>&background=e2e8f0&color=475569" alt="<?= htmlspecialchars($user_login['nama']) ?>">
                        <div class="user-info">
                            <span class="user-name"><?= htmlspecialchars($user_login['nama']) ?></span>
                            <span class="user-role">Administrator</span>
                        </div>
                    </div>
                </div>
            </header>

            <section class="overview-cards">
                <div class="card">
                    <p class="stat-title">Total User</p>
                    <div class="stat-header">
                        <h2><?= number_format($total_user) ?></h2>
                    </div>
                    <p class="stat-desc text-green">Pengguna terdaftar</p>
                </div>
                <div class="card">
                    <p class="stat-title">Total Grup</p>
                    <div class="stat-header">
                        <h2><?= number_format($total_grup) ?></h2>
                    </div>
                    <p class="stat-desc text-green">Grup terdaftar</p>
                </div>
                <div class="card">
                    <p class="stat-title">Total Transaksi</p>
                    <div class="stat-header">
                        <h2><?= number_format($total_trx) ?></h2>
                    </div>
                    <p class="stat-desc text-green">Transaksi tercatat</p>
                </div>
                <div class="card">
                    <p class="stat-title">Total Saldo</p>
                    <div class="stat-header">
                        <h2>Rp <?= number_format($total_saldo, 0, ',', '.') ?></h2>
                    </div>
                    <p class="stat-desc">Pemasukan - Pengeluaran</p>
                </div>
            </section>

                    <div class="cash-flow-cards">
                        <div class="cash-flow-box">
                            <p class="stat-desc">Total Pemasukan</p>
                            <h4>Rp <?= number_format($total_pemasukan, 0, ',', '.') ?></h4>
                        </div>
                        <div class="cash-flow-box">
                            <p class="stat-desc">Total Pengeluaran</p>
                            <h4>Rp <?= number_format($total_pengeluaran, 0, ',', '.') ?></h4>
                        </div>
                        <div class="cash-flow-box">
                            <p class="stat-desc">Saldo Bersih</p>
                            <h4>Rp <?= number_format($total_saldo, 0, ',', '.') ?></h4>
                        </div>
                    </div>

                <div class="card flex-1">
                    <h3 class="card-title">Aktivitas Terbaru</h3>
                    <div class="activity-list">
                        <?php if (count($q_aktivitas) > 0): ?>
                            <?php foreach ($q_aktivitas as $akt): ?>
                                <div class="activity-item">
                                    <div class="activity-user">
                                        <strong><?= htmlspecialchars($akt['nama_user']) ?></strong>
                                        <span><?= htmlspecialchars($akt['aktivitas']) ?></span>
                                    </div>
                                    <span class="activity-time"><?= date('d M', strtotime($akt['tanggal'])) ?></span>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="stat-desc" style="text-align: center; padding: 20px;">Belum ada aktivitas</p>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </main>
    </div>

</body>
</html>