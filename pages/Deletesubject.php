<?php
include '../config/db.php';

$response = ['status' => '', 'message' => ''];

if (isset($_POST['subject_id'])) {
    $subject_id = $conn->real_escape_string($_POST['subject_id']);

    $sql = "DELETE FROM subject_table WHERE subject_id = '$subject_id'";
    if ($conn->query($sql) === TRUE) {
        $response['status'] = 'success';
        $response['message'] = 'Subject deleted successfully!';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error deleting subject: ' . $conn->error;
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request';
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>
