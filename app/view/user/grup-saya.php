<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grup Saya</title>
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
                <h1>Grup Saya</h1>
                <p class="subtitle">Grup Yang Anda Miliki</p>
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

        <section class="charts-section">
            <div class="card flex-1">
                <h3 class="card-title">Daftar Grup</h3>
                <?php if (!empty($grup_list)): ?>
                    <div class="group-list-container">
                    <?php foreach ($grup_list as $g): ?>
                        <a href="../../controller/user/GrupUserController.php?id_grup=<?= $g['id_grup']; ?>" class="group-list-item <?= $selected_grup_id == $g['id_grup'] ? 'active-bg' : ''; ?>">
                            <div class="fw-500 mb-5"><?= htmlspecialchars($g['nama_grup']); ?></div>
                            <div class="text-sm text-muted">Bendahara: <?= htmlspecialchars($g['nama_bendahara']); ?></div>
                        </a>
                    <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="empty-msg">Anda belum bergabung dengan grup manapun.</p>
                <?php endif; ?>
            </div>

            <div class="card flex-2">
                <?php if ($detail_grup): ?>
                    <div class="mb-25">
                        <h2 class="mb-5"><?= htmlspecialchars($detail_grup['nama_grup']); ?></h2>
                        <p class="text-muted"><?= htmlspecialchars($detail_grup['deskripsi']); ?></p>
                    </div>
                    
                    <div class="flex-gap-20 mb-25">
                        <div class="cash-flow-box">
                            <p class="legend-label">Bendahara</p>
                            <h4 class="text-md"><?= htmlspecialchars($detail_grup['nama_bendahara']); ?></h4>
                        </div>
                        <div class="cash-flow-box">
                            <p class="legend-label">Jumlah Anggota</p>
                            <h4 class="text-md"><?= $detail_grup['jml_anggota']; ?> orang</h4>
                        </div>
                    </div>

                    <div class="table-card">
                        <h3 class="card-title">Tagihan Saya di Grup Ini</h3>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Nama Iuran</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($grup_tagihan_list)) {
                                    foreach ($grup_tagihan_list as $t) {
                                        $status_cl = ($t['status_bayar'] == 'Lunas') ? 'badge-lunas' : 'badge-pending';
                                        ?>
                                        <tr>
                                            <td class="fw-500"><?= htmlspecialchars($t['nama_iuran']); ?></td>
                                            <td class="fw-500 text-green">Rp <?= number_format($t['nominal'], 0, ',', '.'); ?></td>
                                            <td><span class="badge <?= $status_cl; ?>"><?= $t['status_bayar']; ?></span></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="3" class="text-center text-muted-dark">Belum ada tagihan di grup ini.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state-container">
                        <i class="fa-solid fa-users-slash empty-state-icon"></i>
                        <p>Pilih grup di sebelah kiri untuk melihat detail.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>
</div>
</body>
</html>