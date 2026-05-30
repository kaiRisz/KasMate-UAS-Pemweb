<?php

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KasMate - Pengaturan</title>
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
                    <a href="../../controller/admin/DashboardAdminController.php" class="menu-item">
                        <i class='bx bxs-dashboard'></i> Dashboard
                    </a>
                    <a href="../../controller/admin/ManajemenUserController.php" class="menu-item">
                        <i class='bx bxs-user-account'></i> Manajemen User
                    </a>
                    <a href="../../controller/admin/ManajemenGrupController.php" class="menu-item">
                        <i class='bx bxs-group'></i> Manajemen Grup
                    </a>
                    <a href="../../controller/admin/PengaturanController.php" class="menu-item active">
                        <i class='bx bxs-cog'></i> Pengaturan Sistem
                    </a>
                </div>
                <div class="menu-section" style="margin-top: auto; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
                    <a href="../../controller/auth/LogoutController.php" class="menu-item">
                        <i class='bx bx-log-out'></i> Logout
                    </a>
                </div>
            </nav>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <div class="header-text">
                    <h1>Pengaturan</h1>
                    <p class="subtitle">Pengaturan Akun & Informasi Sistem</p>
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

            <section class="content-body">
                <?php if ($sukses): ?>
                    <div class="alert alert-success"><i class='bx bx-check-circle'></i> Perubahan berhasil disimpan!</div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="alert alert-error"><i class='bx bx-error-circle'></i> <?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <div class="settings-grid">
                    
                    <div class="card">
                        <h3 class="card-title"><i class='bx bx-user'></i> Profil Admin</h3>
                        <form method="POST">
                            <input type="hidden" name="aksi" value="update_profil">
                            <div class="input-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="nama" value="<?= htmlspecialchars($user_login['nama']) ?>" required>
                            </div>
                            <div class="input-group">
                                <label>Email</label>
                                <input type="email" name="email" value="<?= htmlspecialchars($user_login['email']) ?>" required>
                            </div>
                            <div style="display: flex; justify-content: flex-end;">
                                <button type="submit" class="btn-action btn-dark">Simpan Profil</button>
                            </div>
                        </form>
                    </div>

                    <div class="card">
                        <h3 class="card-title"><i class='bx bx-lock-alt'></i> Ganti Password</h3>
                        <form method="POST">
                            <input type="hidden" name="aksi" value="update_password">
                            <div class="input-group">
                                <label>Password Lama</label>
                                <input type="password" name="password_lama" required placeholder="Masukkan password lama">
                            </div>
                            <div class="input-group">
                                <label>Password Baru</label>
                                <input type="password" name="password_baru" required placeholder="Minimal 6 karakter">
                            </div>
                            <div class="input-group">
                                <label>Konfirmasi Password Baru</label>
                                <input type="password" name="konfirmasi_password" required placeholder="Ulangi password baru">
                            </div>
                            <div style="display: flex; justify-content: flex-end;">
                                <button type="submit" class="btn-action btn-dark">Ganti Password</button>
                            </div>
                        </form>
                    </div>

                    <div class="card full-width">
                        <h3 class="card-title"><i class='bx bx-info-circle'></i> Informasi Sistem</h3>
                        <div class="info-row">
                            <span class="label">Nama Sistem</span>
                            <span class="value">KasMate</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Deskripsi</span>
                            <span class="value">Sistem Informasi Manajemen Iuran dan Keuangan Kelompok</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Total Pengguna</span>
                            <span class="value"><?= $total_user ?> user</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Total Grup</span>
                            <span class="value"><?= $total_grup ?> grup</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Total Transaksi</span>
                            <span class="value"><?= $total_trx ?> transaksi</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Versi</span>
                            <span class="value">v1.0.0</span>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

</body>
</html>