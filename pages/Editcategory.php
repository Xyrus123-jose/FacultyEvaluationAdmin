<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_category_id = $_POST['old_category_id'];
    $evaluation_category = $_POST['evaluation_category'];
    $status = $_POST['status'];

    // Allow status 0 but still check others
    if (!empty($old_category_id) && !empty($evaluation_category) && isset($status)) {
        $sql = "UPDATE evaluation_category_table 
                SET evaluation_category = ?, status = ?
                WHERE evaluation_category_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $evaluation_category, $status, $old_category_id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Category updated successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error updating category: " . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Please fill in all required fields."]);
    }

    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>
