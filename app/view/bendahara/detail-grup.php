<?php

$total_tagihan = $data_tagihan['total_tagihan'] ?? 0;
$total_lunas = $data_tagihan['total_lunas'] ?? 0;
$total_belum = $data_tagihan['total_belum'] ?? 0;

$persen_lunas = $total_tagihan > 0 ? round(($total_lunas / $total_tagihan) * 100, 1) : 0;
$persen_belum = $total_tagihan > 0 ? round(($total_belum / $total_tagihan) * 100, 1) : 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KasMate - Detail Grup</title>
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
                    <p class="section-title">KEUANGAN</p>
                    <a href="../../controller/bendahara/PemasukanController.php" class="menu-item"><i class="fa-solid fa-clock-rotate-left"></i> Pemasukan</a>
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
                    <h1>Detail Grup</h1>
                    <p class="subtitle">Grup Iuran > <?php echo htmlspecialchars($nama_grup); ?></p>
                </div>
                <div class="header-right">
                    <button class="btn-notification"><i class="fa-regular fa-bell"></i></button>
                    <div class="user-profile">
                        <img src="../../../public/assets/image/user_pict.jpg" alt="Profile" style="width: 32px; height: 32px; border-radius: 50%;">
                        <div class="user-info">
                            <span class="user-name"><?php echo htmlspecialchars($nama_bendahara); ?></span>
                            <span class="user-role">Bendahara Utama</span>
                        </div>
                    </div>
                </div>
            </header>

            <div class="tabs-container">
                <a href="../../controller/bendahara/DetailGrupController.php?id=<?php echo $id_grup; ?>&tab=anggota" class="tab-item <?php echo $tab == 'anggota' ? 'active' : ''; ?>">Anggota</a>
                <a href="../../controller/bendahara/DetailGrupController.php?id=<?php echo $id_grup; ?>&tab=tagihan" class="tab-item <?php echo $tab == 'tagihan' ? 'active' : ''; ?>">Tagihan</a>
                <a href="../../controller/bendahara/DetailGrupController.php?id=<?php echo $id_grup; ?>&tab=pembayaran" class="tab-item <?php echo $tab == 'pembayaran' ? 'active' : ''; ?>">Pembayaran</a>
            </div>

            <?php if($tab == 'pembayaran'): ?>
            <section class="overview-cards">
                <div class="card stat-card">
                    <div><i class="fa-solid fa-file-invoice-dollar"></i></div>
                    <div>
                        <p>Total Tagihan</p>
                        <h2>Rp <?php echo number_format($total_tagihan, 0, ',', '.'); ?></h2>
                    </div>
                </div>
                <div class="card stat-card">
                    <div><i class="fa-regular fa-circle-check"></i></div>
                    <div>
                        <p>Lunas (<?php echo $persen_lunas; ?>%)</p>
                        <h2>Rp <?php echo number_format($total_lunas, 0, ',', '.'); ?></h2>
                    </div>
                </div>
                <div class="card stat-card">
                    <div><i class="fa-solid fa-clock-rotate-left"></i></div>
                    <div>
                        <p>Belum Lunas (<?php echo $persen_belum; ?>%)</p>
                        <h2>Rp <?php echo number_format($total_belum, 0, ',', '.'); ?></h2>
                    </div>
                </div>
            </section>
            <?php endif; ?>

            <section class="card table-card">
                <?php if($tab == 'anggota'): ?>
                    <div class="table-controls">
                        <h3 class="card-title" style="margin-bottom: 0;">Daftar Anggota Grup</h3>
                        <button class="btn-action btn-dark" onclick="document.getElementById('modalTambahAnggota').style.display='flex'">+ Tambah Anggota</button>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Anggota</th>
                                <th>Email</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            if (count($anggota_grup) > 0):
                                foreach($anggota_grup as $row):
                            ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $no++; ?></td>
                                <td class="fw-500"><?php echo htmlspecialchars($row['nama']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td>
                                    <div class="action-icons" style="justify-content: center;">
                                        <a href="../../controller/bendahara/DetailGrupController.php?id=<?php echo $id_grup; ?>&tab=anggota&hapus_anggota=<?php echo $row['id_user']; ?>" onclick="return confirm('Keluarkan anggota ini dari grup?');" style="color: #ef4444;"><i class="fa-regular fa-trash-can"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <?php 
                                endforeach;
                            endif; 
                            ?>
                        </tbody>
                    </table>

                <?php elseif($tab == 'tagihan'): ?>
                    <div class="table-controls">
                        <h3 class="card-title" style="margin-bottom: 0;">Daftar Tagihan Iuran</h3>
                        <button class="btn-action btn-dark" onclick="document.getElementById('modalTambahTagihan').style.display='flex'">+ Buat Tagihan</button>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Iuran / Tagihan</th>
                                <th>Nominal</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            if (count($tagihan_grup) > 0):
                                foreach($tagihan_grup as $row):
                            ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $no++; ?></td>
                                <td class="fw-500"><?php echo htmlspecialchars($row['nama_iuran']); ?></td>
                                <td class="fw-500">Rp <?php echo number_format($row['nominal'], 0, ',', '.'); ?></td>
                                <td>
                                    <div class="action-icons" style="justify-content: center;">
                                        <a href="../../controller/bendahara/DetailGrupController.php?id=<?php echo $id_grup; ?>&tab=tagihan&hapus_tagihan=<?php echo $row['id_iuran']; ?>" onclick="return confirm('Hapus tagihan ini? Data pembayaran terkait juga akan hilang.');" style="color: #ef4444;"><i class="fa-regular fa-trash-can"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <?php 
                                endforeach;
                            endif; 
                            ?>
                        </tbody>
                    </table>

                <?php else: ?>
                    <div class="table-controls">
                        <h3 class="card-title" style="margin-bottom: 0;">Status Pembayaran Anggota</h3>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Nama Anggota</th>
                                <th>Status Global</th>
                                <th>Terakhir Bayar</th>
                                <th>Total Bayar</th>
                                <th>Sisa Tagihan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (count($status_pembayaran_anggota) > 0):
                                foreach($status_pembayaran_anggota as $row):
                                    $sisa_tagihan = $row['total_beban'] - $row['dibayar'];
                                    $status = ($sisa_tagihan <= 0 && $row['total_beban'] > 0) ? "Lunas" : "Belum Lunas";
                                    $badge_class = ($status == "Lunas") ? "badge-lunas" : "badge-pending";
                                    $tgl_bayar = $row['tgl_bayar'] ? date('d M Y', strtotime($row['tgl_bayar'])) : '-';
                            ?>
                            <tr>
                                <td class="fw-500"><?php echo htmlspecialchars($row['nama']); ?></td>
                                <td><span class="badge <?php echo $badge_class; ?>"><?php echo $status; ?></span></td>
                                <td><?php echo $tgl_bayar; ?></td>
                                <td>Rp <?php echo number_format($row['dibayar'] ?? 0, 0, ',', '.'); ?></td>
                                <td>Rp <?php echo number_format($sisa_tagihan > 0 ? $sisa_tagihan : 0, 0, ',', '.'); ?></td>
                                <td>
                                    <?php if($sisa_tagihan > 0): ?>
                                        <button class="btn-action btn-dark" onclick="openBayarModal('<?php echo $row['id_user']; ?>', '<?php echo addslashes(htmlspecialchars($row['nama'])); ?>')">Bayar</button>
                                    <?php else: ?>
                                        <div class="action-icons"><i class="fa-regular fa-circle-check" style="color: #10b981;"></i></div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php 
                                endforeach;
                            endif; 
                            ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </section>
        </main>
    </div>

    <div id="modalTambahAnggota" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
        <div style="background:#fff; padding:30px; border-radius:12px; width:400px; max-width:90%; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
            <h3 style="margin-top:0; margin-bottom:20px; color:#1e293b;">Tambah Anggota Baru</h3>
            <form action="" method="POST">
                <div style="margin-bottom:20px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500; color:#475569;">Pilih User</label>
                    <select name="id_user_baru" required style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; box-sizing: border-box;">
                        <option value="">-- Pilih User --</option>
                        <?php
                        if (count($users_not_in_grup) > 0):
                            foreach($users_not_in_grup as $u):
                        ?>
                        <option value="<?php echo $u['id_user']; ?>"><?php echo htmlspecialchars($u['nama']); ?></option>
                        <?php 
                            endforeach;
                        endif; 
                        ?>
                    </select>
                </div>
                <div style="display:flex; justify-content:flex-end; gap:10px;">
                    <button type="button" onclick="document.getElementById('modalTambahAnggota').style.display='none'" style="padding:10px 20px; border:none; background:#e2e8f0; color:#475569; font-weight:600; border-radius:8px; cursor:pointer;">Batal</button>
                    <button type="submit" name="tambah_anggota" style="padding:10px 20px; border:none; background:#1e293b; color:#fff; font-weight:600; border-radius:8px; cursor:pointer;">Tambahkan</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalTambahTagihan" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
        <div style="background:#fff; padding:30px; border-radius:12px; width:400px; max-width:90%; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
            <h3 style="margin-top:0; margin-bottom:20px; color:#1e293b;">Buat Tagihan Iuran</h3>
            <form action="" method="POST">
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500; color:#475569;">Nama Iuran</label>
                    <input type="text" name="nama_iuran" placeholder="Contoh: Iuran Bulan Mei" required style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; box-sizing: border-box;">
                </div>
                <div style="margin-bottom:20px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500; color:#475569;">Nominal (Rp)</label>
                    <input type="number" name="nominal" placeholder="50000" required style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; box-sizing: border-box;">
                </div>
                <div style="display:flex; justify-content:flex-end; gap:10px;">
                    <button type="button" onclick="document.getElementById('modalTambahTagihan').style.display='none'" style="padding:10px 20px; border:none; background:#e2e8f0; color:#475569; font-weight:600; border-radius:8px; cursor:pointer;">Batal</button>
                    <button type="submit" name="tambah_tagihan" style="padding:10px 20px; border:none; background:#1e293b; color:#fff; font-weight:600; border-radius:8px; cursor:pointer;">Buat Tagihan</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalBayar" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
        <div style="background:#fff; padding:30px; border-radius:12px; width:400px; max-width:90%; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
            <h3 style="margin-top:0; margin-bottom:20px; color:#1e293b;">Bayar Tagihan</h3>
            <form action="" method="POST">
                <input type="hidden" name="id_user_bayar" id="bayar_id_user">
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500; color:#475569;">Nama Anggota</label>
                    <input type="text" id="bayar_nama_user" readonly style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; box-sizing: border-box; background:#f1f5f9;">
                </div>
                <div style="margin-bottom:20px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500; color:#475569;">Pilih Tagihan yang Dibayar</label>
                    <select name="id_iuran_bayar" required style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px; box-sizing: border-box;">
                        <?php
                        if (count($tagihan_grup) > 0):
                            foreach($tagihan_grup as $i):
                        ?>
                        <option value="<?php echo $i['id_iuran']; ?>"><?php echo htmlspecialchars($i['nama_iuran']); ?> (Rp <?php echo number_format($i['nominal'], 0, ',', '.'); ?>)</option>
                        <?php 
                            endforeach;
                        endif; 
                        ?>
                    </select>
                </div>
                <div style="display:flex; justify-content:flex-end; gap:10px;">
                    <button type="button" onclick="document.getElementById('modalBayar').style.display='none'" style="padding:10px 20px; border:none; background:#e2e8f0; color:#475569; font-weight:600; border-radius:8px; cursor:pointer;">Batal</button>
                    <button type="submit" name="bayar_tagihan" style="padding:10px 20px; border:none; background:#10b981; color:#fff; font-weight:600; border-radius:8px; cursor:pointer;">Konfirmasi Bayar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openBayarModal(id_user, nama_user) {
            document.getElementById('bayar_id_user').value = id_user;
            document.getElementById('bayar_nama_user').value = nama_user;
            document.getElementById('modalBayar').style.display = 'flex';
        }
    </script>
</body>
</html>