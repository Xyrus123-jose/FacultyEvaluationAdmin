<?php
include '../config/db.php';
header('Content-Type: application/json');

// Function to generate new numeric academic_year_id
function generateAcademicYearID($conn) {
    $query = "SELECT academic_year_id FROM academic_year_table ORDER BY academic_year_id DESC LIMIT 1";
    $result = $conn->query($query);

    if ($result && $row = $result->fetch_assoc()) {
        $lastId = intval($row['academic_year_id']);
        return $lastId + 1;
    } else {
        return 1; // Start from 1 if no record exists
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $academic_year_id = generateAcademicYearID($conn);
    $academic_year_start = trim($_POST['academic_year_start'] ?? '');
    $academic_year_end = trim($_POST['academic_year_end'] ?? '');
    $semester = trim($_POST['semester'] ?? '');
    $status = isset($_POST['status']) ? intval($_POST['status']) : 0; // Default to 0 if not provided

    // Validate input
    if ($academic_year_start === '' || $academic_year_end === '' || $semester === '') {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit;
    }

    // Ensure status is either 0 or 1
    if ($status !== 0 && $status !== 1) {
        $status = 0;
    }

    // Check for duplicates
    $checkQuery = "SELECT * FROM academic_year_table WHERE academic_year_start=? AND academic_year_end=? AND semester=?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("iis", $academic_year_start, $academic_year_end, $semester);
    $stmt->execute();
    $checkResult = $stmt->get_result();

    if ($checkResult->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'This academic year and semester already exist.']);
        exit;
    }

    // Insert record
    $insertQuery = "INSERT INTO academic_year_table 
                    (academic_year_id, academic_year_start, academic_year_end, semester, status)
                    VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("iiiii", $academic_year_id, $academic_year_start, $academic_year_end, $semester, $status);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Academic year added successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add academic year.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
