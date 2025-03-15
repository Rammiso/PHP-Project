<?php
session_start();
require_once '../backend/user.php';

$user = new User();

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $email = $_POST['email'];
    if ($user->register($username, $password, $role, $email)) {
        echo "/frontend/login.html"; // Redirect path for JS
    } else {
        echo "Registration failed!";
    }
    exit();
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($result = $user->login($username, $password)) {
        $_SESSION['user_id'] = $result['id'];
        $_SESSION['role'] = $result['role'];
        if ($result['role'] == 'employee') {
            echo "/frontend/dashboard_employee.html";
        } elseif ($result['role'] == 'manager') {
            echo "/frontend/dashboard_manager.html";
        } else {
            echo "/frontend/dashboard_finance.html";
        }
    } else {
        echo "Login failed!";
    }
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: /frontend/login.html");
    exit();
}