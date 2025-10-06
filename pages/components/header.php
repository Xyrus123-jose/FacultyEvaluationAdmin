<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
<?php
// Get the current file name without extension
$pageTitle = basename($_SERVER['PHP_SELF'], '.php');

// Optional: Convert to a more readable format (replace underscores with spaces, capitalize words)
$pageTitle = ucwords(str_replace('_', ' ', $pageTitle));
?>
<title>Admin Dashboard | <?php echo $pageTitle; ?></title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    
        <link rel="stylesheet" href="/assets/css/demo.css" />
        <a>
<link
      rel="icon"
      href="/assets/css/background/QCU_Logo.png"
      type="image/x-icon"
    />

    <!-- Fonts and icons -->
    <script src="/assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["/assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/assets/css/plugins.min.css" />
    <link rel="stylesheet" href="/assets/css/kaiadmin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="/assets/css/demo.css" />
  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
         <!-- Logo Header --> 
          <div class="logo-header" data-background-color="dark">
            <a href="index.php" class="logo">
              <img src="/assets/css/background/headerlogo.svg" alt="navbar brand" class="navbar-brand" height="40">
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
<!-- End Logo Header -->

        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item active">
                <a href="index.php">
                  <i class="fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Components</h4>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#curriculum">
                  <i class="fas fa-book-open"></i>
                  <p>Curriculum Management</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="curriculum">
                  <ul class="nav nav-collapse">
                  <li>
                  <a href="subject.php">
                    <span class="sub-item">Subjects</span>
                  </a>
                </li>
                <li>
                  <a href="branch.php">
                    <span class="sub-item">Branches</span>
                  </a>
                </li>
                <li>
                  <a href="year_level.php">
                    <span class="sub-item">Year Level</span>
                  </a>
                </li>
                <li>
                  <a href="section.php">
                    <span class="sub-item">Sections</span>
                  </a>
                </li>
                <li>
                  <a href="department.php">
                    <span class="sub-item">Departments</span>
                  </a>
                </li>
                <li>
                  <a href="program.php">
                    <span class="sub-item">Programs</span>
                  </a>
                </li>
                <li>
                  <a href="academicyear.php">
                    <span class="sub-item">Academic year</span>
                  </a>
                </li>
                <li>
                  <a href="evaluationperiod.php">
                    <span class="sub-item">Evaluation Period</span>
                  </a>
                </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#evaluation">
                  <i class="fas fa-clipboard-check"></i>
                  <p>Evaluation Management</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="evaluation">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="">
                        <span class="sub-item">Questionnaire</span>
                      </a>
                    </li>
                    <li>
                      <a href="criteria.php">
                        <span class="sub-item">Criteria</span>
                      </a>
                    </li>
                    <li>
                      <a href="category.php">
                        <span class="sub-item">Category</span>
                      </a>
                    </li>
                     <li>
                      <a href="studentreport.php">
                        <span class="sub-item">Student Report</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#personnel">
                  <i class="fas fa-users-cog"></i>
                  <p>Personnel Management</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="personnel">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="faculty.php">
                        <span class="sub-item">Faculty</span>
                      </a>
                    </li>
                     <li>
                      <a href="student.php">
                        <span class="sub-item">Students</span>
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <span class="sub-item">HR</span>
                      </a>
                    </li>
                    <li>
                      <a href="user.php">
                        <span class="sub-item">Users</span>
                      </a>
                    </li>
                    <li>
                      <a href="">
                        <span class="sub-item">Registrar</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
              <a href="index.html" class="logo">
                <img
                  src="/assets/img/kaiadmin/logo_light.svg"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="20"
                />
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
          <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    
    <!-- Left: Current Time & Date -->
    <div class="navbar-text fw-bold" id="currentDateTime"></div>

    <!-- Right: User Profile + Logout -->
    <ul class="navbar-nav ms-auto align-items-center">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fas fa-user-circle me-1"></i> Admin
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
          <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i> Profile</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item text-danger" href="login.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
          <!-- End Navbar -->
        </div>

<script>
  // Select elements
  const toggleBtn = document.querySelector('.btn-toggle.toggle-sidebar');
  const adminTitle = document.querySelector('.logo-header h1');

  // Toggle visibility on button click
  toggleBtn.addEventListener('click', () => {
    if (adminTitle.style.display === 'none') {
      adminTitle.style.display = 'block';
    } else {
      adminTitle.style.display = 'none';
    }
  });
</script>

<script>
  function updateDateTime() {
    const now = new Date();
    document.getElementById("currentDateTime").textContent = 
      now.toLocaleString("en-PH", { dateStyle: "medium", timeStyle: "short" });
  }
  setInterval(updateDateTime, 1000);
  updateDateTime();
</script>
