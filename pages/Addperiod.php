<?php
include '../config/db.php';

// Set JSON header
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $academic_year_id = $_POST['academic_year_id'] ?? '';
    $program_id       = $_POST['program_id'] ?? '';
    $year_level_id    = $_POST['year_level_id'] ?? '';
    $section_id       = $_POST['section_id'] ?? '';
    $start_date       = $_POST['start_date'] ?? '';
    $end_date         = $_POST['end_date'] ?? '';
    $time_start       = $_POST['time_start'] ?? '';
    $time_end         = $_POST['time_end'] ?? '';

    // Validation
    if (!$academic_year_id || !$program_id || !$year_level_id || !$section_id || !$start_date || !$end_date || !$time_start || !$time_end) {
        echo json_encode([
            'status' => 'error',
            'message' => 'All fields are required.'
        ]);
        exit();
    }

    // Get year from academic_year_id
    $year_result = $conn->query("SELECT academic_year_start FROM academic_year_table WHERE academic_year_id='$academic_year_id'");
    $year_row = $year_result->fetch_assoc();
    $year = date('Y', strtotime($year_row['academic_year_start']));

    // Count existing periods
    $count_result = $conn->query("SELECT COUNT(*) AS total FROM evaluation_period_table WHERE period_id LIKE 'P-$year-%'");
    $count_row = $count_result->fetch_assoc();
    $next_number = $count_row['total'] + 1;

    $period_id = "P-$year-$next_number";

    // Insert new period
    $stmt = $conn->prepare("INSERT INTO evaluation_period_table (period_id, academic_year_id, program_id, year_level_id, section_id, start_date, end_date, time_start, time_end) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisssssss", $period_id, $academic_year_id, $program_id, $year_level_id, $section_id, $start_date, $end_date, $time_start, $time_end);

    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Evaluation period added successfully.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Error adding period: ' . $conn->error
        ]);
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>
