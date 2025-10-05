document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.edit-branch-btn');
    
    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const branchId = this.getAttribute('data-id');
            const branchName = this.getAttribute('data-name');
            const branchAbbreviation = this.getAttribute('data-abbreviation');

            document.getElementById('edit_branch_id').value = branchId;
            document.getElementById('edit_branch_name').value = branchName;
            document.getElementById('edit_branch_abbreviation').value = branchAbbreviation;

            // Show modal (Bootstrap 5)
            const editModal = new bootstrap.Modal(document.getElementById('editBranchModal'));
            editModal.show();
        });
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const editForm = document.getElementById('editBranchForm');

    if (!editForm) return; // safety check

    editForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default form submit

        // Show confirmation before submitting
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to save the changes to this branch?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit via AJAX
                const formData = new FormData(editForm);

                fetch('Editbranch.php', {
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
                            window.location.reload(); // Refresh table or page
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
    const deleteButtons = document.querySelectorAll('.delete-branch-btn');

    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const branchId = this.getAttribute('data-id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This will permanently delete the branch!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request to delete
                    fetch('Deletebranch.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `branch_id=${branchId}`
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
                                window.location.reload(); // Refresh table
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
});

document.addEventListener('DOMContentLoaded', function() {
    const addForm = document.getElementById('addBranchForm');

    if (!addForm) return;

    addForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default form submit

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to add this branch?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, add it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData(addForm);

                fetch('Addbranch.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Added!',
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
});

const branchInput = document.getElementById('branch_abbreviation');
    branchInput.addEventListener('input', () => {
        branchInput.value = branchInput.value.toUpperCase();
    });
    