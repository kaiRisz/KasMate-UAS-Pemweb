<?php
require_once '../../../config/auth_check.php';
cekRole('admin');

if (isset($_GET['hapus'])) {
    $id_hapus = (int)$_GET['hapus'];
    if ($id_hapus !== (int)$user_login['id_user']) {
        mysqli_query($conn, "DELETE FROM users WHERE id_user = $id_hapus");
    }
    header("Location: manajemen-user.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi']) && $_POST['aksi'] === 'tambah') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    mysqli_query($conn, "INSERT INTO users (nama, email, password, role) VALUES ('$nama', '$email', '$password', '$role')");
    header("Location: manajemen-user.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi']) && $_POST['aksi'] === 'edit') {
    $id_edit = (int)$_POST['id_user'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $query_update = "UPDATE users SET nama='$nama', email='$email', role='$role'";
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $query_update .= ", password='$password'";
    }
    $query_update .= " WHERE id_user = $id_edit";
    mysqli_query($conn, $query_update);
    header("Location: manajemen-user.php");
    exit();
}

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$filter_role = isset($_GET['role']) ? mysqli_real_escape_string($conn, $_GET['role']) : '';

$where = "WHERE 1=1";
if ($search !== '') {
    $where .= " AND (nama LIKE '%$search%' OR email LIKE '%$search%')";
}
if ($filter_role !== '') {
    $where .= " AND role = '$filter_role'";
}

$per_page = 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $per_page;

$q_count = mysqli_query($conn, "SELECT COUNT(*) as total FROM users $where");
$total_data = mysqli_fetch_assoc($q_count)['total'];
$total_pages = max(1, ceil($total_data / $per_page));

$q_users = mysqli_query($conn, "SELECT * FROM users $where ORDER BY id_user DESC LIMIT $per_page OFFSET $offset");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KasMate - Manajemen User</title>
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
                    <a href="manajemen-user.php" class="menu-item active">
                        <i class='bx bxs-user-account'></i> Manajemen User
                    </a>
                    <a href="manajemen-grup.php" class="menu-item">
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
                    <h1>Manajemen User</h1>
                    <p class="subtitle">Kelola semua pengguna sistem</p>
                </div>
                <div class="header-right">
                    <button class="btn-add-user" onclick="bukaModalTambah()"><i class='bx bx-plus'></i> Tambah User</button>
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
                            <input type="text" name="search" placeholder="Cari nama atau email..." value="<?= htmlspecialchars($search) ?>">
                            <?php if ($filter_role): ?>
                                <input type="hidden" name="role" value="<?= htmlspecialchars($filter_role) ?>">
                            <?php endif; ?>
                        </form>
                        <div class="filter-box">
                            <span>Filter Role</span>
                            <select onchange="window.location.href='manajemen-user.php?role='+this.value+'&search=<?= urlencode($search) ?>'">
                                <option value="" <?= $filter_role === '' ? 'selected' : '' ?>>Semua Role</option>
                                <option value="admin" <?= $filter_role === 'admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="bendahara" <?= $filter_role === 'bendahara' ? 'selected' : '' ?>>Bendahara</option>
                                <option value="user" <?= $filter_role === 'user' ? 'selected' : '' ?>>Anggota</option>
                            </select>
                        </div>
                    </div>

                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($q_users) > 0): ?>
                                <?php while ($u = mysqli_fetch_assoc($q_users)): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($u['nama']) ?></td>
                                        <td><?= htmlspecialchars($u['email']) ?></td>
                                        <td>
                                            <span class="badge <?php
                                                if ($u['role'] === 'admin') echo 'badge-terlambat';
                                                elseif ($u['role'] === 'bendahara') echo 'badge-pending';
                                                else echo 'badge-aktif';
                                            ?>">
                                                <?= ucfirst($u['role']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-icons">
                                                <i class='bx bx-edit-alt' style="cursor:pointer;" 
                                                   onclick="bukaModalEdit(<?= $u['id_user'] ?>, '<?= htmlspecialchars(addslashes($u['nama'])) ?>', '<?= htmlspecialchars(addslashes($u['email'])) ?>', '<?= $u['role'] ?>')"></i>
                                                <?php if ((int)$u['id_user'] !== (int)$user_login['id_user']): ?>
                                                    <i class='bx bx-trash text-red' style="cursor:pointer;" 
                                                       onclick="bukaModalHapus(<?= $u['id_user'] ?>, '<?= htmlspecialchars(addslashes($u['nama'])) ?>')"></i>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" style="text-align: center; padding: 30px; color: #94a3b8;">Data tidak ditemukan</td>
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
                                <a href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>&role=<?= urlencode($filter_role) ?>" class="page-btn"><i class='bx bx-chevron-left'></i></a>
                            <?php endif; ?>
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&role=<?= urlencode($filter_role) ?>" class="page-btn <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
                            <?php endfor; ?>
                            <?php if ($page < $total_pages): ?>
                                <a href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>&role=<?= urlencode($filter_role) ?>" class="page-btn"><i class='bx bx-chevron-right'></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <div class="modal-overlay" id="modalTambah">
        <div class="modal-box">
            <h3><i class='bx bx-user-plus'></i> Tambah User Baru</h3>
            <form method="POST">
                <input type="hidden" name="aksi" value="tambah">
                <div class="input-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" required placeholder="Masukkan nama">
                </div>
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" required placeholder="Masukkan email">
                </div>
                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="Masukkan password">
                </div>
                <div class="input-group">
                    <label>Role</label>
                    <select name="role" required>
                        <option value="user">User / Anggota</option>
                        <option value="bendahara">Bendahara</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="tutupModal('modalTambah')">Batal</button>
                    <button type="submit" class="btn-save">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="modalEdit">
        <div class="modal-box">
            <h3><i class='bx bx-edit'></i> Edit User</h3>
            <form method="POST">
                <input type="hidden" name="aksi" value="edit">
                <input type="hidden" name="id_user" id="edit_id_user">
                <div class="input-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" id="edit_nama" required>
                </div>
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" id="edit_email" required>
                </div>
                <div class="input-group">
                    <label>Password Baru (kosongkan jika tidak diganti)</label>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak diganti">
                </div>
                <div class="input-group">
                    <label>Role</label>
                    <select name="role" id="edit_role" required>
                        <option value="user">User / Anggota</option>
                        <option value="bendahara">Bendahara</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="tutupModal('modalEdit')">Batal</button>
                    <button type="submit" class="btn-save">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="modalHapus">
        <div class="modal-box">
            <h3><i class='bx bx-trash' style="color: #ef4444;"></i> Hapus User</h3>
            <p>Apakah Anda yakin ingin menghapus user <strong id="hapus_nama"></strong>? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="tutupModal('modalHapus')">Batal</button>
                <a id="hapus_link" href="#" class="btn-confirm-delete" style="text-decoration: none; text-align: center; padding: 10px 24px; border-radius: 8px; font-weight: 600; font-size: 0.9rem;">Hapus</a>
            </div>
        </div>
    </div>

    <script>
        function bukaModalTambah() {
            document.getElementById('modalTambah').classList.add('active');
        }

        function bukaModalEdit(id, nama, email, role) {
            document.getElementById('edit_id_user').value = id;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_role').value = role;
            document.getElementById('modalEdit').classList.add('active');
        }

        function bukaModalHapus(id, nama) {
            document.getElementById('hapus_nama').textContent = nama;
            document.getElementById('hapus_link').href = 'manajemen-user.php?hapus=' + id;
            document.getElementById('modalHapus').classList.add('active');
        }

        function tutupModal(id) {
            document.getElementById(id).classList.remove('active');
        }

        document.querySelectorAll('.modal-overlay').forEach(function(overlay) {
            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) {
                    overlay.classList.remove('active');
                }
            });
        });
    </script>

</body>
</html>