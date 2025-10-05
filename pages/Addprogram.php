<?php
// Include database connection
include '../config/db.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $program_id = trim($_POST['program_id']);
    $program_name = trim($_POST['program_name']);
    $program_status = isset($_POST['program_status']) ? 1 : 0;

    // Validate input
    if (empty($program_id) || empty($program_name)) {
        echo "Program ID and Program Name are required.";
        exit;
    }

    // Prepare and execute insert query
    $stmt = $conn->prepare("INSERT INTO program_table (program_id, program_name, status) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $program_id, $program_name, $program_status);

    if ($stmt->execute()) {
        // Success, redirect back to form or program list
        header("Location: ../pages/program.php?msg=added");
        exit;
    } else {
        // Error
        echo "Error adding program: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
