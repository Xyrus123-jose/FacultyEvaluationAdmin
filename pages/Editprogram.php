<?php
// Include database connection
include '../config/db.php';

// Check if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_id = $_POST['old_program_id']; // original ID
    $new_id = trim($_POST['program_id']);
    $program_name = trim($_POST['program_name']);
    $program_status = isset($_POST['program_status']) ? 1 : 0;

    // Validate inputs
    if (empty($new_id) || empty($program_name)) {
        echo "Program ID and Program Name are required.";
        exit;
    }

    // Update program in the database
    $stmt = $conn->prepare("UPDATE program_table SET program_id=?, program_name=?, status=? WHERE program_id=?");
    $stmt->bind_param("ssis", $new_id, $program_name, $program_status, $old_id);

    if ($stmt->execute()) {
        // Success, redirect back to programs page
        header("Location: program.php?msg=updated");
        exit;
    } else {
        echo "Error updating program: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch program to edit if program_id is provided via GET
if (isset($_GET['program_id'])) {
    $program_id = $_GET['program_id'];
    $stmt = $conn->prepare("SELECT * FROM program_table WHERE program_id=?");
    $stmt->bind_param("s", $program_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $program = $result->fetch_assoc();
    $stmt->close();
} else {
    echo "No program selected.";
    exit;
}

$conn->close();
?>



