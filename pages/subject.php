<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<?php include 'components/header.php'; ?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Manage Subjects</h4>
        </div>

        <div class="row g-4">

            <!-- Add Subject Form -->
                <div class="col-lg-4 col-md-6">
                    <div class="card-custom">
                        <div class="card-header">
                            <h5><i class="fas fa-plus-circle"></i> Add New Subject</h5>
                        </div>
                        <form id="addSubjectForm" method="POST" action="Addsubject.php">
                            <input type="hidden" name="subject_id" id="subject_id" value="<?= 'sub-' . time() ?>">

                            <div class="mb-3">
                                <label for="subject_code" class="form-label">Subject Code</label>
                                <input type="text" class="form-control" name="subject_code" id="subject_code" placeholder="Enter subject code" required>
                            </div>

                            <div class="mb-3">
                                <label for="subject_title" class="form-label">Subject Title</label>
                                <input type="text" class="form-control" name="subject_title" id="subject_title" placeholder="Enter subject title" required>
                            </div>

                            <div class="mb-3">
                                <label for="units" class="form-label">Units</label>
                                <input type="number" min="1" max="3" class="form-control" name="units" id="units" placeholder="Enter units" min="1" required>
                            </div>

                            <div class="mb-3">
                                <label for="program_id" class="form-label">Program</label>
                                <select class="form-select" name="program_id" id="program_id" required>
                                    <option value="">Select Program</option>
                                    <?php
                                        include '../config/db.php';
                                        // Fetch only active programs
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
                                <label for="year_level_id" class="form-label">Year Level</label>
                                <select class="form-select" name="year_level_id" id="year_level_id" required>
                                    <option value="">Select Year Level</option>
                                    <?php
                                        $year_levels = $conn->query("SELECT * FROM year_level_table ORDER BY year_level ASC");
                                        while($yl = $year_levels->fetch_assoc()):
                                    ?>
                                    <option value="<?= $yl['year_level_id'] ?>"><?= $yl['year_level_label'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Add Subject</button>
                        </form>
                    </div>
                </div>


            <!-- Subject List Table -->
                <div class="col-lg-8 col-md-10">
                    <div class="table-container">
                        <div class="table-header d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0"><i class="fas fa-list me-2"></i> Subject List</h5>
                            <div class="d-flex align-items-center gap-2">
                            <!-- Search Bar -->
                            <div class="input-group input-group-sm">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" id="searchProgram" class="form-control" placeholder="Search program...">
                            </div>
                        </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover mb-0 text-center">
                                <thead>
                                    <tr>
                                        <th>Subject ID</th>
                                        <th>Subject Code</th>
                                        <th>Subject Title</th>
                                        <th>Units</th>
                                        <th>Program</th>
                                        <th>Year Level</th>
                                        <th>Created Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $subjects = $conn->query("
                                            SELECT s.*, p.program_name, y.year_level, y.year_level_label
                                            FROM subject_table s
                                            LEFT JOIN program_table p ON s.program_id = p.program_id
                                            LEFT JOIN year_level_table y ON s.year_level_id = y.year_level_id
                                            ORDER BY s.subject_id ASC
                                        ");
                                        while($sub = $subjects->fetch_assoc()):
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($sub['subject_id']) ?></td>
                                        <td><?= htmlspecialchars($sub['subject_code']) ?></td>
                                        <td><?= htmlspecialchars($sub['subject_title']) ?></td>
                                        <td><?= htmlspecialchars($sub['units']) ?></td>
                                        <td><?= htmlspecialchars($sub['program_id']) ?></td>
                                        <td><?= htmlspecialchars($sub['year_level_label']) ?></td>
                                        <td><?= htmlspecialchars($sub['created_date']) ?></td>
                                        <td class='actions'>
                                            <div class='form-button-action'>
                                                <button 
                                                    class="btn btn-link btn-primary edit-btn" 
                                                    data-id="<?= $sub['subject_id'] ?>" 
                                                    data-code="<?= htmlspecialchars($sub['subject_code'], ENT_QUOTES) ?>"
                                                    data-title="<?= htmlspecialchars($sub['subject_title'], ENT_QUOTES) ?>"
                                                    data-units="<?= $sub['units'] ?>"
                                                    data-program="<?= $sub['program_id'] ?>"
                                                    data-year="<?= $sub['year_level_id'] ?>"
                                                    title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <button 
                                                    class="btn btn-link btn-danger delete-btn" 
                                                    data-id="<?= $sub['subject_id'] ?>" 
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

<!-- Edit Subject Modal -->
<div class="modal fade" id="editSubjectModal" tabindex="-1" aria-labelledby="editSubjectLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editSubjectForm" method="POST" action="Editsubject.php">
                <!-- Hidden field to store original subject_id -->
                <input type="hidden" name="old_subject_id" id="edit_old_subject_id">

                <div class="modal-header">
                    <h5 class="modal-title" id="editSubjectLabel"><i class="fas fa-edit"></i> Edit Subject</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_subject_code" class="form-label">Subject Code</label>
                        <input type="text" class="form-control" name="subject_code" id="edit_subject_code" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_subject_title" class="form-label">Subject Title</label>
                        <input type="text" class="form-control" name="subject_title" id="edit_subject_title" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_units" class="form-label">Units</label>
                        <input type="number" class="form-control" name="units" id="edit_units" required min="1">
                    </div>

                    <div class="mb-3">
                        <label for="edit_program_id" class="form-label">Program</label>
                        <select class="form-select" name="program_id" id="edit_program_id" required>
                            <option value="">-- Select Program --</option>
                            <?php
                            // Fetch only active programs
                            $programs = $conn->query("SELECT * FROM program_table WHERE status = 1 ORDER BY program_name ASC");
                            while ($program = $programs->fetch_assoc()):
                                // Check if this is the current program for the subject
                                $selected = (isset($sub['program_id']) && $sub['program_id'] == $program['program_id']) ? 'selected' : '';
                            ?>
                                <option value="<?= $program['program_id'] ?>" <?= $selected ?>><?= $program['program_name'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_year_level_id" class="form-label">Year Level</label>
                        <select class="form-select" name="year_level_id" id="edit_year_level_id" required>
                            <option value="">-- Select Year Level --</option>
                            <?php
                            $year_levels = $conn->query("SELECT * FROM year_level_table ORDER BY year_level ASC");
                            while ($yl = $year_levels->fetch_assoc()):
                                // Check if this is the current year level for the subject
                                $selected = (isset($sub['year_level_id']) && $sub['year_level_id'] == $yl['year_level_id']) ? 'selected' : '';
                            ?>
                                <option value="<?= $yl['year_level_id'] ?>" <?= $selected ?>><?= $yl['year_level_label'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save Changes</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-arrow-left"></i> Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/assets/js/subject.js"></script>

<?php include 'components/footer.php'; ?>
