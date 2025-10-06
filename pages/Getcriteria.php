<?php
include '../config/db.php';
header('Content-Type: application/json');

$result = $conn->query("
    SELECT c.criteria_question, c.max_score, e.evaluation_category, c.criteria_id
    FROM evaluation_criteria_table c
    JOIN evaluation_category_table e 
    ON c.evaluation_category_id = e.evaluation_category_id
    WHERE c.use_state = 1
    ORDER BY c.criteria_id ASC
");

$criteria = [];
while ($row = $result->fetch_assoc()) {
    $criteria[] = $row;
}

echo json_encode($criteria);
$conn->close();
?>
