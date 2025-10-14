<?php
include '../config/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['academic_year_id'] ?? '';

    if (empty($id)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid academic year ID.']);
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM academic_year_table WHERE academic_year_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Academic year deleted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete academic year.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
