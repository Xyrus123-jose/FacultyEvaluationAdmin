<?php
session_start();

$pageTitle = basename($_SERVER['PHP_SELF'], '.php');
$currentPage = basename($_SERVER['PHP_SELF']);

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Session data
$username = $_SESSION['username'] ?? 'Guest';
$userRole = $_SESSION['role'] ?? 'User';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Admin Dashboard | <?= htmlspecialchars($pageTitle) ?></title>

    <link rel="icon" href="../../FacultyEvaluationAdmin/assets/css/background/QCU_Logo.png" type="image/x-icon" />

    <link rel="stylesheet" href="../../FacultyEvaluationAdmin/assets/css/design.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../FacultyEvaluationAdmin/assets/css/sidebar.css" />
</head>

<body>
<div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
            <div class="logo-header" data-background-color="dark">
                <a href="index.php" class="logo me-2">
                    <img src="/FacultyEvaluationAdmin/assets/css/background/logoheader.svg"
                         alt="navbar brand" class="img-fluid" style="max-height: 30px;">
                </a>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
                    <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
                </div>
            </div>
        </div>

        <div class="sidebar-wrapper scrollbar scrollbar-inner">
            <div class="sidebar-content">
                <ul class="nav nav-secondary">
                    <!-- User Info -->
                    <li class="nav-section mt-auto user-info-section d-flex align-items-center">
                        <div class="user-avatar me-2"><?= strtoupper(substr($username, 0, 1)) ?></div>
                        <div class="user-details">
                            <p class="user-name mb-1"><?= htmlspecialchars($username) ?></p>
                            <p class="user-role mb-0"><?= htmlspecialchars($userRole) ?></p>
                        </div>
                    </li>

                    <!-- Main Navigation -->
                    <li class="nav-item <?= ($currentPage == 'index.php') ? 'active' : '' ?>">
                        <a href="index.php"><i class="fas fa-tachometer-alt"></i><p>Dashboard</p></a>
                    </li>
                    <li class="nav-item <?= ($currentPage == 'evaluationperiod.php') ? 'active' : '' ?>">
                        <a href="evaluationperiod.php"><i class="fas fa-clock"></i><p>Evaluation Schedule</p></a>
                    </li>
                    <li class="nav-item <?= ($currentPage == 'academicyear.php') ? 'active' : '' ?>">
                        <a href="academicyear.php"><i class="fas fa-calendar-alt"></i><p>Academic Year</p></a>
                    </li>
                    <li class="nav-item <?= ($currentPage == 'criteria.php') ? 'active' : '' ?>">
                        <a href="criteria.php"><i class="fas fa-clipboard-check"></i><p>Criteria</p></a>
                    </li>
                    <li class="nav-item <?= ($currentPage == 'category.php') ? 'active' : '' ?>">
                        <a href="category.php"><i class="fas fa-list"></i><p>Category</p></a>
                    </li>
                    <li class="nav-item <?= ($currentPage == 'branch.php') ? 'active' : '' ?>">
                        <a href="branch.php"><i class="fas fa-building"></i><p>Branches</p></a>
                    </li>
                    <li class="nav-item <?= ($currentPage == 'user.php') ? 'active' : '' ?>">
                        <a href="user.php"><i class="fas fa-user"></i><p>Users</p></a>
                    </li>

                    <?php if ($userRole !== 'guidance'): ?>
                    <li class="nav-section mt-3">
                        <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
                        <h4 class="text-section">Registrar</h4>
                    </li>
                    <li class="nav-item <?= ($currentPage == 'student.php') ? 'active' : '' ?>">
                        <a href="student.php"><i class="fas fa-user-graduate"></i><p>Students</p></a>
                    </li>
                    <li class="nav-item <?= ($currentPage == 'department.php') ? 'active' : '' ?>">
                        <a href="department.php"><i class="fas fa-building"></i><p>Departments</p></a>
                    </li>
                    <li class="nav-item <?= ($currentPage == 'program.php') ? 'active' : '' ?>">
                        <a href="program.php"><i class="fas fa-graduation-cap"></i><p>Programs</p></a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a href="logout.php">
                        <i class="fas fa-sign-out-alt text-danger"></i>
                    <p class="text-danger mb-0">Logout</p></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End Sidebar -->

    <!-- Main Panel -->
    <div class="main-panel">
        <div class="main-header">
            <div class="main-header-logo">
                <div class="logo-header" data-background-color="dark">
                    <a href="index.php" class="logo">
                        <img src="" alt="navbar brand" class="navbar-brand" height="40" />
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
                        <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
                    </div>
                </div>
            </div>

            <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                <div class="container-fluid d-flex justify-content-between align-items-center">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <div class="navbar-text fw-bold" id="currentDateTime"></div>
                    </ul>
                </div>
            </nav>
        </div>
<script>
    function updateDateTime() {
        const now = new Date();
        const time = now.toLocaleTimeString("en-PH", { hour: "2-digit", minute: "2-digit", second: "2-digit" });
        const date = now.toLocaleDateString("en-PH", { year: "numeric", month: "long", day: "numeric" });

        document.getElementById("currentDateTime").innerHTML = `
            <div style="font-size: 19px; color: #fff; font-weight: 700;">${time}</div>
            <div style="font-size: 12px; color: #fff;">${date}</div>
        `;
    }

    setInterval(updateDateTime, 1000);
    updateDateTime();

    document.addEventListener("DOMContentLoaded", () => {
        const toggleButtons = document.querySelectorAll('.toggle-sidebar, .sidenav-toggler');
        const sidebar = document.querySelector('.sidebar');

        toggleButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                sidebar.classList.toggle('sidebar-mini');
            });
        });
    });
</script>
