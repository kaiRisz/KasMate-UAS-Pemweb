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
                    <h1>Detail Grup</h1>
                    <p class="subtitle">Grup Iuran > <?= htmlspecialchars($nama_grup); ?></p>
                </div>
                <div class="header-right">
                    <button class="btn-notification"><i class="fa-regular fa-bell"></i></button>
                    <div class="user-profile">
                        <img src="../../../public/assets/image/user_pict.jpg" alt="Profile">
                        <div class="user-info">
                            <span class="user-name"><?= htmlspecialchars($nama_bendahara); ?></span>
                            <span class="user-role">Bendahara Utama</span>
                        </div>
                    </div>
                </div>
            </header>

            <div class="tabs-container">
                <a href="../../controller/bendahara/DetailGrupController.php?id=<?= $id_grup; ?>&tab=anggota" class="tab-item <?= $tab == 'anggota' ? 'active' : ''; ?>">Anggota</a>
                <a href="../../controller/bendahara/DetailGrupController.php?id=<?= $id_grup; ?>&tab=tagihan" class="tab-item <?= $tab == 'tagihan' ? 'active' : ''; ?>">Tagihan</a>
                <a href="../../controller/bendahara/DetailGrupController.php?id=<?= $id_grup; ?>&tab=pembayaran" class="tab-item <?= $tab == 'pembayaran' ? 'active' : ''; ?>">Pembayaran</a>
                <a href="../../controller/bendahara/DetailGrupController.php?id=<?= $id_grup; ?>&tab=pemasukan" class="tab-item <?= $tab == 'pemasukan' ? 'active' : ''; ?>">Pemasukan Kas</a>
                <a href="../../controller/bendahara/DetailGrupController.php?id=<?= $id_grup; ?>&tab=pengeluaran" class="tab-item <?= $tab == 'pengeluaran' ? 'active' : ''; ?>">Pengeluaran Kas</a>
                <a href="../../controller/bendahara/DetailGrupController.php?id=<?= $id_grup; ?>&tab=pengaturan_pembayaran" class="tab-item <?= $tab == 'pengaturan_pembayaran' ? 'active' : ''; ?>">Pengaturan Pembayaran</a>
            </div>

            <?php if($tab == 'pembayaran'): ?>
            <section class="overview-cards">
                <div class="card stat-card">
                    <div><i class="fa-solid fa-file-invoice-dollar"></i></div>
                    <div>
                        <p>Total Tagihan</p>
                        <h2>Rp <?= number_format($total_tagihan, 0, ',', '.'); ?></h2>
                    </div>
                </div>
                <div class="card stat-card">
                    <div><i class="fa-regular fa-circle-check"></i></div>
                    <div>
                        <p>Lunas (<?= $persen_lunas; ?>%)</p>
                        <h2>Rp <?= number_format($total_lunas, 0, ',', '.'); ?></h2>
                    </div>
                </div>
                <div class="card stat-card">
                    <div><i class="fa-solid fa-clock-rotate-left"></i></div>
                    <div>
                        <p>Belum Lunas (<?= $persen_belum; ?>%)</p>
                        <h2>Rp <?= number_format($total_belum, 0, ',', '.'); ?></h2>
                    </div>
                </div>
            </section>
            
            <?php elseif($tab == 'pemasukan'): ?>
            <section class="overview-cards">
                <div class="card stat-card">
                    <div><i class="fa-solid fa-money-bill-trend-up"></i></div>
                    <div>
                        <p>Iuran Terkumpul</p>
                        <h2>Rp <?= number_format($total_lunas, 0, ',', '.'); ?></h2>
                    </div>
                </div>
                <div class="card stat-card">
                    <div><i class="fa-solid fa-hand-holding-dollar text-green"></i></div>
                    <div>
                        <p>Pemasukan Lain</p>
                        <h2>Rp <?= number_format($total_pemasukan_lain, 0, ',', '.'); ?></h2>
                    </div>
                </div>
                <div class="card stat-card">
                    <div><i class="fa-solid fa-wallet text-blue"></i></div>
                    <div>
                        <p>Total Kas Masuk</p>
                        <h2>Rp <?= number_format($total_kas_masuk, 0, ',', '.'); ?></h2>
                    </div>
                </div>
            </section>

            <?php elseif($tab == 'pengeluaran'): ?>
            <section class="overview-cards">
                <div class="card stat-card">
                    <div><i class="fa-solid fa-wallet text-blue"></i></div>
                    <div>
                        <p>Total Kas Masuk</p>
                        <h2>Rp <?= number_format($total_kas_masuk, 0, ',', '.'); ?></h2>
                    </div>
                </div>
                <div class="card stat-card">
                    <div><i class="fa-solid fa-file-invoice-dollar text-red"></i></div>
                    <div>
                        <p>Total Pengeluaran</p>
                        <h2>Rp <?= number_format($total_pengeluaran_kas, 0, ',', '.'); ?></h2>
                    </div>
                </div>
                <div class="card stat-card">
                    <div><i class="fa-solid fa-sack-dollar text-green"></i></div>
                    <div>
                        <p>Saldo Tersedia</p>
                        <h2>Rp <?= number_format($saldo_tersedia, 0, ',', '.'); ?></h2>
                    </div>
                </div>
            </section>
            <?php endif; ?>

            <section class="card table-card">
                <?php if($tab == 'anggota'): ?>
                    <div class="table-controls">
                        <h3 class="card-title mb-0">Daftar Anggota Grup</h3>
                        <button class="btn-action btn-dark" onclick="document.getElementById('modalTambahAnggota').classList.add('active')">+ Tambah Anggota</button>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Nama Anggota</th>
                                <th>Email</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            if (count($anggota_grup) > 0):
                                foreach($anggota_grup as $row):
                            ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td class="fw-500"><?= htmlspecialchars($row['nama']); ?></td>
                                <td><?= htmlspecialchars($row['email']); ?></td>
                                <td>
                                    <div class="action-icons justify-center">
                                        <a href="../../controller/bendahara/DetailGrupController.php?id=<?= $id_grup; ?>&tab=anggota&hapus_anggota=<?= $row['id_user']; ?>" onclick="confirmDelete(event, this.href, 'Keluarkan anggota ini dari grup?');" class="text-red"><i class="fa-regular fa-trash-can"></i></a>
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
                        <h3 class="card-title mb-0">Daftar Tagihan Iuran</h3>
                        <button class="btn-action btn-dark" onclick="document.getElementById('modalTambahTagihan').classList.add('active')">+ Buat Tagihan</button>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Nama Iuran / Tagihan</th>
                                <th>Nominal</th>
                                <th>Deadline</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            if (count($tagihan_grup) > 0):
                                foreach($tagihan_grup as $row):
                            ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td class="fw-500"><?= htmlspecialchars($row['nama_iuran']); ?></td>
                                <td class="fw-500">Rp <?= number_format($row['nominal'], 0, ',', '.'); ?></td>
                                <td class="fw-500"><?= $row['deadline'] ? date('d M Y', strtotime($row['deadline'])) : '-'; ?></td>
                                <td>
                                    <div class="action-icons justify-center">
                                        <a href="../../controller/bendahara/DetailGrupController.php?id=<?= $id_grup; ?>&tab=tagihan&hapus_tagihan=<?= $row['id_iuran']; ?>" onclick="confirmDelete(event, this.href, 'Hapus tagihan ini? Data pembayaran terkait juga akan hilang.');" class="text-red"><i class="fa-regular fa-trash-can"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <?php 
                                endforeach;
                            endif; 
                            ?>
                        </tbody>
                    </table>

                <?php elseif($tab == 'pemasukan'): ?>
                    <div class="table-controls">
                        <h3 class="card-title mb-0">Daftar Pemasukan Kas Lainnya</h3>
                        <button class="btn-action btn-dark" onclick="document.getElementById('modalTambahPemasukan').classList.add('active')">+ Tambah Pemasukan</button>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Sumber / Anggota</th>
                                <th>Deskripsi</th>
                                <th>Nominal</th>
                                <th>Metode</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($pemasukan_grup) > 0): ?>
                                <?php foreach($pemasukan_grup as $p): ?>
                                <tr>
                                    <td><?= date('d M Y', strtotime($p['tanggal'])); ?></td>
                                    <td class="fw-500"><?= htmlspecialchars($p['nama_user'] ?? '-'); ?></td>
                                    <td><?= htmlspecialchars($p['deskripsi']); ?></td>
                                    <td class="fw-500 text-green">Rp <?= number_format($p['nominal'], 0, ',', '.'); ?></td>
                                    <td><span class="badge badge-grey"><?= htmlspecialchars($p['metode']); ?></span></td>
                                    <td>
                                        <div class="action-icons justify-center">
                                            <a href="../../controller/bendahara/DetailGrupController.php?id=<?= $id_grup; ?>&tab=pemasukan&hapus_pemasukan=<?= $p['id_pemasukan']; ?>" onclick="confirmDelete(event, this.href, 'Hapus catatan pemasukan kas ini?');" class="text-red"><i class="fa-regular fa-trash-can"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada pemasukan tambahan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                <?php elseif($tab == 'pengeluaran'): ?>
                    <div class="table-controls">
                        <h3 class="card-title mb-0">Daftar Pengeluaran Kas</h3>
                        <button class="btn-action btn-dark" onclick="document.getElementById('modalTambahPengeluaran').classList.add('active')">+ Tambah Pengeluaran</button>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Deskripsi</th>
                                <th>Nominal Keluar</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($pengeluaran_grup) > 0): ?>
                                <?php foreach($pengeluaran_grup as $p): ?>
                                <tr>
                                    <td><?= date('d M Y', strtotime($p['tanggal_keluar'])); ?></td>
                                    <td><?= htmlspecialchars($p['deskripsi']); ?></td>
                                    <td class="fw-500 text-red">Rp <?= number_format($p['nominal_keluar'], 0, ',', '.'); ?></td>
                                    <td>
                                        <div class="action-icons justify-center">
                                            <a href="../../controller/bendahara/DetailGrupController.php?id=<?= $id_grup; ?>&tab=pengeluaran&hapus_pengeluaran=<?= $p['id_pengeluaran']; ?>" onclick="confirmDelete(event, this.href, 'Hapus catatan pengeluaran kas ini?');" class="text-red"><i class="fa-regular fa-trash-can"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada pengeluaran yang dicatat.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                <?php elseif($tab == 'pengaturan_pembayaran'): ?>
                    <div class="card card-flat">
                        <h3 class="card-title mb-20"><i class="fa-solid fa-building-columns text-blue"></i> Pengaturan Rekening & QRIS</h3>
                        <p class="text-muted-custom text-sm mb-20">Masukkan detail metode pembayaran agar anggota bisa melakukan transfer ke rekening ini.</p>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="input-group">
                                <label>Bank / E-Wallet</label>
                                <input type="text" name="rekening_bank" value="<?= htmlspecialchars($grup_info['rekening_bank'] ?? '') ?>" placeholder="Contoh: BCA, Mandiri, DANA, GoPay" required class="form-control-bordered">
                            </div>
                            <div class="input-group">
                                <label>Nomor Rekening / No. HP</label>
                                <input type="text" name="rekening_nomor" value="<?= htmlspecialchars($grup_info['rekening_nomor'] ?? '') ?>" placeholder="Contoh: 1234567890" required class="form-control-bordered">
                            </div>
                            <div class="input-group">
                                <label>Atas Nama (A/N)</label>
                                <input type="text" name="rekening_nama" value="<?= htmlspecialchars($grup_info['rekening_nama'] ?? '') ?>" placeholder="Contoh: Faqih Lakaisha Putra" required class="form-control-bordered">
                            </div>
                            <div class="input-group">
                                <label>Upload QRIS (Opsional)</label>
                                <?php if(!empty($grup_info['qris_image'])): ?>
                                    <img src="../../../public/assets/uploads/qris/<?= $grup_info['qris_image'] ?>" alt="QRIS" class="qris-preview">
                                <?php endif; ?>
                                <input type="file" name="qris_image" accept="image/*" class="form-control-bordered">
                                <small class="text-muted-custom">*Biarkan kosong jika tidak ingin mengubah atau menambahkan foto QRIS</small>
                            </div>
                            <div class="flex-justify-end mt-20">
                                <button type="submit" name="simpan_pengaturan_pembayaran" class="btn-save-profile">Simpan Pengaturan</button>
                            </div>
                        </form>
                    </div>

                <?php elseif($tab == 'pembayaran'): ?>
                    <div class="table-controls">
                        <h3 class="card-title mb-0">Konfirmasi Pengajuan Pembayaran</h3>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Nama Anggota</th>
                                <th>Nama Tagihan</th>
                                <th>Metode</th>
                                <th>Bukti Transfer</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($pembayaran_grup) > 0): ?>
                                <?php foreach($pembayaran_grup as $p): ?>
                                    <tr>
                                        <td class="fw-500"><?= htmlspecialchars($p['nama']); ?></td>
                                        <td><?= htmlspecialchars($p['nama_iuran']); ?> (Rp <?= number_format($p['nominal'], 0, ',', '.'); ?>)</td>
                                        <td><span class="badge badge-grey"><?= htmlspecialchars($p['metode_pembayaran'] ?? 'Cash'); ?></span></td>
                                        <td>
                                            <?php if (!empty($p['bukti_pembayaran'])): ?>
                                                <button type="button" class="btn-action" onclick="lihatBuktiTransfer('../../../public/assets/uploads/bukti_tf/<?= $p['bukti_pembayaran']; ?>')"><i class="fa-regular fa-image"></i> Lihat Bukti</button>
                                            <?php else: ?>
                                                <span class="text-slate-400 font-sm">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php 
                                                $st = $p['status'];
                                                $bc = ($st == 'Lunas') ? 'badge-lunas' : (($st == 'Menunggu Verifikasi') ? 'badge-pending' : 'badge-terlambat');
                                            ?>
                                            <span class="badge <?= $bc; ?>"><?= $st; ?></span>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($st == 'Menunggu Verifikasi'): ?>
                                                <div class="action-buttons">
                                                    <a href="DetailGrupController.php?id=<?= $id_grup; ?>&tab=pembayaran&setujui_pembayaran=<?= $p['id_pembayaran']; ?>" class="btn-confirm-success">Setujui</a>
                                                    <a href="DetailGrupController.php?id=<?= $id_grup; ?>&tab=pembayaran&tolak_pembayaran=<?= $p['id_pembayaran']; ?>" class="btn-danger">Tolak</a>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-slate-400 font-sm">-</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada riwayat pengajuan pembayaran di grup ini.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <div class="table-controls mt-25">
                        <h3 class="card-title mb-0">Status Global Pembayaran Anggota</h3>
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
                                <td class="fw-500"><?= htmlspecialchars($row['nama']); ?></td>
                                <td><span class="badge <?= $badge_class; ?>"><?= $status; ?></span></td>
                                <td><?= $tgl_bayar; ?></td>
                                <td>Rp <?= number_format($row['dibayar'] ?? 0, 0, ',', '.'); ?></td>
                                <td>Rp <?= number_format($sisa_tagihan > 0 ? $sisa_tagihan : 0, 0, ',', '.'); ?></td>
                                <td>
                                    <?php if($sisa_tagihan > 0): ?>
                                        <button class="btn-action btn-dark" onclick="openBayarModal('<?= $row['id_user']; ?>', '<?= addslashes(htmlspecialchars($row['nama'])); ?>')">Bayar Manual</button>
                                    <?php else: ?>
                                        <div class="action-icons"><i class="fa-regular fa-circle-check text-green"></i></div>
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

    <div class="modal-overlay" id="modalTambahAnggota">
        <div class="modal-box">
            <h3 class="modal-title mb-5"><i class="fa-solid fa-user-plus text-blue"></i> Tambah Anggota</h3>
            <p class="text-muted-custom text-sm mb-20">Pilih pengguna untuk ditambahkan ke grup iuran ini.</p>
            <form action="" method="POST">
                <div class="input-group">
                    <label>Pilih User</label>
                    <select name="id_user_baru" required class="form-control-bordered-select">
                        <option value="">-- Pilih User --</option>
                        <?php if (count($users_not_in_grup) > 0): foreach($users_not_in_grup as $u): ?>
                        <option value="<?= $u['id_user']; ?>"><?= htmlspecialchars($u['nama']); ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="document.getElementById('modalTambahAnggota').classList.remove('active')">Batal</button>
                    <button type="submit" name="tambah_anggota" class="btn-add-user"><i class="fa-solid fa-plus"></i> Tambahkan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="modalTambahTagihan">
        <div class="modal-box">
            <h3 class="modal-title mb-5"><i class="fa-solid fa-file-circle-plus text-green"></i> Buat Tagihan</h3>
            <p class="text-muted-custom text-sm mb-20">Tentukan nama, nominal, dan batas waktu tagihan untuk anggota grup.</p>
            <form action="" method="POST">
                <div class="input-group">
                    <label>Nama Iuran</label>
                    <input type="text" name="nama_iuran" placeholder="Contoh: Iuran Bulan Mei" required class="form-control-bordered">
                </div>
                <div class="input-group">
                    <label>Nominal (Rp)</label>
                    <input type="number" name="nominal" placeholder="Contoh: 50000" required class="form-control-bordered">
                </div>
                <div class="input-group">
                    <label>Deadline / Batas Waktu</label>
                    <input type="date" name="deadline" required class="form-control-bordered">
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="document.getElementById('modalTambahTagihan').classList.remove('active')">Batal</button>
                    <button type="submit" name="tambah_tagihan" class="btn-add-user"><i class="fa-solid fa-check"></i> Simpan Tagihan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="modalBayar">
        <div class="modal-box">
            <h3 class="modal-title mb-5"><i class="fa-solid fa-money-bill-transfer text-orange"></i> Catat Pembayaran Cash</h3>
            <p class="text-muted-custom text-sm mb-20">Input manual jika anggota menitipkan uang tunai (Cash) secara langsung.</p>
            <form action="" method="POST">
                <input type="hidden" name="id_user_bayar" id="bayar_id_user">
                <div class="input-group">
                    <label>Nama Anggota</label>
                    <input type="text" id="bayar_nama_user" class="input-readonly" readonly>
                </div>
                <div class="input-group">
                    <label>Pilih Tagihan yang Dibayar</label>
                    <select name="id_iuran_bayar" required class="form-control-bordered-select">
                        <?php if (count($tagihan_grup) > 0): foreach($tagihan_grup as $i): ?>
                        <option value="<?= $i['id_iuran']; ?>"><?= htmlspecialchars($i['nama_iuran']); ?> (Rp <?= number_format($i['nominal'], 0, ',', '.'); ?>)</option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="document.getElementById('modalBayar').classList.remove('active')">Batal</button>
                    <button type="submit" name="bayar_tagihan" class="btn-confirm-success"><i class="fa-solid fa-check-double"></i> Konfirmasi Bayar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="modalTambahPemasukan">
        <div class="modal-box">
            <h3 class="modal-title mb-5">Tambah Pemasukan Kas</h3>
            <form action="" method="POST">
                <div class="input-group">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" required class="form-control-bordered" value="<?= date('Y-m-d'); ?>">
                </div>
                <div class="input-group">
                    <label>Deskripsi (Sumber Dana)</label>
                    <input type="text" name="deskripsi" placeholder="Contoh: Donasi Pak RT" required class="form-control-bordered">
                </div>
                <div class="input-group">
                    <label>Nominal (Rp)</label>
                    <input type="number" name="nominal" required class="form-control-bordered">
                </div>
                <div class="input-group">
                    <label>Metode</label>
                    <select name="metode" required class="form-control-bordered-select">
                        <option value="Cash">Cash</option>
                        <option value="Transfer">Transfer</option>
                    </select>
                </div>
                <div class="input-group">
                    <label>Terkait Anggota (Opsional)</label>
                    <select name="id_user" class="form-control-bordered-select">
                        <option value="">-- Bukan dari anggota spesifik --</option>
                        <?php if (count($anggota_grup) > 0): foreach($anggota_grup as $u): ?>
                        <option value="<?= $u['id_user']; ?>"><?= htmlspecialchars($u['nama']); ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="document.getElementById('modalTambahPemasukan').classList.remove('active')">Batal</button>
                    <button type="submit" name="tambah_pemasukan" class="btn-confirm-success">Simpan Pemasukan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="modalTambahPengeluaran">
        <div class="modal-box">
            <h3 class="modal-title mb-5 text-red">Catat Pengeluaran Kas</h3>
            <form action="" method="POST">
                <div class="input-group">
                    <label>Tanggal Keluar</label>
                    <input type="date" name="tanggal_keluar" required class="form-control-bordered" value="<?= date('Y-m-d'); ?>">
                </div>
                <div class="input-group">
                    <label>Deskripsi Pengeluaran</label>
                    <input type="text" name="deskripsi" placeholder="Contoh: Beli sapu & ember" required class="form-control-bordered">
                </div>
                <div class="input-group">
                    <label>Nominal (Rp)</label>
                    <input type="number" name="nominal_keluar" required class="form-control-bordered">
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="document.getElementById('modalTambahPengeluaran').classList.remove('active')">Batal</button>
                    <button type="submit" name="tambah_pengeluaran" class="btn-danger">Simpan Pengeluaran</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="modalConfirmDelete">
        <div class="modal-box">
            <h3 class="modal-title text-red mb-15">Konfirmasi Hapus</h3>
            <p id="deleteConfirmMessage" class="text-muted-custom mb-25 text-sm"></p>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="document.getElementById('modalConfirmDelete').classList.remove('active')">Batal</button>
                <a href="#" id="deleteConfirmBtn" class="btn-danger">Ya, Hapus</a>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="modalLihatBukti">
        <div class="modal-box text-center" style="max-width: 500px;">
            <h3 class="modal-title mb-15">Bukti Transfer</h3>
            <img id="gambarBuktiTransfer" src="" alt="Bukti Transfer" style="max-width: 100%; max-height: 60vh; border-radius: 8px; object-fit: contain; margin-bottom: 20px;">
            <div class="modal-actions justify-center">
                <button type="button" class="btn-cancel" onclick="document.getElementById('modalLihatBukti').classList.remove('active')">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        function openBayarModal(id_user, nama_user) {
            document.getElementById('bayar_id_user').value = id_user;
            document.getElementById('bayar_nama_user').value = nama_user;
            document.getElementById('modalBayar').classList.add('active');
        }

        function confirmDelete(event, url, message) {
            event.preventDefault();
            document.getElementById('deleteConfirmMessage').innerText = message;
            document.getElementById('deleteConfirmBtn').href = url;
            document.getElementById('modalConfirmDelete').classList.add('active');
        }

        function lihatBuktiTransfer(imageUrl) {
            document.getElementById('gambarBuktiTransfer').src = imageUrl;
            document.getElementById('modalLihatBukti').classList.add('active');
        }
    </script>
</body>
</html>