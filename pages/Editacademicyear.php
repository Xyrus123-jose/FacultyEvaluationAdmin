<?php
include '../config/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $academic_year_id = $_POST['academic_year_id'] ?? '';
    $academic_year_start = trim($_POST['academic_year_start'] ?? '');
    $academic_year_end = trim($_POST['academic_year_end'] ?? '');
    $semester = trim($_POST['semester'] ?? '');
    $status = trim($_POST['status'] ?? '');


    // Validate that end year is greater than start year
    if ((int)$academic_year_end <= (int)$academic_year_start) {
        echo json_encode(['status' => 'error', 'message' => 'End year must be greater than start year.']);
        exit;
    }

    // Update query
    $stmt = $conn->prepare("
        UPDATE academic_year_table 
        SET academic_year_start = ?, academic_year_end = ?, semester = ?, status = ? 
        WHERE academic_year_id = ?
    ");
    $stmt->bind_param("iisii", $academic_year_start, $academic_year_end, $semester, $status, $academic_year_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Academic year updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update academic year.']);
    }

    $stmt->close();
    $conn->close();
}
?>
