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