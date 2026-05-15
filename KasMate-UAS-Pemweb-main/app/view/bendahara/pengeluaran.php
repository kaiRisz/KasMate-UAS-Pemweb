<?php
session_start();
require_once '../../../config/database.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'bendahara') {
    header("Location: ../auth/login.php");
    exit();
}

$id_user = $_SESSION['id_user'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah_pengeluaran'])) {
    $id_grup = $_POST['id_grup'];
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];
    $jumlah = $_POST['jumlah'];
    
    if(!empty($id_grup) && !empty($tanggal) && !empty($keterangan) && !empty($jumlah)) {
        mysqli_query($conn, "INSERT INTO pengeluaran (id_grup, deskripsi, nominal_keluar, tanggal_keluar) VALUES ('$id_grup', '$keterangan', '$jumlah', '$tanggal')");
        header("Location: pengeluaran.php");
        exit();
    }
}

$user_q = mysqli_query($conn, "SELECT nama FROM users WHERE id_user = '$id_user'");
$nama_bendahara = mysqli_fetch_assoc($user_q)['nama'] ?? 'Bendahara';

$keluar_query = mysqli_query($conn, "SELECT SUM(pe.nominal_keluar) as total, COUNT(pe.id_pengeluaran) as jml, MAX(pe.nominal_keluar) as terbesar, AVG(pe.nominal_keluar) as rata FROM pengeluaran pe JOIN grup g ON pe.id_grup = g.id_grup WHERE g.id_bendahara = '$id_user'");
$data_keluar = mysqli_fetch_assoc($keluar_query);
$total_keluar = $data_keluar['total'] ?? 0;
$total_trx = $data_keluar['jml'] ?? 0;
$pengeluaran_terbesar = $data_keluar['terbesar'] ?? 0;
$rata_rata = $data_keluar['rata'] ?? 0;

$tabel_pengeluaran = mysqli_query($conn, "SELECT pe.*, g.nama_grup FROM pengeluaran pe JOIN grup g ON pe.id_grup = g.id_grup WHERE g.id_bendahara = '$id_user' ORDER BY pe.tanggal_keluar DESC");
$daftar_grup = mysqli_query($conn, "SELECT id_grup, nama_grup FROM grup WHERE id_bendahara = '$id_user'");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KasMate - Pengeluaran</title>
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
                <a href="dashboard-bendahara.php" class="menu-item"><i class="fa-solid fa-border-all"></i> Dashboard</a>
                <div class="menu-section">
                    <p class="section-title">KELOLA IURAN</p>
                    <a href="grup-iuran.php" class="menu-item"><i class="fa-solid fa-users-line"></i> Grup Iuran</a>
                    <a href="detail-grup.php" class="menu-item"><i class="fa-solid fa-user-group"></i> Detail Grup</a>
                </div>
                <div class="menu-section">
                    <p class="section-title">KEUANGAN</p>
                    <a href="pemasukan.php" class="menu-item"><i class="fa-solid fa-clock-rotate-left"></i> Pemasukan</a>
                    <a href="pengeluaran.php" class="menu-item active"><i class="fa-regular fa-eye"></i> Pengeluaran</a>
                </div>
                <div class="menu-section">
                    <p class="section-title">LAPORAN</p>
                    <a href="laporan-keuangan.php" class="menu-item"><i class="fa-regular fa-file-lines"></i> Laporan Keuangan</a>
                </div>
            </div>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <div class="header-text">
                    <h1>Pengeluaran</h1>
                    <p class="subtitle">Catat dan pantau semua pengeluaran kas kelompok.</p>
                </div>
                <div class="header-right">
                    <button class="btn-notification"><i class="fa-regular fa-bell"></i></button>
                    <div class="user-profile">
                        <img src="../../../public/assets/image/user_pict.jpg" alt="Profile" style="width: 32px; height: 32px; border-radius: 50%;">
                        <div class="user-info">
                            <span class="user-name"><?php echo htmlspecialchars($nama_bendahara); ?></span>
                            <span class="user-role">Bendahara Utama</span>
                        </div>
                        <i class="fa-solid fa-chevron-down dropdown-icon"></i>
                    </div>
                </div>
            </header>

            <section class="overview-cards">
                <div class="card stat-card">
                    <div><i class="fa-solid fa-arrow-trend-down"></i></div>
                    <div>
                        <p>Total Pengeluaran</p>
                        <h2 class="text-red">Rp <?php echo number_format($total_keluar, 0, ',', '.'); ?></h2>
                    </div>
                </div>
                <div class="card stat-card">
                    <div><i class="fa-solid fa-receipt"></i></div>
                    <div>
                        <p>Total Transaksi</p>
                        <h2><?php echo $total_trx; ?> <span>Transaksi</span></h2>
                    </div>
                </div>
                <div class="card stat-card">
                    <div><i class="fa-solid fa-cart-shopping"></i></div>
                    <div>
                        <p>Pengeluaran Terbesar</p>
                        <h2>Rp <?php echo number_format($pengeluaran_terbesar, 0, ',', '.'); ?></h2>
                    </div>
                </div>
                <div class="card stat-card">
                    <div><i class="fa-solid fa-paperclip"></i></div>
                    <div>
                        <p>Rata-rata Keluar</p>
                        <h2>Rp <?php echo number_format($rata_rata, 0, ',', '.'); ?> <span>/ Trx</span></h2>
                    </div>
                </div>
            </section>

            <section class="card" style="margin-bottom: 25px;">
                <h3 class="card-title">Tambah Pengeluaran Baru</h3>
                <form action="" method="POST" style="display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap;">
                    <div class="input-group" style="margin-bottom: 0; flex: 1; min-width: 150px;">
                        <label>Grup Iuran</label>
                        <select name="id_grup" required style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #cbd5e1;">
                            <option value="">Pilih Grup</option>
                            <?php while($g = mysqli_fetch_assoc($daftar_grup)): ?>
                                <option value="<?php echo $g['id_grup']; ?>"><?php echo htmlspecialchars($g['nama_grup']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="input-group" style="margin-bottom: 0; flex: 1; min-width: 150px;">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1;">
                    </div>
                    <div class="input-group" style="margin-bottom: 0; flex: 2; min-width: 250px;">
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" placeholder="Contoh: Beli ATK, Konsumsi, dll." required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1;">
                    </div>
                    <div class="input-group" style="margin-bottom: 0; flex: 1; min-width: 150px;">
                        <label>Jumlah (Rp)</label>
                        <input type="number" name="jumlah" placeholder="0" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1;">
                    </div>
                    <button type="submit" name="tambah_pengeluaran" class="btn-action btn-dark" style="padding: 12px 20px; height: 46px; border-radius: 10px; border:none; cursor:pointer;">
                        <i class="fa-solid fa-save"></i> Simpan
                    </button>
                </form>
            </section>

            <section class="card table-card">
                <div class="search-box" style="margin-bottom: 20px;">
                    <input type="text" placeholder="Cari pengeluaran...">
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 50px; text-align: center;">No</th>
                            <th>Tanggal</th>
                            <th>Grup</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        while($row = mysqli_fetch_assoc($tabel_pengeluaran)): 
                        ?>
                        <tr>
                            <td style="text-align: center; color: var(--text-muted);"><?php echo $no++; ?></td>
                            <td><?php echo date('d M Y', strtotime($row['tanggal_keluar'])); ?></td>
                            <td><span class="badge" style="background: #f1f5f9; color: #1e293b;"><?php echo htmlspecialchars($row['nama_grup']); ?></span></td>
                            <td class="fw-500"><?php echo htmlspecialchars($row['deskripsi']); ?></td>
                            <td class="fw-500 text-red">- Rp <?php echo number_format($row['nominal_keluar'], 0, ',', '.'); ?></td>
                            <td>
                                <div class="action-icons" style="justify-content: center;">
                                    <i class="fa-solid fa-pen"></i>
                                    <i class="fa-solid fa-trash-can text-red"></i>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        <?php if(mysqli_num_rows($tabel_pengeluaran) == 0): ?>
                        <tr>
                            <td colspan="6" style="text-align:center;">Belum ada data pengeluaran.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>