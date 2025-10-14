<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../FacultyEvaluationAdmin/assets/css/studentreport.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<?php include 'components/header.php'; ?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Manage Student Reports</h4>
        </div>

<div class="summary-cards">
      <div class="summary-card total">
        <div class="summary-icon total">
          <i class="fas fa-file-alt"></i>
        </div>
        <div class="summary-content">
          <div class="summary-number" id="totalReports">0</div>
          <div class="summary-label">Total Reports</div>
        </div>
      </div>
      
      <div class="summary-card pending">
        <div class="summary-icon pending">
          <i class="fas fa-clock"></i>
        </div>
        <div class="summary-content">
          <div class="summary-number" id="pendingReports">0</div>
          <div class="summary-label">Pending Reports</div>
        </div>
      </div>
      
      <div class="summary-card addressed">
        <div class="summary-icon addressed">
          <i class="fas fa-check-circle"></i>
        </div>
        <div class="summary-content">
          <div class="summary-number" id="addressedReports">0</div>
          <div class="summary-label">Addressed Reports</div>
        </div>
      </div>
      
      <div class="summary-card escalated">
        <div class="summary-icon escalated">
          <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="summary-content">
          <div class="summary-number" id="escalatedReports">0</div>
          <div class="summary-label">Escalated Reports</div>
        </div>
      </div>
    </div>
    
    <!-- Action Buttons -->
    <div class="action-buttons">
      <button class="btn btn-primary" id="addReportBtn">
        <i class="fas fa-plus me-2"></i>Add New Report
      </button>
      <button class="btn btn-outline-secondary" id="exportBtn">
        <i class="fas fa-download me-2"></i>Export Reports
      </button>
      <button class="btn btn-outline-secondary" id="printBtn">
        <i class="fas fa-print me-2"></i>Print Summary
      </button>
      <button class="btn btn-outline-secondary" id="refreshBtn">
        <i class="fas fa-sync-alt me-2"></i>Refresh Data
      </button>
    </div>

    <!-- Filters -->
    <div class="filters">
      <div class="filter-group">
        <label for="statusFilter" class="form-label">Filter by Status</label>
        <select class="form-control" id="statusFilter">
          <option value="all">All Statuses</option>
          <option value="pending">Pending</option>
          <option value="addressed">Addressed</option>
          <option value="escalated">Escalated</option>
        </select>
      </div>
      <div class="filter-group">
        <label for="typeFilter" class="form-label">Filter by Report Type</label>
        <select class="form-control" id="typeFilter">
          <option value="all">All Types</option>
          <option value="Abuse">Abuse</option>
          <option value="Harassment">Harassment</option>
          <option value="Academic">Academic</option>
          <option value="Other">Other</option>
        </select>
      </div>
      <div class="filter-group">
        <label for="dateFilter" class="form-label">Filter by Date</label>
        <input type="date" class="form-control" id="dateFilter">
      </div>
    </div>

    <!-- Reports List -->
    <div class="table-container">
      <div class="table-header">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i> Student Reports</h5>
        <div class="d-flex align-items-center gap-2">
          <div class="input-group input-group-sm">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            <input type="text" id="searchReports" class="form-control search-input" placeholder="Search reports...">
          </div>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-hover mb-0" id="reportsTable">
          <thead>
            <tr>
              <th>Report ID</th>
              <th>Student Number</th>
              <th>Report Type</th>
              <th>Date</th>
              <th>Location</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="reportsTableBody">
            <!-- Reports will be dynamically generated -->
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Report Details Modal -->
  <div class="modal fade" id="reportDetailsModal" tabindex="-1" aria-labelledby="reportDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="reportDetailsModalLabel">
            <i class="fas fa-file-alt me-2"></i>Report Details
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="report-details">
            <div class="detail-row">
              <div class="detail-label">Report ID:</div>
              <div class="detail-value" id="modalReportId"></div>
            </div>
            <div class="detail-row">
              <div class="detail-label">Professor ID:</div>
              <div class="detail-value" id="modalProfessorId"></div>
            </div>
            <div class="detail-row">
              <div class="detail-label">Student Number:</div>
              <div class="detail-value" id="modalStudentNumber"></div>
            </div>
            <div class="detail-row">
              <div class="detail-label">Report Type:</div>
              <div class="detail-value" id="modalReportType"></div>
            </div>
            <div class="detail-row">
              <div class="detail-label">Report Date:</div>
              <div class="detail-value" id="modalReportDate"></div>
            </div>
            <div class="detail-row">
              <div class="detail-label">Location:</div>
              <div class="detail-value" id="modalReportLocation"></div>
            </div>
            <div class="detail-row">
              <div class="detail-label">Status:</div>
              <div class="detail-value" id="modalReportStatus"></div>
            </div>
            <div class="detail-row">
              <div class="detail-label">Report Details:</div>
              <div class="detail-value">
                <div class="report-content" id="modalReportDetails"></div>
              </div>
            </div>
            <div class="detail-row">
              <div class="detail-label">Student Resolution:</div>
              <div class="detail-value">
                <div class="report-content" id="modalStudentResolution"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>Close
          </button>
          <button type="button" class="btn btn-warning" id="updateStatusBtn">
            <i class="fas fa-edit me-1"></i>Update Status
          </button>
          <button type="button" class="btn btn-primary" id="printReportBtn">
            <i class="fas fa-print me-1"></i>Print Report
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Update Status Modal -->
  <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateStatusModalLabel">
            <i class="fas fa-edit me-2"></i>Update Report Status
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="updateStatusForm">
            <div class="mb-3">
              <label for="statusUpdate" class="form-label">Status</label>
              <select class="form-control" id="statusUpdate" required>
                <option value="pending">Pending</option>
                <option value="addressed">Addressed</option>
                <option value="escalated">Escalated</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="statusNotes" class="form-label">Notes (Optional)</label>
              <textarea class="form-control" id="statusNotes" rows="3" placeholder="Add any notes about this status update..."></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>Cancel
          </button>
          <button type="button" class="btn btn-primary" id="saveStatusUpdateBtn">
            <i class="fas fa-save me-1"></i>Save Changes
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Report Modal -->
  <div class="modal fade" id="addReportModal" tabindex="-1" aria-labelledby="addReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addReportModalLabel">
            <i class="fas fa-plus-circle me-2"></i>Add New Report
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addReportForm">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="newStudentNumber" class="form-label">Student Number</label>
                  <input type="text" class="form-control" id="newStudentNumber" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="newProfessorId" class="form-label">Professor ID</label>
                  <input type="text" class="form-control" id="newProfessorId" required>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="newReportType" class="form-label">Report Type</label>
              <select class="form-control" id="newReportType" required>
                <option value="">Select Type</option>
                <option value="Abuse">Abuse</option>
                <option value="Harassment">Harassment</option>
                <option value="Academic">Academic</option>
                <option value="Other">Other</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="newReportDetails" class="form-label">Report Details</label>
              <textarea class="form-control" id="newReportDetails" rows="3" required></textarea>
            </div>
            <div class="mb-3">
              <label for="newStudentResolution" class="form-label">Student Resolution</label>
              <textarea class="form-control" id="newStudentResolution" rows="2"></textarea>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="newReportLocation" class="form-label">Location</label>
                  <input type="text" class="form-control" id="newReportLocation">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="newReportDate" class="form-label">Report Date</label>
                  <input type="date" class="form-control" id="newReportDate">
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>Cancel
          </button>
          <button type="button" class="btn btn-primary" id="saveNewReportBtn">
            <i class="fas fa-save me-1"></i>Save Report
          </button>
        </div> </div> </div> </div> </div> 



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../../FacultyEvaluationAdmin/assets/js/studentreport.js"></script>

<?php include 'components/footer.php'; ?>