// Get status and message from URL
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    const message = urlParams.get('message');

    if (status && message) {
        Swal.fire({
            icon: status === 'success' ? 'success' : 'error',
            title: status === 'success' ? 'Success' : 'Error',
            text: decodeURIComponent(message),
            confirmButtonColor: '#3085d6',
        }).then(() => {
            // Remove query params from URL without reloading
            const url = window.location.href.split('?')[0];
            window.history.replaceState({}, document.title, url);
        });
    }

    const editButtons = document.querySelectorAll('.edit-btn');
const editModal = new bootstrap.Modal(document.getElementById('editYearLevelModal'));

editButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.getAttribute('data-id');
        const year_level = btn.getAttribute('data-year_level');
        const year_level_label = btn.getAttribute('data-year_level_label');

        document.getElementById('edit_old_year_level_id').value = id;
        document.getElementById('edit_year_level_id').value = id;
        document.getElementById('edit_year_level').value = year_level;
        document.getElementById('edit_year_level_label').value = year_level_label;

        editModal.show();
    });
});

// Edit form submission with SweetAlert confirmation
const editForm = document.getElementById('editYearLevelForm');
editForm.addEventListener('submit', function(e) {
    e.preventDefault();

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to save these changes?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, save it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            editForm.submit(); // submit the form normally
        }
    });
});

const deleteButtons = document.querySelectorAll('.delete-btn');

deleteButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.getAttribute('data-id');
        const name = btn.getAttribute('data-name');

        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to delete "${name}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to PHP delete script
                window.location.href = `DeleteYearLevel.php?id=${id}`;
            }
        });
    });
});

document.getElementById('refreshTable').addEventListener('click', () => {
    // refresh table logic here
    console.log('Refresh clicked!');
});

