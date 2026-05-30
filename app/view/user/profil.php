<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../../public/assets/css/style.css">
</head>
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
                    <h1>Profil</h1>
                    <p class="subtitle">Profil Pengguna</p>
                </div>
            </header>

            <div class="card" style="max-width: 700px; padding: 30px;">
                <?php if (!empty($message)): ?>
                    <div style="padding: 10px; margin-bottom: 15px; border-radius: 8px; background-color: #dcfce7; color: #16a34a; border: 1px solid #bbf7d0;"><?= htmlspecialchars($message); ?></div>
                <?php endif; ?>

                <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 30px;">
                    <div style="width: 80px; height: 80px; border-radius: 50%; overflow: hidden; border: 2px solid var(--border-color);">
                        <img src="../../../public/assets/image/user_pict.jpg" alt="User Image" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div>
                        <div style="font-size: 18px; font-weight: 600; color: var(--text-dark);"><?= htmlspecialchars($data_user['nama']); ?></div>
                        <div style="font-size: 14px; color: var(--text-muted);">Anggota</div>
                    </div>
                </div>

                <form action="" method="POST">
                    <input type="hidden" name="aksi" value="update">
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; margin-bottom: 6px; font-size: 14px; font-weight: 500; color: var(--text-dark);">Nama Lengkap</label>
                        <input type="text" name="nama" value="<?= htmlspecialchars($data_user['nama']); ?>" required style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #cbd5e1; outline: none;">
                    </div>
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; margin-bottom: 6px; font-size: 14px; font-weight: 500; color: var(--text-dark);">Email</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($data_user['email']); ?>" required style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #cbd5e1; outline: none;">
                    </div>
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; margin-bottom: 6px; font-size: 14px; font-weight: 500; color: var(--text-dark);">Password Baru</label>
                        <input type="password" name="password_baru" placeholder="Masukkan password baru" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #cbd5e1; outline: none;">
                    </div>
                    <div style="margin-bottom: 25px;">
                        <label style="display: block; margin-bottom: 6px; font-size: 14px; font-weight: 500; color: var(--text-dark);">Konfirmasi Password</label>
                        <input type="password" name="konfirmasi_password" placeholder="Ulangi password" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #cbd5e1; outline: none;">
                    </div>
                    <button type="submit" class="btn-action btn-dark" style="font-size: 14px; padding: 10px 20px;">Simpan Perubahan</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>