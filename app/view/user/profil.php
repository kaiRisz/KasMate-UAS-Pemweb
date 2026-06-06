<?php

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KasMate - Profil Pengguna</title>
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
                    <h1>Profil Saya</h1>
                    <p class="subtitle">Kelola informasi data diri dan keamanan akun Anda</p>
                </div>
                <div class="header-right">
                    <button class="btn-notification"><i class="fa-regular fa-bell"></i></button>
                    <div class="user-profile">
                        <img src="../../../public/assets/image/user_pict.jpg" alt="Profile">
                        <div class="user-info">
                            <span class="user-name"><?= htmlspecialchars($data_user['nama']); ?></span>
                            <span class="user-role">Anggota</span>
                        </div>
                    </div>
                </div>
            </header>

            <section class="content-body">
                <?php if (!empty($message)): ?>
                    <div class="alert alert-success">
                        <i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>

                <form action="" method="POST" class="settings-grid">
                    <input type="hidden" name="aksi" value="update">
                    
                    <div class="card">
                        <h3 class="card-title mb-20"><i class="fa-solid fa-id-badge text-blue"></i> Data Pribadi</h3>
                        
                        <div class="profile-header-flex mb-25">
                            <div class="profile-avatar-large">
                                <img src="../../../public/assets/image/user_pict.jpg" alt="User Image" class="img-cover-full">
                            </div>
                            <div>
                                <div class="profile-name-lg"><?= htmlspecialchars($data_user['nama']); ?></div>
                                <div class="profile-role-text text-muted-custom">Anggota KasMate</div>
                            </div>
                        </div>

                        <div class="input-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" value="<?= htmlspecialchars($data_user['nama']); ?>" required class="form-control-bordered">
                        </div>
                        <div class="input-group">
                            <label>Alamat Email</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($data_user['email']); ?>" required class="form-control-bordered">
                        </div>
                    </div>

                    <div class="card">
                        <h3 class="card-title mb-20"><i class="fa-solid fa-shield-halved text-green"></i> Keamanan Akun</h3>
                        <p class="text-muted-custom text-sm mb-20">Kosongkan kolom di bawah ini jika Anda tidak ingin mengubah password akun Anda.</p>
                        
                        <div class="input-group">
                            <label>Password Baru</label>
                            <input type="password" name="password_baru" placeholder="Ketik password baru (min. 6 karakter)" class="form-control-bordered">
                        </div>
                        <div class="input-group mb-25">
                            <label>Konfirmasi Password Baru</label>
                            <input type="password" name="konfirmasi_password" placeholder="Ketik ulang password baru" class="form-control-bordered">
                        </div>
                        
                        <div class="flex-justify-end mt-20">
                            <button type="submit" class="btn-add-user"><i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
            </section>
        </main>
    </div>
</body>
</html>