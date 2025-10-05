document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('addSubjectForm');

    form.addEventListener('submit', function (e) {
        e.preventDefault(); // prevent default form submission

        const formData = new FormData(form);

        fetch('Addsubject.php', {
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
                    window.location.href = 'subject.php';
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


// /assets/js/subject.js

document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.edit-btn');
    const editModal = new bootstrap.Modal(document.getElementById('editSubjectModal'));
    
    editButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Fill modal fields with the button's data attributes
            document.getElementById('edit_old_subject_id').value = button.getAttribute('data-id');
            document.getElementById('edit_subject_code').value = button.getAttribute('data-code');
            document.getElementById('edit_subject_title').value = button.getAttribute('data-title');
            document.getElementById('edit_units').value = button.getAttribute('data-units');
            document.getElementById('edit_program_id').value = button.getAttribute('data-program');
            document.getElementById('edit_year_level_id').value = button.getAttribute('data-year');

            // If needed, set status checkbox
            const statusCheckbox = document.getElementById('edit_subject_status');
            // Here, you can add a data-status attribute if you store active/inactive in DB
            // Example: button.dataset.status == 1 ? statusCheckbox.checked = true : statusCheckbox.checked = false;

            // Show the modal
            editModal.show();
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const editForm = document.getElementById('editSubjectForm');

    editForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default form submit

        // Show confirmation before submitting
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to save the changes to this subject?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, submit via AJAX
                const formData = new FormData(editForm);

                fetch('Editsubject.php', {
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
                            window.location.reload(); // Refresh or update table dynamically
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
});

document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-btn');

    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const subjectId = this.dataset.id;

            Swal.fire({
                title: 'Are you sure?',
                text: "This will permanently delete the subject!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request to delete
                    fetch('DeleteSubject.php', {
                        method: 'POST',
                        body: new URLSearchParams({ subject_id: subjectId })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: data.message,
                                confirmButtonColor: '#3085d6'
                            }).then(() => {
                                window.location.reload(); // Or remove the row dynamically
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
                            text: 'Unexpected error occurred.',
                            confirmButtonColor: '#d33'
                        });
                        console.error(err);
                    });
                }
            });
        });
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchProgram');
    const table = document.querySelector('table'); // Assumes one table
    const rows = table.querySelectorAll('tbody tr');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();

        rows.forEach(row => {
            // Check if any cell in this row contains the search term
            const match = Array.from(row.cells).some(cell => 
                cell.textContent.toLowerCase().includes(searchTerm)
            );

            row.style.display = match ? '' : 'none';
        });
    });
});
