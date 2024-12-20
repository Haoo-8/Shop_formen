<?php

class User extends Db
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // -----------------
    // QUẢN LÝ NGƯỜI DÙNG
    // -----------------
    public function getAllUsers()
    {
        $sql = "SELECT * FROM users ORDER BY created_at DESC";
        return $this->db->select($sql);
    }
    // Đăng ký người dùng
    public function register($username, $password, $email, $phone, $role = 'user')
    {
        if ($this->checkUsernameExists($username)) {
            throw new Exception("Username đã tồn tại.");
        }
        if ($this->checkEmailExists($email)) {
            throw new Exception("Email đã tồn tại.");
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password, email, phone, role) VALUES (?, ?, ?,?,?)";
        return $this->db->insert($sql, [$username, $passwordHash, $email, $phone, $role]);
    }
    public function addUser($fullName, $password, $email, $role)
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (username, password,email, role) VALUES (?, ?, ?, ?)";
        return $this->db->insert($sql, [$fullName, $hashedPassword, $email, $role]);
    }

    public function loginAdmin($username, $password)
    {
        $sql = "SELECT * FROM users WHERE username = ? AND role = 'admin'";
        $user = $this->db->selectOne($sql, [$username]);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    // Đăng nhập
    public function login($username, $password)
    {
        $user = $this->getUserByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function isAdmin($userId)
    {
        $sql = "SELECT role FROM users WHERE user_id = $userId";
        $role = $this->db->selectOne($sql, [$userId]);
        return $role['role'] == 'admin';
    }

    // Lấy thông tin người dùng theo username
    public function getUserByUsername($username)
    {
        $sql = "SELECT * FROM users WHERE username = ?";
        return $this->db->selectOne($sql, [$username]);
    }

    // Lấy thông tin người dùng theo ID
    public function getUserById($userId)
    {
        $sql = "SELECT * FROM users WHERE user_id = ?";
        return $this->db->selectOne($sql, [$userId]);
    }

    public function getUserInfoById($userId){
        $sql = "SELECT * FROM users WHERE user_id =?";
        return $this->db->fetch($sql, [$userId]);
    }

    // Xóa người dùng
    public function deleteUser($userId)
    {
        $sql = "DELETE FROM users WHERE user_id = ?";
        return $this->db->delete($sql, [$userId]);
    }

    // Cập nhật thông tin người dùng
    public function updateUser($userId, $fullName, $email, $role)
    {
        $sql = "UPDATE users SET username = ?, email = ?, role = ? WHERE user_id = ?";
        return $this->db->update($sql, [$fullName, $email, $role, $userId]);
    }

    public function updateUserStatus($userId, $status)
    {
        $sql = "UPDATE users SET status = ? WHERE user_id = ?";
        return $this->db->update($sql, [$status, $userId]);
    }

    // Cập nhật thông tin người dùng
    public function updateUserInfo($full_name, $phone_number, $address, $user_id)
    {
    $sql = "UPDATE users SET  fullname = ?, phone = ?, address = ? WHERE user_id = ?";
        return $this->db->update($sql, ([$full_name, $phone_number, $address, $user_id]));
    }


    // -----------------
    // QUẢN LÝ MẬT KHẨU
    // -----------------

    // Đổi mật khẩu
    public function changePassword($userId, $oldPassword, $newPassword)
    {
        $user = $this->getUserById($userId);
        if ($user && password_verify($oldPassword, $user['password'])) {
            $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET password = ? WHERE user_id = ?";
            return $this->db->update($sql, [$passwordHash, $userId]);
        }
        return false;
    }

    // Reset mật khẩu
    public function resetPassword($username, $newPassword)
    {
        $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = ? WHERE username = ?";
        return $this->db->update($sql, [$passwordHash, $username]);
    }

    // -----------------
    // KIỂM TRA DỮ LIỆU
    // -----------------

    // Kiểm tra username tồn tại
    public function checkUsernameExists($username)
    {
        $sql = "SELECT COUNT(*) as total FROM users WHERE username = ?";
        return $this->db->selectOne($sql, [$username])['total'] > 0;
    }

    // Kiểm tra email tồn tại
    public function checkEmailExists($email)
    {
        $sql = "SELECT COUNT(*) as total FROM users WHERE email = ?";
        return $this->db->selectOne($sql, [$email])['total'] > 0;
    }

    public function checkLogin($username, $password)
    { 
        $sql = "SELECT * FROM users WHERE username = ?";
        $user = $this->db->selectOne($sql, [$username]); // Kiểm tra xem người dùng có tồn tại hay không và mật khẩu có khớp không 
        if ($user && password_verify($password, $user['password'])) {
            return $user; 
        } else {
            return false; 
        }
    }
    // -----------------
    // QUẢN LÝ VAI TRÒ
    // -----------------

    // Thay đổi vai trò
    public function changeUserRole($userId, $newRole)
    {
        $sql = "UPDATE users SET role = ? WHERE user_id = ?";
        return $this->db->update($sql, [$newRole, $userId]);
    }

    // Lấy tất cả vai trò
    public function getAllRoles()
    {
        $sql = "SELECT DISTINCT role FROM users";
        return $this->db->select($sql);
    }

    // Lấy người dùng theo vai trò
    public function getUsersByRole($role)
    {
        $sql = "SELECT * FROM users WHERE role = ?";
        return $this->db->select($sql, [$role]);
    }

    // -----------------
    // TÌM KIẾM VÀ PHÂN TRANG
    // -----------------

    // Tìm kiếm người dùng
    public function searchUsers($keyword)
    {
        $sql = "SELECT * FROM users WHERE username LIKE ? OR email LIKE ?";
        return $this->db->select($sql, ["%$keyword%", "%$keyword%"]);
    }

    // Lấy tổng số người dùng
    public function getUserCount()
    {
        $sql = "SELECT COUNT(*) AS count FROM users";
        $result = $this->db->select($sql);
        return $result[0]['count'] ?? 0;
    }


    // Lấy người dùng theo trang
    public function getUsersByPage($page, $limit)
    {
        $start = ($page - 1) * $limit;
        $sql = "SELECT * FROM users LIMIT ?, ?";
        return $this->db->select($sql, [$start, $limit]);
    }
}
