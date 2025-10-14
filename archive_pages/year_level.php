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
            <h4 class="page-title">Manage Year Level</h4>
        </div>

        <div class="row g-4">

            <!-- Add Year Level Form -->
                <div class="col-lg-4 col-md-6">
                    <div class="card-custom">
                        <div class="card-header">
                            <h5><i class="fas fa-plus-circle"></i> Add New Year Level</h5>
                        </div>
                        <form id="addYearLevelForm" method="POST" action="AddYearLevel.php">
                            <div class="mb-3">
                                <label for="year_level_id" class="form-label">Year Level ID</label>
                                <input type="text" class="form-control" name="year_level_id" id="year_level_id" placeholder="Enter year level ID" required>
                            </div>

                            <div class="mb-3">
                                <label for="year_level" class="form-label">Year Level</label>
                                <input type="number" class="form-control" name="year_level" id="year_level" 
                                    placeholder="Enter year level" min="1" max="6" required>
                            </div>


                            <div class="mb-3">
                                <label for="year_level_label" class="form-label">Year Level Label</label>
                                <input type="text" class="form-control" name="year_level_label" id="year_level_label" placeholder="Enter year level label" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Add Year Level</button>
                        </form>
                    </div>
                </div>


            <!-- Program List Table -->
            <div class="col-lg-8 col-md-10">
                <div class="table-container">
                    <!-- Table Header -->
                    <div class="table-header d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i> Year Level List</h5>
                        <div class="d-flex align-items-center gap-2">
                        <div class="input-group">
                            <i id="refreshTable" class="fas fa-sync-alt" style="cursor: pointer; font-size: 1.2rem;"></i>
                        </div>
                        </div>
                    </div>

                    <!-- Table Body -->
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 text-center">
                            <thead>
                                <tr>
                                    <th>Year Level ID</th>
                                    <th>Year Level</th>
                                    <th>Year Level Label</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    include '../config/db.php';
                                    $yearLevels = $conn->query("SELECT * FROM year_level_table ORDER BY year_level_id ASC");
                                    while($yl = $yearLevels->fetch_assoc()):
                                ?>
                                <tr>
                                    <td><?= $yl['year_level_id'] ?></td>
                                    <td><?= $yl['year_level'] ?></td>
                                    <td><?= $yl['year_level_label'] ?></td>
                                    <td class='actions'>
                                        <div class='form-button-action'>
                                            <button 
                                                class="btn btn-link btn-primary edit-btn" 
                                                data-id="<?= $yl['year_level_id'] ?>" 
                                                data-year_level="<?= htmlspecialchars($yl['year_level'], ENT_QUOTES) ?>" 
                                                data-year_level_label="<?= htmlspecialchars($yl['year_level_label'], ENT_QUOTES) ?>" 
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <button 
                                                class="btn btn-link btn-danger delete-btn" 
                                                data-id="<?= $yl['year_level_id'] ?>" 
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

<!-- Edit Year Level Modal -->
<div class="modal fade" id="editYearLevelModal" tabindex="-1" aria-labelledby="editYearLevelLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editYearLevelForm" method="POST" action="EditYearLevel.php">
                <!-- Hidden field to store old ID -->
                <input type="hidden" name="old_year_level_id" id="edit_old_year_level_id">

                <div class="modal-header">
                    <h5 class="modal-title" id="editYearLevelLabel"><i class="fas fa-edit"></i> Edit Year Level</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Editable Year Level ID -->
                    <div class="mb-3">
                        <label for="edit_year_level_id" class="form-label">Year Level ID</label>
                        <input type="text" class="form-control" name="year_level_id" id="edit_year_level_id" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_year_level" class="form-label">Year Level</label>
                        <input type="number" class="form-control" name="year_level" id="edit_year_level" 
                            placeholder="Enter year level" min="1" max="12" required>
                    </div>


                    <div class="mb-3">
                        <label for="edit_year_level_label" class="form-label">Year Level Label</label>
                        <input type="text" class="form-control" name="year_level_label" id="edit_year_level_label" required>
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
<script src="../../FacultyEvaluationAdmin/assets/js/yearlevel.js"></script>

<?php include 'components/footer.php'; ?>
