<?php
include '../config/db.php';

// Function to auto-generate section_id (s-1, s-2, ...)
function generateSectionID($conn) {
    $result = $conn->query("SELECT section_id FROM section_table ORDER BY section_id DESC LIMIT 1");
    if ($result && $row = $result->fetch_assoc()) {
        $lastId = $row['section_id'];
        $number = intval(str_replace('s-', '', $lastId));
        $newNumber = $number + 1;
    } else {
        $newNumber = 1;
    }
    return 's-' . $newNumber;
}

$response = []; // for JSON response

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $section_id = generateSectionID($conn);
    $section = trim($_POST['section']);

    // Validation
    if (empty($section)) {
        $response = ['status' => 'error', 'message' => 'Section name is required.'];
    } else {
        // Insert into database
        $stmt = $conn->prepare("INSERT INTO section_table (section_id, section) VALUES (?, ?)");
        $stmt->bind_param("ss", $section_id, $section);

        if ($stmt->execute()) {
            $response = ['status' => 'success', 'message' => 'Section added successfully!', 'section_id' => $section_id];
        } else {
            $response = ['status' => 'error', 'message' => $stmt->error];
        }

        $stmt->close();
    }

    $conn->close();

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;

} else {
    // Redirect if not POST
    header("Location: section.php");
    exit;
}
?>
