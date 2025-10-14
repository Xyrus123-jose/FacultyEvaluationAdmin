
$(document).ready(function () {

    // ==========================
    // ADD Academic Year
    // ==========================
    $('#addAcademicYearForm').on('submit', function(e) {
        e.preventDefault();

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
                    }).then(() => location.reload());
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

    // ==========================
    // EDIT Academic Year
    // ==========================
    const editModal = new bootstrap.Modal(document.getElementById('editAcademicYearModal'));

    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-id');
            const start = btn.getAttribute('data-start');
            const end = btn.getAttribute('data-end');
            const semester = btn.getAttribute('data-semester');
            const status = btn.getAttribute('data-status');

            $('#edit_academic_year_id').val(id);
            $('#edit_academic_year_start').val(start);
            $('#edit_academic_year_end').val(end);
            $('#edit_semester').val(semester);
            $('#edit_status').val(status);

            editModal.show();
        });
    });

    $('#editAcademicYearForm').on('submit', function(e) {
        e.preventDefault();

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
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => location.reload());
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

    // ==========================
    // DELETE Academic Year
    // ==========================
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');

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
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => location.reload());
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

    // ==========================
    // FILTER Academic Years
    // ==========================
    function filterTable() {
        const startYear = $('#filterStartYear').val();
        const endYear = $('#filterEndYear').val();

        $('#academicYearTable tbody tr').each(function() {
            const rowStart = $(this).find('td:eq(1)').text();
            const rowEnd = $(this).find('td:eq(2)').text();

            const showRow =
                (startYear === "" || rowStart === startYear) &&
                (endYear === "" || rowEnd === endYear);

            $(this).toggle(showRow);
        });
    }

    $('#filterStartYear, #filterEndYear').on('change', filterTable);
});