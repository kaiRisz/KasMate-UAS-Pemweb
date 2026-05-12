<?php
require_once '../../../config/auth_check.php';
cekRole('admin');

if (isset($_GET['hapus'])) {
    $id_hapus = (int)$_GET['hapus'];
    mysqli_query($conn, "DELETE FROM grup WHERE id_grup = $id_hapus");
    header("Location: manajemen-grup.php");
    exit();
}

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$where = "WHERE 1=1";
if ($search !== '') {
    $where .= " AND (g.nama_grup LIKE '%$search%' OR u.nama LIKE '%$search%')";
}

$per_page = 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $per_page;

$q_count = mysqli_query($conn, "
    SELECT COUNT(*) as total 
    FROM grup g 
    JOIN users u ON g.id_bendahara = u.id_user 
    $where
");
$total_data = mysqli_fetch_assoc($q_count)['total'];
$total_pages = max(1, ceil($total_data / $per_page));

$q_groups = mysqli_query($conn, "
    SELECT g.*, u.nama as nama_bendahara,
        (SELECT COUNT(*) FROM grup_anggota ga WHERE ga.id_grup = g.id_grup) as jumlah_anggota
    FROM grup g 
    JOIN users u ON g.id_bendahara = u.id_user 
    $where 
    ORDER BY g.id_grup DESC 
    LIMIT $per_page OFFSET $offset
");
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

    <div class="dashboard-layout">
        <aside class="sidebar">
            <div class="logo">
                <i class="fa-solid fa-cube"></i>
                <span>KasMate</span>
            </div>
            <nav class="sidebar-menu">
                <div class="menu-section">
                    <a href="dashboard-admin.php" class="menu-item">
                        <i class='bx bxs-dashboard'></i> Dashboard
                    </a>
                    <a href="manajemen-user.php" class="menu-item">
                        <i class='bx bxs-user-account'></i> Manajemen User
                    </a>
                    <a href="manajemen-grup.php" class="menu-item active">
                        <i class='bx bxs-group'></i> Manajemen Grup
                    </a>
                    <a href="pengaturan.php" class="menu-item">
                        <i class='bx bxs-cog'></i> Pengaturan Sistem
                    </a>
                </div>
                <div class="menu-section" style="margin-top: auto; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
                    <a href="logout.php" class="menu-item">
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
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($user_login['nama']) ?>&background=e2e8f0&color=475569" alt="<?= htmlspecialchars($user_login['nama']) ?>">
                        <div class="user-info">
                            <span class="user-name"><?= htmlspecialchars($user_login['nama']) ?></span>
                            <span class="user-role">Administrator</span>
                        </div>
                    </div>
                </div>
            </header>

            <section class="content-body">
                <div class="card table-card">
                    <div class="table-controls">
                        <form method="GET" class="search-box">
                            <input type="text" name="search" placeholder="Cari grup..." value="<?= htmlspecialchars($search) ?>">
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
                            <?php if (mysqli_num_rows($q_groups) > 0): ?>
                                <?php while ($g = mysqli_fetch_assoc($q_groups)): ?>
                                    <tr>
                                        <td class="fw-500"><?= htmlspecialchars($g['nama_grup']) ?></td>
                                        <td><?= htmlspecialchars($g['deskripsi'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($g['nama_bendahara']) ?></td>
                                        <td><?= $g['jumlah_anggota'] ?> orang</td>
                                        <td>
                                            <div class="action-icons">
                                                <i class='bx bx-trash text-red' style="cursor:pointer;" 
                                                   onclick="bukaModalHapus(<?= $g['id_grup'] ?>, '<?= htmlspecialchars(addslashes($g['nama_grup'])) ?>')"></i>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 30px; color: #94a3b8;">Data tidak ditemukan</td>
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
                                <a href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>" class="page-btn"><i class='bx bx-chevron-left'></i></a>
                            <?php endif; ?>
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>" class="page-btn <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
                            <?php endfor; ?>
                            <?php if ($page < $total_pages): ?>
                                <a href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>" class="page-btn"><i class='bx bx-chevron-right'></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <div class="modal-overlay" id="modalHapus">
        <div class="modal-box">
            <h3><i class='bx bx-trash' style="color: #ef4444;"></i> Hapus Grup</h3>
            <p>Apakah Anda yakin ingin menghapus grup <strong id="hapus_nama"></strong>? Semua data anggota dan transaksi dalam grup ini akan ikut terhapus.</p>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="tutupModal()">Batal</button>
                <a id="hapus_link" href="#" class="btn-confirm-delete">Hapus</a>
            </div>
        </div>
    </div>

    <script>
        function bukaModalHapus(id, nama) {
            document.getElementById('hapus_nama').textContent = nama;
            document.getElementById('hapus_link').href = 'manajemen-grup.php?hapus=' + id;
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