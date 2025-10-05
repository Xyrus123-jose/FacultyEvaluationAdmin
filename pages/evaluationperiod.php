<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/evalperiod.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<?php include 'components/header.php'; ?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Manage Evaluation Period</h4>
        </div>

            <div class="table-container">
                <div class="table-header">
                    <h5><i class="fas fa-calendar-alt me-2"></i>Evaluation Periods</h5>
                    <button class="btn-add" id="addPeriodBtn">
                        <i class="fas fa-plus me-1"></i> Add New Period
                    </button>
                </div>
                
                <div class="filters">
                    <div class="filter-row">
                        <div class="filter-group">
                            <label for="academicYearFilter">Academic Year</label>
                            <select class="form-control form-control-sm" id="academicYearFilter">
                                <option value="">All Years</option>
                                <option value="2023-2024">2023-2024</option>
                                <option value="2022-2023">2022-2023</option>
                                <option value="2021-2022">2021-2022</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="programFilter">Program</label>
                            <select class="form-control form-control-sm" id="programFilter">
                                <option value="">All Programs</option>
                                <option value="Computer Science">Computer Science</option>
                                <option value="Business Administration">Business Administration</option>
                                <option value="Engineering">Engineering</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="yearLevelFilter">Year Level</label>
                            <select class="form-control form-control-sm" id="yearLevelFilter">
                                <option value="">All Levels</option>
                                <option value="First Year">First Year</option>
                                <option value="Second Year">Second Year</option>
                                <option value="Third Year">Third Year</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="statusFilter">Status</label>
                            <select class="form-control form-control-sm" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover mb-0 text-center" id="evaluationPeriodTable">
                        <thead>
                            <tr>
                                <th>Period ID</th>
                                <th>Academic Year</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Program</th>
                                <th>Year Level</th>
                                <th>Section</th>
                                <th>Time</th>
                                <th>Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include '../config/db.php';

                            $periods = $conn->query("
                                SELECT e.period_id, a.academic_year_id, a.academic_year_start, a.academic_year_end,
                                    e.start_date, e.end_date, e.time_start, e.time_end,
                                    p.program_name,
                                    y.year_level_label,
                                    s.section
                                FROM evaluation_period_table e
                                JOIN academic_year_table a ON e.academic_year_id = a.academic_year_id
                                JOIN program_table p ON e.program_id = p.program_id
                                JOIN year_level_table y ON e.year_level_id = y.year_level_id
                                JOIN section_table s ON e.section_id = s.section_id
                                ORDER BY e.period_id ASC
                            ");

                            if ($periods && $periods->num_rows > 0):
                                while($row = $periods->fetch_assoc()):
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($row['period_id']) ?></td>
                                <td><?= htmlspecialchars($row['academic_year_start']) . ' - ' . htmlspecialchars($row['academic_year_end']) ?></td>
                                <td><?= htmlspecialchars($row['start_date']) ?></td>
                                <td><?= htmlspecialchars($row['end_date']) ?></td>
                                <td><?= htmlspecialchars($row['program_name']) ?></td>
                                <td><?= htmlspecialchars($row['year_level_label']) ?></td>
                                <td><?= htmlspecialchars($row['section']) ?></td>
                                <td><?= htmlspecialchars($row['time_start']) ?> - <?= htmlspecialchars($row['time_end']) ?></td>
                                <td class="actions">
                                    <div class="form-button-action">
                                        <button 
                                            class="btn btn-link btn-primary edit-btn" 
                                            data-id="<?= $row['period_id'] ?>" 
                                            data-academic-year="<?= htmlspecialchars($row['academic_year_id'], ENT_QUOTES) ?>"
                                            data-start-date="<?= $row['start_date'] ?>"
                                            data-end-date="<?= $row['end_date'] ?>"
                                            data-program="<?= htmlspecialchars($row['program_name'], ENT_QUOTES) ?>"
                                            data-year-level="<?= htmlspecialchars($row['year_level_label'], ENT_QUOTES) ?>"
                                            data-section="<?= htmlspecialchars($row['section'], ENT_QUOTES) ?>"
                                            data-time-start="<?= $row['time_start'] ?>"
                                            data-time-end="<?= $row['time_end'] ?>"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <button 
                                            class="btn btn-link btn-danger delete-btn" 
                                            data-id="<?= $row['period_id'] ?>" 
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
                                <td colspan="9">No evaluation periods found.</td>
                            </tr>
                            <?php endif; ?>
                            </tbody>

                    </table>
`
                </div>
                
                <div class="pagination-container">
                    <div class="pagination-info">
                        Showing 1 to 5 of 5 entries
                    </div>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

            <!-- Edit Evaluation Period Modal -->
                <div class="modal fade" id="editPeriodModal" tabindex="-1" aria-labelledby="editPeriodModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <form id="editPeriodForm" method="POST" action="Editperiod.php">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editPeriodModalLabel">
                                        <i class="fas fa-edit me-2"></i>Edit Evaluation Period
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <input type="hidden" id="editPeriodId" name="period_id">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="editAcademicYear" class="form-label">Academic Year</label>
                                            <select class="form-select" id="editAcademicYear" name="academic_year_id" required>
                                                <?php
                                                $years = $conn->query("SELECT * FROM academic_year_table WHERE status = 1 ORDER BY academic_year_id DESC");
                                                while($y = $years->fetch_assoc()):
                                                ?>
                                                    <option value="<?= $y['academic_year_id'] ?>" 
                                                            data-start="<?= $y['academic_year_start'] ?>"
                                                            data-end="<?= $y['academic_year_end'] ?>">
                                                        <?= htmlspecialchars($y['academic_year_start']) . ' - ' . htmlspecialchars($y['academic_year_end']) ?>
                                                    </option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="editProgram" class="form-label">Program</label>
                                            <select class="form-select" id="editProgram" name="program_id" required>
                                                <?php
                                                $programs = $conn->query("SELECT * FROM program_table ORDER BY program_id ASC");
                                                while($p = $programs->fetch_assoc()):
                                                ?>
                                                    <option value="<?= $p['program_id'] ?>"><?= htmlspecialchars($p['program_name']) ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="editYearLevel" class="form-label">Year Level</label>
                                            <select class="form-select" id="editYearLevel" name="year_level_id" required>
                                                <?php
                                                $levels = $conn->query("SELECT * FROM year_level_table ORDER BY year_level_id ASC");
                                                while($l = $levels->fetch_assoc()):
                                                ?>
                                                    <option value="<?= $l['year_level_id'] ?>"><?= htmlspecialchars($l['year_level_label']) ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="editSection" class="form-label">Section</label>
                                            <select class="form-select" id="editSection" name="section_id" required>
                                                <?php
                                                $sections = $conn->query("SELECT * FROM section_table ORDER BY section_id ASC");
                                                while($s = $sections->fetch_assoc()):
                                                ?>
                                                    <option value="<?= $s['section_id'] ?>"><?= htmlspecialchars($s['section']) ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="editStartDate" class="form-label">Start Date</label>
                                            <input type="date" class="form-control" id="editStartDate" name="start_date" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="editEndDate" class="form-label">End Date</label>
                                            <input type="date" class="form-control" id="editEndDate" name="end_date" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="editTimeStart" class="form-label">Start Time</label>
                                            <select class="form-select" id="editTimeStart" name="time_start" required>
                                                <option value="" disabled selected>Select Start Time</option>
                                                <?php
                                                for ($h = 7; $h <= 21; $h++) {
                                                    if ($h == 12) continue;
                                                    $time = date("g:i A", strtotime("$h:00"));
                                                    echo "<option value='$time'>$time</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="editTimeEnd" class="form-label">End Time</label>
                                            <select class="form-select" id="editTimeEnd" name="time_end" required>
                                                <option value="" disabled selected>Select End Time</option>
                                                <?php
                                                for ($h = 8; $h <= 21; $h++) {
                                                    if ($h == 12) continue;
                                                    $time = date("g:i A", strtotime("$h:00"));
                                                    echo "<option value='$time'>$time</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-1"></i> Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Update Period
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            <!-- Add New Evaluation Period Modal -->
                <div class="modal fade" id="addPeriodModal" tabindex="-1" aria-labelledby="addPeriodModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered"> <!-- Added modal-dialog-centered -->
                        <div class="modal-content">
                            <form id="addPeriodForm" method="POST" action="Addperiod.php">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addPeriodModalLabel"><i class="fas fa-calendar-alt me-2"></i>Add New Evaluation Period</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="academicYear" class="form-label">Academic Year</label>
                                            <select class="form-select" id="academicYear" name="academic_year_id" required>
                                                <?php
                                                $years = $conn->query("SELECT * FROM academic_year_table WHERE status = 1 ORDER BY academic_year_id DESC");
                                                $first = true;
                                                while($y = $years->fetch_assoc()):
                                                ?>
                                                    <option value="<?= $y['academic_year_id'] ?>"
                                                            data-start="<?= $y['academic_year_start'] ?>"
                                                            data-end="<?= $y['academic_year_end'] ?>"
                                                            <?= $first ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($y['academic_year_start']) . ' - ' . htmlspecialchars($y['academic_year_end']) ?>
                                                    </option>
                                                <?php 
                                                    $first = false;
                                                    endwhile; 
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="program" class="form-label">Program</label>
                                            <select class="form-select" id="program" name="program_id" required>
                                                <option value="" disabled selected>Select Program</option>
                                                <?php
                                                $programs = $conn->query("SELECT * FROM program_table ORDER BY program_id ASC");
                                                while($p = $programs->fetch_assoc()):
                                                ?>
                                                    <option value="<?= $p['program_id'] ?>"><?= htmlspecialchars($p['program_name']) ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="yearLevel" class="form-label">Year Level</label>
                                            <select class="form-select" id="yearLevel" name="year_level_id" required>
                                                <option value="" disabled selected>Select Year Level</option>
                                                <?php
                                                $levels = $conn->query("SELECT * FROM year_level_table ORDER BY year_level_id ASC");
                                                while($l = $levels->fetch_assoc()):
                                                ?>
                                                    <option value="<?= $l['year_level_id'] ?>"><?= htmlspecialchars($l['year_level_label']) ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="section" class="form-label">Section</label>
                                            <select class="form-select" id="section" name="section_id" required>
                                                <option value="" disabled selected>Select Section</option>
                                                <?php
                                                $sections = $conn->query("SELECT * FROM section_table ORDER BY section_id ASC");
                                                while($s = $sections->fetch_assoc()):
                                                ?>
                                                    <option value="<?= $s['section_id'] ?>"><?= htmlspecialchars($s['section']) ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="startDate" class="form-label">Start Date</label>
                                            <input type="date" class="form-control" id="startDate" name="start_date" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="endDate" class="form-label">End Date</label>
                                            <input type="date" class="form-control" id="endDate" name="end_date" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="timeStart" class="form-label">Start Time</label>
                                            <select class="form-select" id="timeStart" name="time_start" required>
                                                <option value="" disabled selected>Select Start Time</option>
                                                <?php
                                                for ($h = 7; $h <= 21; $h++) {
                                                    if ($h == 12) continue;
                                                    $time = date("g:i A", strtotime("$h:00"));
                                                    echo "<option value='$time'>$time</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="timeEnd" class="form-label">End Time</label>
                                            <select class="form-select" id="timeEnd" name="time_end" required disabled>
                                                <option value="" disabled selected>Select End Time</option>
                                                <?php
                                                for ($h = 8; $h <= 21; $h++) {
                                                    if ($h == 12) continue;
                                                    $time = date("g:i A", strtotime("$h:00"));
                                                    echo "<option value='$time'>$time</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-1"></i> Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-plus me-1"></i> Add Period
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>



<script src="/assets/js/evalperiod.js"></script>

<?php include 'components/footer.php'; ?>
