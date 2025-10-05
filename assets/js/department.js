document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('addDepartmentForm');

    form.addEventListener('submit', function (e) {
        e.preventDefault(); // prevent default form submission

        const formData = new FormData(form);

        fetch('Adddepartment.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            Swal.fire({
                icon: data.status === 'success' ? 'success' : 'error',
                title: data.status === 'success' ? 'Success!' : 'Error!',
                text: data.message,
                confirmButtonText: 'OK'
            }).then((result) => {
                if (data.status === 'success' && result.isConfirmed) {
                    window.location.reload(); // reload the page to update list
                }
            });
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'An unexpected error occurred.',
                confirmButtonText: 'OK'
            });
            console.error(error);
        });
    });
});

 document.addEventListener('DOMContentLoaded', function () {
    // Bootstrap modal instance
    var editModal = new bootstrap.Modal(document.getElementById('editDepartmentModal'));

    // All edit buttons
    document.querySelectorAll('.edit-dept-btn').forEach(button => {
        button.addEventListener('click', function () {
            // Get data attributes
            const id = this.dataset.id;
            const name = this.dataset.name;
            const program = this.dataset.program;
            const head = this.dataset.head;
            const office = this.dataset.office;

            // Fill modal form fields
            document.getElementById('edit_department_id').value = id;
            document.getElementById('edit_department_name').value = name;
            document.getElementById('edit_college_program').value = program;
            document.getElementById('edit_department_head').value = head;
            document.getElementById('edit_office_location').value = office;

            // Show modal
            editModal.show();
        });
    });
});
document.getElementById('editDepartmentForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('Editdepartment.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        Swal.fire({
            icon: data.status,
            title: data.message
        }).then(() => location.reload());
    })
    .catch(err => console.error(err));
});

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-dept-btn').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.id;

            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request to delete
                    fetch('Deletedepartment.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `department_id=${id}`
                    })
                    .then(res => res.json())
                    .then(data => {
                        Swal.fire({
                            icon: data.status,
                            title: data.message
                        }).then(() => location.reload()); // Reload table
                    })
                    .catch(err => console.error(err));
                }
            });
        });
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchDepartment');
    const statusFilter = document.getElementById('statusFilterDepartment');
    const tableBody = document.getElementById('departmentTableBody');

    function filterDepartments() {
        const searchText = searchInput.value.toLowerCase();
        const status = statusFilter.value;

        tableBody.querySelectorAll('tr').forEach(row => {
            const rowText = row.textContent.toLowerCase();
            const rowStatus = row.dataset.status;

            const matchesSearch = rowText.includes(searchText);
            const matchesStatus = status === '' || rowStatus === status;

            if (matchesSearch && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterDepartments);
    statusFilter.addEventListener('change', filterDepartments);
});
// Get elements
const searchInput = document.getElementById('searchDepartment');
const departmentFilter = document.getElementById('departmentNameFilter');
const tableBody = document.getElementById('departmentTableBody');

// Function to filter table
function filterDepartments() {
    const searchValue = searchInput.value.toLowerCase();
    const filterValue = departmentFilter.value.toLowerCase();

    const rows = tableBody.querySelectorAll('tr');
    rows.forEach(row => {
        const deptName = row.cells[1].textContent.toLowerCase();
        const program = row.cells[2].textContent.toLowerCase();
        const head = row.cells[3].textContent.toLowerCase();
        const office = row.cells[4].textContent.toLowerCase();

        const matchesSearch = deptName.includes(searchValue) || program.includes(searchValue) || head.includes(searchValue) || office.includes(searchValue);
        const matchesFilter = filterValue === "" || deptName === filterValue;

        if (matchesSearch && matchesFilter) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Event listeners
searchInput.addEventListener('input', filterDepartments);
departmentFilter.addEventListener('change', filterDepartments);

