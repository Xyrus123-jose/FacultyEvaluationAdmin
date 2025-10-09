<?php
include '../config/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize input
    $user_id        = trim($_POST['user_id']);
    $username       = trim($_POST['username']);
    $password_plain = trim($_POST['password_hash']);
    $role           = trim($_POST['role']);
    $department_id  = trim($_POST['department_id']);
    $email          = trim($_POST['email']);
    $status         = trim($_POST['status']);

    // Validate required fields
    if (empty($username) || empty($password_plain) || empty($role) || empty($department_id) || empty($email)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
        exit;
    }

    // Hash the password
    $password_hash = password_hash($password_plain, PASSWORD_DEFAULT);

    try {
        // Prepare the SQL insert
        $stmt = $conn->prepare("
            INSERT INTO user_table (user_id, username, password_hash, role, department_id, email, status)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        if ($stmt === false) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        // Bind parameters
        $stmt->bind_param(
            "isssssi",
            $user_id,
            $username,
            $password_hash,
            $role,
            $department_id,
            $email,
            $status
        );

        // Execute
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'User added successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error adding user: ' . $stmt->error]);
        }

        $stmt->close();
        $conn->close();

    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
