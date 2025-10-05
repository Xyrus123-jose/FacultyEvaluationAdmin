$('#addAcademicYearForm').on('submit', function(e) {
    e.preventDefault(); // Prevent default form submission

    $.ajax({
        url: 'Addacademicyear.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    location.reload(); // Reload page or table
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: response.message
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!'
            });
        }
    });
});

document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', () => {
        const id = button.getAttribute('data-id');
        const start = button.getAttribute('data-start');
        const end = button.getAttribute('data-end');
        const semester = button.getAttribute('data-semester');
        const status = button.getAttribute('data-status');

        // Fill the modal fields
        document.getElementById('edit_academic_year_id').value = id;
        document.getElementById('edit_academic_year_start').value = start;
        document.getElementById('edit_academic_year_end').value = end;
        document.getElementById('edit_semester').value = semester;
        document.getElementById('edit_status').value = status;

        // Show the modal
        const editModal = new bootstrap.Modal(document.getElementById('editAcademicYearModal'));
        editModal.show();
    });
});
$('#editAcademicYearForm').on('submit', function(e) {
    e.preventDefault(); // prevent default form submission

    // Show SweetAlert confirmation
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to update this academic year?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, update it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // If confirmed, send AJAX request to your PHP script
            $.ajax({
                url: 'Editacademicyear.php',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload(); // reload table after update
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!'
                    });
                }
            });
        }
    });
});


// Delete Academic Year
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.getAttribute('data-id'); // get academic_year_id

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
                $.ajax({
                    url: 'Deleteacadyear.php',
                    type: 'POST',
                    data: { academic_year_id: id },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload(); // reload table
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!'
                        });
                    }
                });
            }
        });
    });
});


$(document).ready(function() {
    function filterTable() {
        const startYear = $('#filterStartYear').val();
        const endYear = $('#filterEndYear').val();

        $('#academicYearTable tbody tr').each(function() {
            const rowStart = $(this).find('td:eq(1)').text(); // Start Year column
            const rowEnd = $(this).find('td:eq(2)').text();   // End Year column

            // Show row if it matches filters or if filter is empty
            const showRow =
                (startYear === "" || rowStart === startYear) &&
                (endYear === "" || rowEnd === endYear);

            $(this).toggle(showRow);
        });
    }

    // Run filter when dropdowns change
    $('#filterStartYear, #filterEndYear').on('change', filterTable);
});
