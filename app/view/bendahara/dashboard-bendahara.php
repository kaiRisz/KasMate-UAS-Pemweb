<?php
session_start();
require_once '../../../config/database.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'bendahara') {
    header("Location: ../auth/login.php");
    exit();
}

$id_user = $_SESSION['id_user'];

$user_query = mysqli_query($conn, "SELECT nama FROM users WHERE id_user = '$id_user'");
$user_data = mysqli_fetch_assoc($user_query);
$nama_bendahara = $user_data['nama'] ?? 'Bendahara';

$grup_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM grup WHERE id_bendahara = '$id_user'");
$total_grup = mysqli_fetch_assoc($grup_query)['total'] ?? 0;

$anggota_query = mysqli_query($conn, "SELECT COUNT(DISTINCT ga.id_user) as total FROM grup_anggota ga JOIN grup g ON ga.id_grup = g.id_grup WHERE g.id_bendahara = '$id_user'");
$total_anggota = mysqli_fetch_assoc($anggota_query)['total'] ?? 0;

$masuk_query = mysqli_query($conn, "SELECT SUM(i.nominal) as total FROM pembayaran p JOIN iuran i ON p.id_iuran = i.id_iuran JOIN grup g ON i.id_grup = g.id_grup WHERE g.id_bendahara = '$id_user' AND p.status = 'Lunas'");
$total_masuk = mysqli_fetch_assoc($masuk_query)['total'] ?? 0;

$keluar_query = mysqli_query($conn, "SELECT SUM(pe.nominal_keluar) as total FROM pengeluaran pe JOIN grup g ON pe.id_grup = g.id_grup WHERE g.id_bendahara = '$id_user'");
$total_keluar = mysqli_fetch_assoc($keluar_query)['total'] ?? 0;

$saldo = $total_masuk - $total_keluar;

$status_lunas_q = mysqli_query($conn, "SELECT COUNT(*) as total FROM pembayaran p JOIN iuran i ON p.id_iuran = i.id_iuran JOIN grup g ON i.id_grup = g.id_grup WHERE g.id_bendahara = '$id_user' AND p.status = 'Lunas'");
$count_lunas = mysqli_fetch_assoc($status_lunas_q)['total'] ?? 0;

$status_belum_q = mysqli_query($conn, "SELECT COUNT(*) as total FROM pembayaran p JOIN iuran i ON p.id_iuran = i.id_iuran JOIN grup g ON i.id_grup = g.id_grup WHERE g.id_bendahara = '$id_user' AND p.status = 'Belum Lunas'");
$count_belum = mysqli_fetch_assoc($status_belum_q)['total'] ?? 0;

$total_tagihan_semua = $count_lunas + $count_belum;
$persen_lunas = $total_tagihan_semua > 0 ? round(($count_lunas / $total_tagihan_semua) * 100, 1) : 0;
$persen_belum = $total_tagihan_semua > 0 ? round(($count_belum / $total_tagihan_semua) * 100, 1) : 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KasMate - Dashboard Bendahara</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../../public/assets/css/style.css">
</head>
<body>
    <div class="dashboard-layout">
        <aside class="sidebar">
            <div class="logo">
                <i class="fa-solid fa-cube"></i>
                <span>KasMate</span>
            </div>
            <div class="sidebar-menu">
                <a href="dashboard-bendahara.php" class="menu-item active">
                    <i class="fa-solid fa-border-all"></i> Dashboard
                </a>
                <div class="menu-section">
                    <p class="section-title">KELOLA IURAN</p>
                    <a href="grup-iuran.php" class="menu-item"><i class="fa-solid fa-users-line"></i> Grup Iuran</a>
                    <a href="detail-grup.php" class="menu-item"><i class="fa-solid fa-user-group"></i> Detail Grup</a>
                </div>
                <div class="menu-section">
                    <p class="section-title">KEUANGAN</p>
                    <a href="pemasukan.php" class="menu-item"><i class="fa-solid fa-clock-rotate-left"></i> Pemasukan</a>
                    <a href="pengeluaran.php" class="menu-item"><i class="fa-regular fa-eye"></i> Pengeluaran</a>
                </div>
                <div class="menu-section">
                    <p class="section-title">LAPORAN</p>
                    <a href="laporan-keuangan.php" class="menu-item"><i class="fa-regular fa-file-lines"></i> Laporan Keuangan</a>
                </div>
                <div class="sidebar-bottom">
                    <a href="logout.php" class="menu-item">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </a>
                </div>
            </div>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <div class="header-text">
                    <h1>Dashboard Bendahara</h1>
                    <p class="welcome-text">Halo, <?php echo $nama_bendahara; ?> 👋</p>
                    <p class="subtitle">Berikut adalah ringkasan aktivitas keuangan kelompok Anda.</p>
                </div>
                <div class="header-right">
                    <button class="btn-notification"><i class="fa-regular fa-bell"></i></button>
                    <div class="user-profile">
                        <img src="../../../public/assets/image/user_pict.jpg" alt="Profile">
                        <div class="user-info">
                            <span class="user-name"><?php echo $nama_bendahara; ?></span>
                            <span class="user-role">Bendahara Utama</span>
                        </div>
                        <i class="fa-solid fa-chevron-down dropdown-icon"></i>
                    </div>
                </div>
            </header>

            <section class="overview-cards">
                <div class="card stat-card">
                    <div><i class="fa-solid fa-users-rectangle"></i></div>
                    <div>
                        <p>Grup Aktif</p>
                        <h2><?php echo $total_grup; ?></h2>
                    </div>
                </div>
                <div class="card stat-card">
                    <div><i class="fa-solid fa-user-group"></i></div>
                    <div>
                        <p>Total Anggota</p>
                        <h2><?php echo $total_anggota; ?> <span>Orang</span></h2>
                    </div>
                </div>
                <div class="card stat-card">
                    <div><i class="fa-solid fa-wallet"></i></div>
                    <div>
                        <p>Total Pemasukan</p>
                        <h2>Rp <?php echo number_format($total_masuk, 0, ',', '.'); ?></h2>
                    </div>
                </div>
                <div class="card stat-card">
                    <div><i class="fa-solid fa-file-invoice-dollar"></i></div>
                    <div>
                        <p>Total Pengeluaran</p>
                        <h2>Rp <?php echo number_format($total_keluar, 0, ',', '.'); ?></h2>
                    </div>
                </div>
            </section>

            <section class="charts-section">
                <div class="card chart-card flex-2">
                    <h3 class="card-title">Arus Kas</h3>
                    <div class="cash-flow-cards">
                        <div class="cash-flow-box">
                            <p class="legend-label"><span class="dot dot-blue"></span> Pemasukan</p>
                            <h4>Rp <?php echo number_format($total_masuk, 0, ',', '.'); ?></h4>
                        </div>
                        <div class="cash-flow-box">
                            <p class="legend-label"><span class="dot dot-green"></span> Total Saldo</p>
                            <h4>Rp <?php echo number_format($saldo, 0, ',', '.'); ?></h4>
                        </div>
                        <div class="cash-flow-box">
                            <p class="legend-label"><span class="dot dot-yellow"></span> Pengeluaran</p>
                            <h4>Rp <?php echo number_format($total_keluar, 0, ',', '.'); ?></h4>
                        </div>
                    </div>
                </div>
                <div class="card chart-card flex-1">
                    <h3 class="card-title">Status Tagihan</h3>
                    <div class="chart-container">
                        <ul class="legend-list status-tagihan-list">
                            <li>
                                <span><span class="dot dot-green"></span> Lunas</span>
                                <span><?php echo $count_lunas; ?> <span>(<?php echo $persen_lunas; ?>%)</span></span>
                            </li>
                            <li>
                                <span><span class="dot dot-orange"></span> Belum Lunas</span>
                                <span><?php echo $count_belum; ?> <span>(<?php echo $persen_belum; ?>%)</span></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <section class="table-section">
                <div class="card table-card">
                    <h3 class="card-title">Grup Iuran Terbaru</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Grup</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $tabel_grup = mysqli_query($conn, "SELECT * FROM grup WHERE id_bendahara = '$id_user' ORDER BY id_grup DESC LIMIT 5");
                            $no = 1;
                            while($row = mysqli_fetch_assoc($tabel_grup)):
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><span class="fw-500"><?php echo $row['nama_grup']; ?></span></td>
                                <td><?php echo $row['deskripsi']; ?></td>
                                <td>
                                    <a href="detail-grup.php?id=<?php echo $row['id_grup']; ?>" class="btn-action" style="text-decoration:none; padding:5px 10px; border-radius:5px; background:#1e293b; color:#fff;">Kelola</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                            <?php if(mysqli_num_rows($tabel_grup) == 0): ?>
                            <tr>
                                <td colspan="4" style="text-align:center;">Belum ada grup yang dibuat.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</body>
</html>