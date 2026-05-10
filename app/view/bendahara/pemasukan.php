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

    <div class="dashboard-layout">
        <aside class="sidebar">
            <div class="logo">
                <i class="fa-solid fa-cube"></i>
                <span>KasMate</span>
            </div>

            <div class="sidebar-menu">
                <a href="dashboard-bendahara.php" class="menu-item">
                    <i class="fa-solid fa-border-all"></i> Dashboard
                </a>

                <div class="menu-section">
                    <p class="section-title">KELOLA IURAN</p>
                    <a href="grup-iuran.php" class="menu-item"><i class="fa-solid fa-users-line"></i> Grup Iuran</a>
                    <a href="detail-grup.php" class="menu-item"><i class="fa-solid fa-user-group"></i> Detail Grup</a>
                </div>

                <div class="menu-section">
                    <p class="section-title">KEUANGAN</p>
                    <a href="pemasukan.php" class="menu-item active"><i class="fa-solid fa-clock-rotate-left"></i> Pemasukan</a>
                    <a href="pengeluaran.php" class="menu-item"><i class="fa-regular fa-eye"></i> Pengeluaran</a>
                </div>

                <div class="menu-section">
                    <p class="section-title">LAPORAN</p>
                    <a href="laporan-keuangan.php" class="menu-item"><i class="fa-regular fa-file-lines"></i> Laporan Keuangan</a>
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
                    <button class="btn-action btn-dark">
                        <i class="fa-solid fa-plus"></i> Tambah Pemasukan
                    </button>
                </div>
            </header>

            <section class="overview-cards">
                <div class="card stat-card">
                    <div>
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <div>
                        <p>Total Pemasukan</p>
                        <h2>Rp 1.140.000 <span>(Bulan ini)</span></h2>
                    </div>
                </div>

                <div class="card stat-card">
                    <div>
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                    <div>
                        <p>Total Transaksi</p>
                        <h2>3 <span>Transaksi</span></h2>
                    </div>
                </div>

                <div class="card stat-card">
                    <div>
                        <i class="fa-solid fa-money-bill-wave"></i>
                    </div>
                    <div>
                        <p>Via Tunai</p>
                        <h2>Rp 900.000 <span>(2 Trx)</span></h2>
                    </div>
                </div>

                <div class="card stat-card">
                    <div>
                        <i class="fa-solid fa-building-columns"></i>
                    </div>
                    <div>
                        <p>Via Transfer</p>
                        <h2>Rp 240.000 <span>(1 Trx)</span></h2>
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
                            <th>Sumber</th>
                            <th>Deskripsi</th>
                            <th>Jumlah</th>
                            <th>Metode</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: center; color: var(--text-muted);">1</td>
                            <td>10 Mei 2024</td>
                            <td class="fw-500">Iuran Kelas TI-2A 2024</td>
                            <td>Pembayaran iuran Mei 2024</td>
                            <td class="fw-500 text-green">+ Rp 300.000</td>
                            <td><span class="badge">Tunai</span></td>
                            <td>
                                <div class="action-icons" style="justify-content: center;">
                                    <i class="fa-solid fa-pen"></i>
                                    <i class="fa-solid fa-trash-can text-red"></i>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center; color: var(--text-muted);">2</td>
                            <td>05 Mei 2024</td>
                            <td class="fw-500">Iuran PKK RT 05</td>
                            <td>Pembayaran iuran Mei 2024</td>
                            <td class="fw-500 text-green">+ Rp 240.000</td>
                            <td><span class="badge">Transfer</span></td>
                            <td>
                                <div class="action-icons" style="justify-content: center;">
                                    <i class="fa-solid fa-pen"></i>
                                    <i class="fa-solid fa-trash-can text-red"></i>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center; color: var(--text-muted);">3</td>
                            <td>01 Mei 2024</td>
                            <td class="fw-500">Arisan Keluarga</td>
                            <td>Pembayaran arisan Mei 2024</td>
                            <td class="fw-500 text-green">+ Rp 600.000</td>
                            <td><span class="badge">Tunai</span></td>
                            <td>
                                <div class="action-icons" style="justify-content: center;">
                                    <i class="fa-solid fa-pen"></i>
                                    <i class="fa-solid fa-trash-can text-red"></i>
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