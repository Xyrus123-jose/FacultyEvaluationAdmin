<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../FacultyEvaluationAdmin/assets/css/evalperiod.css">
</head>

<?php 
include 'components/header.php'; 
include '../config/db.php'; // database connection
?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Evaluation Schedule</h4>
        </div>



            <div class="card-body">
                <div class="upload-section">
                    <form action="import_student.php" method="post" enctype="multipart/form-data" class="d-flex justify-content-end mb-3">
                        <div class="file-upload">
                            <input type="file" name="csv_file" accept=".csv" id="csv-file" class="file-input" required>
                            <label for="csv-file" class="file-label">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                    <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                                </svg>
                                Choose CSV File
                            </label>
                            <span class="file-name" id="file-name">No file chosen</span>
                        </div>
                        <button type="submit" name="import" class="btn btn-primary btn-sm ms-2">Upload CSV</button>
                    </form>
                </div>

                <?php if (isset($_GET['msg'])): ?>
                    <div class="alert alert-info"><?= htmlspecialchars($_GET['msg']); ?></div>
                <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <span>Evaluation Periods</span>
                <button class="btn btn-primary" id="add-period-btn">
                    <i class="fas fa-plus"></i> Add New Period
                </button>
            </div>
            <div class="card-body">
                <div class="evaluation-periods" id="evaluation-periods-list">
                    <div class="period-card">
                        <div class="period-header">
                            <div class="period-title">First Semester 2023-2024</div>
                        </div>
                        <div class="period-details">
                            <div class="period-detail">
                                <span class="detail-label">Date Range</span>
                                <span class="detail-value">2023-09-01 to 2023-12-15</span>
                            </div>
                            <div class="period-detail">
                                <span class="detail-label">Time</span>
                                <span class="detail-value">08:00 to 17:00</span>
                            </div>
                            <div class="period-detail">
                                <span class="detail-label">Students</span>
                                <span class="detail-value">150</span>
                            </div>
                            <div class="period-detail">
                                <span class="detail-label">Scope</span>
                                <span class="detail-value">All Students</span>
                            </div>
                            <div>
                                <span class="status-badge status-active">Active</span>
                                <button class="action-btn edit-period" data-id="1">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="action-btn danger delete-period" data-id="1">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="period-card">
                        <div class="period-header">
                            <div class="period-title">Second Semester 2023-2024</div>
                        </div>
                        <div class="period-details">
                            <div class="period-detail">
                                <span class="detail-label">Date Range</span>
                                <span class="detail-value">2024-01-15 to 2024-05-20</span>
                            </div>
                            <div class="period-detail">
                                <span class="detail-label">Time</span>
                                <span class="detail-value">08:00 to 17:00</span>
                            </div>
                            <div class="period-detail">
                                <span class="detail-label">Students</span>
                                <span class="detail-value">45</span>
                            </div>
                            <div class="period-detail">
                                <span class="detail-label">Scope</span>
                                <span class="detail-value">Year 3, Section A, CS</span>
                            </div>
                            <div>
                                <span class="status-badge status-inactive">Upcoming</span>
                                <button class="action-btn edit-period" data-id="2">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="action-btn danger delete-period" data-id="2">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student List Card -->
        <div class="card mt-4">
            <div class="card-header">
                <span>Student List</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Student Number</th>
                                <th>Surname</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Program</th>
                                <th>Year Level</th>
                                <th>Section</th>
                                <th>Branch</th>
                                <th>Type</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Birthdate</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "
                                SELECT s.*, 
                                       p.program_name, 
                                       y.year_level_label, 
                                       sec.section, 
                                       b.branch_name
                                FROM student_table s
                                LEFT JOIN program_table p ON s.program_id = p.program_id
                                LEFT JOIN year_level_table y ON s.year_level_id = y.year_level_id
                                LEFT JOIN section_table sec ON s.section_id = sec.section_id
                                LEFT JOIN branch_table b ON s.branch_id = b.branch_id
                                ORDER BY s.student_number ASC
                            ";

                            $result = $conn->query($query);
                            $count = 1;

                            if ($result && $result->num_rows > 0):
                                while ($row = $result->fetch_assoc()):
                            ?>
                                <tr>
                                    <td><?= $count++; ?></td>
                                    <td><?= htmlspecialchars($row['student_number']); ?></td>
                                    <td><?= htmlspecialchars($row['surname']); ?></td>
                                    <td><?= htmlspecialchars($row['first_name']); ?></td>
                                    <td><?= htmlspecialchars($row['middle_name']); ?></td>
                                    <td><?= htmlspecialchars($row['program_name']); ?></td>
                                    <td><?= htmlspecialchars($row['year_level_label']); ?></td>
                                    <td><?= htmlspecialchars($row['section']); ?></td>
                                    <td><?= htmlspecialchars($row['branch_name']); ?></td>
                                    <td><?= htmlspecialchars($row['student_type']); ?></td>
                                    <td><?= htmlspecialchars($row['email']); ?></td>
                                    <td><?= htmlspecialchars($row['gender']); ?></td>
                                    <td><?= htmlspecialchars($row['birthdate']); ?></td>
                                </tr>
                            <?php
                                endwhile;
                            else:
                                echo '<tr><td colspan="13" class="text-center">No students found</td></tr>';
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script>
            // File name display
            document.getElementById('csv-file').addEventListener('change', function(e) {
                const fileName = e.target.files[0] ? e.target.files[0].name : 'No file chosen';
                document.getElementById('file-name').textContent = fileName;
            });
        </script>

    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../../FacultyEvaluationAdmin/assets/js/period.js"></script>

<?php include 'components/footer.php'; ?>
