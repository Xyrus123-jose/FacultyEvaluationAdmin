<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/criteria.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<?php include 'components/header.php'; ?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Manage Criteria</h4>
        </div>


    <div class="row">
      <!-- Form Section -->
      <div class="col-lg-4">
        <div class="card-custom">
          <div class="card-header">
            <h5><i class="fas fa-plus-circle"></i> Add New Criteria</h5>
          </div>
             <p class="text-muted mb-3">Create a new evaluation question</p>
            <form id="criteriaForm" method="POST" action="Addcriteria.php">
                <div class="mb-3">
                    <label for="criteria_question" class="form-label">Question</label>
                    <textarea name="criteria_question" id="criteria_question" class="form-control" rows="3" placeholder="Enter evaluation question..." required></textarea>
                </div>

                <div class="mb-3">
                    <label for="max_score" class="form-label">Max Score</label>
                    <input type="number" name="max_score" id="max_score" class="form-control" min="1" max="5" placeholder="Enter max score" required />
                </div>

                <div class="mb-3">
                    <label for="evaluation_category_id" class="form-label">Category</label>
                    <select id="evaluation_category_id" name="evaluation_category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        <?php
                        include '../config/db.php';
                        $result = $conn->query("SELECT evaluation_category_id, evaluation_category FROM evaluation_category_table WHERE status = 1");
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['evaluation_category_id']}'>{$row['evaluation_category']}</option>";
                        }
                        $conn->close();
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="evaluation_type" class="form-label">Evaluation Type</label>
                    <select name="evaluation_type" id="evaluation_type" class="form-control" required>
                        <option value="">Select Type</option>
                        <option value="Peer">Peer</option>
                        <option value="Self">Self</option>
                        <option value="Supervisor">Supervisor</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="use_state" class="form-label">Use State</label>
                    <select name="use_state" id="use_state" class="form-control" required>
                        <option value="">Select State</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add Criteria
                </button>
            </form>



        </div>
      </div>

      <!-- Criteria Display -->
      <div class="col-lg-8">
        <!-- Rating Legend -->
        <div class="rating-legend">
          <div class="legend-title">Rating Scale:</div>
          <div class="legend-items">
            <div class="legend-item">
              <div class="legend-number">5</div>
              <div class="legend-text">Very Satisfied</div>
            </div>
            <div class="legend-item">
              <div class="legend-number">4</div>
              <div class="legend-text">Satisfied</div>
            </div>
            <div class="legend-item">
              <div class="legend-number">3</div>
              <div class="legend-text">Neutral</div>
            </div>
            <div class="legend-item">
              <div class="legend-number">2</div>
              <div class="legend-text">Dissatisfied</div>
            </div>
            <div class="legend-item">
              <div class="legend-number">1</div>
              <div class="legend-text">Very Dissatisfied</div>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="mb-0">Evaluation Criteria</h5>
          <button class="btn btn-outline-secondary btn-sm btn-clear" id="clearAllBtn">
            <i class="fas fa-times me-1"></i>Clear All
          </button>
        </div>
        <div id="criteriaContainer">
          <!-- Content will be dynamically generated -->
        </div>
      </div>
    </div>

    <!-- Edit Criteria Modal -->
<div class="modal fade" id="editCriteriaModal" tabindex="-1" aria-labelledby="editCriteriaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editCriteriaForm" method="POST" action="Editcriteria.php">
                <!-- Hidden field to store the criteria ID -->
                <input type="hidden" name="criteria_id" id="edit_criteria_id">

                <div class="modal-header">
                    <h5 class="modal-title" id="editCriteriaModalLabel">Edit Criteria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_criteria_question" class="form-label">Question</label>
                        <textarea name="criteria_question" id="edit_criteria_question" class="form-control" rows="3" placeholder="Enter evaluation question..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="edit_max_score" class="form-label">Max Score</label>
                        <input type="number" name="max_score" id="edit_max_score" class="form-control" min="1" max="5" placeholder="Enter max score" required />
                    </div>

                    <div class="mb-3">
                        <label for="edit_evaluation_category_id" class="form-label">Category</label>
                        <select id="edit_evaluation_category_id" name="evaluation_category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            <?php
                            include '../config/db.php';
                            $result = $conn->query("SELECT evaluation_category_id, evaluation_category FROM evaluation_category_table WHERE status = 1");
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['evaluation_category_id']}'>{$row['evaluation_category']}</option>";
                            }
                            $conn->close();
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_evaluation_type" class="form-label">Evaluation Type</label>
                        <select name="evaluation_type" id="edit_evaluation_type" class="form-control" required>
                            <option value="">Select Type</option>
                            <option value="Peer">Peer</option>
                            <option value="Self">Self</option>
                            <option value="Supervisor">Supervisor</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_use_state" class="form-label">Use State</label>
                        <select name="use_state" id="edit_use_state" class="form-control" required>
                            <option value="">Select State</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>Update Criteria
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>






    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/assets/js/criteria.js"></script>

<?php include 'components/footer.php'; ?>
