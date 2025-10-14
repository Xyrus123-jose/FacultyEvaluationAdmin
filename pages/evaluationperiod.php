<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../FacultyEvaluationAdmin/assets/css/evalperiod.css">

</head>

<?php include 'components/header.php'; ?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Manage Schedules</h4>
        </div>


  <div class="card shadow">
        <div class="card-header bg-primary text-white fw-bold">
            Setup Evaluation Period
        </div>
        <div class="card-body">
            <form action="save_period.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Academic Year</label>
                    <select name="academic_year_id" class="form-select" required>
                        <option value="">Select Academic Year</option>
                        <?php
                        include '../config/db.php';
                        $result = mysqli_query($conn, "SELECT academic_year_id, academic_year_start, academic_year_end FROM academic_year_table WHERE status='Active'");
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='{$row['academic_year_id']}'>
                                {$row['academic_year_start']} - {$row['academic_year_end']}
                            </option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date_period" id="start_date_period" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date_period" id="end_date_period" class="form-control" disabled required>
                </div>

                <button type="submit" class="btn btn-success">Save Period</button>
            </form>
        </div>
    </div>
        

    </div>
</div>
<script>
const start = document.getElementById('start_date_period');
const end = document.getElementById('end_date_period');

start.addEventListener('change', () => {
    if (start.value) {
        end.disabled = false;
        end.min = start.value;
    } else {
        end.disabled = true;
        end.value = '';
    }
});
</script>
<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../../FacultyEvaluationAdmin/assets/js/period.js"></script>

<?php include 'components/footer.php'; ?>
