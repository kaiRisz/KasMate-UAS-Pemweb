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
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                    <?php foreach ($grup_list as $g): ?>
                        <a href="../../controller/user/GrupUserController.php?id_grup=<?= $g['id_grup']; ?>" style="border: 1px solid var(--border-color); border-radius: 12px; padding: 15px; text-decoration: none; color: inherit; background-color: <?= $selected_grup_id == $g['id_grup'] ? '#f1f5f9' : 'white'; ?>;">
                            <div class="fw-500" style="margin-bottom: 5px;"><?= htmlspecialchars($g['nama_grup']); ?></div>
                            <div style="font-size: 13px; color: var(--text-muted);">Bendahara: <?= htmlspecialchars($g['nama_bendahara']); ?></div>
                        </a>
                    <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p style="color: var(--text-muted); font-size: 14px;">Anda belum bergabung dengan grup manapun.</p>
                <?php endif; ?>
            </div>

            <div class="card flex-2">
                <?php if ($detail_grup): ?>
                    <div style="margin-bottom: 25px;">
                        <h2 style="margin-bottom: 5px;"><?= htmlspecialchars($detail_grup['nama_grup']); ?></h2>
                        <p style="color: var(--text-muted);"><?= htmlspecialchars($detail_grup['deskripsi']); ?></p>
                    </div>
                    
                    <div style="display: flex; gap: 20px; margin-bottom: 25px;">
                        <div class="cash-flow-box">
                            <p class="legend-label">Bendahara</p>
                            <h4 style="font-size: 16px;"><?= htmlspecialchars($detail_grup['nama_bendahara']); ?></h4>
                        </div>
                        <div class="cash-flow-box">
                            <p class="legend-label">Jumlah Anggota</p>
                            <h4 style="font-size: 16px;"><?= $detail_grup['jml_anggota']; ?> orang</h4>
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
                                    echo '<tr><td colspan="3" style="text-align:center; color:#666;">Belum ada tagihan di grup ini.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; color: #94a3b8; padding: 50px 0;">
                        <i class="fa-solid fa-users-slash" style="font-size: 40px; margin-bottom: 15px;"></i>
                        <p>Pilih grup di sebelah kiri untuk melihat detail.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>
</div>
</body>
</html>