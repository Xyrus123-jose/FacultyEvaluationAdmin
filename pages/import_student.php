<?php
include '../config/db.php'; 

if (isset($_POST['import'])) {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['csv_file']['tmp_name'];
        if (($handle = fopen($fileTmpPath, "r")) !== FALSE) {
            $rowCount = 0;
            $inserted = 0;
            $header = fgetcsv($handle, 1000, ",");

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $rowCount++;

                $student_number = $data[0];
                $surname        = $data[1];
                $first_name     = $data[2];
                $middle_name    = $data[3];
                $program_name   = $data[4];
                $year_level_label = $data[5];
                $section        = $data[6];
                $branch_name    = $data[7];
                $student_type   = $data[8];
                $email          = $data[9];
                $password       = $data[10];
                $status         = $data[11];
                $gender         = $data[12];
                $birthdate      = $data[13];

                // Lookup IDs
                $program_id = $conn->query("SELECT program_id FROM program_table WHERE program_name='$program_name'")->fetch_assoc()['program_id'] ?? null;
                $year_level_id = $conn->query("SELECT year_level_id FROM year_level_table WHERE year_level_label='$year_level_label'")->fetch_assoc()['year_level_id'] ?? null;
                $section_id = $conn->query("SELECT section_id FROM section_table WHERE section='$section'")->fetch_assoc()['section_id'] ?? null;
                $branch_id = $conn->query("SELECT branch_id FROM branch_table WHERE branch_name='$branch_name'")->fetch_assoc()['branch_id'] ?? null;

                // Skip row if any FK not found
                if (!$program_id || !$year_level_id || !$section_id || !$branch_id) continue;

                // Skip duplicate student_number
                $exists = $conn->query("SELECT * FROM student_table WHERE student_number='$student_number'");
                if ($exists->num_rows > 0) continue;

                // Insert
                $stmt = $conn->prepare("
                    INSERT INTO student_table 
                    (student_number,surname,first_name,middle_name,program_id,year_level_id,section_id,branch_id,student_type,email,password,status,gender,birthdate) 
                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)
                ");
                $stmt->bind_param("ssssssssssssss",
                    $student_number,$surname,$first_name,$middle_name,
                    $program_id,$year_level_id,$section_id,$branch_id,
                    $student_type,$email,$password,$status,$gender,$birthdate
                );
                $stmt->execute();
                $inserted++;
            }

            fclose($handle);
            header("Location: evaluationperiod.php?msg=CSV import completed. Total rows: $rowCount. Inserted: $inserted");
            exit;
        }
    } else {
        header("Location: import_form.php?msg=Error uploading file.");
        exit;
    }
}
