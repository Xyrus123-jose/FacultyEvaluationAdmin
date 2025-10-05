<?php
include '../config/db.php';
header('Content-Type: application/json');

function updateAcademicYear($conn, $id, $start, $end, $semester, $status) {
    // Validate inputs
    if (empty($id) || empty($start) || empty($end) || empty($semester) || empty($status)) {
        return ['status' => 'error', 'message' => 'All fields are required.'];
    }

    // Optional: check that end year > start year
    if ($end <= $start) {
        return ['status' => 'error', 'message' => 'End year must be greater than start year.'];
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("
        UPDATE academic_year_table 
        SET academic_year_start = ?, 
            academic_year_end = ?, 
            semester = ?, 
            status = ? 
        WHERE academic_year_id = ?
    ");

    $stmt->bind_param("iisii", $start, $end, $semester, $status, $id);

    if ($stmt->execute()) {
        return ['status' => 'success', 'message' => 'Academic year updated successfully.'];
    } else {
        return ['status' => 'error', 'message' => 'Database error: ' . $conn->error];
    }
}

// Check POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['academic_year_id'] ?? '';
    $start = $_POST['academic_year_start'] ?? '';
    $end = $_POST['academic_year_end'] ?? '';
    $semester = $_POST['semester'] ?? '';
    $status = $_POST['status'] ?? '';

    $response = updateAcademicYear($conn, $id, $start, $end, $semester, $status);
    echo json_encode($response);
}
?>
