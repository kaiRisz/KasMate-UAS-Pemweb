<?php

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tagihan Saya</title>
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
        <i class="fa-solid fa-cube"></i>
        <span>KasMate</span>
    </div>
</div>

<label for="menu-toggle" class="sidebar-overlay"></label>

    <div class="dashboard-layout">
        <aside class="sidebar">
            <div class="logo">
                <i class="fa-solid fa-cube"></i>
                <span>KasMate</span>
            </div>
            <div class="menu-section">
                <a href="../../controller/user/DashboardUserController.php" class="menu-item">
                    <i class="fa-solid fa-house-chimney"></i> Dashboard
                </a>
                <a href="../../controller/user/TagihanUserController.php" class="menu-item active">
                    <i class="fa-solid fa-file-invoice-dollar"></i> Tagihan Saya
                </a>
                <a href="../../controller/user/RiwayatUserController.php" class="menu-item">
                    <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Pembayaran
                </a>
                <a href="../../controller/user/GrupUserController.php" class="menu-item">
                    <i class="fa-solid fa-users-line"></i> Grup Saya
                </a>
                <a href="../../controller/user/ProfilUserController.php" class="menu-item">
                    <i class="fa-solid fa-circle-user"></i> Profil
                </a>
                <a href="../../controller/auth/LogoutController.php" class="menu-item">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </div>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <div class="header-text">
                    <h1>Tagihan</h1>
                    <p class="subtitle">Lihat & Bayar Tagihan Saya</p>
                </div>
                <div class="header-right">
                    <button class="btn-notification">
                        <i class="fa-solid fa-bell"></i>
                    </button>
                    <div class="user-profile">
                        <img src="../../../public/assets/image/user_pict.jpg" alt="<?= htmlspecialchars($nama_user); ?>">
                        <div class="user-info">
                            <span class="user-name"><?= htmlspecialchars($nama_user); ?></span>
                            <span class="user-role">Anggota</span>
                        </div>
                    </div>
                </div>
            </header>

            <section class="overview-cards">
                <div class="card stat-card">
                    <div><i class="fa-solid fa-file-invoice-dollar"></i></div>
                    <div>
                        <p>Total Tagihan</p>
                        <h2>Rp <?= number_format($total_tagihan, 0, ',', '.'); ?></h2>
                    </div>
                </div>
                <div class="card stat-card">
                    <div><i class="fa-solid fa-circle-check text-green"></i></div>
                    <div>
                        <p>Sudah Bayar</p>
                        <h2>Rp <?= number_format($sudah_bayar, 0, ',', '.'); ?></h2>
                    </div>
                </div>
                <div class="card stat-card">
                    <div><i class="fa-solid fa-clock-rotate-left text-orange"></i></div>
                    <div>
                        <p>Belum Bayar</p>
                        <h2>Rp <?= number_format($belum_bayar, 0, ',', '.'); ?></h2>
                    </div>
                </div>
            </section>

            <section class="card table-card">
                <h3 class="card-title">Daftar Semua Tagihan</h3>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Grup</th>
                            <th>Nama Iuran</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Deadline</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tagihan_list as $row): ?>
                            <?php 
                                $status = $row['status_bayar'];
                                if ($status == 'Lunas') {
                                    $status_class = 'badge-lunas';
                                    $btn_html = '<button class="btn-action btn-success-disabled" disabled><i class="fa-solid fa-check"></i> Selesai</button>';
                                } elseif ($status == 'Menunggu Verifikasi') {
                                    $status_class = 'badge-pending';
                                    $btn_html = '<button class="btn-action btn-disabled" disabled><i class="fa-solid fa-clock"></i> Diproses</button>';
                                } elseif ($status == 'Ditolak') {
                                    $status_class = 'badge-terlambat';
                                    $btn_html = '<button class="btn-action btn-dark" onclick="bukaModalBayar('.$row['id_iuran'].', \''.htmlspecialchars($row['nama_iuran']).'\', '.$row['nominal'].', \''.htmlspecialchars($row['rekening_bank'] ?? '').'\', \''.htmlspecialchars($row['rekening_nomor'] ?? '').'\', \''.htmlspecialchars($row['rekening_nama'] ?? '').'\', \''.htmlspecialchars($row['qris_image'] ?? '').'\')">Bayar Ulang</button>';
                                } else {
                                    $status_class = 'badge-pending';
                                    $btn_html = '<button class="btn-action btn-dark" onclick="bukaModalBayar('.$row['id_iuran'].', \''.htmlspecialchars($row['nama_iuran']).'\', '.$row['nominal'].', \''.htmlspecialchars($row['rekening_bank'] ?? '').'\', \''.htmlspecialchars($row['rekening_nomor'] ?? '').'\', \''.htmlspecialchars($row['rekening_nama'] ?? '').'\', \''.htmlspecialchars($row['qris_image'] ?? '').'\')">Bayar Sekarang</button>';
                                }
                            ?>
                            <tr>
                                <td class="fw-500"><?= htmlspecialchars($row['nama_grup']); ?></td>
                                <td class="fw-500"><?= htmlspecialchars($row['nama_iuran']); ?></td>
                                <td class="fw-500 text-green">Rp <?= number_format($row['nominal'], 0, ',', '.'); ?></td>
                                <td><span class="badge <?= $status_class; ?>"><?= $status; ?></span></td>
                                <td class="fw-500"><?= !empty($row['deadline']) ? date('d M Y', strtotime($row['deadline'])) : '-'; ?></td>
                                <td><?= $btn_html; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <div class="modal-overlay" id="modalBayar">
        <div class="modal-box">
            <h3 class="modal-title mb-5"><i class="fa-solid fa-money-bill-wave text-blue"></i> Pembayaran Iuran</h3>
            <p class="text-muted-custom text-sm mb-20">Pilih metode pembayaran untuk melunasi tagihan.</p>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="proses_bayar" value="1">
                <input type="hidden" name="id_iuran" id="bayar_id_iuran">
                
                <div class="input-group">
                    <label>Nama Tagihan</label>
                    <input type="text" id="bayar_nama_iuran" class="input-readonly" readonly>
                </div>
                <div class="input-group">
                    <label>Nominal</label>
                    <input type="text" id="bayar_nominal" class="input-readonly text-green fw-600" readonly>
                </div>

                <div class="input-group">
                    <label>Metode Pembayaran</label>
                    <select name="metode_pembayaran" id="pilih_metode" onchange="toggleMetodeBayar()" required class="form-control-bordered-select">
                        <option value="Cash">Cash (Titip ke Bendahara)</option>
                        <option value="Transfer">Transfer Bank / QRIS</option>
                    </select>
                </div>

                <div id="area_transfer" style="display: none;">
                    <div class="card mb-15 input-readonly">
                        <p class="text-sm fw-600 mb-5 text-dark">Informasi Rekening Grup:</p>
                        <p class="text-sm text-muted-dark mb-15" id="info_rekening">Belum ada info rekening.</p>
                        
                        <div id="info_qris" style="display: none;" class="text-center">
                            <p class="text-sm fw-600 mb-5 text-dark">Atau Scan QRIS:</p>
                            <img id="qris_image_preview" src="" style="max-width: 150px; border-radius: 8px; border: 1px solid #cbd5e1;" alt="QRIS">
                        </div>
                    </div>

                    <div class="input-group">
                        <label>Upload Bukti Transfer</label>
                        <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" accept="image/*" class="form-control-bordered">
                        <p class="text-muted-custom text-sm mt-5">*Format gambar JPG/PNG.</p>
                    </div>
                </div>

                <div class="modal-actions mt-20">
                    <button type="button" class="btn-cancel" onclick="document.getElementById('modalBayar').classList.remove('active')">Batal</button>
                    <button type="submit" class="btn-confirm-success"><i class="fa-solid fa-paper-plane"></i> Kirim</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function bukaModalBayar(id_iuran, nama, nominal, bank, nomor, nama_rek, qris) {
            document.getElementById('bayar_id_iuran').value = id_iuran;
            document.getElementById('bayar_nama_iuran').value = nama;
            document.getElementById('bayar_nominal').value = "Rp " + new Intl.NumberFormat('id-ID').format(nominal);
            
            let rekInfo = document.getElementById('info_rekening');
            let qrisInfo = document.getElementById('info_qris');
            let qrisImg = document.getElementById('qris_image_preview');

            if (bank && nomor) {
                rekInfo.innerHTML = "<strong>" + bank + "</strong><br>" + nomor + " a/n " + nama_rek;
            } else {
                rekInfo.innerHTML = "Bendahara belum mengatur nomor rekening.";
            }

            if (qris) {
                qrisImg.src = "../../../public/assets/uploads/qris/" + qris;
                qrisInfo.style.display = 'block';
            } else {
                qrisInfo.style.display = 'none';
            }

            document.getElementById('modalBayar').classList.add('active');
            toggleMetodeBayar(); 
        }
        
        function toggleMetodeBayar() {
            let metode = document.getElementById('pilih_metode').value;
            let transferArea = document.getElementById('area_transfer');
            let fileInput = document.getElementById('bukti_pembayaran');

            if (metode === 'Transfer') {
                transferArea.style.display = 'block';
                fileInput.required = true;
            } else {
                transferArea.style.display = 'none';
                fileInput.required = false;
            }
        }
    </script>
</body>
</html>