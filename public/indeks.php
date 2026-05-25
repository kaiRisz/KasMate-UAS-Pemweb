<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KasMate - Indeks Utama</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f1f5f9;
            margin: 0;
            padding: 20px;
        }
        .index-container {
            width: 100%;
            max-width: 900px;
        }
        .index-header {
            text-align: center;
            margin-bottom: 40px;
        }
        .index-header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        .index-header h1 i {
            margin-right: 10px;
        }
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        .menu-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            text-align: center;
            text-decoration: none;
            color: inherit;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            cursor: pointer;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .menu-card i {
            font-size: 3rem;
            margin-bottom: 20px;
        }
        .menu-card h3 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <div class="index-container">
        <div class="index-header">
            <h1><i class="fa-solid fa-cube"></i> KasMate</h1>
            <p class="subtitle">Pilih Role Akses Aplikasi</p>
        </div>

        <div class="menu-grid">
            <a href="../app/view/auth/login.php" class="menu-card">
                <i class="fa-solid fa-right-to-bracket text-blue" style="color: #3b82f6;"></i>
                <h3>Halaman Login</h3>
            </a>

            <a href="../app/controller/admin/DashboardAdminController.php" class="menu-card">
                <i class="fa-solid fa-user-tie text-red" style="color: #ef4444;"></i>
                <h3>Dashboard Admin</h3>
            </a>

            <a href="../app/view/bendahara/dashboard-bendahara.php" class="menu-card">
                <i class="fa-solid fa-wallet text-green" style="color: #10b981;"></i>
                <h3>Dashboard Bendahara</h3>
            </a>

            <a href="../app/view/user/dashboard-user.php" class="menu-card">
                <i class="fa-solid fa-users text-yellow" style="color: #f59e0b;"></i>
                <h3>Dashboard User</h3>
            </a>
        </div>
    </div>

</body>
</html>