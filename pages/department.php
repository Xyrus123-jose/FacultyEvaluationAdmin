<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../FacultyEvaluationAdmin/assets/css/form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<?php include 'components/header.php'; ?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Manage Departments</h4>
        </div>

        <div class="row g-4">

            <!-- Add Program Form -->
            <div class="col-lg-4 col-md-6">
                <div class="card-custom">
                    <div class="card-header">
                        <h5><i class="fas fa-plus-circle"></i> Add New Department</h5>
                    </div>
                    <form id="addDepartmentForm" method="POST" action="Adddepartment.php">
                        <!-- Generate department ID like d-2025-001 -->
                        <input type="hidden" name="department_id" id="department_id" value="<?= 'd-' . date('Y') . '-' . str_pad(rand(1, 99), 2, '0', STR_PAD_LEFT) ?>">

                        <div class="mb-3">
                            <label for="department_name" class="form-label">Department Name</label>
                            <input type="text" class="form-control" name="department_name" id="department_name" placeholder="Enter department name" required>
                        </div>

                        <div class="mb-3">
                            <label for="college_program" class="form-label">College Program</label>
                            <select class="form-select" name="college_program" id="college_program" required>
                                <option value="">Select Program</option>
                                <?php
                                    include '../config/db.php';
                                    // Fetch active programs
                                    $programs = $conn->query("SELECT * FROM program_table WHERE status = 1 ORDER BY program_name ASC");
                                    if ($programs && $programs->num_rows > 0):
                                        while ($program = $programs->fetch_assoc()):
                                ?>
                                    <option value="<?= $program['program_id'] ?>"><?= $program['program_name'] ?></option>
                                <?php
                                        endwhile;
                                    else:
                                ?>
                                    <option value="">No active programs available</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="department_head" class="form-label">Department Head</label>
                            <select class="form-select" name="department_head" id="department_head" required>
                                <option value="">Select Department Head</option>
                                <?php
                                    include '../config/db.php';
                                    // Fetch all professors
                                    $professors = $conn->query("SELECT professor_id, CONCAT(first_name, ' ', surname) AS full_name FROM professor_table ORDER BY surname ASC");
                                    if ($professors && $professors->num_rows > 0):
                                        while ($prof = $professors->fetch_assoc()):
                                ?>
                                    <option value="<?= $prof['professor_id'] ?>"><?= $prof['full_name'] ?></option>
                                <?php
                                        endwhile;
                                    else:
                                ?>
                                    <option value="">No professors available</option>
                                <?php endif; ?>
                            </select>
                        </div>

                       <div class="mb-3">
                            <label for="office_location" class="form-label">Office Location</label>
                            <input type="text" class="form-control" name="office_location" id="office_location" placeholder="Enter office location" value="B-" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Add Department</button>
                    </form>
                </div>
            </div>

            <!-- Department List Table -->
                <div class="col-lg-8 col-md-10">
                    <div class="table-container">
                        <!-- Table Header -->
                        <div class="table-header d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0"><i class="fas fa-list me-2"></i> Department List</h5>
                            <div class="d-flex align-items-center gap-2">
                                <!-- Search Bar -->
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" id="searchDepartment" class="form-control" placeholder="Search department...">
                                </div>
                                <!-- Department Name Filter Dropdown -->
                                <select id="departmentNameFilter" class="form-select form-select-sm">
                                    <option value="">All Departments</option>
                                    <?php
                                        include '../config/db.php';

                                        // Fetch distinct department names
                                        $result = $conn->query("SELECT DISTINCT department_name FROM department_table ORDER BY department_name ASC");

                                        while($row = $result->fetch_assoc()):
                                    ?>
                                        <option value="<?= htmlspecialchars($row['department_name'], ENT_QUOTES) ?>">
                                            <?= htmlspecialchars($row['department_name']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Table Body -->
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 text-center">
                                <thead>
                                    <tr>
                                        <th>Department ID</th>
                                        <th>Department Name</th>
                                        <th>College Program</th>
                                        <th>Department Head</th>
                                        <th>Office Location</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="departmentTableBody">
                                    <?php
                                        include '../config/db.php';
                                        $departments = $conn->query("
                                            SELECT d.*, p.program_id, 
                                                CONCAT(pr.first_name, ' ', pr.surname) AS head_name
                                            FROM department_table d
                                            LEFT JOIN program_table p ON d.college_program = p.program_id
                                            LEFT JOIN professor_table pr ON d.department_head = pr.professor_id
                                            ORDER BY d.department_id ASC
                                        ");

                                        while($dept = $departments->fetch_assoc()):
                                    ?>
                                    <tr>
                                        <td><?= $dept['department_id'] ?></td>
                                        <td><?= $dept['department_name'] ?></td>
                                        <td><?= $dept['program_id'] ?></td>
                                        <td><?= $dept['head_name'] ?></td>
                                        <td><?= $dept['office_location'] ?></td>
                                        <td class='actions'>
                                            <div class='form-button-action'>
                                                <button 
                                                    class="btn btn-link btn-primary edit-dept-btn" 
                                                    data-id="<?= $dept['department_id'] ?>" 
                                                    data-name="<?= htmlspecialchars($dept['department_name'], ENT_QUOTES) ?>" 
                                                    data-program="<?= $dept['college_program'] ?>"
                                                    data-head="<?= $dept['department_head'] ?>"
                                                    data-office="<?= htmlspecialchars($dept['office_location'], ENT_QUOTES) ?>"
                                                    title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <button 
                                                    class="btn btn-link btn-danger delete-dept-btn" 
                                                    data-id="<?= $dept['department_id'] ?>" 
                                                    title="Delete">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


        </div>
    </div>
</div>

<!-- Edit Department Modal -->
<div class="modal fade" id="editDepartmentModal" tabindex="-1" aria-labelledby="editDepartmentLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editDepartmentForm" method="POST" action="Editdepartment.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDepartmentLabel"><i class="fas fa-edit"></i> Edit Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Hidden field for department ID -->
                    <input type="hidden" name="department_id" id="edit_department_id">

                    <div class="mb-3">
                        <label for="edit_department_name" class="form-label">Department Name</label>
                        <input type="text" class="form-control" name="department_name" id="edit_department_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_college_program" class="form-label">College Program</label>
                        <select class="form-select" name="college_program" id="edit_college_program" required>
                            <option value="">Select Program</option>
                            <?php
                                include '../config/db.php';
                                $programs = $conn->query("SELECT * FROM program_table WHERE status = 1 ORDER BY program_name ASC");
                                if ($programs && $programs->num_rows > 0):
                                    while ($program = $programs->fetch_assoc()):
                            ?>
                                <option value="<?= $program['program_id'] ?>"><?= $program['program_name'] ?></option>
                            <?php
                                    endwhile;
                                endif;
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_department_head" class="form-label">Department Head</label>
                        <select class="form-select" name="department_head" id="edit_department_head" required>
                            <option value="">Select Department Head</option>
                            <?php
                                $professors = $conn->query("SELECT professor_id, CONCAT(first_name, ' ', surname) AS full_name FROM professor_table ORDER BY surname ASC");
                                if ($professors && $professors->num_rows > 0):
                                    while ($prof = $professors->fetch_assoc()):
                            ?>
                                <option value="<?= $prof['professor_id'] ?>"><?= $prof['full_name'] ?></option>
                            <?php
                                    endwhile;
                                endif;
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_office_location" class="form-label">Office Location</label>
                        <input type="text" class="form-control" name="office_location" id="edit_office_location" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save Changes</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-arrow-left"></i> Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../../FacultyEvaluationAdmin/assets/js/department.js"></script>

<?php include 'components/footer.php'; ?>
