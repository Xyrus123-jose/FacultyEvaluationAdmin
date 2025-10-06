<?php
include '../config/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $criteria_question = trim($_POST['criteria_question']);
    $max_score = intval($_POST['max_score']);
    $evaluation_category_id = intval($_POST['evaluation_category_id']);
    $evaluation_type = trim($_POST['evaluation_type']);
    $use_state = intval($_POST['use_state']);

    if ($criteria_question && $max_score && $evaluation_category_id && $evaluation_type !== "" && isset($use_state)) {
        $stmt = $conn->prepare("INSERT INTO evaluation_criteria_table (criteria_question, max_score, evaluation_category_id, evaluation_type, use_state) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("siisi", $criteria_question, $max_score, $evaluation_category_id, $evaluation_type, $use_state);

        if ($stmt->execute()) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Criteria added successfully.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to add criteria: '.$stmt->error
            ]);
        }

        $stmt->close();
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Please fill in all required fields.'
        ]);
    }

    $conn->close();
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method.'
    ]);
}
?>
