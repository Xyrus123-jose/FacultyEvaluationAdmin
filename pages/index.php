<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../../FacultyEvaluationAdmin/assets/css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<?php include 'components/header.php'; ?>

<div class="container">
    <div class="page-inner">
        <h1 class="mb-2" style="font-size: 2.2rem; font-weight: 700;">
            Welcome, <?= htmlspecialchars($username) ?>
        </h1>
        <p class="text-muted mb-4" style="font-size: 1.1rem; font-weight: 500;">
            This is your Dashboard
        </p>

        <div class="row g-4">
            <!-- Column 1 -->
            <div class="col-md-6 d-flex flex-column gap-4">

                <!-- Evaluation Table Card -->
                <div class="table-container d-flex flex-column flex-grow-1">
                    <div class="table-header d-flex justify-content-between align-items-center mb-2">
                        <h5><i class="fas fa-calendar-alt me-2"></i>Evaluation Status</h5>
                        <div id="totalCount" class="fw-semibold">Total: 1</div>
                    </div>

                    <!-- Filters -->
                    <div class="filters mb-2 d-flex gap-2">
                        <select class="form-control form-control-sm" id="academicYearFilter">
                            <option value="">All Years</option>
                            <option value="2023-2024">2023-2024</option>
                            <option value="2022-2023">2022-2023</option>
                            <option value="2021-2022">2021-2022</option>
                        </select>
                        <select class="form-control form-control-sm" id="semesterFilter">
                            <option value="">All Semesters</option>
                            <option value="1st Semester">1st Semester</option>
                            <option value="2nd Semester">2nd Semester</option>
                        </select>
                        <select class="form-control form-control-sm" id="completedFilter">
                            <option value="">All</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive flex-grow-1">
                        <table class="table table-hover table-sm text-center mb-0" id="evaluationPeriodTable">
                            <thead>
                                <tr>
                                    <th>Student Number</th>
                                    <th>Student Name</th>
                                    <th>Section</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>2025-001</td>
                                    <td>Juan Dela Cruz</td>
                                    <td>A</td>
                                    <td>
                                        <button class="btn btn-link btn-primary btn-sm edit-btn" data-id="2025-001" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-link btn-danger btn-sm delete-btn" data-id="2025-001" title="Delete">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-container mt-2 d-flex justify-content-between align-items-center">
                        <div class="pagination-info">Showing 1 to 1 of 1 entries</div>
                        <nav>
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <!-- Multiple Bar Chart -->
                <div class="card p-3 mt-auto">
                    <div class="card-header">
                        <div class="card-title">Evaluation Status</div>
                    </div>
                    <div class="card-body" style="height: 300px;">
                        <canvas id="multipleBarChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Column 2 -->
            <div class="col-md-6 d-flex flex-column gap-4">
                <div class="row g-2">
                    <!-- Done Evaluations -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body pb-0">
                                <div class="h1 fw-bold float-end text-success">+5%</div>
                                <h2 class="mb-2 text-success">17</h2>
                                <p class="text-muted text-success">Done Evaluations</p>
                                <div id="lineChart"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Evaluations -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body pb-0">
                                <div class="h1 fw-bold float-end text-danger">-3%</div>
                                <h2 class="mb-2 text-danger">27</h2>
                                <p class="text-muted text-danger">Pending Evaluations</p>
                                <div id="lineChart2"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Participants -->
                    <div class="col-md-6">
                        <div class="card card-stats  card-round">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5 text-center">
                                        <i class="fas fa-users fa-2x"></i>
                                    </div>
                                    <div class="col-7">
                                        <p class="card-category">Participants</p>
                                        <h4 class="card-title">1,294</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Overall Rating -->
                    <div class="col-md-6">
                        <div class="card card-stats  card-round">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5 text-center">
                                        <i class="fas fa-chart-pie fa-2x"></i>
                                    </div>
                                    <div class="col-7">
                                        <p class="card-category">Overall Rating</p>
                                        <h4 class="card-title">1,294</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pie Chart -->
                <div class="card p-3 mt-auto">
                    <div class="card-header">
                        <div class="card-title">Feedback Sentiment</div>
                    </div>
                    <div class="card-body" style="height: 400px;">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sparklines/2.1.2/jquery.sparkline.min.js"></script>

<script>
    // Multiple Bar Chart
    const multipleBarChart = new Chart(document.getElementById('multipleBarChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June'],
            datasets: [
                { label: '1st Sem', data: [12, 19, 3, 5, 2, 3], backgroundColor: '#1abc9c' },
                { label: '2nd Sem', data: [5, 10, 8, 3, 7, 6], backgroundColor: '#3498db' }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'top' }, title: { display: false } },
            scales: { x: { beginAtZero: true }, y: { beginAtZero: true } }
        }
    });

    // Pie Chart
    new Chart(document.getElementById('pieChart'), {
        type: 'pie',
        data: {
            datasets: [{
                data: [50, 35, 15],
                backgroundColor: ["#1d7af3", "#6fcf97"],
                borderWidth: 0
            }],
            labels: ["Positive Reviews", "Negative Reviews"]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: "bottom", labels: { padding: 20, usePointStyle: true } }
            }
        }
    });

    $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], { type: "line", height: "70", width: "100%", lineWidth: 2, lineColor: "#0b8948ff", fillColor: "rgba(23,125,255,0.14)" });
    $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], { type: "line", height: "70", width: "100%", lineWidth: 2, lineColor: "#f3545d", fillColor: "rgba(243,84,93,0.14)" });
</script>
