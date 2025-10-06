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
            <h4 class="page-title">Manage Programs</h4>
        </div>

        <div class="row g-4">

            <!-- Add Program Form -->
            <div class="col-lg-4 col-md-6">
                <div class="card-custom">
                    <div class="card-header">
                        <h5><i class="fas fa-plus-circle"></i> Add New Program</h5>
                    </div>
                    <form id="addProgramForm" method="POST" action="Addprogram.php">
                        <div class="mb-3">
                            <label for="program_id" class="form-label">Program ID</label>
                            <input type="text" class="form-control" name="program_id" id="program_id" placeholder="Enter program ID" required>
                        </div>

                        <div class="mb-3">
                            <label for="program_name" class="form-label">Program Name</label>
                            <input type="text" class="form-control" name="program_name" id="program_name" placeholder="Enter program name" required>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="program_status" id="program_status" checked>
                            <label class="form-check-label" for="program_status">Active Program</label>
                        </div>

                        <button type="submit" class="btn btn-primary">Add Program</button>
                    </form>
                </div>
            </div>

            <!-- Program List Table -->
            <div class="col-lg-8 col-md-10">
                <div class="table-container">
                    <!-- Table Header -->
                    <div class="table-header d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i> Program List</h5>
                        <div class="d-flex align-items-center gap-2">
                            <!-- Search Bar -->
                            <div class="input-group input-group-sm">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" id="searchProgram" class="form-control" placeholder="Search program...">
                            </div>

                            <!-- Status Filter Dropdown -->
                            <select id="statusFilter" class="form-select form-select-sm">
                                <option value="">All Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- Table Body -->
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 text-center">
                            <thead>
                                <tr>
                                    <th>Program ID</th>
                                    <th>Program Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    include '../config/db.php';
                                    $result = $conn->query("SELECT COUNT(*) AS total FROM program_table");
                                    $row = $result->fetch_assoc();
                                ?>
                                <?php
                                    $programs = $conn->query("SELECT * FROM program_table ORDER BY program_id ASC");
                                    while($program = $programs->fetch_assoc()):
                                ?>
                                <tr>
                                    <td><?= $program['program_id'] ?></td>
                                    <td><?= $program['program_name'] ?></td>
                                    <td>
                                    <?php 
                                        if ($program['status'] == 1) {
                                            echo "<span class='status-badge status-active'>Active</span>";
                                        } else {
                                            echo "<span class='status-badge status-inactive'>Inactive</span>";
                                        }
                                    ?>
                                    </td>
                                    <td class='actions'>
                                        <div class='form-button-action'>
                                        <button 
                                            class="btn btn-link btn-primary edit-btn" 
                                            data-id="<?= $program['program_id'] ?>" 
                                            data-name="<?= htmlspecialchars($program['program_name'], ENT_QUOTES) ?>" 
                                            data-status="<?= $program['status'] ?>" 
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <button 
                                            class="btn btn-link btn-danger delete-btn" 
                                            data-id="<?= $program['program_id'] ?>" 
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

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="editCategoryForm" method="POST" action="Editcategory.php">
        <!-- Hidden field to store old category ID -->
        <input type="hidden" name="old_category_id" id="edit_old_category_id">

        <div class="modal-header">
          <h5 class="modal-title" id="editCategoryModalLabel">
            <i class="fas fa-edit me-2"></i> Edit Category
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="edit_category_id" class="form-label">Category ID</label>
            <input type="text" class="form-control" name="category_id" id="edit_category_id" required>
          </div>

          <div class="mb-3">
            <label for="edit_category_name" class="form-label">Category Name</label>
            <input type="text" class="form-control" name="category_name" id="edit_category_name" required>
          </div>

          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="category_status" id="edit_category_status">
            <label class="form-check-label" for="edit_category_status">Active Category</label>
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


<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/program.js"></script>

<?php include 'components/footer.php'; ?>
