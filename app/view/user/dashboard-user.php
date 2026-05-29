<?php
require_once '../../../config/auth_check.php';
cekRole('user');

$id_user = $_SESSION['id_user'];
$nama_user = $user_login['nama'] ?? 'User';

$query_total = mysqli_query($conn, "
    SELECT SUM(i.nominal) AS total 
    FROM iuran i 
    JOIN grup_anggota ga ON i.id_grup = ga.id_grup 
    WHERE ga.id_user = $id_user
");
$total_tagihan = mysqli_fetch_assoc($query_total)['total'] ?? 0;

$query_lunas = mysqli_query($conn, "
    SELECT SUM(i.nominal) AS total 
    FROM pembayaran p 
    JOIN iuran i ON p.id_iuran = i.id_iuran 
    WHERE p.id_user = $id_user AND p.status = 'Lunas'
");
$sudah_bayar = mysqli_fetch_assoc($query_lunas)['total'] ?? 0;

$belum_bayar = $total_tagihan - $sudah_bayar;
?>

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
.main-content { padding: 20px; }

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

.user-name{
    font-size: 13px; font-weight: 600;
}
.user-role { font-size: 11px; color: #65676b; display: block; }

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
    display: inline-block;
}

.status-sudah-lunas {
    background-color: #d4edda;
    color: darkgreen;
    padding: 5px 10px;
    border-radius: 10px;
    display: inline-block;
}

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

        <a href="../../view/user/logout.php" class="menu-item">
    <i class="fa-solid fa-right-from-bracket"></i> Logout
</a>
    </div>
</aside>

    <main class="main-content">
        <header class="topbar">
            <div class="header-text">
                <h1>Dashboard</h1>
                <p class="subtitle">Selamat Datang, <?= htmlspecialchars($nama_user) ?></p>
            </div>

            <div class="header-right">
                <button class="btn-notification">
                    <i class="fa-solid fa-bell"></i>
                </button>

                <div class="user-profile">
                    <img src="../../../public/assets/image/user_pict.jpg">
                    <div class="user-info">
                        <span class="user-name"><?= htmlspecialchars($nama_user) ?></span>
                        <span class="user-role">Anggota</span>
                    </div>
                </div>
            </div>
        </header>

        <section class="overview">
            <div class="overview-cards">
                <p class="overview-tittle">Total Tagihan</p>
                <h1 class="overview-content">Rp. <?= number_format($total_tagihan, 2, ',', '.') ?></h1>
            </div>

            <div class="overview-cards">
                <p class="overview-tittle">Sudah Bayar</p>
                <h1 class="overview-content">Rp. <?= number_format($sudah_bayar, 2, ',', '.') ?></h1>
            </div>

            <div class="overview-cards">
                <p class="overview-tittle">Belum Bayar</p>
                <h1 class="overview-content">Rp. <?= number_format($belum_bayar, 2, ',', '.') ?></h1>
            </div>
        </section>

        <section class="table-content">
            <h1 class="table-tittle">Tagihan Terdekat</h1>

            <div table-card>
                <table cellpadding="2px">
                    <tr>
                        <th>Grup</th>
                        <th>Periode</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Deadline</th>
                    </tr>

                    <?php
                    
                    $query_tagihan = mysqli_query($conn, "
                        SELECT g.nama_grup, i.nama_iuran, i.nominal,
                        COALESCE(p.status, 'Belum Lunas') AS status_bayar
                        FROM iuran i
                        JOIN grup g ON i.id_grup = g.id_grup
                        JOIN grup_anggota ga ON g.id_grup = ga.id_grup
                        LEFT JOIN pembayaran p 
                            ON i.id_iuran = p.id_iuran AND p.id_user = ga.id_user
                        WHERE ga.id_user = $id_user
                        LIMIT 4
                    ");

                    while ($row = mysqli_fetch_assoc($query_tagihan)) {
                        $status_class = ($row['status_bayar'] == 'Lunas') ? 'status-sudah-lunas' : 'status-belum-lunas';
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nama_grup']) ?></td>
                            <td><?= htmlspecialchars($row['nama_iuran']) ?></td>
                            <td>Rp. <?= number_format($row['nominal'], 2, ',', '.') ?></td>
                            <td><span class="<?= $status_class ?>"><?= $row['status_bayar'] ?></span></td>
                            <td>-</td>
                        </tr>
                    <?php } ?>

                </table>
            </div>
        </section>

    </main>
</div>
</body>
</html>