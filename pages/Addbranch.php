<?php
// Addbranch.php
require_once '../config/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $branch_name = trim($_POST['branch_name']);
    $branch_abbreviation = trim($_POST['branch_abbreviation']);

    // Get the last branch_id
    $query = "SELECT branch_id FROM branch_table ORDER BY CAST(SUBSTRING(branch_id, 4) AS UNSIGNED) DESC LIMIT 1";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $last_id = $row['branch_id']; // e.g., "br-5"
        $num = intval(substr($last_id, 3)) + 1;
        $branch_id = 'br-' . $num;
    } else {
        $branch_id = 'br-1';
    }

    $stmt = $conn->prepare("INSERT INTO branch_table (branch_id, branch_name, branch_abbreviation) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $branch_id, $branch_name, $branch_abbreviation);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Branch added successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error adding branch.']);
    }

    $stmt->close();
    $conn->close();
}
?>
