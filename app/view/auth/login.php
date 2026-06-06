<?php
if (!isset($authModel)) {
    header("Location: ../../controller/auth/LoginController.php");
    exit();
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

    <script>
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };
    </script>
</head>

<body>
<div class="split-layout">

    <div class="left-panel">
        <div class="login-card">

            <div class="login-header">
                <h1>Login</h1>
                <p>Silahkan masukkan email dan password anda</p>
            </div>

                        <?php if (!empty($error)) : ?>
                <div class="error-message">
                    Email atau password salah!
                </div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Masukkan email aktif" required>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                </div>

                <button type="submit" class="btn-login">Login</button>

                <p class="register-link">
                    Belum punya akun? <a href="RegisterController.php">Daftar sekarang</a>
                </p>
            </form>

        </div>
    </div>

    <div class="right-panel">
        <img src="../../../public/assets/image/gambar.jpeg" alt="pict">
    </div>

</div>
</body>
</html>