<?php
include '../config/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM year_level_table WHERE year_level_id = ?");
    $stmt->bind_param("s", $id);

    if ($stmt->execute()) {
        header("Location: year_level.php?status=success&message=Year Level deleted successfully");
        exit;
    } else {
        header("Location: year_level.php?status=error&message=Failed to delete Year Level");
        exit;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: year_level.php");
    exit;
}
?>
