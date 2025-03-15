<?php
session_start();
require_once '../backend/request.php';

$request = new Request();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'finance') {
    header("Location: /frontend/login.html");
    exit();
}

if (isset($_POST['generate_report'])) {
    $start_date = $_POST['start_date'] . " 00:00:00";
    $end_date = $_POST['end_date'] . " 23:59:59";
    $reports = $request->getReports($start_date, $end_date);
    echo json_encode($reports);
    exit();
}