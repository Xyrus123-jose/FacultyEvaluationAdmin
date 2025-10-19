<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<?php include 'components/header.php'; ?>
<?php include '../config/db.php'; // DB connection ?>
<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h4 class="page-title">Add Student</h4>
    </div>

    <!-- Stat Cards -->
    <div class="row align-items-start">
      <!-- Regular Student Card -->
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body text-center">
            <div class="d-flex justify-content-center align-items-center mb-1">
              <div class="icon-small me-3">
                <i class="fas fa-users fa-2x"></i>
              </div>
              <p class="card-category mb-0" style="font-size: 21px; color: black; font-family: 'Inclusive Sans', sans-serif;">
                Regular Student
              </p>
            </div>
            <h4 class="card-title" style="font-size: 34px; color: black;">1,500</h4>
          </div>
        </div>
      </div>

      <!-- Irregular Student Card -->
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body text-center">
            <div class="d-flex justify-content-center align-items-center mb-1">
              <div class="icon-small me-3">
                <i class="fas fa-users fa-2x"></i>
              </div>
              <p class="card-category mb-0" style="font-size: 21px; color: black; font-family: 'Inclusive Sans', sans-serif;">
                Irregular Student
              </p>
            </div>
            <h4 class="card-title" style="font-size: 34px; color: black;">500</h4>
          </div>
        </div>
      </div>

      <!-- Student Population Card -->
      <div class="col-sm-6 col-md-3 ms-auto">
        <div class="card card-stats card-round">
          <div class="card-body text-center">
            <div class="d-flex justify-content-center align-items-center mb-1">
              <div class="icon-small me-3">
                <i class="fas fa-users fa-2x"></i>
              </div>
              <p class="card-category mb-0" style="font-size: 21px; color: black; font-family: 'Inclusive Sans', sans-serif;">
                Student Population
              </p>
            </div>
            <h4 class="card-title" style="font-size: 34px; color: black;">2,000</h4>
          </div>
        </div>
      </div>
    </div>

    <!-- Student List -->
    <div class="row mt-4">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h4 class="card-title">Student List</h4>
              <a href="AddstudentForm.php" class="btn btn-primary btn-round ms-auto">
                <i class="fa fa-plus"></i> Add Student
              </a>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="add-row" class="display table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Student Number</th>
                    <th>Surname</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Program</th>
                    <th>Year Level</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                 <?php
                    $sql = "SELECT s.student_number, s.surname, s.first_name, s.middle_name, 
                                  p.program_name, y.year_level_label, 
                                  s.email, s.status
                            FROM student_table s
                            LEFT JOIN program_table p ON s.program_id = p.program_id
                            LEFT JOIN year_level_table y ON s.year_level_id = y.year_level_id
                            WHERE s.status != 'Archived'";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['student_number']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['surname']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['middle_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['program_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['year_level_label']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['status']) . "</td>";

                    

                        echo "<td>
                                <div class='form-button-action'>
                                  <a href='Editstudent.php?id=" . $row['student_number'] . "' class='btn btn-link btn-primary btn-lg' data-bs-toggle='tooltip' title='Edit'>
                                    <i class='fa fa-edit'></i>
                                  </a>
                                 <button type='button' class='btn btn-link btn-warning archive-btn' data-id='" . $row['student_number'] . "' title='Archive'>
                                      <i class='fa fa-archive'></i>
                                    </button>
                                </div>
                              </td>";
                        echo "</tr>";
                      }
                    } else {
                      echo "<tr><td colspan='10' class='text-center'>No students found</td></tr>";
                    }
                    $conn->close();
                    ?>

                </tbody>

              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    
  </div>
</div>
<script src="/project_internal/assets/js/profile.js"></script>
<?php if (isset($_GET['archived']) && $_GET['archived'] == 1): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
    icon: 'success',
    title: 'Archived!',
    text: 'Student has been archived successfully.',
    timer: 1000,
    showConfirmButton: false,
    timerProgressBar: true
}).then(() => {
    const url = new URL(window.location);
    url.searchParams.delete('archived');
    window.history.replaceState({}, document.title, url);
});
</script>
<?php endif; ?>


<?php include 'components/footer.php'; ?>

<!-- jQuery Scrollbar -->
<script src="../../FacultyEvaluationAdmin/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<!-- Datatables -->
<script src="../../FacultyEvaluationAdmin/assets/js/plugin/datatables/datatables.min.js"></script>
<!-- Kaiadmin JS -->
<script src="../../FacultyEvaluationAdmin/assets/js/kaiadmin.min.js"></script>
<script>
  $(document).ready(function () {
    $("#add-row").DataTable({
      pageLength: 5,
    });
  });
</script>
