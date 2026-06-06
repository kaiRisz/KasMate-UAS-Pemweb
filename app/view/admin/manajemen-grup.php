<?php

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KasMate - Manajemen Grup</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/assets/css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            <nav class="sidebar-menu">
                <div class="menu-section">
                    <a href="../../controller/admin/DashboardAdminController.php" class="menu-item">
                        <i class='bx bxs-dashboard'></i> Dashboard
                    </a>
                    <a href="../../controller/admin/ManajemenUserController.php" class="menu-item">
                        <i class='bx bxs-user-account'></i> Manajemen User
                    </a>
                    <a href="../../controller/admin/ManajemenGrupController.php" class="menu-item active">
                        <i class='bx bxs-group'></i> Manajemen Grup
                    </a>
                    <a href="../../controller/admin/PengaturanController.php" class="menu-item">
                        <i class='bx bxs-cog'></i> Pengaturan Akun
                    </a>
                </div>
                <div class="menu-section sidebar-footer-menu">
                    <a href="../../controller/auth/LogoutController.php" class="menu-item">
                        <i class='bx bx-log-out'></i> Logout
                    </a>
                </div>
            </nav>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <div class="header-text">
                    <h1>Manajemen Grup</h1>
                    <p class="subtitle">Kelola semua grup yang terdaftar</p>
                </div>
                <div class="header-right">
                    <button class="btn-notification"><i class='bx bx-bell'></i></button>
                    <div class="user-profile">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($user_login['nama'] ?? 'Admin') ?>&background=e2e8f0&color=475569" alt="<?= htmlspecialchars($user_login['nama'] ?? 'Admin') ?>">
                        <div class="user-info">
                            <span class="user-name"><?= htmlspecialchars($user_login['nama'] ?? 'Admin') ?></span>
                            <span class="user-role">Administrator</span>
                        </div>
                    </div>
                </div>
            </header>

            <section class="content-body">
                <div class="card table-card">
                    <div class="table-controls">
                        <form method="GET" class="search-box">
                            <input type="text" name="search" placeholder="Cari grup..." value="<?= htmlspecialchars($search ?? '') ?>">
                        </form>
                    </div>

                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Nama Grup</th>
                                <th>Deskripsi</th>
                                <th>Bendahara</th>
                                <th>Jumlah Anggota</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($q_groups) && count($q_groups) > 0): ?>
                                <?php foreach ($q_groups as $g): ?>
                                    <tr>
                                        <td class="fw-500"><?= htmlspecialchars($g['nama_grup'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($g['deskripsi'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($g['nama_bendahara'] ?? 'Belum Ada') ?></td>
                                        <td><?= $g['jumlah_anggota'] ?? 0 ?> orang</td>
                                        <td>
                                            <div class="action-icons">
                                                <i class='bx bx-trash text-red cursor-pointer' 
                                                   onclick="bukaModalHapus(<?= $g['id_grup'] ?>, '<?= htmlspecialchars(addslashes($g['nama_grup'] ?? '')) ?>')"></i>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="empty-table-row">Data tidak ditemukan</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <div class="table-footer">
                        <span class="table-info">
                            Menampilkan <?= min($offset + 1, $total_data) ?> - <?= min($offset + $per_page, $total_data) ?> dari <?= $total_data ?> data
                        </span>
                        <div class="pagination">
                            <?php if ($page > 1): ?>
                                <a href="?page=<?= $page - 1 ?>&search=<?= urlencode($search ?? '') ?>" class="page-btn"><i class='bx bx-chevron-left'></i></a>
                            <?php endif; ?>
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <a href="?page=<?= $i ?>&search=<?= urlencode($search ?? '') ?>" class="page-btn <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
                            <?php endfor; ?>
                            <?php if ($page < $total_pages): ?>
                                <a href="?page=<?= $page + 1 ?>&search=<?= urlencode($search ?? '') ?>" class="page-btn"><i class='bx bx-chevron-right'></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <div class="modal-overlay" id="modalHapus">
        <div class="modal-box">
            <h3 class="modal-title text-red mb-15"><i class='bx bx-trash'></i> Konfirmasi Hapus</h3>
            <p class="text-muted-custom text-sm mb-25">Apakah Anda yakin ingin menghapus grup <strong id="hapus_nama" class="text-dark"></strong>? Semua data anggota dan transaksi dalam grup ini akan ikut terhapus permanen.</p>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="tutupModal()">Batal</button>
                <a id="hapus_link" href="#" class="btn-danger">Ya, Hapus Grup</a>
            </div>
        </div>
    </div>

    <script>
        function bukaModalHapus(id, nama) {
            document.getElementById('hapus_nama').textContent = nama;
            document.getElementById('hapus_link').href = '../../controller/admin/ManajemenGrupController.php?hapus=' + id;
            document.getElementById('modalHapus').classList.add('active');
        }

        function tutupModal() {
            document.getElementById('modalHapus').classList.remove('active');
        }

        document.querySelectorAll('.modal-overlay').forEach(function(overlay) {
            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) overlay.classList.remove('active');
            });
        });
    </script>
</body>
</html>