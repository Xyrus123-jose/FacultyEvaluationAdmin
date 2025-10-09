<?php
session_start();
$pageTitle = basename($_SERVER['PHP_SELF'], '.php');

// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// User is logged in, can use:
$userRole = $_SESSION['role'] ?? '';
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Admin Dashboard | <?php echo $pageTitle; ?></title>

    <!-- Favicon -->
    <link rel="icon" href="../../FacultyEvaluationAdmin/assets/css/background/QCU_Logo.png" type="image/x-icon" />

    <!-- Fonts and Icons -->
    <script src="../../FacultyEvaluationAdmin/assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: { families: ["Public Sans:300,400,500,600,700"] },
            custom: {
                families: ["Font Awesome 5 Solid","Font Awesome 5 Regular","Font Awesome 5 Brands","simple-line-icons"],
                urls: ["../../FacultyEvaluationAdmin/assets/css/fonts.min.css"]
            },
            active: function () { sessionStorage.fonts = true; }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="../../FacultyEvaluationAdmin/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../FacultyEvaluationAdmin/assets/css/plugins.min.css" />
    <link rel="stylesheet" href="../../FacultyEvaluationAdmin/assets/css/kaiadmin.min.css" />
    <link rel="stylesheet" href="../../FacultyEvaluationAdmin/assets/css/demo.css" />
</head>

<body>
<div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
            <div class="logo-header" data-background-color="dark">
                <a href="index.php" class="logo">
                    <img src="../../FacultyEvaluationAdmin/assets/css/background/headerlogo.svg" alt="navbar brand" class="navbar-brand" height="40">
                </a>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
                    <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
                </div>
                <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
            </div>
        </div>

        <div class="sidebar-wrapper scrollbar scrollbar-inner">
            <div class="sidebar-content">
                <ul class="nav nav-secondary">
                    <?php if ($userRole === 'guidance'): ?>
                        <!-- Guidance Menu -->
                        <li class="nav-item active"><a href="index.php"><i class="fas fa-tachometer-alt"></i><p>Dashboard</p></a></li>
                        <li class="nav-item"><a href="evaluationperiod.php"><i class="fas fa-clock"></i><p>Evaluation Period</p></a></li>
                        <li class="nav-item"><a href="academicyear.php"><i class="fas fa-calendar-alt"></i><p>Academic Year</p></a></li>
                        <li class="nav-item"><a href="criteria.php"><i class="fas fa-clipboard-check"></i><p>Criteria</p></a></li>
                        <li class="nav-item"><a href="category.php"><i class="fas fa-list"></i><p>Category</p></a></li>
                        <li class="nav-item"><a href="studentreport.php"><i class="fas fa-file-alt"></i><p>Student Report</p></a></li>
                    <?php else: ?>
                        <!-- Admin & Others Menu -->
                        <li class="nav-item active"><a href="index.php"><i class="fas fa-tachometer-alt"></i><p>Dashboard</p></a></li>
                        <li class="nav-item"><a href="evaluationperiod.php"><i class="fas fa-clock"></i><p>Evaluation Period</p></a></li>
                        <li class="nav-item"><a href="academicyear.php"><i class="fas fa-calendar-alt"></i><p>Academic Year</p></a></li>
                        <li class="nav-item"><a href="criteria.php"><i class="fas fa-clipboard-check"></i><p>Criteria</p></a></li>
                        <li class="nav-item"><a href="category.php"><i class="fas fa-list"></i><p>Category</p></a></li>
                        <li class="nav-item"><a href="studentreport.php"><i class="fas fa-file-alt"></i><p>Student Report</p></a></li>

                        <li class="nav-section">
                            <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
                            <h4 class="text-section">Components</h4>
                        </li>

                        <li class="nav-item"><a href="subject.php"><i class="fas fa-book-open"></i><p>Subjects</p></a></li>
                        <li class="nav-item"><a href="branch.php"><i class="fas fa-code-branch"></i><p>Branches</p></a></li>
                        <li class="nav-item"><a href="year_level.php"><i class="fas fa-layer-group"></i><p>Year Level</p></a></li>
                        <li class="nav-item"><a href="section.php"><i class="fas fa-columns"></i><p>Sections</p></a></li>
                        <li class="nav-item"><a href="department.php"><i class="fas fa-building"></i><p>Departments</p></a></li>
                        <li class="nav-item"><a href="program.php"><i class="fas fa-graduation-cap"></i><p>Programs</p></a></li>
                        <li class="nav-item"><a href="faculty.php"><i class="fas fa-user-tie"></i><p>Faculty</p></a></li>
                        <li class="nav-item"><a href="student.php"><i class="fas fa-user-graduate"></i><p>Students</p></a></li>
                        <li class="nav-item"><a href="#"><i class="fas fa-user-shield"></i><p>HR</p></a></li>
                        <li class="nav-item"><a href="user.php"><i class="fas fa-users"></i><p>Users</p></a></li>
                        <li class="nav-item"><a href="#"><i class="fas fa-clipboard-user"></i><p>Registrar</p></a></li>
                    <?php endif; ?>
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
                    <a href="index.html" class="logo">
                        <img src="../../FacultyEvaluationAdmin/assets/css/background/headerlogo.svg" alt="navbar brand" class="navbar-brand" height="40" />
                    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
                        <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
                    </div>
                    <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
                </div>
            </div>

            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                <div class="container-fluid d-flex justify-content-between align-items-center">
                    <!-- Left: Current Time & Date -->
                    <div class="navbar-text fw-bold" id="currentDateTime"></div>

                    <!-- Right: User Profile + Logout -->
                    <ul class="navbar-nav ms-auto align-items-center">
                      <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle d-flex align-items-center px-4 py-3"
                            href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                            style="font-size: 1.2rem; font-weight: 600; color: #2c3e50; gap: 0.5rem;">
                              <i class="fas fa-user-circle" style="font-size: 1.6rem;"></i>
                              <?php echo htmlspecialchars($_SESSION['username'] ?? 'Guest'); ?>
                          </a>
                          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                              <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i> Profile</a></li>
                              <li><hr class="dropdown-divider"></li>
                              <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                          </ul>
                      </li>
                  </ul>

                </div>
            </nav>
            <!-- End Navbar -->
        </div>
<!-- Scripts -->
<script>
    // Sidebar toggle
    const toggleBtn = document.querySelector('.btn-toggle.toggle-sidebar');
    const adminTitle = document.querySelector('.logo-header h1');
    toggleBtn.addEventListener('click', () => {
        adminTitle.style.display = (adminTitle.style.display === 'none') ? 'block' : 'none';
    });

    // Current date and time
    function updateDateTime() {
        const now = new Date();
        document.getElementById("currentDateTime").textContent =
            now.toLocaleString("en-PH", { dateStyle: "medium", timeStyle: "short" });
    }
    setInterval(updateDateTime, 1000);
    updateDateTime();
</script>
