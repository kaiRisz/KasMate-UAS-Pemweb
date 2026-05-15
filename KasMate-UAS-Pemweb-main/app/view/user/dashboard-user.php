<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../../public/assets/css/style.css">
</head>

<style>

    .main-content {
        padding: 20px;
    }

.user-profile {
    display: flex;
    align-items: center;
    gap: 10px;
    background: white;
    padding: 5px 15px 5px 5px;
    border-radius: 30px;
    border: 1px solid #dddfe2;
}

.user-profile img {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
}

.user-name {
    font-size: 13px;
    font-weight: 600;
}

.user-role {
    font-size: 11px;
    color: #65676b;
    display: block;
}

.overview {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 30px;
}

.overview-cards {
    background-color: white;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.overview-tittle {
    font-size: 13px;
    color: #65676b;
    font-weight: 500;
}

.overview-content {
    font-size: 22px;
    font-weight: 700;
    color: #1c1e21;
}

.table-content {
    background-color: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.table-tittle {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 20px;
    color: #1c1e21;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    text-align: left;
    padding: 12px 15px;
    border-bottom: 2px solid #f0f2f5;
    color: #65676b;
    font-size: 13px;
    font-weight: 600;
}

td {
    padding: 15px;
    border-bottom: 1px solid #f0f2f5;
    font-size: 14px;
    color: #1c1e21;
}

.status-belum-lunas {
    background-color: #ffcdcd;
    color: crimson;
    padding: 5px 10px;
    border-radius: 10px;
    text-align: center;
    display: inline-block;
}

.status-sudah-lunas {
    background-color: #d4edda;
    color: darkgreen;
    padding: 5px 10px;
    border-radius: 10px;
    text-align: center;
    display: inline-block;
}
/* ACTIVE SIDEBAR USER */
.menu-item.active {
    background-color: #6f9693 !important;
    color: white !important;
    border-radius: 12px;
    font-weight: 600;
}

.menu-item.active i {
    color: white !important;
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

</div>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <div class="header-text">
                    <h1>Dashboard</h1>
                    <p class="subtitle">Selamat Datang, Muhammad Raka</p>
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

            <section class="overview">
                <div class="overview-cards">
                    <p class="overview-tittle">Total Tagihan</p>
                    <h1 class="overview-content">Rp. 900.000,00</h1>
                </div>

                <div class="overview-cards">
                    <p class="overview-tittle">Sudah Bayar</p>
                    <h1 class="overview-content">Rp. 600.000,00</h1>
                </div>

                <div class="overview-cards">
                    <p class="overview-tittle">Belum Bayar</p>
                    <h1 class="overview-content">Rp. 300.000,00</h1>
                </div>
            </section>

            <section class="table-content">
                <h1 class="table-tittle">Tagihan Terdekat</h1>

                <div table-card>
                    <table cellpading="2px">
                        <th>Grup</th>
                        <th>Periode</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Deadline</th>

                        <tr>
                            <td>Kelas Matdis-A 2024</td>
                            <td>Mei 2024</td>
                            <td>Rp. 300.000,00</td>
                            <td><span class="status-belum-lunas">Belum Lunas</span></td>
                            <td>31 Mei 2024</td>
                        </tr>

                        <tr>
                            <td>Kelas RPL-A 2024</td>
                            <td>Mei 2024</td>
                            <td>Rp. 300.000,00</td>
                            <td> <span  class="status-belum-lunas">Belum Lunas</span></td>
                            <td>31 Mei 2024</td>
                        </tr>

                        <tr>
                            <td>Kelas ADSI-A 2024</td>
                            <td>April 2024</td>
                            <td>Rp. 300.000,00</td>
                            <td><span class="status-sudah-lunas">Sudah Lunas</span></td>
                            <td>31 April 2024</td>
                        </tr>

                        <tr>
                            <td>Kelas RPL-A 2024</td>
                            <td>Maret 2024</td>
                            <td>Rp. 300.000,00</td>
                            <td><span class="status-sudah-lunas">Sudah Lunas</span></td>
                            <td>31 Maret 2024</td>
                        </tr>

                    </table>

                </div>

            </section>


</body>

</html>
    