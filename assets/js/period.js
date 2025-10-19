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
            
            
            
        });