<?php
header('Content-Type: application/json');
include '../config/db.php';

// Check required POST data
if (!isset($_POST['criteria_question'], $_POST['max_score'], $_POST['category'], $_POST['use_state'], $_POST['evaluation_type'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
    exit;
}

// Sanitize and assign variables
$criteria_question = trim($_POST['criteria_question']);
$max_score = (int)$_POST['max_score'];
$category_id = (int)$_POST['category'];
$use_state = (int)$_POST['use_state'];
$evaluation_type = trim($_POST['evaluation_type']); // Example: 'rating', 'text', etc.

// Validate input
if ($criteria_question === '' || $max_score <= 0 || $category_id <= 0 || $evaluation_type === '') {
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
    exit;
}

// Prepare and execute insert
$sql = "INSERT INTO evaluation_criteria_table (criteria_question, max_score, evaluation_category_id, use_state, evaluation_type) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("siiis", $criteria_question, $max_score, $category_id, $use_state, $evaluation_type);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Criteria added successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add criteria.']);
}

$stmt->close();
$conn->close();
