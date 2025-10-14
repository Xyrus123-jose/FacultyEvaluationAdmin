<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $old_id = trim($_POST['old_year_level_id']);  // original ID
    $year_level_id = trim($_POST['year_level_id']); // possibly new ID
    $year_level = trim($_POST['year_level']);
    $year_level_label = trim($_POST['year_level_label']);

    // Validate inputs
    if (empty($year_level_id) || empty($year_level) || empty($year_level_label)) {
        header("Location: year_level.php?status=error&message=All fields are required");
        exit;
    }

    // Check for duplicate ID if it was changed
    if ($old_id !== $year_level_id) {
        $check = $conn->prepare("SELECT * FROM year_level_table WHERE year_level_id = ?");
        $check->bind_param("s", $year_level_id);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            header("Location: year_level.php?status=error&message=Year Level ID already exists");
            exit;
        }
    }

    // Update the record
    $stmt = $conn->prepare("UPDATE year_level_table SET year_level_id = ?, year_level = ?, year_level_label = ? WHERE year_level_id = ?");
    $stmt->bind_param("ssss", $year_level_id, $year_level, $year_level_label, $old_id);

    if ($stmt->execute()) {
        header("Location: year_level.php?status=success&message=Year Level updated successfully");
        exit;
    } else {
        header("Location: year_level.php?status=error&message=Failed to update Year Level");
        exit;
    }

    $stmt->close();
    $conn->close();
} else {
    // Redirect if accessed directly
    header("Location: year_level.php");
    exit;
}
?>
