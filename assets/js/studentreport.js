 // Sample data
    const reports = [
      {
        report_id: "r-01",
        professor_id: "p-2022-00001",
        student_number: "22-0011",
        report_type: "Abuse",
        report_details: "Si sir nanakit ng damdamin",
        student_resolution: "I just want an apology",
        report_date: "09/09/20",
        report_location: "QCU SB - ACAD BUILDING",
        report_status: "Addressed"
      },
      {
        report_id: "r-02",
        professor_id: "p-2022-00002",
        student_number: "22-0015",
        report_type: "Harassment",
        report_details: "Professor made inappropriate comments during class",
        student_resolution: "Request for sensitivity training",
        report_date: "09/15/20",
        report_location: "QCU MAIN - ROOM 205",
        report_status: "Pending"
      },
      {
        report_id: "r-03",
        professor_id: "p-2022-00003",
        student_number: "22-0020",
        report_type: "Academic",
        report_details: "Unfair grading practices",
        student_resolution: "Request for grade review",
        report_date: "09/20/20",
        report_location: "QCU SB - FACULTY OFFICE",
        report_status: "Escalated"
      },
      {
        report_id: "r-04",
        professor_id: "p-2022-00001",
        student_number: "22-0033",
        report_type: "Abuse",
        report_details: "Professor used derogatory language",
        student_resolution: "Formal apology required",
        report_date: "09/25/20",
        report_location: "QCU MAIN - LIBRARY",
        report_status: "Pending"
      },
      {
        report_id: "r-05",
        professor_id: "p-2022-00004",
        student_number: "22-0045",
        report_type: "Other",
        report_details: "Issues with course materials accessibility",
        student_resolution: "Request for alternative materials",
        report_date: "10/01/20",
        report_location: "QCU SB - ONLINE",
        report_status: "Addressed"
      }
    ];

    let currentReport = null;
    let filteredReports = [...reports];

    // Initialize modals
    let reportDetailsModal, updateStatusModal, addReportModal;

    document.addEventListener('DOMContentLoaded', function() {
      reportDetailsModal = new bootstrap.Modal(document.getElementById('reportDetailsModal'));
      updateStatusModal = new bootstrap.Modal(document.getElementById('updateStatusModal'));
      addReportModal = new bootstrap.Modal(document.getElementById('addReportModal'));
      
      // Load initial data
      loadReports();
      updateSummaryCards();
      
      // Add event listeners
      document.getElementById('searchReports').addEventListener('input', function(e) {
        filterReports();
      });
      
      document.getElementById('statusFilter').addEventListener('change', function() {
        filterReports();
      });
      
      document.getElementById('typeFilter').addEventListener('change', function() {
        filterReports();
      });
      
      document.getElementById('dateFilter').addEventListener('change', function() {
        filterReports();
      });
      
      document.getElementById('clearFiltersBtn').addEventListener('click', function() {
        clearFilters();
      });
      
      document.getElementById('updateStatusBtn').addEventListener('click', function() {
        openUpdateStatusModal();
      });
      
      document.getElementById('saveStatusUpdateBtn').addEventListener('click', function() {
        saveStatusUpdate();
      });
      
      document.getElementById('addReportBtn').addEventListener('click', function() {
        openAddReportModal();
      });
      
      document.getElementById('saveNewReportBtn').addEventListener('click', function() {
        saveNewReport();
      });
      
      document.getElementById('exportBtn').addEventListener('click', function() {
        exportReports();
      });
      
      document.getElementById('printBtn').addEventListener('click', function() {
        printSummary();
      });
      
      document.getElementById('refreshBtn').addEventListener('click', function() {
        refreshData();
      });
      
      document.getElementById('printReportBtn').addEventListener('click', function() {
        printCurrentReport();
      });
    });

    // Report Management Functions
    function loadReports() {
      const tableBody = document.getElementById('reportsTableBody');
      tableBody.innerHTML = '';

      if (filteredReports.length === 0) {
        tableBody.innerHTML = `
          <tr>
            <td colspan="7" class="text-muted py-4">
              <i class="fas fa-file-alt fa-2x mb-3 d-block"></i>
              No reports found matching your criteria.
            </td>
          </tr>
        `;
        return;
      }

      filteredReports.forEach((report) => {
        const statusClass = getStatusClass(report.report_status);
        const statusText = report.report_status;
        
        const row = document.createElement('tr');
        row.innerHTML = `
          <td class="fw-semibold">${report.report_id}</td>
          <td>${report.student_number}</td>
          <td>${report.report_type}</td>
          <td>${report.report_date}</td>
          <td>${report.report_location}</td>
          <td><span class="status-badge ${statusClass}">${statusText}</span></td>
          <td>
            <div class="actions">
              <button class="btn-view view-report-btn" data-id="${report.report_id}" title="View Details">
                <i class="fas fa-eye"></i>
              </button>
              <button class="btn-edit edit-report-btn" data-id="${report.report_id}" title="Edit Report">
                <i class="fas fa-edit"></i>
              </button>
              <button class="btn-print print-report-btn" data-id="${report.report_id}" title="Print Report">
                <i class="fas fa-print"></i>
              </button>
              <button class="btn-delete delete-report-btn" data-id="${report.report_id}" title="Delete Report">
                <i class="fas fa-trash"></i>
              </button>
            </div>
          </td>
        `;
        tableBody.appendChild(row);
      });

      // Add event listeners
      document.querySelectorAll('.view-report-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
          e.stopPropagation();
          const reportId = e.currentTarget.dataset.id;
          openReportDetailsModal(reportId);
        });
      });
      
      document.querySelectorAll('.edit-report-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
          e.stopPropagation();
          const reportId = e.currentTarget.dataset.id;
          editReport(reportId);
        });
      });
      
      document.querySelectorAll('.print-report-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
          e.stopPropagation();
          const reportId = e.currentTarget.dataset.id;
          printReport(reportId);
        });
      });
      
      document.querySelectorAll('.delete-report-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
          e.stopPropagation();
          const reportId = e.currentTarget.dataset.id;
          deleteReport(reportId);
        });
      });
      
      // Also make entire row clickable
      document.querySelectorAll('tbody tr').forEach(row => {
        row.addEventListener('click', (e) => {
          // Don't trigger if clicking on action buttons
          if (!e.target.closest('.actions')) {
            const reportId = row.querySelector('.view-report-btn').dataset.id;
            openReportDetailsModal(reportId);
          }
        });
      });
    }

    function updateSummaryCards() {
      const total = reports.length;
      const pending = reports.filter(r => r.report_status === 'Pending').length;
      const addressed = reports.filter(r => r.report_status === 'Addressed').length;
      const escalated = reports.filter(r => r.report_status === 'Escalated').length;
      
      document.getElementById('totalReports').textContent = total;
      document.getElementById('pendingReports').textContent = pending;
      document.getElementById('addressedReports').textContent = addressed;
      document.getElementById('escalatedReports').textContent = escalated;
    }

    function filterReports() {
      const searchTerm = document.getElementById('searchReports').value.toLowerCase();
      const statusFilter = document.getElementById('statusFilter').value;
      const typeFilter = document.getElementById('typeFilter').value;
      const dateFilter = document.getElementById('dateFilter').value;
      
      filteredReports = reports.filter(report => {
        // Search filter
        const matchesSearch = 
          report.report_id.toLowerCase().includes(searchTerm) ||
          report.student_number.toLowerCase().includes(searchTerm) ||
          report.report_type.toLowerCase().includes(searchTerm) ||
          report.report_location.toLowerCase().includes(searchTerm);
        
        // Status filter
        const matchesStatus = statusFilter === 'all' || 
          report.report_status.toLowerCase() === statusFilter.toLowerCase();
        
        // Type filter
        const matchesType = typeFilter === 'all' || 
          report.report_type.toLowerCase() === typeFilter.toLowerCase();
        
        // Date filter
        let matchesDate = true;
        if (dateFilter) {
          // Convert report date to comparable format (MM/DD/YY to YYYY-MM-DD)
          const reportDateParts = report.report_date.split('/');
          const reportDateFormatted = `20${reportDateParts[2]}-${reportDateParts[0].padStart(2, '0')}-${reportDateParts[1].padStart(2, '0')}`;
          matchesDate = reportDateFormatted === dateFilter;
        }
        
        return matchesSearch && matchesStatus && matchesType && matchesDate;
      });
      
      loadReports();
    }

    function clearFilters() {
      document.getElementById('searchReports').value = '';
      document.getElementById('statusFilter').value = 'all';
      document.getElementById('typeFilter').value = 'all';
      document.getElementById('dateFilter').value = '';
      filteredReports = [...reports];
      loadReports();
    }

    function getStatusClass(status) {
      switch(status.toLowerCase()) {
        case 'pending': return 'status-pending';
        case 'addressed': return 'status-addressed';
        case 'escalated': return 'status-escalated';
        default: return 'status-pending';
      }
    }

    function openReportDetailsModal(reportId) {
      const report = reports.find(r => r.report_id === reportId);
      if (report) {
        currentReport = report;
        
        document.getElementById('modalReportId').textContent = report.report_id;
        document.getElementById('modalProfessorId').textContent = report.professor_id;
        document.getElementById('modalStudentNumber').textContent = report.student_number;
        document.getElementById('modalReportType').textContent = report.report_type;
        document.getElementById('modalReportDate').textContent = report.report_date;
        document.getElementById('modalReportLocation').textContent = report.report_location;
        document.getElementById('modalReportStatus').innerHTML = `<span class="status-badge ${getStatusClass(report.report_status)}">${report.report_status}</span>`;
        document.getElementById('modalReportDetails').textContent = report.report_details;
        document.getElementById('modalStudentResolution').textContent = report.student_resolution;
        
        reportDetailsModal.show();
      }
    }

    function openUpdateStatusModal() {
      if (currentReport) {
        document.getElementById('statusUpdate').value = currentReport.report_status.toLowerCase();
        document.getElementById('statusNotes').value = '';
        updateStatusModal.show();
      }
    }

    function saveStatusUpdate() {
      if (currentReport) {
        const newStatus = document.getElementById('statusUpdate').value;
        const notes = document.getElementById('statusNotes').value;
        
        // Update the report status
        currentReport.report_status = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
        
        // In a real application, you would save this to a database
        // For now, we'll just update our local data and refresh the display
        
        // Update the reports array
        const reportIndex = reports.findIndex(r => r.report_id === currentReport.report_id);
        if (reportIndex !== -1) {
          reports[reportIndex] = currentReport;
        }
        
        // Refresh the display
        filterReports();
        updateSummaryCards();
        
        // Close modals
        updateStatusModal.hide();
        reportDetailsModal.hide();
        
        // Show success message
        showAlert('Report status updated successfully!', 'success');
      }
    }

    function openAddReportModal() {
      // Set today's date as default
      const today = new Date().toISOString().split('T')[0];
      document.getElementById('newReportDate').value = today;
      
      // Clear form
      document.getElementById('addReportForm').reset();
      
      addReportModal.show();
    }

    function saveNewReport() {
      const studentNumber = document.getElementById('newStudentNumber').value;
      const professorId = document.getElementById('newProfessorId').value;
      const reportType = document.getElementById('newReportType').value;
      const reportDetails = document.getElementById('newReportDetails').value;
      const studentResolution = document.getElementById('newStudentResolution').value;
      const reportLocation = document.getElementById('newReportLocation').value;
      const reportDate = document.getElementById('newReportDate').value;
      
      if (!studentNumber || !professorId || !reportType || !reportDetails) {
        showAlert('Please fill in all required fields!', 'warning');
        return;
      }
      
      // Generate new report ID
      const newReportId = 'r-' + (reports.length + 1).toString().padStart(2, '0');
      
      // Format date if needed
      let formattedDate = reportDate;
      if (reportDate) {
        const dateObj = new Date(reportDate);
        formattedDate = `${(dateObj.getMonth() + 1).toString().padStart(2, '0')}/${dateObj.getDate().toString().padStart(2, '0')}/${dateObj.getFullYear().toString().slice(2)}`;
      }
      
      // Create new report
      const newReport = {
        report_id: newReportId,
        professor_id: professorId,
        student_number: studentNumber,
        report_type: reportType,
        report_details: reportDetails,
        student_resolution: studentResolution,
        report_date: formattedDate,
        report_location: reportLocation,
        report_status: 'Pending'
      };
      
      // Add to reports array
      reports.push(newReport);
      
      // Refresh display
      filterReports();
      updateSummaryCards();
      
      // Close modal
      addReportModal.hide();
      
      // Show success message
      showAlert('New report added successfully!', 'success');
    }

    function editReport(reportId) {
      const report = reports.find(r => r.report_id === reportId);
      if (report) {
        // For now, we'll just open the details modal
        // In a real application, you would open an edit form
        openReportDetailsModal(reportId);
        showAlert('Edit functionality would open here in a real application', 'info');
      }
    }

    function printReport(reportId) {
      const report = reports.find(r => r.report_id === reportId);
      if (report) {
        // In a real application, this would generate a printable report
        showAlert(`Printing report: ${report.report_id}`, 'info');
        
        // For demo purposes, we'll just open the details modal
        openReportDetailsModal(reportId);
      }
    }

    function printCurrentReport() {
      if (currentReport) {
        showAlert(`Printing report: ${currentReport.report_id}`, 'info');
        // In a real application, this would trigger the browser's print dialog
        // window.print();
      }
    }

    function deleteReport(reportId) {
      if (confirm('Are you sure you want to delete this report? This action cannot be undone.')) {
        const reportIndex = reports.findIndex(r => r.report_id === reportId);
        if (reportIndex !== -1) {
          reports.splice(reportIndex, 1);
          filterReports();
          updateSummaryCards();
          showAlert('Report deleted successfully!', 'success');
        }
      }
    }

    function exportReports() {
      // In a real application, this would generate a CSV or Excel file
      showAlert('Exporting reports to CSV file...', 'info');
      
      // Create CSV content
      let csvContent = "Report ID,Student Number,Professor ID,Report Type,Report Details,Student Resolution,Report Date,Location,Status\n";
      
      filteredReports.forEach(report => {
        csvContent += `"${report.report_id}","${report.student_number}","${report.professor_id}","${report.report_type}","${report.report_details}","${report.student_resolution}","${report.report_date}","${report.report_location}","${report.report_status}"\n`;
      });
      
      // Create download link
      const blob = new Blob([csvContent], { type: 'text/csv' });
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = 'student_reports.csv';
      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);
      URL.revokeObjectURL(url);
    }

    function printSummary() {
      showAlert('Opening print preview for summary...', 'info');
      // In a real application, this would trigger the browser's print dialog
      // window.print();
    }

    function refreshData() {
      // In a real application, this would fetch fresh data from the server
      showAlert('Refreshing data from server...', 'info');
      // For demo, we'll just reload the current data
      filterReports();
      updateSummaryCards();
    }

    function showAlert(message, type) {
      // Create alert element
      const alertDiv = document.createElement('div');
      alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
      alertDiv.style.top = '20px';
      alertDiv.style.right = '20px';
      alertDiv.style.zIndex = '9999';
      alertDiv.style.minWidth = '300px';
      alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      `;
      
      // Add to page
      document.body.appendChild(alertDiv);
      
      // Auto remove after 3 seconds
      setTimeout(() => {
        if (alertDiv.parentNode) {
          alertDiv.remove();
        }
      }, 3000);
    }