$(document).ready(function () {
    // 🟩 Add Section
    $('#addSectionForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: 'Addsection.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        $('#section').val('');
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: response.message,
                        icon: 'error',
                        confirmButtonColor: '#d33'
                    });
                }
            },
            error: function () {
                Swal.fire({
                    title: 'Error!',
                    text: 'Something went wrong while saving the section.',
                    icon: 'error'
                });
            }
        });
    });

    // 🟦 Edit Section
    $(document).on('click', '.edit-btn', function () {
        const id = $(this).data('id');
        const section = $(this).data('section');

        // ✅ Make sure this matches your modal input
        $('#edit_section_id').val(id);
        $('#edit_section').val(section);

        const modal = new bootstrap.Modal($('#editSectionModal')[0]);
        modal.show();
    });

    $('#editSectionForm').on('submit', function (e) {
        e.preventDefault();

        const form = $(this);

        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to save the changes to this section?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, save it!',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'Editsection.php',
                    type: 'POST',
                    data: form.serialize(),
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                confirmButtonColor: '#3085d6'
                            }).then(() => {
                                location.reload();
                            });
                        } else if (response.status === 'warning') {
                            Swal.fire({
                                icon: 'warning',
                                title: 'No Changes',
                                text: response.message
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'An unexpected error occurred while updating the section.'
                        });
                    }
                });
            }
        });
    });

    // 🟥 Delete Section
    $(document).on('click', '.delete-btn', function () {
        const sectionId = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: 'This action will permanently delete the section.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'Deletesection.php',
                    type: 'POST',
                    data: { section_id: sectionId },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message,
                                confirmButtonColor: '#3085d6'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'An unexpected error occurred while deleting the section.'
                        });
                    }
                });
            }
        });
    });

    // 🟨 Search Function
    $('#searchSection').on('keyup', function () {
        const value = $(this).val().toLowerCase();
        $('#sectionTable tbody tr').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});
