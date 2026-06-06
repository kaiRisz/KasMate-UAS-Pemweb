<?php

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
                    <a href="../../controller/bendahara/GrupIuranController.php" class="menu-item"><i class="fa-solid fa-users-line"></i> Grup Iuran</a>
                </div>
                <div class="menu-section">
                    <p class="section-title">KEUANGAN</p>
                    <a href="../../controller/bendahara/PemasukanController.php" class="menu-item active"><i class="fa-solid fa-clock-rotate-left"></i> Pemasukan</a>
                    <a href="../../controller/bendahara/PengeluaranController.php" class="menu-item"><i class="fa-regular fa-eye"></i> Pengeluaran</a>
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
                    <h1>Pemasukan</h1>
                    <p class="subtitle">Catat semua pemasukan keuangan kelompok.</p>
                </div>
                <div class="header-right">
                    <button class="btn-action btn-dark" onclick="document.getElementById('modalTambahPemasukan').classList.add('active')">
                        <i class="fa-solid fa-plus"></i> Tambah Pemasukan
                    </button>
                    <div class="user-profile profile-info-container">
                        <img src="../../../public/assets/image/user_pict.jpg" alt="Profile" class="profile-img-medium">
                        <div class="user-info">
                            <span class="user-name fw-600 block-element"><?php echo htmlspecialchars($nama_bendahara); ?></span>
                            <span class="user-role font-sm text-slate-500">Bendahara</span>
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
                <div class="search-box mb-20">
                    <input type="text" placeholder="Cari pemasukan...">
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="width-50 text-center">No</th>
                            <th>Tanggal</th>
                            <th>Grup</th>
                            <th>Deskripsi (Anggota)</th>
                            <th>Jumlah</th>
                            <th>Metode</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        if (count($tabel_pemasukan) > 0):
                            foreach($tabel_pemasukan as $row): 
                        ?>
                        <tr>
                            <td class="text-center text-muted-custom"><?php echo $no++; ?></td>
                            <td><?php echo date('d M Y', strtotime($row['tanggal'])); ?></td>
                            <td><span class="badge badge-grey"><?php echo htmlspecialchars($row['nama_grup']); ?></span></td>
                            <td class="fw-500"><?php echo htmlspecialchars($row['deskripsi']); ?></td>
                            <td class="fw-500 text-green">+ Rp <?php echo number_format($row['nominal'], 0, ',', '.'); ?></td>
                            <td><span class="badge <?php echo $row['metode'] == 'Transfer' ? 'badge-indigo' : 'badge-emerald'; ?>"><?php echo htmlspecialchars($row['metode']); ?></span></td>
                            <td>
                                <div class="action-icons justify-center">
                                    <?php if($row['tipe'] == 'Manual'): ?>
                                        <a href="../../controller/bendahara/PemasukanController.php?hapus_manual=<?php echo $row['id']; ?>" onclick="return confirm('Hapus pemasukan ini?');" class="text-red"><i class="fa-solid fa-trash-can"></i></a>
                                    <?php else: ?>
                                        <span class="font-sm text-slate-400">(Iuran Anggota)</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php 
                            endforeach;
                        endif; 
                        ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <div class="modal-overlay" id="modalTambahPemasukan">
        <div class="modal-box modal-box-large">
            <h3 class="modal-title">Catat Pemasukan Baru</h3>
            <form action="" method="POST">
                <div class="input-group">
                    <label>Pilih Grup</label>
                    <select name="id_grup" required>
                        <option value="">-- Pilih Grup --</option>
                        <?php
                        if (count($daftar_grup) > 0):
                            foreach($daftar_grup as $g): 
                        ?>
                            <option value="<?php echo $g['id_grup']; ?>"><?php echo htmlspecialchars($g['nama_grup']); ?></option>
                        <?php 
                            endforeach;
                        endif; 
                        ?>
                    </select>
                </div>
                <div class="input-group">
                    <label>Pilih Anggota (Opsional)</label>
                    <select name="id_user_pembayar">
                        <option value="">-- Umum / Bukan Anggota --</option>
                        <?php
                        if (count($daftar_anggota) > 0):
                            foreach($daftar_anggota as $u): 
                        ?>
                            <option value="<?php echo $u['id_user']; ?>"><?php echo htmlspecialchars($u['nama']); ?></option>
                        <?php 
                            endforeach;
                        endif; 
                        ?>
                    </select>
                </div>
                <div class="flex-gap-15 mb-15">
                    <div class="flex-1 input-group-mb-0">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" required class="input-date">
                    </div>
                    <div class="flex-1 input-group-mb-0">
                        <label>Metode</label>
                        <select name="metode" required>
                            <option value="Tunai">Tunai</option>
                            <option value="Transfer">Transfer</option>
                        </select>
                    </div>
                </div>
                <div class="input-group">
                    <label>Deskripsi / Sumber</label>
                    <input type="text" name="deskripsi" placeholder="Contoh: Donasi, Sisa Dana Acara, dll." required>
                </div>
                <div class="input-group mb-25">
                    <label>Nominal (Rp)</label>
                    <input type="number" name="nominal" placeholder="0" required>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="document.getElementById('modalTambahPemasukan').classList.remove('active')">Batal</button>
                    <button type="submit" name="tambah_pemasukan" class="btn-confirm-success">Simpan Pemasukan</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>