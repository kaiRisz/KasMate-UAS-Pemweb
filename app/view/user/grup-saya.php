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

.main-content {
    padding: 20px;
}

.content-wrapper{
    display: flex;
    gap: 20px;
}

.group-list{
    width: 40%;
    background: white;
    border-radius: 16px;
    padding: 20px;
}

.group-card{
    border: 1px solid #ddd;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 12px;
    cursor: pointer;
    transition: 0.2s;
}

.group-card:hover{
    background-color: #f5f5f5;
}

.group-name{
    font-weight: 600;
    margin-bottom: 6px;
}

.group-info{
    font-size: 13px;
    color: #666;
}

.group-detail{
    width: 60%;
    background: white;
    border-radius: 16px;
    padding: 20px;
}

.detail-header{
    margin-bottom: 20px;
}

.detail-header h2{
    margin: 0;
}

.detail-item{
    margin-bottom: 10px;
    font-size: 14px;
}

.tagihan-table{
    margin-top: 20px;
}

.tagihan-table table{
    width: 100%;
    border-collapse: collapse;
}

.tagihan-table th, .tagihan-table td{
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: left;
}

.status-lunas{
    background-color: #d4edda;
    color: darkgreen;
    padding: 5px 10px;
    border-radius: 10px;
    text-align: center;
    display: inline-block;
}

.status-belum{
    background-color: #ffcdcd;
    color: crimson;
    padding: 5px 10px;
    border-radius: 10px;
    text-align: center;
    display: inline-block;
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
                    <h1>Grup Saya</h1>
                    <p class="subtitle">Grup Yang Anda Miliki</p>
                </div>
                <div class="header-right">
                    <button class="btn-notification">
                        <i class="fa-solid fa-bell"></i>
                    </button>
                    <div class="user-profile">
                        <img src="../../../public/assets/image/user_pict.jpg" alt="Muhammad Raka">
                        <div class="user-info">
                            <span class="user-name">Muhammad Raka</span>
                            <span class="user-role">Anggota</span>
                        </div>

                    </div>
                </div>
            </header>

        <div class="content-wrapper">
   
            <div class="group-list">
                <h3 class="section-title">Daftar Grup</h3>

                <div class="group-card">
                    <div class="group-name">Kelas TI-2A 2024</div>
                    <div class="group-info">25 anggota • Rp 50.000/bulan</div>
                </div>

                <div class="group-card">
                    <div class="group-name">Arisan Keluarga</div>
                    <div class="group-info">12 anggota • Rp 100.000/bulan</div>
                </div>

                <div class="group-card">
                    <div class="group-name">HIMA TI UNNES</div>
                    <div class="group-info">40 anggota • Rp 25.000/bulan</div>
                </div>

            </div>

            <div class="group-detail">
                <div class="detail-header">
                    <h2>Kelas TI-2A 2024</h2>
                    <p>Grup iuran kelas angkatan 2024</p>
                </div>

                <div class="detail-item">Bendahara: Budi Santoso</div>
                <div class="detail-item">Jumlah Anggota: 25 orang</div>
                <div class="detail-item">Iuran: Rp 50.000 / bulan</div>
                <div class="detail-item">Periode: Jan 2024 - Des 2024</div>

                <div class="tagihan-table">
                    <h3 class="section-title">Tagihan Saya</h3>

                    <table>
                        <tr>
                            <th>Periode</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                        </tr>

                        <tr>
                            <td>Mei 2024</td>
                            <td>Rp 50.000</td>
                            <td><span class="status-lunas">Sudah Lunas</span></td>
                        </tr>

                        <tr>
                            <td>Juni 2024</td>
                            <td>Rp 50.000</td>
                            <td><span class="status-belum">Belum Lunas</span></td>
                        </tr>

                    </table>
                </div>
            </div>

        </div>

    </main>
</div>
</body>
</html>

