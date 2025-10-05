<?php
include '../config/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $branch_id = $_POST['branch_id'];
    $branch_name = trim($_POST['branch_name']);
    $branch_abbreviation = trim($_POST['branch_abbreviation']);

    $stmt = $conn->prepare("UPDATE branch_table SET branch_name = ?, branch_abbreviation = ? WHERE branch_id = ?");
    $stmt->bind_param("sss", $branch_name, $branch_abbreviation, $branch_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Branch updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update branch.']);
    }

    $stmt->close();
    $conn->close();
}
?>
