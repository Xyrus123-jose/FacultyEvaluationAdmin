<?php
header('Content-Type: application/json');
include '../config/db.php'; // adjust if needed

$query = "SELECT evaluation_category FROM evaluation_category_table";
$result = $conn->query($query);

$categories = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row['evaluation_category'];
    }
}

echo json_encode($categories);
$conn->close();
?>
