<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KasMate - Buku Besar Laporan Keuangan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../../public/assets/css/style.css">
    <style>
        @media screen {
            .print-header { display: none; }
        }
        @media print {
            body { background: white !important; color: black !important; margin: 0; padding: 0; }
            .sidebar, .topbar, .topbar-mobile, .menu-checkbox, .hamburger-btn, .filter-section { display: none !important; }
            .main-content { padding: 0 !important; margin: 0 !important; width: 100% !important; overflow: visible !important; }
            .dashboard-layout { display: block !important; height: auto !important; }
            .card { box-shadow: none !important; border: none !important; padding: 0 !important; }
            .print-header { display: block !important; text-align: center; margin-bottom: 30px; }
            .print-header h2 { font-size: 24px; margin-bottom: 5px; font-weight: 700; }
            .print-header p { font-size: 14px; color: #333; margin-bottom: 5px; }
            .data-table th { background-color: #f1f5f9 !important; -webkit-print-color-adjust: exact; color: #000 !important; border-bottom: 2px solid #000 !important;}
            .data-table td { border-bottom: 1px solid #ccc !important; }
            .badge, .btn-action { display: inline-block; border: none; background: transparent; padding: 0; font-weight: normal; color: black !important; }
        }
    </style>
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
                    <p class="section-title">LAPORAN</p>
                    <a href="../../controller/bendahara/LaporanKeuanganController.php" class="menu-item active"><i class="fa-regular fa-file-lines"></i> Laporan Keuangan</a>
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
                    <h1>Buku Besar (Ledger)</h1>
                    <p class="subtitle">Laporan riwayat transaksi keluar masuk grup.</p>
                </div>
                <div class="header-right">
                    <div class="user-profile">
                        <img src="../../../public/assets/image/user_pict.jpg" alt="Profile" class="profile-img-small">
                        <div class="user-info">
                            <span class="user-name"><?php echo htmlspecialchars($nama_bendahara); ?></span>
                            <span class="user-role">Bendahara Utama</span>
                        </div>
                    </div>
                </div>
            </header>

            <div class="filter-section mb-20" style="display:flex; justify-content:space-between; align-items:flex-end; flex-wrap:wrap; gap:15px;">
                <form action="" method="GET" style="display:flex; gap:15px; align-items:flex-end; flex-wrap:wrap;">
                    <div style="display:flex; flex-direction:column; gap:5px;">
                        <label class="fw-600 font-sm">Pilih Grup:</label>
                        <select name="id_grup" class="form-control-bordered-select" style="min-width: 200px; padding: 8px 15px;">
                            <?php if(count($daftar_grup) > 0): foreach($daftar_grup as $g): ?>
                                <option value="<?= $g['id_grup'] ?>" <?= $g['id_grup'] == $selected_grup ? 'selected' : '' ?>><?= htmlspecialchars($g['nama_grup']) ?></option>
                            <?php endforeach; else: ?>
                                <option value="">Belum ada grup</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div style="display:flex; flex-direction:column; gap:5px;">
                        <label class="fw-600 font-sm">Dari Tanggal:</label>
                        <input type="date" name="start_date" value="<?= htmlspecialchars($start_date) ?>" class="form-control-bordered" style="padding: 7px 15px;">
                    </div>
                    <div style="display:flex; flex-direction:column; gap:5px;">
                        <label class="fw-600 font-sm">Sampai Tanggal:</label>
                        <input type="date" name="end_date" value="<?= htmlspecialchars($end_date) ?>" class="form-control-bordered" style="padding: 7px 15px;">
                    </div>
                    <button type="submit" class="btn-dark" style="padding: 9px 20px; border-radius: 8px; font-weight: 500; border: none; cursor: pointer;"><i class="fa-solid fa-filter"></i> Filter</button>
                    <?php if(!empty($start_date) || !empty($end_date)): ?>
                        <a href="LaporanKeuanganController.php?id_grup=<?= $selected_grup ?>" class="btn-cancel" style="padding: 9px 20px; text-decoration:none;"><i class="fa-solid fa-rotate-left"></i> Reset</a>
                    <?php endif; ?>
                </form>
                
                <?php if($selected_grup && count($buku_besar) > 0): ?>
                    <button onclick="window.print()" class="btn-confirm-success"><i class="fa-solid fa-print"></i> Cetak PDF</button>
                <?php endif; ?>
            </div>

            <?php if($selected_grup): ?>
            <section class="card table-card">
                <div class="print-header">
                    <h2>Buku Besar Laporan Kas</h2>
                    <p>Grup Iuran: <strong><?= htmlspecialchars($nama_grup_terpilih) ?></strong></p>
                    <?php if(!empty($start_date) && !empty($end_date)): ?>
                        <p>Periode: <?= date('d M Y', strtotime($start_date)) ?> s/d <?= date('d M Y', strtotime($end_date)) ?></p>
                    <?php endif; ?>
                    <p>Dicetak pada: <?= date('d M Y') ?></p>
                    <hr style="margin-top: 15px; border: 1px solid #000;">
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Keterangan Transaksi</th>
                            <th>Debit (Masuk)</th>
                            <th>Kredit (Keluar)</th>
                            <th>Saldo Kas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($start_date)): ?>
                        <tr style="background-color: #f8fafc;">
                            <td class="text-center">-</td>
                            <td class="fw-600">Saldo Awal (Sebelum <?= date('d M Y', strtotime($start_date)) ?>)</td>
                            <td class="text-center">-</td>
                            <td class="text-center">-</td>
                            <td class="fw-600 text-blue">Rp <?= number_format($saldo_awal, 0, ',', '.') ?></td>
                        </tr>
                        <?php endif; ?>

                        <?php 
                        $saldo = $saldo_awal;
                        if(count($buku_besar) > 0): 
                            foreach($buku_besar as $row): 
                                $saldo += $row['masuk'] - $row['keluar'];
                                $total_masuk += $row['masuk'];
                                $total_keluar += $row['keluar'];
                        ?>
                            <tr>
                                <td><?= date('d M Y', strtotime($row['tanggal'])) ?></td>
                                <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                                <td class="text-green">Rp <?= number_format($row['masuk'], 0, ',', '.') ?></td>
                                <td class="text-red">Rp <?= number_format($row['keluar'], 0, ',', '.') ?></td>
                                <td class="fw-600">Rp <?= number_format($saldo, 0, ',', '.') ?></td>
                            </tr>
                        <?php 
                            endforeach; 
                        else: 
                        ?>
                            <tr>
                                <td colspan="5" class="text-center">Belum ada riwayat transaksi pada periode terpilih.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>