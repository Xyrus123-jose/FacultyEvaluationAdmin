<?php
include '../config/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $department_id   = $_POST['department_id'];
    $department_name = trim($_POST['department_name']);
    $college_program = $_POST['college_program'];
    $department_head = $_POST['department_head'];
    $office_location = trim($_POST['office_location']);

    if (empty($department_name) || empty($college_program) || empty($department_head) || empty($office_location)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'All fields are required.'
        ]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO department_table (department_id, department_name, college_program, department_head, office_location) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $department_id, $department_name, $college_program, $department_head, $office_location);

    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Department added successfully.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => $stmt->error
        ]);
    }

    $stmt->close();
    $conn->close();

} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request.'
    ]);
}
?>
