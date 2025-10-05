<?php
include '../config/db.php';

$response = ['status' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $department_id = $conn->real_escape_string($_POST['department_id']);
    $department_name = $conn->real_escape_string($_POST['department_name']);
    $college_program = $conn->real_escape_string($_POST['college_program']);
    $department_head = $conn->real_escape_string($_POST['department_head']);
    $office_location = $conn->real_escape_string($_POST['office_location']);

    // Update query
    $sql = "UPDATE department_table 
            SET department_name = '$department_name',
                college_program = '$college_program',
                department_head = '$department_head',
                office_location = '$office_location'
            WHERE department_id = '$department_id'";

    if ($conn->query($sql) === TRUE) {
        $response['status'] = 'success';
        $response['message'] = 'Department updated successfully!';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error updating department: ' . $conn->error;
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
} else {
    // Redirect if accessed directly
    header("Location: department.php");
    exit();
}
?>
