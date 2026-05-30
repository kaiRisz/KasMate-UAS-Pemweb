<?php
require_once '../../../config/database.php';
require_once '../../model/auth/AuthModel.php';

$authModel = new AuthModel($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $authModel->registerUser($nama, $email, $password);

    header("Location: LoginController.php");
    exit();
}

require_once '../../view/auth/register.php';
?>
