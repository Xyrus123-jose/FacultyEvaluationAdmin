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
            <h4 class="page-title">Manage Academic Year</h4>
        </div>

        <div class="row g-4">

            <!-- Add Subject Form -->
                <div class="col-lg-4 col-md-6">
                    <div class="card-custom">
                        <div class="card-header">
                            <h5><i class="fas fa-plus-circle"></i> Add New Academic Year</h5>
                        </div>
                        <form id="addAcademicYearForm" method="POST" action="Addacademicyear.php">
                            <input type="hidden" name="academic_year_id" id="academic_year_id">

                            <div class="mb-3">
                                <label for="academic_year_start" class="form-label">Academic Year Start</label>
                                <input type="number" class="form-control" name="academic_year_start" id="academic_year_start" min="2025" max="2030" placeholder="Enter start year (e.g., 2025)" required>
                            </div>

                            <div class="mb-3">
                                <label for="academic_year_end" class="form-label">Academic Year End</label>
                                <input type="number" class="form-control" name="academic_year_end" id="academic_year_end" min="2026" max="2030" placeholder="Enter end year (e.g., 2026)" required>
                            </div>

                            <div class="mb-3">
                                <label for="semester" class="form-label">Semester</label>
                                <select class="form-select" name="semester" id="semester" required>
                                    <option value="" disabled selected>Select semester</option>
                                    <option value="1">1st Semester</option>
                                    <option value="2">2nd Semester</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" name="status" id="status" required>
                                    <option value="" disabled selected>Select status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Add Academic Year</button>
                        </form>


                    </div>
                </div>


       
                <div class="col-lg-8 col-md-10">
                    <div class="table-container">
                        <div class="table-header d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0"><i class="fas fa-list me-2"></i> Academic Year List</h5>
                            <div class="d-flex align-items-center gap-2">
                               <div class="d-flex gap-2 align-items-center">
                                    <!-- Academic Year Start Filter -->
                                    <select id="filterStartYear" class="form-select form-select-sm">
                                        <option value="" selected>All Start Years</option>
                                        <?php
                                        include '../config/db.php';
                                        $years = $conn->query("SELECT DISTINCT academic_year_start FROM academic_year_table ORDER BY academic_year_start ASC");
                                        while($y = $years->fetch_assoc()) {
                                            echo '<option value="'.$y['academic_year_start'].'">'.$y['academic_year_start'].'</option>';
                                        }
                                        ?>
                                    </select>

                                    <!-- Academic Year End Filter -->
                                    <select id="filterEndYear" class="form-select form-select-sm">
                                        <option value="" selected>All End Years</option>
                                        <?php
                                        $yearsEnd = $conn->query("SELECT DISTINCT academic_year_end FROM academic_year_table ORDER BY academic_year_end ASC");
                                        while($y = $yearsEnd->fetch_assoc()) {
                                            echo '<option value="'.$y['academic_year_end'].'">'.$y['academic_year_end'].'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                            </div>
                        </div>

                         <div class="table-responsive">
                            <table class="table table-hover mb-0 text-center" id="academicYearTable">
                                <thead>
                                    <tr>
                                        <th>Academic Year ID</th>
                                        <th>Start Year</th>
                                        <th>End Year</th>
                                        <th>Semester</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        include '../config/db.php';
                                        $academicYears = $conn->query("SELECT * FROM academic_year_table ORDER BY academic_year_id ASC");

                                        if ($academicYears && $academicYears->num_rows > 0):
                                            while($ay = $academicYears->fetch_assoc()):
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($ay['academic_year_id']) ?></td>
                                        <td><?= htmlspecialchars($ay['academic_year_start']) ?></td>
                                        <td><?= htmlspecialchars($ay['academic_year_end']) ?></td>
                                        <td><?= htmlspecialchars($ay['semester']) ?></td>
                                        <td>
                                            <?php if ($ay['status'] == 1): ?>
                                                <span class="badge rounded-pill bg-success">Starting</span>
                                            <?php else: ?>
                                                <span class="badge rounded-pill bg-primary">Closed</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class='actions'>
                                            <div class='form-button-action'>
                                                <!-- Edit Button -->
                                                <button 
                                                    class="btn btn-link btn-primary edit-btn" 
                                                    data-id="<?= $ay['academic_year_id'] ?>" 
                                                    data-start="<?= htmlspecialchars($ay['academic_year_start'], ENT_QUOTES) ?>" 
                                                    data-end="<?= htmlspecialchars($ay['academic_year_end'], ENT_QUOTES) ?>" 
                                                    data-semester="<?= htmlspecialchars($ay['semester'], ENT_QUOTES) ?>" 
                                                    data-status="<?= htmlspecialchars($ay['status'], ENT_QUOTES) ?>" 
                                                    title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button 
                                                    class="btn btn-link btn-warning archive-btn" 
                                                    data-id="<?= $ay['academic_year_id'] ?>" 
                                                    title="Archive">
                                                    <i class="fas fa-archive"></i>
                                                </button>

                                                <button 
                                                    class="btn btn-link btn-danger delete-btn" 
                                                    data-id="<?= $ay['academic_year_id'] ?>" 
                                                    title="Delete">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                
                                            </div>
                                        </td>
                                    </tr>
                                    <?php 
                                            endwhile; 
                                        else: 
                                    ?>
                                    <tr>
                                        <td colspan="6">No academic years found.</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

        </div>
    </div>
</div>

<!-- Edit Academic Year Modal -->
<div class="modal fade" id="editAcademicYearModal" tabindex="-1" aria-labelledby="editAcademicYearModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editAcademicYearForm" method="POST" action="Editacademicyear.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAcademicYearModalLabel">
                        <i class="fas fa-edit me-2"></i>Edit Academic Year
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Hidden ID -->
                    <input type="hidden" name="academic_year_id" id="edit_academic_year_id">

                    <div class="mb-3">
                        <label for="edit_academic_year_start" class="form-label">Academic Year Start</label>
                        <input type="number" class="form-control" name="academic_year_start" id="edit_academic_year_start" min="2025" max="2030" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_academic_year_end" class="form-label">Academic Year End</label>
                        <input type="number" class="form-control" name="academic_year_end" id="edit_academic_year_end" min="2026" max="2030" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_semester" class="form-label">Semester</label>
                        <select class="form-select" name="semester" id="edit_semester" required>
                            <option value="" disabled selected>Select semester</option>
                            <option value="1">1st Semester</option>
                            <option value="2">2nd Semester</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Status</label>
                        <select class="form-select" name="status" id="edit_status" required>
                            <option value="" disabled selected>Select status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        <i class="fas fa-arrow-left"></i> Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>





<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../../FacultyEvaluationAdmin/assets/js/acadyear.js"></script>

<?php include 'components/footer.php'; ?>
