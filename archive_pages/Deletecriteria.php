<?php
header('Content-Type: application/json');
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

if (empty($_POST['criteria_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing criteria ID.']);
    exit;
}

$criteria_id = (int) $_POST['criteria_id'];

try {
    $stmt = $conn->prepare("DELETE FROM evaluation_criteria_table WHERE criteria_id = ?");
    $stmt->bind_param("i", $criteria_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Criterion deleted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete criterion.']);
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
}
?>
