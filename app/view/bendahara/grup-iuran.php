<?php
session_start();
require_once '../../../config/database.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'bendahara') {
    header("Location: ../auth/login.php");
    exit();
}

$id_user = $_SESSION['id_user'];

if (isset($_GET['hapus'])) {
    $id_hapus = $_GET['hapus'];
    
    mysqli_query($conn, "DELETE FROM pembayaran WHERE id_iuran IN (SELECT id_iuran FROM iuran WHERE id_grup='$id_hapus')");
    mysqli_query($conn, "DELETE FROM iuran WHERE id_grup='$id_hapus'");
    mysqli_query($conn, "DELETE FROM pengeluaran WHERE id_grup='$id_hapus'");
    mysqli_query($conn, "DELETE FROM grup_anggota WHERE id_grup='$id_hapus'");
    mysqli_query($conn, "DELETE FROM grup WHERE id_grup='$id_hapus' AND id_bendahara='$id_user'");
    
    header("Location: grup-iuran.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_grup'])) {
    $id_edit = $_POST['id_grup'];
    $nama_edit = $_POST['nama_grup'];
    $deskripsi_edit = $_POST['deskripsi'];
    
    mysqli_query($conn, "UPDATE grup SET nama_grup='$nama_edit', deskripsi='$deskripsi_edit' WHERE id_grup='$id_edit' AND id_bendahara='$id_user'");
    header("Location: grup-iuran.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah_grup'])) {
    $nama_grup = $_POST['nama_grup'];
    $deskripsi = $_POST['deskripsi'];
    
    mysqli_query($conn, "INSERT INTO grup (nama_grup, deskripsi, id_bendahara) VALUES ('$nama_grup', '$deskripsi', '$id_user')");
    header("Location: grup-iuran.php");
    exit();
}

$grup_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM grup WHERE id_bendahara = '$id_user'");
$total_grup = mysqli_fetch_assoc($grup_query)['total'] ?? 0;

$anggota_query = mysqli_query($conn, "SELECT COUNT(DISTINCT ga.id_user) as total FROM grup_anggota ga JOIN grup g ON ga.id_grup = g.id_grup WHERE g.id_bendahara = '$id_user'");
$total_anggota = mysqli_fetch_assoc($anggota_query)['total'] ?? 0;

$iuran_query = mysqli_query($conn, "SELECT AVG(i.nominal) as avg_nominal FROM iuran i JOIN grup g ON i.id_grup = g.id_grup WHERE g.id_bendahara = '$id_user'");
$avg_iuran = mysqli_fetch_assoc($iuran_query)['avg_nominal'] ?? 0;

$max_grup_query = mysqli_query($conn, "SELECT MAX(member_count) as max_member FROM (SELECT COUNT(ga.id_user) as member_count FROM grup g LEFT JOIN grup_anggota ga ON g.id_grup = ga.id_grup WHERE g.id_bendahara = '$id_user' GROUP BY g.id_grup) as counts");
$max_grup = mysqli_fetch_assoc($max_grup_query)['max_member'] ?? 0;

$tabel_grup = mysqli_query($conn, "
    SELECT g.id_grup, g.nama_grup, g.deskripsi, 
    (SELECT COUNT(*) FROM grup_anggota WHERE id_grup = g.id_grup) as jml_anggota,
    (SELECT AVG(nominal) FROM iuran WHERE id_grup = g.id_grup) as avg_nominal
    FROM grup g 
    WHERE g.id_bendahara = '$id_user' 
    ORDER BY g.id_grup DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KasMate - Grup Iuran</title>
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
                    <a href="grup-iuran.php" class="menu-item active"><i class="fa-solid fa-users-line"></i> Grup Iuran</a>
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
                    <h1>Grup Iuran</h1>
                    <p class="subtitle">Kelola semua grup iuran yang Anda buat.</p>
                </div>
                <div class="header-right">
                    <button class="btn-action btn-dark" onclick="document.getElementById('modalTambahGrup').style.display='flex'">
                        <i class="fa-solid fa-plus"></i> Buat Grup Baru
                    </button>
                </div>
            </header>

            <section class="overview-cards">
                <div class="card stat-card">
                    <div><i class="fa-solid fa-users-rectangle"></i></div>
                    <div>
                        <p>Total Grup</p>
                        <h2><?php echo $total_grup; ?></h2>
                    </div>
                </div>
                <div class="card stat-card">
                    <div><i class="fa-solid fa-user-group"></i></div>
                    <div>
                        <p>Total Anggota</p>
                        <h2><?php echo $total_anggota; ?></h2>
                    </div>
                </div>
                <div class="card stat-card">
                    <div><i class="fa-solid fa-money-bill-wave"></i></div>
                    <div>
                        <p>Rata-rata Iuran</p>
                        <h2>Rp <?php echo number_format($avg_iuran, 0, ',', '.'); ?></h2>
                    </div>
                </div>
                <div class="card stat-card">
                    <div><i class="fa-solid fa-chart-column"></i></div>
                    <div>
                        <p>Grup Terbesar</p>
                        <h2><?php echo $max_grup; ?> Orang</h2>
                    </div>
                </div>
            </section>

            <section class="card table-card">
                <div class="search-box" style="margin-bottom: 20px;">
                    <input type="text" placeholder="Cari grup iuran...">
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 50px;">No</th>
                            <th>Nama Grup</th>
                            <th>Deskripsi</th>
                            <th>Jumlah Anggota</th>
                            <th>Iuran per Orang</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        while($row = mysqli_fetch_assoc($tabel_grup)): 
                        ?>
                        <tr>
                            <td style="text-align: center;"><?php echo $no++; ?></td>
                            <td class="fw-500"><?php echo htmlspecialchars($row['nama_grup']); ?></td>
                            <td><?php echo htmlspecialchars($row['deskripsi']); ?></td>
                            <td><?php echo $row['jml_anggota']; ?> Orang</td>
                            <td class="fw-500">Rp <?php echo number_format($row['avg_nominal'] ?? 0, 0, ',', '.'); ?></td>
                            <td>
                                <div class="action-icons" style="justify-content: center; display: flex; gap: 15px; align-items: center;">
                                    <a href="detail-grup.php?id=<?php echo $row['id_grup']; ?>" style="color: #64748b;" title="Lihat Detail"><i class="fa-regular fa-eye"></i></a>
                                    <a href="javascript:void(0);" onclick="openEditModal('<?php echo $row['id_grup']; ?>', '<?php echo addslashes(htmlspecialchars($row['nama_grup'])); ?>', '<?php echo addslashes(htmlspecialchars($row['deskripsi'])); ?>')" style="color: #64748b;" title="Edit Grup"><i class="fa-solid fa-pen"></i></a>
                                    <a href="grup-iuran.php?hapus=<?php echo $row['id_grup']; ?>" onclick="return confirm('Peringatan: Menghapus grup ini juga akan MENGHAPUS SEMUA DATA iuran, pengeluaran, dan pembayaran yang ada di dalamnya. Anda yakin?');" style="color: #ef4444;" title="Hapus Grup"><i class="fa-regular fa-trash-can"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        <?php if(mysqli_num_rows($tabel_grup) == 0): ?>
                        <tr>
                            <td colspan="6" style="text-align:center;">Belum ada grup yang dibuat.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <div id="modalTambahGrup" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
        <div style="background:#fff; padding:30px; border-radius:12px; width:400px; max-width:90%; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
            <h3 style="margin-top:0; margin-bottom:20px; color:#1e293b;">Buat Grup Iuran Baru</h3>
            <form action="" method="POST">
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500; color:#475569;">Nama Grup</label>
                    <input type="text" name="nama_grup" required style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; box-sizing: border-box;">
                </div>
                <div style="margin-bottom:20px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500; color:#475569;">Deskripsi / Keterangan</label>
                    <textarea name="deskripsi" required rows="3" style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; box-sizing: border-box;"></textarea>
                </div>
                <div style="display:flex; justify-content:flex-end; gap:10px;">
                    <button type="button" onclick="document.getElementById('modalTambahGrup').style.display='none'" style="padding:10px 20px; border:none; background:#e2e8f0; color:#475569; font-weight:600; border-radius:8px; cursor:pointer;">Batal</button>
                    <button type="submit" name="tambah_grup" style="padding:10px 20px; border:none; background:#1e293b; color:#fff; font-weight:600; border-radius:8px; cursor:pointer;">Simpan Grup</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalEditGrup" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
        <div style="background:#fff; padding:30px; border-radius:12px; width:400px; max-width:90%; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
            <h3 style="margin-top:0; margin-bottom:20px; color:#1e293b;">Edit Grup Iuran</h3>
            <form action="" method="POST">
                <input type="hidden" name="id_grup" id="edit_id_grup">
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500; color:#475569;">Nama Grup</label>
                    <input type="text" name="nama_grup" id="edit_nama_grup" required style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; box-sizing: border-box;">
                </div>
                <div style="margin-bottom:20px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500; color:#475569;">Deskripsi / Keterangan</label>
                    <textarea name="deskripsi" id="edit_deskripsi" required rows="3" style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; box-sizing: border-box;"></textarea>
                </div>
                <div style="display:flex; justify-content:flex-end; gap:10px;">
                    <button type="button" onclick="document.getElementById('modalEditGrup').style.display='none'" style="padding:10px 20px; border:none; background:#e2e8f0; color:#475569; font-weight:600; border-radius:8px; cursor:pointer;">Batal</button>
                    <button type="submit" name="edit_grup" style="padding:10px 20px; border:none; background:#1e293b; color:#fff; font-weight:600; border-radius:8px; cursor:pointer;">Update Grup</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, nama, deskripsi) {
            document.getElementById('edit_id_grup').value = id;
            document.getElementById('edit_nama_grup').value = nama;
            document.getElementById('edit_deskripsi').value = deskripsi;
            document.getElementById('modalEditGrup').style.display = 'flex';
        }
    </script>
</body>
</html>