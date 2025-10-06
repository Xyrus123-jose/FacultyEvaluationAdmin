<?php
// Editcriteria.php

include '../config/db.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data and sanitize
    $criteria_id = isset($_POST['criteria_id']) ? intval($_POST['criteria_id']) : 0;
    $criteria_question = isset($_POST['criteria_question']) ? $conn->real_escape_string($_POST['criteria_question']) : '';
    $max_score = isset($_POST['max_score']) ? intval($_POST['max_score']) : 0;
    $evaluation_category_id = isset($_POST['evaluation_category_id']) ? intval($_POST['evaluation_category_id']) : 0;
    $evaluation_type = isset($_POST['evaluation_type']) ? $conn->real_escape_string($_POST['evaluation_type']) : '';
    $use_state = isset($_POST['use_state']) ? intval($_POST['use_state']) : 1;

    // Validate inputs
    if ($criteria_id > 0 && !empty($criteria_question) && $max_score > 0 && $evaluation_category_id > 0 && !empty($evaluation_type)) {
        $sql = "UPDATE evaluation_criteria_table 
                SET criteria_question = '$criteria_question',
                    max_score = $max_score,
                    evaluation_category_id = $evaluation_category_id,
                    evaluation_type = '$evaluation_type',
                    use_state = $use_state
                WHERE criteria_id = $criteria_id";

        if ($conn->query($sql) === TRUE) {
            // Success
            header("Location: your_criteria_page.php?success=Criteria updated successfully");
            exit();
        } else {
            // DB error
            header("Location: your_criteria_page.php?error=Failed to update criteria: " . urlencode($conn->error));
            exit();
        }
    } else {
        // Invalid input
        header("Location: your_criteria_page.php?error=Invalid input, please check all fields.");
        exit();
    }

    $conn->close();
} else {
    // Invalid request method
    header("Location: your_criteria_page.php?error=Invalid request.");
    exit();
}
?>
