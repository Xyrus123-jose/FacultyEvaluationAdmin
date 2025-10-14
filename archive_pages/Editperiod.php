<?php
include '../config/db.php';

// Set JSON header
header('Content-Type: application/json');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get POST data safely
    $period_id       = $_POST['period_id'] ?? '';
    $academic_year   = $_POST['academic_year_id'] ?? '';
    $program_id      = $_POST['program_id'] ?? '';
    $year_level_id   = $_POST['year_level_id'] ?? '';
    $section_id      = $_POST['section_id'] ?? '';
    $start_date      = $_POST['start_date'] ?? '';
    $end_date        = $_POST['end_date'] ?? '';
    $time_start      = $_POST['time_start'] ?? '';
    $time_end        = $_POST['time_end'] ?? '';

    // Basic validation
    if (empty($period_id) || empty($academic_year) || empty($program_id) || empty($year_level_id) || empty($section_id) || empty($start_date) || empty($end_date) || empty($time_start) || empty($time_end)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'All fields are required.'
        ]);
        exit();
    }

    // Prepare update statement
    $stmt = $conn->prepare("UPDATE evaluation_period_table 
                            SET academic_year_id = ?, program_id = ?, year_level_id = ?, section_id = ?, start_date = ?, end_date = ?, time_start = ?, time_end = ? 
                            WHERE period_id = ?");
    $stmt->bind_param("issssssss", $academic_year, $program_id, $year_level_id, $section_id, $start_date, $end_date, $time_start, $time_end, $period_id);

    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Evaluation period updated successfully.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Error updating record: ' . $conn->error
        ]);
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>
