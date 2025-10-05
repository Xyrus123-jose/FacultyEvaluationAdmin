<?php
include '../config/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $branch_id = $_POST['branch_id'];

    $stmt = $conn->prepare("DELETE FROM branch_table WHERE branch_id = ?");
    $stmt->bind_param("s", $branch_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Branch deleted successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete branch.']);
    }

    $stmt->close();
    $conn->close();
}
?>
