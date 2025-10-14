<?php
include '../config/db.php';

if (isset($_POST['import'])) {
    $file = $_FILES['csv_file']['tmp_name'];

    if (($handle = fopen($file, "r")) !== FALSE) {
        fgetcsv($handle); // skip header

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            list($student_number, $surname, $first_name, $middle_name, $program, $year_level, $section, $branch, $student_type, $email, $status, $gender, $birthdate, $subject, $professor, $term, $academic_year_id) = $data;

            // Helper function: Get or Insert ID
            function getOrInsertId($conn, $table, $col, $value) {
                $col_id = $table . "_id";
                $query = "SELECT $col_id FROM $table WHERE $col = '$value'";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    return $row[$col_id];
                } else {
                    $insert = "INSERT INTO $table ($col) VALUES ('$value')";
                    mysqli_query($conn, $insert);
                    return mysqli_insert_id($conn);
                }
            }

            // Get or create related IDs
            $program_id    = getOrInsertId($conn, "program_table", "program_name", $program);
            $year_level_id = getOrInsertId($conn, "year_level_table", "year_level_name", $year_level);
            $section_id    = getOrInsertId($conn, "section_table", "section_name", $section);
            $branch_id     = getOrInsertId($conn, "branch_table", "branch_name", $branch);
            $subject_id    = getOrInsertId($conn, "subject_table", "subject_name", $subject);
            $professor_id  = getOrInsertId($conn, "professor_table", "surname", $professor);

            // Check if student already exists
            $check = mysqli_query($conn, "SELECT * FROM student_table WHERE student_number = '$student_number'");
            if (mysqli_num_rows($check) == 0) {
                $insertStudent = "INSERT INTO student_table 
                    (student_number, surname, first_name, middle_name, program_id, year_level_id, section_id, branch_id, student_type, email, status, gender, birthdate)
                    VALUES ('$student_number', '$surname', '$first_name', '$middle_name', '$program_id', '$year_level_id', '$section_id', '$branch_id', '$student_type', '$email', '$status', '$gender', '$birthdate')";
                mysqli_query($conn, $insertStudent);
            }

            // Insert into enrollment table
            $insertEnroll = "INSERT INTO enrollment_table 
                (student_number, subject_id, professor_id, section_id, term, enrollment_date, registration_date, academic_year_id)
                VALUES ('$student_number', '$subject_id', '$professor_id', '$section_id', '$term', NOW(), NOW(), '$academic_year_id')";
            mysqli_query($conn, $insertEnroll);
        }

        fclose($handle);
        echo "<script>alert('Import completed successfully!');</script>";
    }
}
?>
