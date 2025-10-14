<?php
include '../config/db.php';

// Set JSON header
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $period_id = $_POST['period_id'] ?? '';

    if (empty($period_id)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Period ID is required.'
        ]);
        exit();
    }

    // Prepare DELETE statement
    $stmt = $conn->prepare("DELETE FROM evaluation_period_table WHERE period_id = ?");
    $stmt->bind_param("s", $period_id);

    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Evaluation period deleted successfully.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Error deleting period: ' . $conn->error
        ]);
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>
