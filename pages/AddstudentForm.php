<!-- Bootstrap CSS & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="../../FacultyEvaluationAdmin/assets/css/profile.css">

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
include '../config/db.php'; // Database connection

// Fetch dropdown data
$programs = $conn->query("SELECT program_id, program_name FROM program_table");
$years    = $conn->query("SELECT year_level_id, year_level FROM year_level_table");
$sections = $conn->query("SELECT section_id, section FROM section_table");
$branches = $conn->query("SELECT branch_id, branch_name FROM branch_table");
?>

<?php include 'components/header.php'; ?>

<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h4 class="page-title">Student Form</h4>
    </div>

    <!-- Student Form -->
    <form id="studentForm" action="add_student_process.php" method="POST" enctype="multipart/form-data">
      <div class="row g-4">

        <!-- LEFT COLUMN : Profile Picture -->
        <div class="col-xl-3 col-lg-4 col-md-12">
          <div class="card p-4 text-center">

            <!-- Profile Image -->
            <div class="mb-3">
              <img id="previewImage" 
                   src="https://static.vecteezy.com/system/resources/previews/004/141/669/non_2x/no-photo-or-blank-image-icon-loading-images-or-missing-image-mark-image-not-available-or-image-coming-soon-sign-simple-nature-silhouette-in-frame-isolated-illustration-vector.jpg" 
                   alt="Profile Picture" 
                   class="img-fluid rounded-circle profile-img">
            </div>

            <!-- Upload Image -->
            <div class="mb-3">
              <label for="profile_picture" class="form-label fw-semibold">
                <i class="bi bi-upload me-1"></i> Upload Picture
              </label>
              <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*" onchange="previewFile(event)">
            </div>

            <!-- Hidden Student Number -->
            <input type="hidden" id="student_number_input" name="student_number">

          </div>
        </div>

        <!-- RIGHT COLUMN : Student Info -->
        <div class="col-xl-9 col-lg-8 col-md-12">
          <div class="card p-4">
            <h4 class="mb-4 text-dark fw-bold">
              <i class="bi bi-journal-text me-2"></i> Student Information
            </h4>

            <div class="row g-3">
              
              <!-- Name Fields -->
              <div class="col-md-6">
                <label for="surname" class="form-label">Surname</label>
                <input type="text" class="form-control" id="surname" name="surname" placeholder="Enter surname" required>
              </div>

              <div class="col-md-6">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" required>
              </div>

              <div class="col-md-6">
                <label for="middle_name" class="form-label">Middle Name</label>
                <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Enter middle name">
              </div>

              <!-- Program Dropdown -->
              <div class="col-md-6">
                <label for="program_id" class="form-label">Program</label>
                <select class="form-select" id="program_id" name="program_id" required>
                  <option value="">Select Program</option>
                  <?php while($row = $programs->fetch_assoc()): ?>
                    <option value="<?= $row['program_id'] ?>"><?= $row['program_name'] ?></option>
                  <?php endwhile; ?>
                </select>
              </div>

              <!-- Year Level Dropdown -->
              <div class="col-md-6">
                <label for="year_level_id" class="form-label">Year Level</label>
                <select class="form-select" id="year_level_id" name="year_level_id" required>
                  <option value="">Select Year</option>
                  <?php while($row = $years->fetch_assoc()): ?>
                    <option value="<?= $row['year_level_id'] ?>"><?= $row['year_level'] ?></option>
                  <?php endwhile; ?>
                </select>
              </div>

              <!-- Section Dropdown -->
              <div class="col-md-6">
                <label for="section_id" class="form-label">Section</label>
                <select class="form-select" id="section_id" name="section_id" required>
                  <option value="">Select Section</option>
                  <?php while($row = $sections->fetch_assoc()): ?>
                    <option value="<?= $row['section_id'] ?>"><?= $row['section'] ?></option>
                  <?php endwhile; ?>
                </select>
              </div>

              <!-- Branch Dropdown -->
              <div class="col-md-6">
                <label for="branch_id" class="form-label">Branch</label>
                <select class="form-select" id="branch_id" name="branch_id" required>
                  <option value="">Select Branch</option>
                  <?php while($row = $branches->fetch_assoc()): ?>
                    <option value="<?= $row['branch_id'] ?>"><?= $row['branch_name'] ?></option>
                  <?php endwhile; ?>
                </select>
              </div>

              <!-- Student Type -->
              <div class="col-md-6">
                <label for="student_type" class="form-label">Student Type</label>
                <select class="form-select" id="student_type" name="student_type" required>
                  <option value="">Select Type</option>
                  <option value="Regular">Regular</option>
                  <option value="Irregular">Irregular</option>
                  <option value="Transferee">Transferee</option>
                </select>
              </div>

              <!-- Email -->
              <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
              </div>

              <!-- Status -->
              <div class="col-md-6">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                  <option value="">Select Status</option>
                  <option value="Active">Active</option>
                  <option value="Inactive">Inactive</option>
                  <option value="Graduated">Graduated</option>
                </select>
              </div>

              <!-- Gender -->
              <div class="col-md-6">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" id="gender" name="gender" required>
                  <option value="">Select Gender</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>

              <!-- Birthdate -->
              <div class="col-md-6">
                <label for="birthdate" class="form-label">Birthdate</label>
                <input type="date" class="form-control" id="birthdate" name="birthdate" required>
              </div>
            </div>

            <!-- Buttons -->
            <div class="mt-4 text-end">
              <a href="student.php" class="btn btn-danger me-2">
                <i class="bi bi-x-circle me-1"></i> Cancel
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Add Student
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('studentForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent default form submission

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to add this student?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, add student',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit form via POST using fetch
            let formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Student Added!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false,
                        timerProgressBar: true
                    }).then(() => {
                        window.location.href = 'student.php';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Something went wrong.'
                });
            });
        }
    });
});
</script>


<!-- JS Scripts -->
<script src="../../FacultyEvaluationAdmin/assets/js/profile.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php include 'components/footer.php'; ?>
