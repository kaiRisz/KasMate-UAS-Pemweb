<?php
require_once '../../../config/auth_check.php';
cekRole('bendahara');

$id_user = $_SESSION['id_user'];

if (isset($_GET['hapus_manual'])) {
    $id_hapus = mysqli_real_escape_string($conn, $_GET['hapus_manual']);
    mysqli_query($conn, "DELETE FROM pemasukan_kas WHERE id_pemasukan='$id_hapus'");
    header("Location: pemasukan.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah_pemasukan'])) {
    $id_grup = mysqli_real_escape_string($conn, $_POST['id_grup']);
    $id_anggota = mysqli_real_escape_string($conn, $_POST['id_user_pembayar']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $nominal = mysqli_real_escape_string($conn, $_POST['nominal']);
    $metode = mysqli_real_escape_string($conn, $_POST['metode']);
    
    $val_user = empty($id_anggota) ? "NULL" : "'$id_anggota'";
    
    mysqli_query($conn, "INSERT INTO pemasukan_kas (id_grup, id_user, tanggal, deskripsi, nominal, metode) VALUES ('$id_grup', $val_user, '$tanggal', '$deskripsi', '$nominal', '$metode')");
    header("Location: pemasukan.php");
    exit();
}

$user_q = mysqli_query($conn, "SELECT nama FROM users WHERE id_user = '$id_user'");
$nama_bendahara = mysqli_fetch_assoc($user_q)['nama'] ?? 'Bendahara';

$q_masuk_iuran = mysqli_query($conn, "SELECT SUM(i.nominal) as total, COUNT(p.id_pembayaran) as jml FROM pembayaran p JOIN iuran i ON p.id_iuran = i.id_iuran WHERE p.status = 'Lunas'");
$d_iuran = mysqli_fetch_assoc($q_masuk_iuran);

$q_masuk_manual = mysqli_query($conn, "SELECT SUM(nominal) as total, COUNT(id_pemasukan) as jml, SUM(CASE WHEN metode='Tunai' THEN nominal ELSE 0 END) as tunai, SUM(CASE WHEN metode='Transfer' THEN nominal ELSE 0 END) as tf FROM pemasukan_kas");
$d_manual = mysqli_fetch_assoc($q_masuk_manual);

$total_masuk = ($d_iuran['total'] ?? 0) + ($d_manual['total'] ?? 0);
$total_trx = ($d_iuran['jml'] ?? 0) + ($d_manual['jml'] ?? 0);
$total_tunai = ($d_iuran['total'] ?? 0) + ($d_manual['tunai'] ?? 0);
$total_tf = $d_manual['tf'] ?? 0;

$query_gabungan = "
    SELECT 
        'Iuran' as tipe, p.id_pembayaran as id, p.tanggal_bayar as tanggal, g.nama_grup, 
        CONCAT(i.nama_iuran, ' (', u.nama, ')') as deskripsi, i.nominal, 'Tunai' as metode
    FROM pembayaran p 
    JOIN iuran i ON p.id_iuran = i.id_iuran 
    JOIN grup g ON i.id_grup = g.id_grup 
    JOIN users u ON p.id_user = u.id_user 
    WHERE g.id_bendahara = '$id_user' AND p.status = 'Lunas'
    
    UNION ALL
    
    SELECT 
        'Manual' as tipe, pk.id_pemasukan as id, pk.tanggal, g.nama_grup, 
        IF(pk.id_user IS NOT NULL, CONCAT(pk.deskripsi, ' (', u_man.nama, ')'), pk.deskripsi) as deskripsi, 
        pk.nominal, pk.metode
    FROM pemasukan_kas pk
    JOIN grup g ON pk.id_grup = g.id_grup
    LEFT JOIN users u_man ON pk.id_user = u_man.id_user
    WHERE g.id_bendahara = '$id_user'
    ORDER BY tanggal DESC
";
$tabel_pemasukan = mysqli_query($conn, $query_gabungan);
$daftar_grup = mysqli_query($conn, "SELECT id_grup, nama_grup FROM grup WHERE id_bendahara = '$id_user'");
$daftar_anggota = mysqli_query($conn, "SELECT DISTINCT u.id_user, u.nama FROM users u JOIN grup_anggota ga ON u.id_user = ga.id_user JOIN grup g ON ga.id_grup = g.id_grup WHERE g.id_bendahara = '$id_user'");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KasMate - Pemasukan</title>
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
                    <a href="pemasukan.php" class="menu-item active"><i class="fa-solid fa-clock-rotate-left"></i> Pemasukan</a>
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
                    <h1>Pemasukan</h1>
                    <p class="subtitle">Catat semua pemasukan keuangan kelompok.</p>
                </div>
                <div class="header-right">
                    <button class="btn-action btn-dark" onclick="document.getElementById('modalTambahPemasukan').style.display='flex'">
                        <i class="fa-solid fa-plus"></i> Tambah Pemasukan
                    </button>
                    <div class="user-profile" style="margin-left: 20px; display: flex; align-items: center; gap: 10px;">
                        <img src="../../../public/assets/image/user_pict.jpg" alt="Profile" style="width: 40px; height: 40px; border-radius: 50%;">
                        <div class="user-info">
                            <span class="user-name" style="display: block; font-weight: 600;"><?php echo htmlspecialchars($nama_bendahara); ?></span>
                            <span class="user-role" style="font-size: 0.8rem; color: #64748b;">Bendahara</span>
                        </div>
                    </div>
                </div>
            </header>

            <section class="overview-cards">
                <div class="card stat-card">
                    <div><i class="fa-solid fa-wallet"></i></div>
                    <div>
                        <p>Total Pemasukan</p>
                        <h2>Rp <?php echo number_format($total_masuk, 0, ',', '.'); ?></h2>
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
                    <div><i class="fa-solid fa-money-bill-wave"></i></div>
                    <div>
                        <p>Pemasukan Tunai</p>
                        <h2>Rp <?php echo number_format($total_tunai, 0, ',', '.'); ?></h2>
                    </div>
                </div>
                <div class="card stat-card">
                    <div><i class="fa-solid fa-building-columns"></i></div>
                    <div>
                        <p>Via Transfer</p>
                        <h2>Rp <?php echo number_format($total_tf, 0, ',', '.'); ?></h2>
                    </div>
                </div>
            </section>

            <section class="card table-card">
                <div class="search-box" style="margin-bottom: 20px;">
                    <input type="text" placeholder="Cari pemasukan...">
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 50px; text-align: center;">No</th>
                            <th>Tanggal</th>
                            <th>Grup</th>
                            <th>Deskripsi (Anggota)</th>
                            <th>Jumlah</th>
                            <th>Metode</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        while($row = mysqli_fetch_assoc($tabel_pemasukan)): 
                        ?>
                        <tr>
                            <td style="text-align: center; color: var(--text-muted);"><?php echo $no++; ?></td>
                            <td><?php echo date('d M Y', strtotime($row['tanggal'])); ?></td>
                            <td><span class="badge" style="background: #f1f5f9; color: #1e293b;"><?php echo htmlspecialchars($row['nama_grup']); ?></span></td>
                            <td class="fw-500"><?php echo htmlspecialchars($row['deskripsi']); ?></td>
                            <td class="fw-500 text-green">+ Rp <?php echo number_format($row['nominal'], 0, ',', '.'); ?></td>
                            <td><span class="badge" style="background: <?php echo $row['metode'] == 'Transfer' ? '#e0e7ff' : '#dcfce3'; ?>; color: <?php echo $row['metode'] == 'Transfer' ? '#4f46e5' : '#16a34a'; ?>;"><?php echo htmlspecialchars($row['metode']); ?></span></td>
                            <td>
                                <div class="action-icons" style="justify-content: center;">
                                    <?php if($row['tipe'] == 'Manual'): ?>
                                        <a href="pemasukan.php?hapus_manual=<?php echo $row['id']; ?>" onclick="return confirm('Hapus pemasukan ini?');" style="color: #ef4444;"><i class="fa-solid fa-trash-can"></i></a>
                                    <?php else: ?>
                                        <span style="font-size: 0.8rem; color: #94a3b8;">(Iuran Anggota)</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <div id="modalTambahPemasukan" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
        <div style="background:#fff; padding:30px; border-radius:12px; width:480px; max-width:90%; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
            <h3 style="margin-top:0; margin-bottom:20px; color:#1e293b;">Catat Pemasukan Baru</h3>
            <form action="" method="POST">
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500; color:#475569;">Pilih Grup</label>
                    <select name="id_grup" required style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; box-sizing: border-box;">
                        <option value="">-- Pilih Grup --</option>
                        <?php mysqli_data_seek($daftar_grup, 0); while($g = mysqli_fetch_assoc($daftar_grup)): ?>
                            <option value="<?php echo $g['id_grup']; ?>"><?php echo htmlspecialchars($g['nama_grup']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500; color:#475569;">Pilih Anggota (Opsional)</label>
                    <select name="id_user_pembayar" style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; box-sizing: border-box;">
                        <option value="">-- Umum / Bukan Anggota --</option>
                        <?php while($u = mysqli_fetch_assoc($daftar_anggota)): ?>
                            <option value="<?php echo $u['id_user']; ?>"><?php echo htmlspecialchars($u['nama']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div style="display:flex; gap:15px; margin-bottom:15px;">
                    <div style="flex:1;">
                        <label style="display:block; margin-bottom:5px; font-weight:500; color:#475569;">Tanggal</label>
                        <input type="date" name="tanggal" required style="width:100%; padding:11px; border:1px solid #cbd5e1; border-radius:8px; box-sizing: border-box;">
                    </div>
                    <div style="flex:1;">
                        <label style="display:block; margin-bottom:5px; font-weight:500; color:#475569;">Metode</label>
                        <select name="metode" required style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; box-sizing: border-box;">
                            <option value="Tunai">Tunai</option>
                            <option value="Transfer">Transfer</option>
                        </select>
                    </div>
                </div>
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500; color:#475569;">Deskripsi / Sumber</label>
                    <input type="text" name="deskripsi" placeholder="Contoh: Donasi, Sisa Dana Acara, dll." required style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; box-sizing: border-box;">
                </div>
                <div style="margin-bottom:25px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500; color:#475569;">Nominal (Rp)</label>
                    <input type="number" name="nominal" placeholder="0" required style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; box-sizing: border-box;">
                </div>
                <div style="display:flex; justify-content:flex-end; gap:10px;">
                    <button type="button" onclick="document.getElementById('modalTambahPemasukan').style.display='none'" style="padding:10px 20px; border:none; background:#e2e8f0; color:#475569; font-weight:600; border-radius:8px; cursor:pointer;">Batal</button>
                    <button type="submit" name="tambah_pemasukan" style="padding:10px 20px; border:none; background:#10b981; color:#fff; font-weight:600; border-radius:8px; cursor:pointer;">Simpan Pemasukan</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>