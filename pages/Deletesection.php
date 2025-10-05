<?php
require_once '../config/db.php';
header('Content-Type: application/json');

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $section_id = $_POST['section_id'] ?? '';

    if (empty($section_id)) {
        $response = ['status' => 'error', 'message' => 'Section ID is missing.'];
    } else {
        $stmt = $conn->prepare("DELETE FROM section_table WHERE section_id = ?");
        $stmt->bind_param("s", $section_id);

        if ($stmt->execute()) {
            $response = ['status' => 'success', 'message' => 'Section deleted successfully.'];
        } else {
            $response = ['status' => 'error', 'message' => 'Failed to delete section.'];
        }

        $stmt->close();
    }
} else {
    $response = ['status' => 'error', 'message' => 'Invalid request method.'];
}

echo json_encode($response);
$conn->close();
?>
