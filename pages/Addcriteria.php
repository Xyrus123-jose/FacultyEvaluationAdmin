<?php
header('Content-Type: application/json');
include '../config/db.php';

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// Validate required fields
if (
    empty($_POST['criteria_question']) ||
    !isset($_POST['max_score']) ||
    empty($_POST['category']) ||
    !isset($_POST['use_state'])
) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

// Sanitize input
$criteria_question = trim($_POST['criteria_question']);
$max_score = (int) $_POST['max_score'];
$category_id = (int) $_POST['category'];
$use_state = (int) $_POST['use_state'];

// Validate values
if ($criteria_question === '' || $max_score <= 0 || $category_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
    exit;
}

try {
    // Prepare SQL insert
    $sql = "INSERT INTO evaluation_criteria_table 
            (criteria_question, max_score, evaluation_category_id, use_state) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siii", $criteria_question, $max_score, $category_id, $use_state);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Criteria added successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database insertion failed.']);
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>
