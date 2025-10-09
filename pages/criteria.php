<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Criteria</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../FacultyEvaluationAdmin/assets/css/criteria.css">
</head>

<?php
include '../config/db.php';

// Fetch all criteria
$criteria_data = [];
$sql = "
    SELECT 
        c.criteria_id,
        c.evaluation_category_id,
        cat.evaluation_category AS category_name,
        c.criteria_question,
        c.max_score,
        c.evaluation_type
    FROM evaluation_criteria_table AS c
    INNER JOIN evaluation_category_table AS cat 
        ON c.evaluation_category_id = cat.evaluation_category_id
    ORDER BY cat.evaluation_category ASC
";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $criteria_data[] = $row;
    }
}
$conn->close();
?>

<?php include 'components/header.php'; ?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Manage Criteria</h4>
        </div>

        <div class="row">
            <!-- Form Section -->
            <div class="col-lg-4">
                <div class="criteria-form-container">
                    <div class="card-header">
                        <h5><i class="fas fa-plus-circle me-2"></i> Add New Category</h5>
                    </div>
                    <p class="text-muted mb-3">Create a new evaluation question</p>

                    <form id="addCriteriaForm" action="Addcriteria.php" method="POST">
                        <div class="mb-3">
                            <label for="criteria_question" class="form-label">Question</label>
                            <textarea id="criteria_question" name="criteria_question" class="form-control" rows="3" placeholder="Enter evaluation question..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="max_score" class="form-label">Max Score</label>
                            <input type="number" id="max_score" name="max_score" class="form-control" min="1" max="100" placeholder="Enter max score" required/>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select id="category" name="category" class="form-control" required>
                                <option value="">Select Category</option>
                                <?php
                                include '../config/db.php';
                                $sql = "SELECT evaluation_category_id, evaluation_category FROM evaluation_category_table ORDER BY evaluation_category_id ASC";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['evaluation_category_id'] . '">' . htmlspecialchars($row['evaluation_category']) . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No categories available</option>';
                                }
                                $conn->close();
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="evaluation_type" class="form-label">Evaluation Type</label>
                            <select id="evaluation_type" name="evaluation_type" class="form-control" required>
                                <option value="">Select Type</option>
                                <option value="rating">Rating</option>
                                <option value="text">Text</option>
                                <!-- Add more types as needed -->
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="use_state" class="form-label">Use State</label>
                            <select id="use_state" name="use_state" class="form-control" required>
                                <option value="">Select Use State</option>
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
                <?php if (!empty($criteria_data)):

                    // Group criteria by category
                    $categories = [];
                    foreach ($criteria_data as $row) {
                        $categories[$row['category_name']][] = $row;
                    }
                ?>

                <form method="POST" action="" class="criteria-form-container">
                    <!-- Rating Legend -->
                    <div class="rating-legend mb-3">
                        <div class="legend-title">Rating Scale</div>
                        <div class="legend-items d-flex justify-content-between">
                            <div class="legend-item text-center">
                                <div class="legend-number">1</div>
                                <div class="legend-text">Strongly Disagree</div>
                            </div>
                            <div class="legend-item text-center">
                                <div class="legend-number">2</div>
                                <div class="legend-text">Disagree</div>
                            </div>
                            <div class="legend-item text-center">
                                <div class="legend-number">3</div>
                                <div class="legend-text">Neutral</div>
                            </div>
                            <div class="legend-item text-center">
                                <div class="legend-number">4</div>
                                <div class="legend-text">Agree</div>
                            </div>
                            <div class="legend-item text-center">
                                <div class="legend-number">5</div>
                                <div class="legend-text">Strongly Agree</div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs Navigation -->
                    <div class="criteria-tabs-container">
                        <div class="criteria-tabs-nav mb-3">
                            <?php $first = true; foreach ($categories as $cat_name => $cat_items):
                                $tab_id = 'tab-' . strtolower(str_replace(' ', '-', $cat_name)); ?>
                                <button type="button" class="criteria-tab-btn <?= $first ? 'active' : '' ?>" data-target="<?= $tab_id ?>">
                                    <?= htmlspecialchars($cat_name) ?> <span class="criteria-count"><?= count($cat_items) ?></span>
                                </button>
                            <?php $first = false; endforeach; ?>
                        </div>

                        <!-- Tabs Content -->
                        <div class="criteria-tab-content">
                            <?php $first = true; foreach ($categories as $cat_name => $cat_items):
                                $tab_id = 'tab-' . strtolower(str_replace(' ', '-', $cat_name)); ?>
                                <div class="criteria-tab-pane <?= $first ? 'active' : '' ?>" id="<?= $tab_id ?>">
                                    <div class="criteria-list">
                                        <?php $counter = 1; foreach ($cat_items as $row): ?>
                                            <div class="criteria-item d-flex align-items-center mb-2">
                                                <div class="criteria-number me-3"><?= $counter ?></div>
                                                <div class="criteria-content flex-grow-1">
                                                    <div class="criteria-question"><?= htmlspecialchars($row['criteria_question']) ?></div>
                                                    <div class="criteria-rating mt-1">
                                                        <div class="rating-scale d-flex gap-2">
                                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                                <div class="rating-option">
                                                                    <input type="radio" 
                                                                        id="score_<?= $row['criteria_id'] . '_' . $i ?>" 
                                                                        name="score[<?= $row['criteria_id'] ?>]" 
                                                                        value="<?= $i ?>" 
                                                                        class="rating-input">
                                                                    <label for="score_<?= $row['criteria_id'] . '_' . $i ?>" class="rating-label"><?= $i ?></label>
                                                                </div>
                                                            <?php endfor; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="criteria-actions ms-3">
<button type="button" 
        class="criteria-action-btn edit" 
        title="Edit Criteria"
        data-bs-toggle="modal" 
        data-bs-target="#editCriteriaModal"
        data-id="<?= $row['criteria_id'] ?>"
        data-question="<?= htmlspecialchars($row['criteria_question'], ENT_QUOTES) ?>"
        data-max="<?= $row['max_score'] ?>"
        data-category="<?= $row['evaluation_category_id'] ?>"
        data-type ="<?= $row['evaluation_type'] ?>">
    <i class="fas fa-edit"></i>
</button>                                                    <button type="button" class="criteria-action-btn delete" title="Delete Criteria"><i class="fas fa-times"></i></button>
                                                </div>
                                            </div>
                                        <?php $counter++; endforeach; ?>
                                    </div>
                                </div>
                            <?php $first = false; endforeach; ?>
                        </div>
                    </div>
                </form>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const tabButtons = document.querySelectorAll(".criteria-tab-btn");
                        const tabPanes = document.querySelectorAll(".criteria-tab-pane");

                        tabButtons.forEach(button => {
                            button.addEventListener("click", function() {
                                const targetId = this.getAttribute("data-target");
                                tabButtons.forEach(btn => btn.classList.remove("active"));
                                tabPanes.forEach(pane => pane.classList.remove("active"));
                                this.classList.add("active");
                                document.getElementById(targetId).classList.add("active");
                            });
                        });
                    });
                </script>

                <?php else: ?>
                    <div class="criteria-form-container text-center py-5">
                        <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                        <h3 class="text-muted">No Criteria Found</h3>
                        <p class="text-muted">There are no evaluation criteria to display at this time.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- Edit Criteria Modal -->
<div class="modal fade" id="editCriteriaModal" tabindex="-1" aria-labelledby="editCriteriaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editCriteriaForm" action="Editcriteria.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCriteriaModalLabel"><i class="fas fa-edit me-2"></i>Edit Criteria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_criteria_id" name="criteria_id">

                    <div class="mb-3">
                        <label for="edit_criteria_question" class="form-label">Question</label>
                        <textarea id="edit_criteria_question" name="criteria_question" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="edit_max_score" class="form-label">Max Score</label>
                        <input type="number" id="edit_max_score" name="max_score" class="form-control" min="1" max="100" required/>
                    </div>

                    <div class="mb-3">
                        <label for="edit_category" class="form-label">Category</label>
                        <select id="edit_category" name="category" class="form-control" required>
                            <option value="">Select Category</option>
                            <?php
                            include '../config/db.php';
                            $sql = "SELECT evaluation_category_id, evaluation_category FROM evaluation_category_table ORDER BY evaluation_category_id ASC";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['evaluation_category_id'] . '">' . htmlspecialchars($row['evaluation_category']) . '</option>';
                                }
                            }
                            $conn->close();
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_evaluation_type" class="form-label">Use State</label>
                        <select id="edit_evaluation_type" name="evaluation_type" class="form-control" required>
                         <option value="">Select Type</option>
                                <option value="rating">Rating</option>
                                <option value="text">Text</option>   
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_use_state" class="form-label">Use State</label>
                        <select id="edit_use_state" name="use_state" class="form-control" required>
                           <option value="">Select Use State</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../../FacultyEvaluationAdmin/assets/js/criteria.js"></script>


<?php include 'components/footer.php'; ?>