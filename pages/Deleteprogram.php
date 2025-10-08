<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../config/db.php'; // adjust if in another directory

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['program_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'Program ID not provided']);
        exit;
    }

    $program_id = $_POST['program_id'];

    // Make sure the ID is valid before deleting
    $stmt = $conn->prepare("DELETE FROM program_table WHERE program_id = ?");
    $stmt->bind_param("s", $program_id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Program deleted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Program not found.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
