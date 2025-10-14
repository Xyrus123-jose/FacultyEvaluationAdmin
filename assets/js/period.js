     // Minimal JavaScript for basic functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Tab functionality
            document.querySelectorAll('.tab').forEach(tab => {
                tab.addEventListener('click', () => {
                    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                    document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                    
                    tab.classList.add('active');
                    const tabId = tab.getAttribute('data-tab');
                    document.getElementById(`${tabId}-content`).classList.add('active');
                });
            });
            
            // File input functionality
            const fileInput = document.getElementById('csv-file');
            const fileName = document.getElementById('file-name');
            
            fileInput.addEventListener('change', (e) => {
                if (e.target.files.length > 0) {
                    fileName.textContent = e.target.files[0].name;
                    alert('CSV file imported successfully! Student data has been updated.');
                } else {
                    fileName.textContent = 'No file selected';
                }
            });
            
            // Filter button functionality
            document.querySelector('.btn-primary').addEventListener('click', () => {
                alert('Filters applied! Student list updated.');
            });
            
            // Send reminders button functionality
            document.getElementById('send-reminders-btn').addEventListener('click', () => {
                alert('Reminders sent successfully to all scheduled students!');
            });
            
            // Modal functionality
            const periodModal = document.getElementById('period-modal');
            const addPeriodBtn = document.getElementById('add-period-btn');
            const closeModal = document.querySelector('.close');
            const cancelPeriodBtn = document.getElementById('cancel-period-btn');
            
            addPeriodBtn.addEventListener('click', () => {
                periodModal.style.display = 'flex';
            });
            
            closeModal.addEventListener('click', () => {
                periodModal.style.display = 'none';
            });
            
            cancelPeriodBtn.addEventListener('click', () => {
                periodModal.style.display = 'none';
            });
            
            // Close modal when clicking outside
            window.addEventListener('click', (e) => {
                if (e.target === periodModal) {
                    periodModal.style.display = 'none';
                }
            });
            
            // Send reminder functionality
            document.querySelectorAll('.send-reminder').forEach(btn => {
                btn.addEventListener('click', function() {
                    const studentId = this.getAttribute('data-student-id');
                    alert(`Reminder email sent to student ${studentId}`);
                });
            });
            
            // Edit and delete period buttons
            document.querySelectorAll('.edit-period').forEach(btn => {
                btn.addEventListener('click', function() {
                    const periodId = this.getAttribute('data-id');
                    alert(`Editing evaluation period with ID: ${periodId}`);
                });
            });
            
            document.querySelectorAll('.delete-period').forEach(btn => {
                btn.addEventListener('click', function() {
                    const periodId = this.getAttribute('data-id');
                    if (confirm('Are you sure you want to delete this evaluation period?')) {
                        alert(`Evaluation period with ID: ${periodId} deleted successfully`);
                    }
                });
            });
        });