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
                <div class="sidebar-bottom">
                    <a href="../../controller/bendahara/LogoutController.php" class="menu-item">
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
                        if (count($tabel_pemasukan) > 0):
                            foreach($tabel_pemasukan as $row): 
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
                                        <a href="../../controller/bendahara/PemasukanController.php?hapus_manual=<?php echo $row['id']; ?>" onclick="return confirm('Hapus pemasukan ini?');" style="color: #ef4444;"><i class="fa-solid fa-trash-can"></i></a>
                                    <?php else: ?>
                                        <span style="font-size: 0.8rem; color: #94a3b8;">(Iuran Anggota)</span>
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

    <div id="modalTambahPemasukan" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
        <div style="background:#fff; padding:30px; border-radius:12px; width:480px; max-width:90%; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
            <h3 style="margin-top:0; margin-bottom:20px; color:#1e293b;">Catat Pemasukan Baru</h3>
            <form action="" method="POST">
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500; color:#475569;">Pilih Grup</label>
                    <select name="id_grup" required style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; box-sizing: border-box;">
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
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500; color:#475569;">Pilih Anggota (Opsional)</label>
                    <select name="id_user_pembayar" style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; box-sizing: border-box;">
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