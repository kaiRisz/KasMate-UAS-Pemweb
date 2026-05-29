<?php
require_once '../../../config/auth_check.php';
cekRole('user');

$id_user = $_SESSION['id_user'];

$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password_baru = $_POST['password_baru'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    if (!empty($password_baru)) {
        if ($password_baru === $konfirmasi_password) {
            $password_hashed = password_hash($password_baru, PASSWORD_BCRYPT);
            mysqli_query($conn, "UPDATE users SET nama='$nama', email='$email', password='$password_hashed' WHERE id_user=$id_user");
            $message = "Profil dan password berhasil diperbarui.";
        } else {
            $message = "Konfirmasi password tidak cocok.";
        }
    } else {
        mysqli_query($conn, "UPDATE users SET nama='$nama', email='$email' WHERE id_user=$id_user");
        $message = "Profil berhasil diperbarui.";
    }
}

$query_user = mysqli_query($conn, "SELECT nama, email FROM users WHERE id_user = $id_user");
$data_user = mysqli_fetch_assoc($query_user);
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
<style>
    .main-content { padding: 20px; }
    .profile-container{ background: white; border-radius: 16px; padding: 30px; max-width: 700px; }
    .profile-header{ display: flex; align-items: center; gap: 20px; margin-bottom: 25px; }
    .profile-name{ font-size: 18px; font-weight: 600; }
    .profile-role{ font-size: 14px; color: gray; }
    .form-group{ margin-bottom: 16px; }
    .form-group label{ display: block; margin-bottom: 6px; font-size: 14px; }
    .form-group input{ width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc; }
    .btn-save{ background-color: #2A3636; color: white; padding: 10px 20px; border-radius: 8px; border: none; cursor: pointer; }
    .btn-save:hover{ background-color: #1f2a2a; }
    .user-profile { width: 100px; height: 100px; border-radius: 50%; overflow: hidden; display: flex; justify-content: center; align-items: center; border: 2px solid #ddd; }
    .user-profile img { width: 100%; height: 100%; object-fit: cover; }
    .menu-item.active { background-color: #6f9693; color: white; border-radius: 12px; font-weight: 600; }
    .menu-item.active i { color: white; }
    .alert { padding: 10px; margin-bottom: 15px; border-radius: 8px; background-color: #d4edda; color: darkgreen; }
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
        <a href="/KasMate-UAS-Pemweb/app/controller/user/DashboardUserController.php" class="menu-item <?= basename($_SERVER['PHP_SELF']) == 'DashboardUserController.php' ? 'active' : '' ?>">
            <i class="fa-solid fa-house-chimney"></i> Dashboard
        </a>

        <a href="/KasMate-UAS-Pemweb/app/controller/user/TagihanUserController.php" class="menu-item <?= basename($_SERVER['PHP_SELF']) == 'TagihanUserController.php' ? 'active' : '' ?>">
            <i class="fa-solid fa-file-invoice-dollar"></i> Tagihan Saya
        </a>

        <a href="/KasMate-UAS-Pemweb/app/controller/user/RiwayatUserController.php" class="menu-item <?= basename($_SERVER['PHP_SELF']) == 'RiwayatUserController.php' ? 'active' : '' ?>">
            <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Pembayaran
        </a>

        <a href="/KasMate-UAS-Pemweb/app/controller/user/GrupUserController.php" class="menu-item <?= basename($_SERVER['PHP_SELF']) == 'GrupUserController.php' ? 'active' : '' ?>">
            <i class="fa-solid fa-users-line"></i> Grup Saya
        </a>

        <a href="/KasMate-UAS-Pemweb/app/controller/user/ProfilUserController.php" class="menu-item <?= basename($_SERVER['PHP_SELF']) == 'ProfilUserController.php' ? 'active' : '' ?>">
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
                    <h1>Profil</h1>
                    <p class="subtitle">Profil Pengguna</p>
                </div>
            </header>

            <div class="profile-container">
                <?php if (!empty($message)): ?>
                    <div class="alert"><?= htmlspecialchars($message); ?></div>
                <?php endif; ?>

                <div class="profile-header">
                    <div class="user-profile">
                        <img src="../../../public/assets/image/user_pict.jpg" alt="User Image">
                    </div>
                    <div>
                        <div class="profile-name"><?= htmlspecialchars($data_user['nama']); ?></div>
                        <div class="profile-role">Anggota</div>
                    </div>
                </div>

                <form action="profil.php" method="POST">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" value="<?= htmlspecialchars($data_user['nama']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($data_user['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Password Baru</label>
                        <input type="password" name="password_baru" placeholder="Masukkan password baru">
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="konfirmasi_password" placeholder="Ulangi password">
                    </div>
                    <button type="submit" class="btn-save">Simpan Perubahan</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>