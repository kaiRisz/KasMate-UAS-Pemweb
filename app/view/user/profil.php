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
    .main-content {
    padding: 20px;
}

.profile-container{
    background: white;
    border-radius: 16px;
    padding: 30px;
    max-width: 700px;
}

.profile-header{
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 25px;
}

.profile-img{
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background-color: #ddd;
}

.profile-name{
    font-size: 18px;
    font-weight: 600;
}

.profile-role{
    font-size: 14px;
    color: gray;
}

.form-group{
    margin-bottom: 16px;
}

.form-group label{
    display: block;
    margin-bottom: 6px;
    font-size: 14px;
}

.form-group input{
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
}

.btn-save{
    background-color: #2A3636;
    color: white;
    padding: 10px 20px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
}

.btn-save:hover{
    background-color: #1f2a2a;
}


.user-profile {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
    border: 2px solid #ddd;
}

.user-profile img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
/* ACTIVE SIDEBAR USER */
.menu-item.active {
    background-color: #6f9693;
    color: white;
    border-radius: 12px;
    font-weight: 600;
}

.menu-item.active i {
    color: white;
}

</style>

<body>
    <div class="dashboard-layout">
        <aside class="sidebar">
            <div class="logo">
                <i class="fa-solid fa-cube"></i>
                <span>KasMate</span>
            </div>

               <div class="menu-section">

    <a href="dashboard-user.php" class="menu-item <?= basename($_SERVER['PHP_SELF']) == 'dashboard-user.php' ? 'active' : '' ?>">
        <i class="fa-solid fa-house-chimney"></i> Dashboard
    </a>

    <a href="tagihan-saya.php" class="menu-item <?= basename($_SERVER['PHP_SELF']) == 'tagihan-saya.php' ? 'active' : '' ?>">
        <i class="fa-solid fa-file-invoice-dollar"></i> Tagihan Saya
    </a>

    <a href="riwayat-pembayaran.php" class="menu-item <?= basename($_SERVER['PHP_SELF']) == 'riwayat-pembayaran.php' ? 'active' : '' ?>">
        <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Pembayaran
    </a>

    <a href="grup-saya.php" class="menu-item <?= basename($_SERVER['PHP_SELF']) == 'grup-saya.php' ? 'active' : '' ?>">
        <i class="fa-solid fa-users-line"></i> Grup Saya
    </a>

    <a href="profil.php" class="menu-item <?= basename($_SERVER['PHP_SELF']) == 'profil.php' ? 'active' : '' ?>">
        <i class="fa-solid fa-circle-user"></i> Profil
    </a>

     <a href="logout.php" class="menu-item"> <i class="fa-solid fa-right-from-bracket"></i> Logout
    </a>


</div>
        </aside>

     <main class="main-content">       
            <header class="topbar">
                <div class="header-text">
                    <h1>Profil</h1>
                    <p class="subtitle">Profil Pengguna</p>
                </div>
                <div class="header-right">
                </div>
            </header>

        <div class="profile-container">

            <div class="profile-header">
                <div class="user-profile">
                        <img src="../../../public/assets/image/user_pict.jpg" alt="Muhammad Raka">

                    </div>
                <div>
                    <div class="profile-name">Muhammad Raka</div>
                    <div class="profile-role">Anggota</div>
                </div>
            </div>

            <form>

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" value="Muhammad Raka">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" value="raka@email.com">
                </div>

                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" placeholder="Masukkan password baru">
                </div>

                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <input type="password" placeholder="Ulangi password">
                </div>

                <button type="submit" class="btn-save">Simpan Perubahan</button>

            </form>

        </div>

    </main>
</div>

</body>
</html>

