<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../FacultyEvaluationAdmin/assets/css/register.css">
</head>
<body>

<div class="register-card">
    <div class="register-image">
    </div>

    <div class="register-form p-3" style="max-width: 744px; width: 100%;">
        <div class="register-right px-3">
            <div class="d-flex align-items-center justify-content-center mt-4 mb-2" style="gap: 30px;">
                <h1 class="ms-2 mt-2 fw-bold">WELCOME</h1>
            </div>

            <form id="registerForm" action="register.php" method="POST" class="mx-auto" style="max-width: 720px;">
                <div class="row mb-1">
                    <div class="col-md-3 mb-1">
                        <label for="firstname" class="form-label fw-bold">First Name</label>
                        <input type="text" class="form-control form-control-sm" id="firstname" name="firstname" placeholder="First Name" required>
                    </div>
                    <div class="col-md-3 mb-1">
                        <label for="middlename" class="form-label fw-bold">Middle Name</label>
                        <input type="text" class="form-control form-control-sm" id="middlename" name="middlename" placeholder="Middle Name">
                    </div>
                    <div class="col-md-3 mb-1">
                        <label for="lastname" class="form-label fw-bold">Last Name</label>
                        <input type="text" class="form-control form-control-sm" id="lastname" name="lastname" placeholder="Last Name" required>
                    </div>
                    <div class="col-md-3 mb-1">
                        <label for="prefix" class="form-label fw-bold">Prefix</label>
                        <input type="text" class="form-control form-control-sm" id="prefix" name="prefix" placeholder="e.g., Jr., Sr.">
                    </div>
                </div>

                <div class="row mb-1">
                    <div class="col-md-6 mb-1">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="Enter Email" required>
                    </div>
                    <div class="col-md-6 mb-1">
                        <label for="dob" class="form-label fw-bold">Date of Birth</label>
                        <input type="date" class="form-control form-control-sm" id="dob" name="dob" placeholder="Select Date of Birth" required>
                    </div>
                </div>

                <div class="row mb-1">
                    <div class="col-md-6 mb-1">
                        <label for="password" class="form-label fw-bold">Password</label>
                        <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Enter Password" required>
                    </div>
                    <div class="col-md-6 mb-1">
                        <label for="gender" class="form-label fw-bold">Gender</label>
                        <select class="form-select form-select-sm" id="gender" name="gender" required>
                            <option value="" selected disabled>Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-1">
                    <div class="col-md-6 mb-1">
                        <label for="department" class="form-label fw-bold">Department</label>
                        <select class="form-select form-select-sm" id="department" name="department" required>
                            <option value="" selected disabled>Select Department</option>

                            <?php
                            include '../config/db.php'; // adjust the path if needed

                            // Fetch department data
                            $sql = "SELECT department_id, department_name FROM department_table ORDER BY department_name ASC";
                            $result = $conn->query($sql);

                            if ($result && $result->num_rows > 0):
                                while ($row = $result->fetch_assoc()):
                            ?>
                                    <option value="<?= htmlspecialchars($row['department_id']) ?>">
                                        <?= htmlspecialchars($row['department_name']) ?>
                                    </option>
                            <?php
                                endwhile;
                            else:
                                echo '<option value="">No departments available</option>';
                            endif;

                            $conn->close();
                            ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-1">
                        <label for="role" class="form-label fw-bold">Role</label>
                        <select class="form-select form-select-sm" id="role" name="role" required>
                            <option value="" selected disabled>Select Role</option>
                            <option value="guidance">Guidance</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    <button type="submit" class="btn  btn-register">
                        Register
                    </button>
                </div>
                <!-- Register Link -->
                    <p class="mb-0 mt-4 text-center register-link">
                        ALREADY HAVE AN ACCOUNT? 
                        <a href="login.php" class="fw-bold text-decoration-none">LOGIN</a>
                    </p>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>