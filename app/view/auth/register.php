<?php
if (!isset($authModel)) {
    header("Location: ../../controller/auth/RegisterController.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - IMPULSEGUARD</title>
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
    </style>
</head>
<body>
    <div class="split-layout">
        <div class="left-panel">
            <div class="login-card">
                <div class="login-header">
                    <h1>Register</h1>
                    <p>Silahkan lengkapi data diri anda untuk mendaftar</p>
                </div>
                <form action="" method="POST">
                    <div class="input-group">
                        <label for="nama">Nama</label>
                        <input type="text" id="nama" name="nama" placeholder="Nama Lengkap" required>
                    </div>
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn-login">Daftar</button>
                    <p class="register-link">Sudah punya akun? <a href="LoginController.php">Login di sini</a></p>
                </form>
            </div>
        </div>
        <div class="right-panel">
            <img src="../../../public/assets/image/gambar.jpeg" alt="pict">
        </div>
    </div>
</body>
</html>