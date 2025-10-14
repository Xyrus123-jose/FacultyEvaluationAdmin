<?php
include '../config/db.php';

$response = []; // For JSON response

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_section_id = trim($_POST['old_section_id']);
    $section = trim($_POST['section']);

    // Validation
    if (empty($old_section_id) || empty($section)) {
        $response = ['status' => 'error', 'message' => 'All fields are required.'];
    } else {
        // Update query
        $stmt = $conn->prepare("UPDATE section_table SET section = ? WHERE section_id = ?");
        $stmt->bind_param("ss", $section, $old_section_id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $response = ['status' => 'success', 'message' => 'Section updated successfully!'];
            } else {
                $response = ['status' => 'warning', 'message' => 'No changes made or section not found.'];
            }
        } else {
            $response = ['status' => 'error', 'message' => $stmt->error];
        }

        $stmt->close();
    }

    $conn->close();

    // Return JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
} else {
    // Redirect if not POST
    header("Location: section.php");
    exit;
}
?>
