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
<style>
    .main-content { padding: 20px; }
    .content-wrapper { display: flex; gap: 20px; }
    .group-list { width: 40%; background: white; border-radius: 16px; padding: 20px; }
    .group-card { border: 1px solid #ddd; border-radius: 12px; padding: 15px; margin-bottom: 12px; cursor: pointer; transition: 0.2s; text-decoration: none; display: block; color: inherit; }
    .group-card:hover { background-color: #f5f5f5; }
    .group-name { font-weight: 600; margin-bottom: 6px; }
    .group-info { font-size: 13px; color: #666; }
    .group-detail { width: 60%; background: white; border-radius: 16px; padding: 20px; }
    .detail-header { margin-bottom: 20px; }
    .detail-header h2 { margin: 0; }
    .detail-item { margin-bottom: 10px; font-size: 14px; }
    .tagihan-table { margin-top: 20px; }
    .tagihan-table table { width: 100%; border-collapse: collapse; }
    .tagihan-table th, .tagihan-table td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
    .status-lunas { background-color: #d4edda; color: darkgreen; padding: 5px 10px; border-radius: 10px; text-align: center; display: inline-block; }
    .status-belum { background-color: #ffcdcd; color: crimson; padding: 5px 10px; border-radius: 10px; text-align: center; display: inline-block; }
    .menu-item.active { background-color: #6f9693; color: white; border-radius: 12px; font-weight: 600; }
    .menu-item.active i { color: white; }
</style>
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
            <a href="../../view/user/logout.php" class="menu-item">
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

        <div class="content-wrapper">
            <div class="group-list">
                <h3 class="section-title">Daftar Grup</h3>
                <?php if (!empty($grup_list)): ?>
                    <?php foreach ($grup_list as $g): ?>
                        <a href="../../controller/user/GrupUserController.php?id_grup=<?= $g['id_grup']; ?>" class="group-card" style="background-color: <?= $selected_grup_id == $g['id_grup'] ? '#f5f5f5' : 'transparent'; ?>">
                            <div class="group-name"><?= htmlspecialchars($g['nama_grup']); ?></div>
                            <div class="group-info">Bendahara: <?= htmlspecialchars($g['nama_bendahara']); ?></div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: #666; font-size: 14px;">Anda belum bergabung dengan grup manapun.</p>
                <?php endif; ?>
            </div>

            <div class="group-detail">
                <?php if ($detail_grup): ?>
                    <div class="detail-header">
                        <h2><?= htmlspecialchars($detail_grup['nama_grup']); ?></h2>
                        <p><?= htmlspecialchars($detail_grup['deskripsi']); ?></p>
                    </div>
                    <div class="detail-item">Bendahara: <?= htmlspecialchars($detail_grup['nama_bendahara']); ?></div>
                    <div class="detail-item">Jumlah Anggota: <?= $detail_grup['jml_anggota']; ?> orang</div>

                    <div class="tagihan-table">
                        <h3 class="section-title">Tagihan Saya di Grup Ini</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>Nama Iuran</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query_grup_tagihan = mysqli_query($conn, "SELECT i.nama_iuran, i.nominal, COALESCE(p.status, 'Belum Lunas') AS status_bayar FROM iuran i LEFT JOIN pembayaran p ON i.id_iuran = p.id_iuran AND p.id_user = $id_user WHERE i.id_grup = $selected_grup_id");
                                if (mysqli_num_rows($query_grup_tagihan) > 0) {
                                    while ($t = mysqli_fetch_assoc($query_grup_tagihan)) {
                                        $status_cl = ($t['status_bayar'] == 'Lunas') ? 'status-lunas' : 'status-belum';
                                        ?>
                                        <tr>
                                            <td><?= htmlspecialchars($t['nama_iuran']); ?></td>
                                            <td>Rp <?= number_format($t['nominal'], 0, ',', '.'); ?></td>
                                            <td><span class="<?= $status_cl; ?>"><?= $t['status_bayar']; ?></span></td>
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
                    <div style="text-align: center; color: #999; margin-top: 50px;">
                        <i class="fa-solid fa-users-slash" style="font-size: 40px; margin-bottom: 10px;"></i>
                        <p>Pilih grup di sebelah kiri untuk melihat detail.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>
</body>
</html>