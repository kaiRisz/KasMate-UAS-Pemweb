<?php
session_start();
require_once '../../../config/database.php';

if (isset($_SESSION['id_user']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: ../admin/dashboard-admin.php");
        exit();
    } elseif ($_SESSION['role'] == 'bendahara') {
        header("Location: ../bendahara/dashboard-bendahara.php");
        exit();
    } else {
        header("Location: ../user/dashboard-user.php");
        exit();
    }
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        if (password_verify($password, $row['password'])) {
            $_SESSION['id_user'] = $row['id_user'];
            $_SESSION['role'] = $row['role'];

            if ($row['role'] == 'admin') {
                header("Location: ../admin/dashboard-admin.php");
            } elseif ($row['role'] == 'bendahara') {
                header("Location: ../bendahara/dashboard-bendahara.php");
            } else {
                header("Location: ../user/dashboard-user.php");
            }
            exit();
        } else {
            $error = true;
        }
    } else {
        $error = true;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - IMPULSEGUARD</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/assets/css/style.css">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
        }
        .split-layout {
            display: flex;
            height: 100vh;
        }
        .left-panel {
            flex: 1;
            background-color: #2b3a4a;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .right-panel {
            flex: 1;
        }
        .right-panel img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .login-card {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            box-sizing: border-box;
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header h1 {
            margin-top: 0;
            color: #1e293b;
            font-size: 2rem;
            margin-bottom: 5px;
        }
        .login-header p {
            color: #64748b;
            font-size: 0.9rem;
            margin: 0;
        }
        .input-group {
            margin-bottom: 20px;
        }
        .input-group label {
            display: block;
            margin-bottom: 8px;
            color: #1e293b;
            font-weight: 500;
            font-size: 0.95rem;
        }
        .input-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            box-sizing: border-box;
            font-family: inherit;
            font-size: 1rem;
        }
        .input-group input:focus {
            outline: none;
            border-color: #3b82f6;
        }
        .btn-login {
            width: 100%;
            padding: 14px;
            background-color: #1e293b;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
            font-size: 1rem;
            margin-top: 10px;
            transition: background-color 0.2s;
        }
        .btn-login:hover {
            background-color: #0f172a;
        }
        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
            color: #64748b;
        }
        .register-link a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: #ef4444;
            font-size: 0.9rem;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="split-layout">
        <div class="left-panel">
            <div class="login-card">
                <div class="login-header">
                    <h1>Login</h1>
                    <p>Silahkan masukkan email dan password anda</p>
                </div>
                
                <?php if(isset($error)) : ?>
                    <div class="error-message">Email atau password salah!</div>
                <?php endif; ?>

                <form action="" method="POST">
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn-login">Login</button>
                    <p class="register-link">Belum punya akun? <a href="register.php">Daftar sekarang</a></p>
                </form>
            </div>
        </div>
        <div class="right-panel">
            <img src="../../../public/assets/image/gambar.jpeg" alt="pict">
        </div>
    </div>
</body>
</html>