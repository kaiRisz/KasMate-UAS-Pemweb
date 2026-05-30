<?php
class AuthModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function getUserByEmail($email) {
        $email = mysqli_real_escape_string($this->conn, $email);
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($this->conn, $query);
        
        if ($result && mysqli_num_rows($result) === 1) {
            return mysqli_fetch_assoc($result);
        }
        return false;
    }

    public function registerUser($nama, $email, $password, $role = 'user') {
        $nama = mysqli_real_escape_string($this->conn, $nama);
        $email = mysqli_real_escape_string($this->conn, $email);
        
        $query = "INSERT INTO users (nama, email, password, role) VALUES ('$nama', '$email', '$password', '$role')";
        return mysqli_query($this->conn, $query);
    }
}
?>
