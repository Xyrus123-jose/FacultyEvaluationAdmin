<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = $_POST['category_id'];

    if (!empty($category_id)) {
        $sql = "DELETE FROM evaluation_category_table WHERE evaluation_category_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $category_id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Category deleted successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error deleting category: " . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid category ID."]);
    }

    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>
