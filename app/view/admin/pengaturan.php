<?php
require_once '../../../config/auth_check.php';
cekRole('admin');

$sukses = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi'])) {
    
    if ($_POST['aksi'] === 'update_profil') {
        $nama = mysqli_real_escape_string($conn, $_POST['nama']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        $q_cek = mysqli_query($conn, "SELECT id_user FROM users WHERE email='$email' AND id_user != {$user_login['id_user']}");
        if (mysqli_num_rows($q_cek) > 0) {
            $error = 'Email sudah digunakan oleh user lain.';
        } else {
            $query = "UPDATE users SET nama='$nama', email='$email' WHERE id_user = {$user_login['id_user']}";
            mysqli_query($conn, $query);

            $result_user_login = mysqli_query($conn, "SELECT * FROM users WHERE id_user = {$user_login['id_user']}");
            $user_login = mysqli_fetch_assoc($result_user_login);
            $sukses = true;
        }
    }
    
    if ($_POST['aksi'] === 'update_password') {
        $password_lama = $_POST['password_lama'];
        $password_baru = $_POST['password_baru'];
        $konfirmasi = $_POST['konfirmasi_password'];
        
        if (!password_verify($password_lama, $user_login['password'])) {
            $error = 'Password lama tidak sesuai.';
        } elseif ($password_baru !== $konfirmasi) {
            $error = 'Konfirmasi password tidak cocok.';
        } elseif (strlen($password_baru) < 6) {
            $error = 'Password baru minimal 6 karakter.';
        } else {
            $hash = password_hash($password_baru, PASSWORD_DEFAULT);
            mysqli_query($conn, "UPDATE users SET password='$hash' WHERE id_user = {$user_login['id_user']}");
            $sukses = true;
        }
    }
}

$q_total_user = mysqli_query($conn, "SELECT COUNT(*) as t FROM users");
$total_user = mysqli_fetch_assoc($q_total_user)['t'];

$q_total_grup = mysqli_query($conn, "SELECT COUNT(*) as t FROM grup");
$total_grup = mysqli_fetch_assoc($q_total_grup)['t'];

$q_trx1 = mysqli_query($conn, "SELECT COUNT(*) as t FROM pembayaran WHERE status = 'Lunas'");
$q_trx2 = mysqli_query($conn, "SELECT COUNT(*) as t FROM pemasukan_kas");
$q_trx3 = mysqli_query($conn, "SELECT COUNT(*) as t FROM pengeluaran");
$total_trx = mysqli_fetch_assoc($q_trx1)['t'] + mysqli_fetch_assoc($q_trx2)['t'] + mysqli_fetch_assoc($q_trx3)['t'];
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

    <div class="dashboard-layout">
        <aside class="sidebar"> 
            <div class="logo">
                <i class="fa-solid fa-cube"></i>
                <span>KasMate</span>
            </div>
            <nav class="sidebar-menu">
                <div class="menu-section">
                    <a href="dashboard-admin.php" class="menu-item">
                        <i class='bx bxs-dashboard'></i> Dashboard
                    </a>
                    <a href="manajemen-user.php" class="menu-item">
                        <i class='bx bxs-user-account'></i> Manajemen User
                    </a>
                    <a href="manajemen-grup.php" class="menu-item">
                        <i class='bx bxs-group'></i> Manajemen Grup
                    </a>
                    <a href="pengaturan.php" class="menu-item active">
                        <i class='bx bxs-cog'></i> Pengaturan Sistem
                    </a>
                </div>
                <div class="menu-section" style="margin-top: auto; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
                    <a href="logout.php" class="menu-item">
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
                    <!-- Profil Admin -->
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