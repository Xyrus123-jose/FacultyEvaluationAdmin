<?php
include '../config/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize inputs
    $criteria_id = intval($_POST['criteria_id']);
    $criteria_question = trim($_POST['criteria_question']);
    $max_score = intval($_POST['max_score']);
    $category = intval($_POST['category']);
    $use_state = intval($_POST['use_state']);

    // Validate
    if (empty($criteria_id) || empty($criteria_question) || empty($max_score) || empty($category)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Please fill out all required fields.'
        ]);
        exit;
    }

    // Prepare SQL Update
    $sql = "UPDATE evaluation_criteria_table 
            SET criteria_question = ?, 
                max_score = ?, 
                evaluation_category_id = ?, 
                use_state = ?
            WHERE criteria_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siiii", $criteria_question, $max_score, $category, $use_state, $criteria_id);

    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Criteria updated successfully!'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update criteria. Please try again.'
        ]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method.'
    ]);
}
?>
