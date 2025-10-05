
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<?php include 'components/header.php'; ?>
  <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h4 class="page-title">Dashboard</h4>
            </div>

    <!-- Stats Cards -->
    <div class="row">
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div class="icon-big text-center icon-primary bubble-shadow-small">
                  <i class="fas fa-users"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Student Population</p>
                  <h4 class="card-title">--</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div class="icon-big text-center icon-info bubble-shadow-small">
                  <i class="fas fa-user-check"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Administrators</p>
                  <h4 class="card-title">- - -</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div class="icon-big text-center icon-warning bubble-shadow-small">
                  <i class="fas fa-chart-pie"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Overall Feedback</p>
                  <h4 class="card-title">- - -</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                  <i class="far fa-star"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Overall Rating</p>
                  <h4 class="card-title">- - -</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Charts -->
    <div class="row gx-4 gy-4">
      <!-- Multiple Bar Chart -->
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-header">
            <div class="card-title">Review Timeline</div>
          </div>
          <div class="card-body p-0 d-flex justify-content-center align-items-center" style="height:300px;">
            <canvas id="multipleBarChart" style="width:100%; height:100%;"></canvas>
          </div>
        </div>
      </div>

      <!-- Radar Chart -->
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-header">
            <div class="card-title">Review Rating</div>
          </div>
          <div class="card-body p-0 d-flex justify-content-center align-items-center" style="height:300px;">
            <canvas id="radarChart" style="width:100%; height:100%;"></canvas>
          </div>
        </div>
      </div>
    </div>

<!-- Chart.js Scripts -->
<script>
  // Multiple Bar Chart
 const ctxBar = document.getElementById('multipleBarChart').getContext('2d');
new Chart(ctxBar, {
  type: 'bar',
  data: {
    labels: ['January', 'February', 'March', 'April', 'May'],
    datasets: [
      {
        label: 'Dataset 1',
        data: [15, 25, 18, 30, 22], // dummy data
        backgroundColor: '#9854CB', // purple
      },
      {
        label: 'Dataset 2',
        data: [10, 20, 12, 28, 18], // dummy data
        backgroundColor: '#2C8ABF', // blue
      }
    ]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      y: {
        beginAtZero: true,
        grid: {
          color: 'rgba(255, 255, 255, 0.2)'
        },
        ticks: {
          color: '#fff'
        }
      },
      x: {
        ticks: {
          color: '#fff'
        }
      }
    },
    plugins: {
      legend: {
        labels: {
          color: '#fff'
        }
      }
    }
  }
});


  // Radar Chart
  const ctxRadar = document.getElementById('radarChart').getContext('2d');
  new Chart(ctxRadar, {
    type: 'radar',
    data: {
      labels: ['performance', 'attendace', 'personality', 'topic', 'assignment'],
      datasets: [
            {
            label: 'Person A',
            data: [65, 59, 90, 81, 56, 55, 40],
            fill: true,
            backgroundColor: 'rgba(222, 172, 245, 0.3)', // #DEACF5 with transparency
            borderColor: '#DEACF5',
            pointBackgroundColor: '#DEACF5'
          },
          {
            label: 'Person B',
            data: [28, 48, 40, 19, 96, 27, 100],
            fill: true,
            backgroundColor: 'rgba(159, 209, 232, 0.3)', // #9FD1E8 with transparency
            borderColor: '#9FD1E8',
            pointBackgroundColor: '#9FD1E8'
          }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      elements: {
        line: { borderWidth: 2 }
      }
    }
  });
</script>


          </div>
        </div>
<?php include 'components/footer.php'; ?>
