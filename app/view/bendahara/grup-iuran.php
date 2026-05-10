<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KasMate - Grup Iuran</title>
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
                    <a href="grup-iuran.php" class="menu-item active"><i class="fa-solid fa-users-line"></i> Grup Iuran</a>
                    <a href="#" class="menu-item"><i class="fa-solid fa-user-group"></i> Anggota</a>
                    <a href="#" class="menu-item"><i class="fa-solid fa-file-invoice-dollar"></i> Iuran & Tagihan</a>
                    <a href="#" class="menu-item"><i class="fa-regular fa-circle-check"></i> Pembayaran</a>
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
                    <h1>Grup Iuran</h1>
                    <p class="subtitle">Kelola semua grup iuran yang Anda buat.</p>
                </div>
                <div class="header-right">
                    <button class="btn-action btn-dark">
                        <i class="fa-solid fa-plus"></i> Buat Grup Baru
                    </button>
                </div>
            </header>

            <section class="overview-cards">
                <div class="card stat-card">
                    <div>
                        <i class="fa-solid fa-users-rectangle"></i>
                    </div>
                    <div>
                        <p>Total Grup</p>
                        <h2>3</h2>
                    </div>
                </div>

                <div class="card stat-card">
                    <div>
                        <i class="fa-solid fa-user-group"></i>
                    </div>
                    <div>
                        <p>Total Anggota</p>
                        <h2>27</h2>
                    </div>
                </div>

                <div class="card stat-card">
                    <div>
                        <i class="fa-solid fa-money-bill-wave"></i>
                    </div>
                    <div>
                        <p>Rata-rata Iuran</p>
                        <h2>Rp 56k</h2>
                    </div>
                </div>

                <div class="card stat-card">
                    <div>
                        <i class="fa-solid fa-chart-column"></i>
                    </div>
                    <div>
                        <p>Grup Terbesar</p>
                        <h2>12 Orang</h2>
                    </div>
                </div>
            </section>

            <section class="card table-card">
                <div class="search-box" style="margin-bottom: 20px;">
                    <input type="text" placeholder="Cari grup iuran...">
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 50px;">No</th>
                            <th>Nama Grup</th>
                            <th>Deskripsi</th>
                            <th>Jumlah Anggota</th>
                            <th>Iuran per Orang</th>
                            <th>Periode</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: center;">1</td>
                            <td class="fw-500">Kelas TI-2A 2024</td>
                            <td>Iuran kelas TI-2A</td>
                            <td>9 Orang</td>
                            <td class="fw-500">Rp 50.000</td>
                            <td><span class="badge" style="background-color: #f1f5f9; color: var(--text-dark);">Mei 2024</span></td>
                            <td>
                                <div class="action-icons" style="justify-content: center;">
                                    <i class="fa-regular fa-eye"></i>
                                    <i class="fa-solid fa-pen"></i>
                                    <i class="fa-regular fa-trash-can text-red"></i>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">2</td>
                            <td class="fw-500">PKK RT 05</td>
                            <td>Iuran rutin PKK RT 05</td>
                            <td>12 Orang</td>
                            <td class="fw-500">Rp 20.000</td>
                            <td><span class="badge" style="background-color: #f1f5f9; color: var(--text-dark);">Mei 2024</span></td>
                            <td>
                                <div class="action-icons" style="justify-content: center;">
                                    <i class="fa-regular fa-eye"></i>
                                    <i class="fa-solid fa-pen"></i>
                                    <i class="fa-regular fa-trash-can text-red"></i>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">3</td>
                            <td class="fw-500">Arisan Keluarga</td>
                            <td>Arisan keluarga besar</td>
                            <td>6 Orang</td>
                            <td class="fw-500">Rp 100.000</td>
                            <td><span class="badge" style="background-color: #f1f5f9; color: var(--text-dark);">Mei 2024</span></td>
                            <td>
                                <div class="action-icons" style="justify-content: center;">
                                    <i class="fa-regular fa-eye"></i>
                                    <i class="fa-solid fa-pen"></i>
                                    <i class="fa-regular fa-trash-can text-red"></i>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="table-footer">
                    <div class="table-info">Menampilkan 1 - 3 dari 3 data</div>
                    <div class="pagination">
                        <button class="page-btn active">1</button>
                        <button class="page-btn"><i class="fa-solid fa-chevron-right"></i></button>
                    </div>
                </div>
            </section>
        </main>
    </div>

</body>
</html>