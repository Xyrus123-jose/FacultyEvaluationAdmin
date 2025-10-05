document.getElementById('addPeriodBtn').addEventListener('click', function() {
    const modal = new bootstrap.Modal(document.getElementById('addPeriodModal'));
    modal.show();
});

const academicYear = document.getElementById('academicYear');
const startDate = document.getElementById('startDate');
const endDate = document.getElementById('endDate');

function updateDateLimits() {
    const selectedOption = academicYear.options[academicYear.selectedIndex];
    let start = selectedOption.getAttribute('data-start');
    let endYear = selectedOption.text.split(' - ')[1];
    let end = endYear + '-12-31';
    start = new Date(start).toISOString().split('T')[0];
    end = new Date(end).toISOString().split('T')[0];
    startDate.min = start;
    startDate.max = end;
    endDate.min = start;
    endDate.max = end;
    if (startDate.value < start || startDate.value > end) startDate.value = start;
    if (endDate.value < start || endDate.value > end) endDate.value = end;
}

academicYear.addEventListener('change', updateDateLimits);
window.addEventListener('DOMContentLoaded', updateDateLimits);

const timeStart = document.getElementById('timeStart');
const timeEnd = document.getElementById('timeEnd');

timeStart.addEventListener('change', () => {
    const startValue = timeStart.value;
    const options = timeEnd.querySelectorAll('option');
    timeEnd.disabled = false;
    options.forEach(option => {
        if(option.value !== "") {
            let startTime = new Date("1970-01-01 " + startValue);
            let endTime = new Date("1970-01-01 " + option.value);
            option.disabled = endTime <= startTime;
        }
    });
    timeEnd.value = "";
});


// EDIT MODAL FUNCTIONALITY
document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function() {
        const periodId = this.getAttribute('data-id');
        const academicYear = this.getAttribute('data-academic-year');
        const startDateVal = this.getAttribute('data-start-date');
        const endDateVal = this.getAttribute('data-end-date');
        const program = this.getAttribute('data-program');
        const yearLevel = this.getAttribute('data-year-level');
        const section = this.getAttribute('data-section');
        const timeStart = this.getAttribute('data-time-start');
        const timeEnd = this.getAttribute('data-time-end');

        // Set values to the edit modal
        document.getElementById('editPeriodId').value = periodId;
        document.getElementById('editAcademicYear').value = academicYear;
        document.getElementById('editStartDate').value = startDateVal;
        document.getElementById('editEndDate').value = endDateVal;
        document.getElementById('editProgram').value = getProgramIdByName(program); // helper function below
        document.getElementById('editYearLevel').value = getYearLevelIdByLabel(yearLevel); // helper function below
        document.getElementById('editSection').value = getSectionIdByName(section); // helper function below
        document.getElementById('editTimeStart').value = timeStart;
        document.getElementById('editTimeEnd').value = timeEnd;

        // Show the modal
        const editModal = new bootstrap.Modal(document.getElementById('editPeriodModal'));
        editModal.show();
    });
});

// Optional helper functions if your form uses IDs for selects
function getProgramIdByName(name) {
    const options = document.querySelectorAll('#editProgram option');
    for (let option of options) {
        if (option.text === name) return option.value;
    }
    return '';
}

function getYearLevelIdByLabel(label) {
    const options = document.querySelectorAll('#editYearLevel option');
    for (let option of options) {
        if (option.text === label) return option.value;
    }
    return '';
}

function getSectionIdByName(name) {
    const options = document.querySelectorAll('#editSection option');
    for (let option of options) {
        if (option.text === name) return option.value;
    }
    return '';
}

// /assets/js/evalperiod.js

document.addEventListener('DOMContentLoaded', function() {
    // Show Add Modal
    const addBtn = document.getElementById('addPeriodBtn');
    const addModal = new bootstrap.Modal(document.getElementById('addPeriodModal'));
    addBtn.addEventListener('click', () => addModal.show());

    // Edit Evaluation Period
    const editButtons = document.querySelectorAll('.edit-btn');
    const editModal = new bootstrap.Modal(document.getElementById('editPeriodModal'));

    editButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Populate modal fields
            document.getElementById('edit_period_id').value = button.dataset.id;
            document.getElementById('edit_academic_year').value = button.dataset.academicYear;
            document.getElementById('edit_program').value = button.dataset.program;
            document.getElementById('edit_year_level').value = button.dataset.yearLevel;
            document.getElementById('edit_section').value = button.dataset.section;
            document.getElementById('edit_start_date').value = button.dataset.startDate;
            document.getElementById('edit_end_date').value = button.dataset.endDate;
            document.getElementById('edit_time_start').value = button.dataset.timeStart;
            document.getElementById('edit_time_end').value = button.dataset.timeEnd;

            editModal.show();
        });
    });

    // Submit Edit Form
    const editForm = document.getElementById('editPeriodForm');
    editForm.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to save the changes to this period?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData(editForm);

                fetch('Editperiod.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: data.message,
                            confirmButtonColor: '#3085d6'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message,
                            confirmButtonColor: '#d33'
                        });
                    }
                })
                .catch(err => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'An unexpected error occurred.',
                        confirmButtonColor: '#d33'
                    });
                    console.error(err);
                });
            }
        });
    });

    // Optional: Handle start/end date limits like your add modal
    const academicYear = document.getElementById('edit_academic_year');
    const startDate = document.getElementById('edit_start_date');
    const endDate = document.getElementById('edit_end_date');

    function updateDateLimits() {
        const selectedOption = academicYear.options[academicYear.selectedIndex];
        const start = selectedOption.getAttribute('data-start');
        const endYear = selectedOption.text.split(' - ')[1];
        const end = endYear + '-12-31';
        startDate.min = start;
        startDate.max = end;
        endDate.min = start;
        endDate.max = end;
        if (startDate.value < start || startDate.value > end) startDate.value = start;
        if (endDate.value < start || endDate.value > end) endDate.value = end;
    }

    academicYear.addEventListener('change', updateDateLimits);
});

document.getElementById('addPeriodForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const formData = new FormData(form);

    fetch('Addperiod.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Added!',
                    text: data.message,
                    confirmButtonColor: '#3085d6'
                }).then(() => {
                    window.location.reload(); // refresh table
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: data.message,
                    confirmButtonColor: '#d33'
                });
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'An unexpected error occurred.',
                confirmButtonColor: '#d33'
            });
        });
});

document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', () => {
        const periodId = button.getAttribute('data-id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('period_id', periodId);

                fetch('Deleteperiod.php', { method: 'POST', body: formData })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: data.message,
                                confirmButtonColor: '#3085d6'
                            }).then(() => window.location.reload());
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: data.message,
                                confirmButtonColor: '#d33'
                            });
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'An unexpected error occurred.',
                            confirmButtonColor: '#d33'
                        });
                    });
            }
        });
    });
});


document.addEventListener('DOMContentLoaded', () => {
    const table = document.getElementById('evaluationPeriodTable').querySelector('tbody');
    const rows = Array.from(table.querySelectorAll('tr'));
    const info = document.querySelector('.pagination-info');
    const pagination = document.querySelector('.pagination');
    const rowsPerPage = 5;
    let currentPage = 1;

    // Filter elements
    const filters = {
        academicYear: document.getElementById('academicYearFilter'),
        program: document.getElementById('programFilter'),
        yearLevel: document.getElementById('yearLevelFilter'),
        status: document.getElementById('statusFilter')
    };

    function filterRows() {
        return rows.filter(row => {
            const cells = row.children;
            const academicYear = cells[1].textContent.trim();
            const program = cells[4].textContent.trim();
            const yearLevel = cells[5].textContent.trim();
            const status = cells[8]?.textContent.trim() || 'Active'; // adjust if status column exists

            return (!filters.academicYear.value || academicYear === filters.academicYear.value) &&
                   (!filters.program.value || program === filters.program.value) &&
                   (!filters.yearLevel.value || yearLevel === filters.yearLevel.value) &&
                   (!filters.status.value || status === filters.status.value);
        });
    }

    function renderPagination(filteredRows) {
        const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
        const paginationList = pagination.querySelector('ul');
        paginationList.innerHTML = '';

        // Previous button
        const prevLi = document.createElement('li');
        prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
        prevLi.innerHTML = `<a class="page-link" href="#">Previous</a>`;
        prevLi.addEventListener('click', e => {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                updateTable();
            }
        });
        paginationList.appendChild(prevLi);

        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
            const li = document.createElement('li');
            li.className = `page-item ${i === currentPage ? 'active' : ''}`;
            li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            li.addEventListener('click', e => {
                e.preventDefault();
                currentPage = i;
                updateTable();
            });
            paginationList.appendChild(li);
        }

        // Next button
        const nextLi = document.createElement('li');
        nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
        nextLi.innerHTML = `<a class="page-link" href="#">Next</a>`;
        nextLi.addEventListener('click', e => {
            e.preventDefault();
            if (currentPage < totalPages) {
                currentPage++;
                updateTable();
            }
        });
        paginationList.appendChild(nextLi);
    }

    function updateTable() {
        const filteredRows = filterRows();
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        rows.forEach(row => row.style.display = 'none');
        filteredRows.slice(start, end).forEach(row => row.style.display = '');

        info.textContent = filteredRows.length > 0 
            ? `Showing ${start + 1} to ${Math.min(end, filteredRows.length)} of ${filteredRows.length} entries` 
            : 'No entries found';

        renderPagination(filteredRows);
    }

    // Attach filter event listeners
    Object.values(filters).forEach(filter => {
        filter.addEventListener('change', () => {
            currentPage = 1; // reset to first page
            updateTable();
        });
    });

    // Initial table render
    updateTable();
});
