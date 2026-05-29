<?php
require_once '../../../config/auth_check.php';
cekRole('user');

$id_user = $_SESSION['id_user'];
$nama_user = $user_login['nama'];
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
<style>
    .main-content { padding: 20px; }   
    .table-tittle{ font-size: 16px; margin-bottom: 16px; }
    .table-content{ background-color: white; padding: 20px 40px 40px 40px; border-radius: 16px; }
    .status-sudah-lunas{ background-color: #d4edda; color: darkgreen; padding: 5px 10px; border-radius: 10px; text-align: center; display: inline-block; }
    .menu-item.active { background-color: #6f9693; color: white; border-radius: 12px; font-weight: 600; }
    .menu-item.active i { color: white; }
    table { width: 100%; border-collapse: collapse; }
    th { text-align: left; padding: 12px 15px; border-bottom: 2px solid #f0f2f5; color: #65676b; font-size: 13px; font-weight: 600; }
    td { padding: 15px; border-bottom: 1px solid #f0f2f5; font-size: 14px; color: #1c1e21; }
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
    <a href="/KasMate-UAS-Pemweb/app/controller/user/DashboardUserController.php" class="menu-item <?= basename($_SERVER['PHP_SELF']) == 'dashboard-user.php' ? 'active' : '' ?>">
        <i class="fa-solid fa-house-chimney"></i> Dashboard
    </a>

    <a href="/KasMate-UAS-Pemweb/app/controller/user/TagihanUserController.php" class="menu-item <?= basename($_SERVER['PHP_SELF']) == 'tagihan-saya.php' ? 'active' : '' ?>">
        <i class="fa-solid fa-file-invoice-dollar"></i> Tagihan Saya
    </a>

    <a href="/KasMate-UAS-Pemweb/app/controller/user/RiwayatUserController.php" class="menu-item <?= basename($_SERVER['PHP_SELF']) == 'riwayat-pembayaran.php' ? 'active' : '' ?>">
        <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Pembayaran
    </a>

    <a href="/KasMate-UAS-Pemweb/app/controller/user/GrupUserController.php" class="menu-item <?= basename($_SERVER['PHP_SELF']) == 'grup-saya.php' ? 'active' : '' ?>">
        <i class="fa-solid fa-users-line"></i> Grup Saya
    </a>

    <a href="/KasMate-UAS-Pemweb/app/controller/user/ProfilUserController.php" class="menu-item <?= basename($_SERVER['PHP_SELF']) == 'profil.php' ? 'active' : '' ?>">
        <i class="fa-solid fa-circle-user"></i> Profil
    </a>

    <a href="/KasMate-UAS-Pemweb/app/view/user/logout.php" class="menu-item">
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

            <section class="table-content">
                <h1 class="table-tittle">Semua Riwayat Transaksi</h1>
                <div table-card>
                    <table cellpadding="2px">
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
                            <?php
                            $query_riwayat = mysqli_query($conn, "SELECT p.tanggal_bayar, g.nama_grup, i.nama_iuran, i.nominal, p.status FROM pembayaran p JOIN iuran i ON p.id_iuran = i.id_iuran JOIN grup g ON i.id_grup = g.id_grup WHERE p.id_user = $id_user AND p.status = 'Lunas' ORDER BY p.tanggal_bayar DESC");
                            while ($row = mysqli_fetch_assoc($query_riwayat)) {
                                ?>
                                <tr>
                                    <td><?= date('d F Y', strtotime($row['tanggal_bayar'])); ?></td>
                                    <td><?= htmlspecialchars($row['nama_grup']); ?></td>
                                    <td><?= htmlspecialchars($row['nama_iuran']); ?></td>
                                    <td>Rp. <?= number_format($row['nominal'], 2, ',', '.'); ?></td>
                                    <td><span class="status-sudah-lunas"><?= $row['status']; ?></span></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</body>
</html>