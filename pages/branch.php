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
            <h4 class="page-title">Manage Branches</h4>
        </div>

        <div class="row g-4">

            <!-- Add Program Form -->
            <div class="col-lg-4 col-md-6">
                <div class="card-custom">
                    <div class="card-header">
                        <h5><i class="fas fa-plus-circle"></i> Add New Program</h5>
                    </div>
                    <form id="addBranchForm" method="POST" action="Addbranch.php">
                        <!-- Hidden field for branch ID (can be auto-generated in PHP) -->
                        <input type="hidden" name="branch_id" id="branch_id" value="<?= 'b-'?>">

                        <div class="mb-3">
                            <label for="branch_name" class="form-label">Branch Name</label>
                            <input type="text" class="form-control" name="branch_name" id="branch_name" placeholder="Enter branch name" required>
                        </div>

                        <div class="mb-3">
                            <label for="branch_abbreviation" class="form-label">Branch Abbreviation</label>
                            <input type="text" class="form-control text-uppercase" name="branch_abbreviation" id="branch_abbreviation" placeholder="Enter branch abbreviation" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Add Branch</button>
                    </form>

                </div>
            </div>

            <div class="col-lg-8 col-md-10">
                <div class="table-container">
                    <!-- Table Header -->
                    <div class="table-header d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i> Branch List</h5>
                        <div class="d-flex align-items-center gap-2">
                            <!-- Search Bar -->
                            <div class="input-group input-group-sm">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" id="searchBranch" class="form-control" placeholder="Search branch...">
                            </div>
                        </div>
                    </div>

                    <!-- Table Body -->
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 text-center">
                            <thead>
                                <tr>
                                    <th>Branch ID</th>
                                    <th>Branch Name</th>
                                    <th>Abbreviation</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    include '../config/db.php';
                                    $branches = $conn->query("SELECT * FROM branch_table ORDER BY branch_id ASC");
                                    while($branch = $branches->fetch_assoc()):
                                ?>
                                <tr>
                                    <td><?= $branch['branch_id'] ?></td>
                                    <td><?= htmlspecialchars($branch['branch_name'], ENT_QUOTES) ?></td>
                                    <td><?= htmlspecialchars($branch['branch_abbreviation'], ENT_QUOTES) ?></td>
                                    <td class='actions'>
                                        <div class='form-button-action'>
                                            <button 
                                                class="btn btn-link btn-primary edit-branch-btn" 
                                                data-id="<?= $branch['branch_id'] ?>" 
                                                data-name="<?= htmlspecialchars($branch['branch_name'], ENT_QUOTES) ?>" 
                                                data-abbreviation="<?= htmlspecialchars($branch['branch_abbreviation'], ENT_QUOTES) ?>"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <button 
                                                class="btn btn-link btn-danger delete-branch-btn" 
                                                data-id="<?= $branch['branch_id'] ?>" 
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

<!-- Edit Branch Modal -->
<div class="modal fade" id="editBranchModal" tabindex="-1" aria-labelledby="editBranchLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editBranchForm" method="POST" action="Editbranch.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBranchLabel">Edit Branch</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="branch_id" id="edit_branch_id">

                    <div class="mb-3">
                        <label for="edit_branch_name" class="form-label">Branch Name</label>
                        <input type="text" class="form-control" name="branch_name" id="edit_branch_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_branch_abbreviation" class="form-label">Branch Abbreviation</label>
                        <input type="text" class="form-control" name="branch_abbreviation" id="edit_branch_abbreviation" required>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../../FacultyEvaluationAdmin/assets/js/branch.js"></script>

<?php include 'components/footer.php'; ?>
