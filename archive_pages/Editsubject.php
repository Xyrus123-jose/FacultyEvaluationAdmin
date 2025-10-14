<?php
include '../config/db.php';

$response = ['status' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_subject_id = $conn->real_escape_string($_POST['old_subject_id']);
    $subject_code = $conn->real_escape_string($_POST['subject_code']);
    $subject_title = $conn->real_escape_string($_POST['subject_title']);
    $units = (int)$_POST['units'];
    $program_id = $conn->real_escape_string($_POST['program_id']);
    $year_level_id = $conn->real_escape_string($_POST['year_level_id']);

    $sql = "UPDATE subject_table 
            SET subject_code = '$subject_code', 
                subject_title = '$subject_title', 
                units = $units, 
                program_id = '$program_id', 
                year_level_id = '$year_level_id'
            WHERE subject_id = '$old_subject_id'";

    if ($conn->query($sql) === TRUE) {
        $response['status'] = 'success';
        $response['message'] = 'Subject updated successfully!';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error updating subject: ' . $conn->error;
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
} else {
    header("Location: subject.php");
    exit();
}
?>
