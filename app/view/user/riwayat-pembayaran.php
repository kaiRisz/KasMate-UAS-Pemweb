<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pembayaran</title>
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
        <i class="fa-solid fa-cube"></i>
        <span>KasMate</span>
    </div>
</div>

<label for="menu-toggle" class="sidebar-overlay"></label>

    <div class="dashboard-layout">
        <aside class="sidebar">
    <div class="logo">
        <i class="fa-solid fa-cube"></i>
        <span>KasMate</span>
    </div>
    <div class="menu-section">
        <a href="../../controller/user/DashboardUserController.php" class="menu-item <?= basename($_SERVER['PHP_SELF']) == 'DashboardUserController.php' ? 'active' : '' ?>">
            <i class="fa-solid fa-house-chimney"></i> Dashboard
        </a>

        <a href="../../controller/user/TagihanUserController.php" class="menu-item <?= basename($_SERVER['PHP_SELF']) == 'TagihanUserController.php' ? 'active' : '' ?>">
            <i class="fa-solid fa-file-invoice-dollar"></i> Tagihan Saya
        </a>

        <a href="../../controller/user/RiwayatUserController.php" class="menu-item <?= basename($_SERVER['PHP_SELF']) == 'RiwayatUserController.php' ? 'active' : '' ?>">
            <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Pembayaran
        </a>

        <a href="../../controller/user/GrupUserController.php" class="menu-item <?= basename($_SERVER['PHP_SELF']) == 'GrupUserController.php' ? 'active' : '' ?>">
            <i class="fa-solid fa-users-line"></i> Grup Saya
        </a>

        <a href="../../controller/user/ProfilUserController.php" class="menu-item <?= basename($_SERVER['PHP_SELF']) == 'ProfilUserController.php' ? 'active' : '' ?>">
            <i class="fa-solid fa-circle-user"></i> Profil
        </a>

        <a href="../../controller/auth/LogoutController.php" class="menu-item">
    <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
    </div>
</aside>

        <main class="main-content">
            <header class="topbar">
                <div class="header-text">
                    <h1>Riwayat Pembayaran</h1>
                    <p class="subtitle">Riwayat Pembayaran Saya</p>
                </div>
                <div class="header-right">
                    <button class="btn-notification">
                        <i class="fa-solid fa-bell"></i>
                    </button>
                    <div class="user-profile">
                        <img src="../../../public/assets/image/user_pict.jpg" alt="<?= htmlspecialchars($nama_user); ?>">
                        <div class="user-info">
                            <span class="user-name"><?= htmlspecialchars($nama_user); ?></span>
                            <span class="user-role">Anggota</span>
                        </div>
                    </div>
                </div>
            </header>

            <section class="card table-card">
                <h3 class="card-title">Semua Riwayat Transaksi</h3>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Tanggal Bayar</th>
                            <th>Grup</th>
                            <th>Nama Iuran</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($riwayat_list as $row): ?>
                            <tr>
                                <td><?= date('d F Y', strtotime($row['tanggal_bayar'])); ?></td>
                                <td class="fw-500"><?= htmlspecialchars($row['nama_grup']); ?></td>
                                <td class="fw-500"><?= htmlspecialchars($row['nama_iuran']); ?></td>
                                <td class="fw-500 text-green">Rp <?= number_format($row['nominal'], 0, ',', '.'); ?></td>
                                <td><span class="badge badge-lunas"><?= $row['status']; ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>