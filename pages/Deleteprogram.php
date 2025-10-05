<?php
// Include database connection
include '../config/db.php';

// Check if program_id is provided
if (isset($_POST['program_id']) && !empty($_POST['program_id'])) {
    $program_id = $_POST['program_id'];

    // Prepare statement to avoid SQL injection
    $stmt = $conn->prepare("DELETE FROM program_table WHERE program_id = ?");
    $stmt->bind_param("s", $program_id);

    if ($stmt->execute()) {
        // Success
        echo json_encode([
            'status' => 'success',
            'message' => 'Program deleted successfully.'
        ]);
    } else {
        // Error executing query
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to delete program. Please try again.'
        ]);
    }

    $stmt->close();
} else {
    // No program_id provided
    echo json_encode([
        'status' => 'error',
        'message' => 'Program ID is required.'
    ]);
}

$conn->close();
?>
