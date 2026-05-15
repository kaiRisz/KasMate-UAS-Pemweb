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

    .main-content {
        padding: 20px;
    }   

    .table-tittle{
        font-size: 16px;
        margin-bottom: 16px;

    }

    .table-content{
        background-color: white;
        padding: 20px 40px 40px 40px;
        border-radius: 16px;
    }

    .status-belum-lunas{
        background-color: #ffcdcd;
        color: crimson;
        padding: 5px 10px;
        border-radius: 10px;
        text-align: center;
        display: inline-block;
    }

    .status-sudah-lunas{
        background-color: #d4edda;
        color: darkgreen;
        padding: 5px 10px;
        border-radius: 10px;
        text-align: center;
        display: inline-block;
    }

    .overview-cards{
        background-color: white;
        border-radius: 16px;
        width: auto;
        padding: 16px;
        display: flex;
        align-items: center;
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
                        <img src="../../../public/assets/image/user_pict.jpg" alt="Muhammad Raka">
                        <div class="user-info">
                            <span class="user-name">Muhammad Raka</span>
                            <span class="user-role">Anggota</span>
                        </div>

                    </div>
                </div>
            </header>

            <section class="table-content">
                <h1 class="table-tittle">Tagihan Terdekat</h1>

                <div table-card>
                    <table  cellpading="2px">
                        <th>Tanggal</th>
                        <th>Grup</th>
                        <th>Jumlah</th>
                        <th>Metode</th>
                        <th>Status</th>


                        <tr>
                            <td>11 April 2024</td>
                            <td>Kelas ADSI-A 2024</td>
                            <td>Rp. 300.000,00</td>
                            <td>Transfer</td>
                            <td><span class="status-belum-lunas">Belum Lunas</span></td>
                
                        </tr>

                        <tr>
                            <td>15 April 2024</td>
                            <td>Kelas RPL-A 2024</td>                           
                            <td>Rp. 300.000,00</td>                        
                            <td>Tunai</td>
                            <td><span class="status-belum-lunas">Belum Lunas</span></td>
                        </tr>

                    </table>

                </div>

            </section>

</body>
</html>
    