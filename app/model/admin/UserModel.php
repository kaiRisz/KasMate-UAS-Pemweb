<?php

class UserModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function hapusUser($id_user_hapus, $id_admin_login) {
        if ((int)$id_user_hapus === (int)$id_admin_login) {
            return ['status' => false, 'pesan' => 'Anda tidak dapat menghapus akun Anda sendiri saat sedang login.'];
        }

        try {
            mysqli_query($this->conn, "SET FOREIGN_KEY_CHECKS=0");
            
            $query = "DELETE FROM users WHERE id_user = '$id_user_hapus'";
            mysqli_query($this->conn, $query);
            
            mysqli_query($this->conn, "SET FOREIGN_KEY_CHECKS=1");
            
            return ['status' => true, 'pesan' => 'User berhasil dihapus, namun data grup yang pernah dibuatnya tetap aman.'];
            
        } catch (\mysqli_sql_exception $e) {
            mysqli_query($this->conn, "SET FOREIGN_KEY_CHECKS=1");
            return ['status' => false, 'pesan' => 'Gagal menghapus user: Terjadi kesalahan sistem database.'];
        }
    }

    public function tambahUser($nama, $email, $password, $role) {
        $nama = mysqli_real_escape_string($this->conn, $nama);
        $email = mysqli_real_escape_string($this->conn, $email);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $role = mysqli_real_escape_string($this->conn, $role);

        mysqli_query($this->conn, "INSERT INTO users (nama, email, password, role) VALUES ('$nama', '$email', '$password', '$role')");
    }

    public function editUser($id_edit, $nama, $email, $role, $password = '') {
        $id_edit = (int)$id_edit;
        $nama = mysqli_real_escape_string($this->conn, $nama);
        $email = mysqli_real_escape_string($this->conn, $email);
        $role = mysqli_real_escape_string($this->conn, $role);

        $query_update = "UPDATE users SET nama='$nama', email='$email', role='$role'";
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query_update .= ", password='$hashed_password'";
        }
        $query_update .= " WHERE id_user = $id_edit";
        mysqli_query($this->conn, $query_update);
    }

    public function getTotalUsers($search = '', $filter_role = '') {
        $where = "WHERE 1=1";
        if ($search !== '') {
            $search = mysqli_real_escape_string($this->conn, $search);
            $where .= " AND (nama LIKE '%$search%' OR email LIKE '%$search%')";
        }
        if ($filter_role !== '') {
            $filter_role = mysqli_real_escape_string($this->conn, $filter_role);
            $where .= " AND role = '$filter_role'";
        }

        $q_count = mysqli_query($this->conn, "SELECT COUNT(*) as total FROM users $where");
        return mysqli_fetch_assoc($q_count)['total'];
    }

    public function getUsers($search = '', $filter_role = '', $per_page = 10, $offset = 0) {
        $where = "WHERE 1=1";
        if ($search !== '') {
            $search = mysqli_real_escape_string($this->conn, $search);
            $where .= " AND (nama LIKE '%$search%' OR email LIKE '%$search%')";
        }
        if ($filter_role !== '') {
            $filter_role = mysqli_real_escape_string($this->conn, $filter_role);
            $where .= " AND role = '$filter_role'";
        }

        $per_page = (int)$per_page;
        $offset = (int)$offset;

        $query = mysqli_query($this->conn, "SELECT * FROM users $where ORDER BY id_user DESC LIMIT $per_page OFFSET $offset");
        
        $users = [];
        if ($query && mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $users[] = $row;
            }
        }
        return $users;
    }
}
?>