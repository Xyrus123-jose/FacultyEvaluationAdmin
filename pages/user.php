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
            <h4 class="page-title">Manage Users</h4>
        </div>

        <!-- Two-column layout -->
        <div class="row g-4">
            <!-- Add Admin User Form -->
                <div class="col-lg-4 col-md-6">
                    <div class="card-custom">
                        <div class="card-header">
                            <h5><i class="fas fa-user-plus"></i> Add New User</h5>
                        </div>
                        <form id="addUserForm" method="POST" action="Adduser.php">
                            <!-- Hidden field for auto-generated user ID -->
                            <input type="hidden" name="user_id" id="user_id" value="<?= 'u-' . time() ?>">

                            <!-- Username -->
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" id="username" placeholder="Enter username" required>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password_hash" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password_hash" id="password_hash" placeholder="Enter password" required>
                            </div>

                            <!-- Role -->
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select" name="role" id="role" required>
                                    <option value="" selected disabled>Select Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="guidance">Guidance</option>
                                </select>
                            </div>

                            <!-- Department -->
                            <div class="mb-3">
                                <label for="department_id" class="form-label">Department</label>
                                <select class="form-select" id="department_id" name="department_id" required>
                                    <option value="" selected disabled>Select Department</option>
                                    <?php
                                    include '../config/db.php';
                                    $dept_query = "SELECT department_id, department_name FROM department_table";
                                    $dept_result = $conn->query($dept_query);
                                    while($row = $dept_result->fetch_assoc()):
                                    ?>
                                        <option value="<?= $row['department_id'] ?>"><?= $row['department_name'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter email address" required>
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" name="status" id="status" required>
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Add User</button>
                        </form>
                    </div>
                </div>


            <!-- Users List Table -->
                <div class="col-lg-8 col-md-10">
                    <div class="table-container">
                        <div class="table-header d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0"><i class="fas fa-users me-2"></i> Users List</h5>
                            <div class="d-flex align-items-center gap-2">
                                <!-- Search Bar -->
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" id="searchUser" class="form-control" placeholder="Search username...">
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover mb-0 text-center" id="userTable">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>Username</th>
                                        <th>Role</th>
                                        <th>Department</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        include '../config/db.php';
                                        $query = "
                                            SELECT 
                                                u.user_id, 
                                                u.username, 
                                                u.role, 
                                                u.email, 
                                                u.status, 
                                                d.department_name 
                                            FROM user_table AS u
                                            LEFT JOIN department_table AS d 
                                                ON u.department_id = d.department_id
                                            ORDER BY u.user_id ASC
                                        ";

                                        $users = $conn->query($query);

                                        if ($users && $users->num_rows > 0):
                                            while($user = $users->fetch_assoc()):
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($user['user_id']) ?></td>
                                        <td><?= htmlspecialchars($user['username']) ?></td>
                                        <td><?= htmlspecialchars($user['role']) ?></td>
                                        <td><?= htmlspecialchars($user['department_name'] ?? 'N/A') ?></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <td>
                                            <span class="badge bg-<?= $user['status'] == 1 ? 'success' : 'secondary' ?>">
                                                <?= $user['status'] == 1 ? 'Active' : 'Inactive' ?>
                                            </span>
                                        </td>
                                        <td class='actions'>
                                            <div class='form-button-action'>
                                                <button 
                                                    class="btn btn-link btn-primary edit-btn" 
                                                    data-id="<?= $user['user_id'] ?>" 
                                                    data-username="<?= htmlspecialchars($user['username'], ENT_QUOTES) ?>"
                                                    data-role="<?= htmlspecialchars($user['role'], ENT_QUOTES) ?>"
                                                    data-department="<?= htmlspecialchars($user['department_name'], ENT_QUOTES) ?>"
                                                    data-email="<?= htmlspecialchars($user['email'], ENT_QUOTES) ?>"
                                                    data-status="<?= $user['status'] ?>"
                                                    title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <button 
                                                    class="btn btn-link btn-danger delete-btn" 
                                                    data-id="<?= $user['user_id'] ?>" 
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
                                        <td colspan="7">No users found.</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

        </div> <!-- End of row -->
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../../FacultyEvaluationAdmin/assets/js/user.js"></script>

<?php include 'components/footer.php'; ?>
