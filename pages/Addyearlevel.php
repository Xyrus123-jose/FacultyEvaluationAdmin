<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $year_level_id = trim($_POST['year_level_id']);  // manual input
    $year_level = trim($_POST['year_level']);
    $year_level_label = trim($_POST['year_level_label']);

    if (empty($year_level_id) || empty($year_level) || empty($year_level_label)) {
        header("Location: year_level.php?status=error&message=All fields are required");
        exit;
    }

    // Check if year_level_id already exists
    $check = $conn->prepare("SELECT * FROM year_level_table WHERE year_level_id = ?");
    $check->bind_param("s", $year_level_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        header("Location: year_level.php?status=error&message=Year Level ID already exists");
        exit;
    }

    // Insert new year level
    $stmt = $conn->prepare("INSERT INTO year_level_table (year_level_id, year_level, year_level_label) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $year_level_id, $year_level, $year_level_label);

    if ($stmt->execute()) {
        header("Location: year_level.php?status=success&message=Year Level added successfully");
        exit;
    } else {
        header("Location: year_level.php?status=error&message=Failed to add Year Level");
        exit;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: year_level.php");
    exit;
}
?>
