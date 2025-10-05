<?php
include '../config/db.php';

$response = ['status' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $department_id = $conn->real_escape_string($_POST['department_id']);

    $sql = "DELETE FROM department_table WHERE department_id = '$department_id'";

    if ($conn->query($sql) === TRUE) {
        $response['status'] = 'success';
        $response['message'] = 'Department deleted successfully!';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error deleting department: ' . $conn->error;
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
} else {
    header("Location: department.php");
    exit();
}
?>
