<?php
session_start();
require_once '../backend/request.php';

$request = new Request();

if (!isset($_SESSION['user_id'])) {
    header("Location: /frontend/login.html");
    exit();
}

if (isset($_POST['submit_request'])) {
    $user_id = $_SESSION['user_id'];
    $destination = $_POST['destination'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $days = (strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24);
    $max_rate = $request->getMaxDailyRate();
    $amount = $days * $max_rate;
    $manager_id = 2; // Hardcoded for demo; assign dynamically in production
    if ($request->submit($user_id, $destination, $start_date, $end_date, $amount, $manager_id)) {
        echo "Request submitted successfully!";
    } else {
        echo "Submission failed!";
    }
    exit();
}

if (isset($_POST['load_requests'])) {
    $role = $_POST['role'];
    if ($role === 'employee') {
        $requests = $request->getUserRequests($_SESSION['user_id']);
    } elseif ($role === 'manager') {
        $requests = $request->getPendingRequests($_SESSION['user_id']);
    }
    echo json_encode($requests);
    exit();
}

if (isset($_POST['approve']) || isset($_POST['reject'])) {
    $request_id = $_POST['request_id'];
    $status = isset($_POST['approve']) ? 'approved' : 'rejected';
    if ($request->updateStatus($request_id, $status)) {
        echo "Request $status successfully!";
    } else {
        echo "Action failed!";
    }
    exit();
}