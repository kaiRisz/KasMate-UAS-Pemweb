<?php
require_once '../../../config/auth_check.php';
cekRole('admin');

$q_total_user = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
$total_user = mysqli_fetch_assoc($q_total_user)['total'];

$q_total_grup = mysqli_query($conn, "SELECT COUNT(*) as total FROM grup");
$total_grup = mysqli_fetch_assoc($q_total_grup)['total'];

$q_masuk_iuran = mysqli_query($conn, "SELECT COALESCE(SUM(i.nominal), 0) as total FROM pembayaran p JOIN iuran i ON p.id_iuran = i.id_iuran WHERE p.status = 'Lunas'");
$total_masuk_iuran = mysqli_fetch_assoc($q_masuk_iuran)['total'];

$q_masuk_manual = mysqli_query($conn, "SELECT COALESCE(SUM(nominal), 0) as total FROM pemasukan_kas");
$total_masuk_manual = mysqli_fetch_assoc($q_masuk_manual)['total'];

$total_pemasukan = $total_masuk_iuran + $total_masuk_manual;

$q_pengeluaran = mysqli_query($conn, "SELECT COALESCE(SUM(nominal_keluar), 0) as total FROM pengeluaran");
$total_pengeluaran = mysqli_fetch_assoc($q_pengeluaran)['total'];

$total_saldo = $total_pemasukan - $total_pengeluaran;

$q_trx1 = mysqli_query($conn, "SELECT COUNT(*) as total FROM pembayaran WHERE status = 'Lunas'");
$q_trx2 = mysqli_query($conn, "SELECT COUNT(*) as total FROM pemasukan_kas");
$q_trx3 = mysqli_query($conn, "SELECT COUNT(*) as total FROM pengeluaran");
$total_trx = mysqli_fetch_assoc($q_trx1)['total'] + mysqli_fetch_assoc($q_trx2)['total'] + mysqli_fetch_assoc($q_trx3)['total'];

$q_aktivitas = mysqli_query($conn, "
    (SELECT 'Pembayaran Iuran' as aktivitas, u.nama as nama_user, i.nominal as jumlah, p.tanggal_bayar as tanggal
     FROM pembayaran p 
     JOIN users u ON p.id_user = u.id_user 
     JOIN iuran i ON p.id_iuran = i.id_iuran 
     WHERE p.status = 'Lunas'
     ORDER BY p.tanggal_bayar DESC LIMIT 5)
    UNION ALL
    (SELECT 'Pemasukan Manual' as aktivitas, COALESCE(u.nama, 'Umum') as nama_user, pk.nominal as jumlah, pk.tanggal
     FROM pemasukan_kas pk 
     LEFT JOIN users u ON pk.id_user = u.id_user 
     ORDER BY pk.tanggal DESC LIMIT 5)
    UNION ALL
    (SELECT CONCAT('Pengeluaran: ', pe.deskripsi) as aktivitas, g.nama_grup as nama_user, pe.nominal_keluar as jumlah, pe.tanggal_keluar as tanggal
     FROM pengeluaran pe 
     JOIN grup g ON pe.id_grup = g.id_grup 
     ORDER BY pe.tanggal_keluar DESC LIMIT 5)
    ORDER BY tanggal DESC
    LIMIT 5
");
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

    <div class="dashboard-layout">
        <aside class="sidebar">
            <div class="logo">
                <i class="fa-solid fa-cube"></i>
                <span>KasMate</span>
            </div>
            <nav class="sidebar-menu">
                <div class="menu-section">
                    <a href="dashboard-admin.php" class="menu-item active">
                        <i class='bx bxs-dashboard'></i> Dashboard
                    </a>
                    <a href="manajemen-user.php" class="menu-item">
                        <i class='bx bxs-user-account'></i> Manajemen User
                    </a>
                    <a href="manajemen-grup.php" class="menu-item">
                        <i class='bx bxs-group'></i> Manajemen Grup
                    </a>
                    <a href="pengaturan.php" class="menu-item">
                        <i class='bx bxs-cog'></i> Pengaturan Sistem
                    </a>
                </div>
                <div class="sidebar-bottom">
                    <a href="logout.php" class="menu-item">
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
                        <?php if (mysqli_num_rows($q_aktivitas) > 0): ?>
                            <?php while ($akt = mysqli_fetch_assoc($q_aktivitas)): ?>
                                <div class="activity-item">
                                    <div class="activity-user">
                                        <strong><?= htmlspecialchars($akt['nama_user']) ?></strong>
                                        <span><?= htmlspecialchars($akt['aktivitas']) ?></span>
                                    </div>
                                    <span class="activity-time"><?= date('d M', strtotime($akt['tanggal'])) ?></span>
                                </div>
                            <?php endwhile; ?>
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