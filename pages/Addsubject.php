<?php
include '../config/db.php';

function generateSubjectID($conn) {
    $result = $conn->query("SELECT subject_id FROM subject_table ORDER BY subject_id DESC LIMIT 1");
    if ($result && $row = $result->fetch_assoc()) {
        $lastId = $row['subject_id'];
        $number = intval(str_replace('sub-', '', $lastId));
        $newNumber = $number + 1;
    } else {
        $newNumber = 1;
    }
    return 'sub-' . $newNumber;
}

$response = []; // to send status to JS

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject_id = generateSubjectID($conn);
    $subject_code = trim($_POST['subject_code']);
    $subject_title = trim($_POST['subject_title']);
    $units = intval($_POST['units']);
    $program_id = trim($_POST['program_id']);
    $year_level_id = trim($_POST['year_level_id']);

    if (empty($subject_code) || empty($subject_title) || empty($units) || empty($program_id) || empty($year_level_id)) {
        $response = ['status' => 'error', 'message' => 'All fields are required.'];
    } else {
        $stmt = $conn->prepare("INSERT INTO subject_table (subject_id, subject_code, subject_title, units, program_id, created_date, year_level_id) VALUES (?, ?, ?, ?, ?, NOW(), ?)");
        $stmt->bind_param("sssiss", $subject_id, $subject_code, $subject_title, $units, $program_id, $year_level_id);

        if ($stmt->execute()) {
            $response = ['status' => 'success', 'message' => 'Subject added successfully!'];
        } else {
            $response = ['status' => 'error', 'message' => $stmt->error];
        }
        $stmt->close();
    }

    $conn->close();

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
} else {
    header("Location: subject.php");
    exit;
}
?>
