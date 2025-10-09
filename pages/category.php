
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../FacultyEvaluationAdmin/assets/css/category.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<?php include 'components/header.php'; ?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Manage Categories</h4>
        </div>

        <div class="row g-4">
            <!-- Add Category Form -->
            <div class="col-lg-4 col-md-6">
                <div class="card-custom">
                    <div class="card-header">
                        <h5><i class="fas fa-plus-circle me-2"></i> Add New Category</h5>
                    </div>
                    <form id="addCategoryForm" method="POST" action="Addcategory.php">
                        <div class="mb-3">
                            <label for="evaluation_category" class="form-label">Evaluation Category</label>
                            <input type="text" class="form-control" name="evaluation_category" id="evaluation_category" placeholder="Enter category name" required>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" name="status" id="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add Category
                        </button>
                    </form>
                </div>
            </div>

            <!-- Categories Table -->
            <div class="col-lg-8 col-md-10">
                <div class="table-container">
                    <div class="table-header d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i> Categories List</h5>
                        <div class="d-flex align-items-center gap-2">
                            <!-- Search Bar -->
                            <div class="input-group input-group-sm">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" id="searchCategory" class="form-control" placeholder="Search categories...">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover mb-0 text-center" id="categoryTable">
                            <thead>
                                <tr>
                                    <th>Category ID</th>
                                    <th>Category Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include '../config/db.php';
                                $categories = $conn->query("
                                    SELECT * FROM evaluation_category_table
                                    ORDER BY evaluation_category_id ASC
                                ");

                                if ($categories && $categories->num_rows > 0):
                                    while($cat = $categories->fetch_assoc()):
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($cat['evaluation_category_id']) ?></td>
                                    <td><?= htmlspecialchars($cat['evaluation_category']) ?></td>
                                    <td>
                                        <?php 
                                            if ($cat['status'] == 1) {
                                                echo "<span class='status-badge status-active'>Active</span>";
                                            } else {
                                                echo "<span class='status-badge status-inactive'>Inactive</span>";
                                            }
                                        ?>
                                    </td>
                                    <td class="actions">
                                        <div class="form-button-action">
                                            <button 
                                                class="btn btn-link btn-primary edit-btn" 
                                                data-id="<?= $cat['evaluation_category_id'] ?>" 
                                                data-category="<?= htmlspecialchars($cat['evaluation_category'], ENT_QUOTES) ?>"
                                                data-status="<?= htmlspecialchars($cat['status'], ENT_QUOTES) ?>"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <button 
                                                class="btn btn-link btn-danger delete-btn" 
                                                data-id="<?= $cat['evaluation_category_id'] ?>" 
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
                                    <td colspan="4">No categories found.</td>
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

<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editCategoryForm" method="POST" action="Editcategory.php">
                <!-- Hidden field for ID -->
                <input type="hidden" name="old_category_id" id="edit_old_category_id">

                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryLabel">
                        <i class="fas fa-edit"></i> Edit Category
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_evaluation_category" class="form-label">Evaluation Category</label>
                        <input type="text" class="form-control" name="evaluation_category" id="edit_evaluation_category" placeholder="Enter category name" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Status</label>
                        <select class="form-control" name="status" id="edit_status" required>
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

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../../FacultyEvaluationAdmin/assets/js/category.js"></script>

<?php include 'components/footer.php'; ?>
