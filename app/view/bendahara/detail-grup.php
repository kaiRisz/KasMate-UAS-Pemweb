<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KasMate - Detail Grup Pembayaran</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../../public/assets/css/style.css">
</head>
<body>

    <div class="dashboard-layout">
        <aside class="sidebar">
            <div class="logo">
                <i class="fa-solid fa-cube"></i>
                <span>KasMate</span>
            </div>

            <div class="sidebar-menu">
                <a href="dashboard.php" class="menu-item">
                    <i class="fa-solid fa-border-all"></i> Dashboard
                </a>

                <div class="menu-section">
                    <p class="section-title">KELOLA IURAN</p>
                    <a href="grup-iuran.php" class="menu-item"><i class="fa-solid fa-users-line"></i> Grup Iuran</a>
                    <a href="#" class="menu-item"><i class="fa-solid fa-user-group"></i> Anggota</a>
                    <a href="#" class="menu-item"><i class="fa-solid fa-file-invoice-dollar"></i> Iuran & Tagihan</a>
                    <a href="#" class="menu-item active"><i class="fa-regular fa-circle-check"></i> Pembayaran</a>
                </div>

                <div class="menu-section">
                    <p class="section-title">KEUANGAN</p>
                    <a href="#" class="menu-item"><i class="fa-solid fa-clock-rotate-left"></i> Pemasukan</a>
                    <a href="#" class="menu-item"><i class="fa-regular fa-eye"></i> Pengeluaran</a>
                    <a href="#" class="menu-item"><i class="fa-solid fa-chart-pie"></i> Ringkasan Keuangan</a>
                </div>

                <div class="menu-section">
                    <p class="section-title">LAPORAN</p>
                    <a href="#" class="menu-item"><i class="fa-regular fa-file-lines"></i> Laporan</a>
                    <a href="#" class="menu-item"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat Transaksi</a>
                </div>
            </div>

            <div class="sidebar-bottom">
                <a href="#" class="menu-item"><i class="fa-solid fa-gear"></i> Pengaturan</a>
            </div>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <div class="header-text">
                    <h1>Detail Grup - Pembayaran</h1>
                    <p class="subtitle">Grup Iuran &gt; Kelas TI-2A 2024 &gt; Pembayaran</p>
                </div>
                <div class="header-right">
                    <button class="btn-notification">
                        <i class="fa-regular fa-bell"></i>
                    </button>
                    <div class="user-profile">
                        <img src="../assets/user_pict.jpg" alt="Budi Santoso">
                        <div class="user-info">
                            <span class="user-name">Budi Santoso</span>
                            <span class="user-role">Bendahara Utama</span>
                        </div>
                        <i class="fa-solid fa-chevron-down dropdown-icon"></i>
                    </div>
                </div>
            </header>

            <div class="tabs-container">
                <a href="#" class="tab-item">Anggota</a>
                <a href="#" class="tab-item">Tagihan</a>
                <a href="#" class="tab-item active">Pembayaran</a>
            </div>

            <section class="overview-cards">
                <div class="card stat-card">
                    <div>
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                    </div>
                    <div>
                        <p>Total Tagihan</p>
                        <h2>Rp 6.000k</h2>
                    </div>
                </div>

                <div class="card stat-card">
                    <div>
                        <i class="fa-regular fa-circle-check"></i>
                    </div>
                    <div>
                        <p>Lunas (56.7%)</p>
                        <h2>Rp 3.400k</h2>
                    </div>
                </div>

                <div class="card stat-card">
                    <div>
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <div>
                        <p>Belum Lunas (33.3%)</p>
                        <h2>Rp 2.000k</h2>
                    </div>
                </div>

                <div class="card stat-card">
                    <div>
                        <i class="fa-solid fa-circle-exclamation"></i>
                    </div>
                    <div>
                        <p>Terlambat (10.0%)</p>
                        <h2>Rp 600k</h2>
                    </div>
                </div>
            </section>

            <section class="card table-card">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Anggota</th>
                            <th>Status</th>
                            <th>Terakhir Bayar</th>
                            <th>Total Bayar</th>
                            <th>Sisa Tagihan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-500">Andi Wijaya</td>
                            <td><span class="badge badge-lunas">Lunas</span></td>
                            <td>08 Mei 2024</td>
                            <td>Rp 300.000</td>
                            <td>Rp 0</td>
                            <td>
                                <div class="action-icons">
                                    <i class="fa-regular fa-eye"></i>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-500">Dewi Lestari</td>
                            <td><span class="badge badge-pending">Belum Lunas</span></td>
                            <td>-</td>
                            <td>Rp 0</td>
                            <td>Rp 300.000</td>
                            <td>
                                <button class="btn-action btn-dark">Bayar</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-500">Rudi Herman</td>
                            <td><span class="badge badge-lunas">Lunas</span></td>
                            <td>09 Mei 2024</td>
                            <td>Rp 300.000</td>
                            <td>Rp 0</td>
                            <td>
                                <div class="action-icons">
                                    <i class="fa-regular fa-eye"></i>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-500">Siti Aisyah</td>
                            <td><span class="badge badge-terlambat">Terlambat</span></td>
                            <td>01 Apr 2024</td>
                            <td>Rp 100.000</td>
                            <td>Rp 200.000</td>
                            <td>
                                <button class="btn-action btn-dark">Bayar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="table-footer">
                    <div class="table-info">Menampilkan 1 - 4 dari 12 data</div>
                    <div class="pagination">
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">3</button>
                        <button class="page-btn"><i class="fa-solid fa-chevron-right"></i></button>
                    </div>
                </div>
            </section>
        </main>
    </div>

</body>
</html>