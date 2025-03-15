<?php
require_once '../backend/db_connect.php';

class Request {
    public function submit($user_id, $destination, $start_date, $end_date, $amount, $manager_id) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO per_diem_requests (user_id, destination, start_date, end_date, amount, manager_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssdi", $user_id, $destination, $start_date, $end_date, $amount, $manager_id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function getPendingRequests($manager_id) {
        global $conn;
        $stmt = $conn->prepare("SELECT id, destination, amount, status FROM per_diem_requests WHERE manager_id = ? AND status = 'pending'");
        $stmt->bind_param("i", $manager_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $requests = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $requests;
    }

    public function getUserRequests($user_id) {
        global $conn;
        $stmt = $conn->prepare("SELECT id, destination, amount, status FROM per_diem_requests WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $requests = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $requests;
    }

    public function updateStatus($request_id, $status) {
        global $conn;
        $approved_date = ($status !== 'pending') ? date('Y-m-d H:i:s') : null;
        $stmt = $conn->prepare("UPDATE per_diem_requests SET status = ?, approved_date = ? WHERE id = ?");
        $stmt->bind_param("ssi", $status, $approved_date, $request_id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function getReports($start_date, $end_date) {
        global $conn;
        $stmt = $conn->prepare("SELECT id, user_id, amount, status FROM per_diem_requests WHERE submission_date BETWEEN ? AND ?");
        $stmt->bind_param("ss", $start_date, $end_date);
        $stmt->execute();
        $result = $stmt->get_result();
        $reports = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $reports;
    }

    public function getMaxDailyRate() {
        global $conn;
        $stmt = $conn->prepare("SELECT max_daily_rate FROM policies LIMIT 1");
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row['max_daily_rate'];
    }
}