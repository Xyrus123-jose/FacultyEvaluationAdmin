<?php
include '../config/db.php';

$academic_year_id = $_POST['academic_year_id'];
$start_date = $_POST['start_date_period'];
$end_date = $_POST['end_date_period'];

// Get academic year start/end
$sql = "SELECT academic_year_start, academic_year_end FROM academic_year_table WHERE academic_year_id = '$academic_year_id'";
$result = mysqli_query($conn, $sql);
$year = mysqli_fetch_assoc($result);

if ($start_date < $year['academic_year_start'] || $end_date > $year['academic_year_end']) {
    echo "<script>alert('Error: Period must fall within the selected academic year.');window.location='add_period.php';</script>";
    exit();
}

// Insert period
mysqli_query($conn, "INSERT INTO evaluation_period_table (academic_year_id, start_date, end_date) 
                     VALUES ('$academic_year_id', '$start_date', '$end_date')");

// Get all students
$students = mysqli_query($conn, "SELECT student_number FROM student_table");

date_default_timezone_set('Asia/Manila');
$current = new DateTime($start_date . ' 08:00:00');
$endTime = new DateTime($end_date . ' 17:00:00');
$interval = new DateInterval('PT10M');

while ($row = mysqli_fetch_assoc($students)) {
    if ($current > $endTime) break;
    $next = clone $current;
    $next->add($interval);

    $student_number = $row['student_number'];
    $timeStart = $current->format('H:i:s');
    $timeEnd = $next->format('H:i:s');

    mysqli_query($conn, "UPDATE enrollment_table 
        SET class_time_start = '$timeStart', class_time_end = '$timeEnd' 
        WHERE student_number = '$student_number'");

    $current->add($interval);
}

echo "<script>alert('Evaluation period saved and 10-minute schedules generated successfully!');window.location='add_period.php';</script>";
?>
