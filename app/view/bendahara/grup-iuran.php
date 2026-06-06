<?php

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
    <input type="checkbox" id="menu-toggle" class="menu-checkbox">
    <div class="topbar-mobile">
        <label for="menu-toggle" class="hamburger-btn">
            <i class="fa-solid fa-bars"></i>
        </label>
        <div class="logo-mobile">
            <i class="fa-solid fa-cube"></i> KasMate
        </div>
    </div>
    <label for="menu-toggle" class="sidebar-overlay"></label>

    <div class="dashboard-layout">
        <aside class="sidebar">
            <div class="logo">
                <i class="fa-solid fa-cube"></i>
                <span>KasMate</span>
            </div>
            <div class="sidebar-menu">
                <a href="../../controller/bendahara/DashboardBendaharaController.php" class="menu-item"><i class="fa-solid fa-border-all"></i> Dashboard</a>
                <div class="menu-section">
                    <p class="section-title">KELOLA IURAN</p>
                    <a href="../../controller/bendahara/GrupIuranController.php" class="menu-item active"><i class="fa-solid fa-users-line"></i> Grup Iuran</a>
                </div>
    
                <div class="menu-section">
                    <p class="section-title">LAPORAN</p>
                    <a href="../../controller/bendahara/LaporanKeuanganController.php" class="menu-item"><i class="fa-regular fa-file-lines"></i> Laporan Keuangan</a>
                </div>
                <div class="sidebar-bottom sidebar-footer-menu">
                    <a href="../../controller/auth/LogoutController.php" class="menu-item">
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
                    <button class="btn-action btn-dark" onclick="document.getElementById('modalTambahGrup').classList.add('active')">
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
                <div class="search-box mb-20">
                    <input type="text" placeholder="Cari grup iuran...">
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="text-center width-50">No</th>
                            <th>Nama Grup</th>
                            <th>Deskripsi</th>
                            <th>Jumlah Anggota</th>
                            <th>Iuran per Orang</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        if (count($tabel_grup) > 0):
                            foreach($tabel_grup as $row): 
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $no++; ?></td>
                            <td class="fw-500"><?php echo htmlspecialchars($row['nama_grup']); ?></td>
                            <td><?php echo htmlspecialchars($row['deskripsi']); ?></td>
                            <td><?php echo $row['jml_anggota']; ?> Orang</td>
                            <td class="fw-500">Rp <?php echo number_format($row['avg_nominal'] ?? 0, 0, ',', '.'); ?></td>
                            <td>
                                <div class="action-icons justify-center flex-gap-15 align-center">
                                    <a href="../../controller/bendahara/DetailGrupController.php?id=<?php echo $row['id_grup']; ?>" class="text-slate-500" title="Kelola Grup"><i class="fa-solid fa-pen"></i></a>
                                    <a href="../../controller/bendahara/GrupIuranController.php?hapus=<?php echo $row['id_grup']; ?>" onclick="return confirm('Peringatan: Menghapus grup ini juga akan MENGHAPUS SEMUA DATA iuran, pengeluaran, dan pembayaran yang ada di dalamnya. Anda yakin?');" class="text-red" title="Hapus Grup"><i class="fa-regular fa-trash-can"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php 
                            endforeach;
                        else: 
                        ?>
                        <tr>
                            <td colspan="6" class="text-center">Belum ada grup yang dibuat.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <div class="modal-overlay" id="modalTambahGrup">
        <div class="modal-box">
            <h3 class="modal-title">Buat Grup Iuran Baru</h3>
            <form action="" method="POST">
                <div class="input-group">
                    <label>Nama Grup</label>
                    <input type="text" name="nama_grup" required>
                </div>
                <div class="input-group">
                    <label>Deskripsi / Keterangan</label>
                    <textarea name="deskripsi" required rows="3"></textarea>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="document.getElementById('modalTambahGrup').classList.remove('active')">Batal</button>
                    <button type="submit" name="tambah_grup" class="btn-save">Simpan Grup</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>