<?php
// auth.php
session_start();
include '../config/db.php'; // database connection

$user = null;

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user_table WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $userData = $result->fetch_assoc();

    if ($userData && password_verify($password, $userData['password'])) {
        $user = $userData;
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
    }
}
