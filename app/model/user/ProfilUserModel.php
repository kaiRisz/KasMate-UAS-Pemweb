<?php
class ProfilUserModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function updateProfil($id_user, $nama, $email, $password = '') {
        $id_user = (int)$id_user;
        $nama = mysqli_real_escape_string($this->conn, $nama);
        $email = mysqli_real_escape_string($this->conn, $email);

        $sql = "UPDATE users SET nama='$nama', email='$email'";
        if (!empty($password)) {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $sql .= ", password='$hashed'";
        }
        $sql .= " WHERE id_user = $id_user";
        return mysqli_query($this->conn, $sql);
    }
}
?>