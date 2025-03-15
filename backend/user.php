<?php
require_once '../backend/db_connect.php';

class User {
    public function register($username, $password, $role, $email) {
        global $conn;
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password, role, email) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $hashed_password, $role, $email);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function login($username, $password) {
        global $conn;
        $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                $stmt->close();
                return $row;
            }
        }
        $stmt->close();
        return false;
    }
}