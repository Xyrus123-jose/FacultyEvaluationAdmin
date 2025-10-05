 // Edit Modal
const editButtons = document.querySelectorAll('.edit-btn');
const editModal = new bootstrap.Modal(document.getElementById('editProgramModal'));

editButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.getAttribute('data-id');
        const name = btn.getAttribute('data-name');
        const status = btn.getAttribute('data-status');

        document.getElementById('edit_old_program_id').value = id;
        document.getElementById('edit_program_id').value = id;
        document.getElementById('edit_program_name').value = name;
        document.getElementById('edit_program_status').checked = status == 1;

        editModal.show();
    });
});

// Form submission with SweetAlert confirmation
const editForm = document.getElementById('editProgramForm');
editForm.addEventListener('submit', function(e) {
    e.preventDefault(); // stop default submit

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to save these changes?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, save it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit the form
            editForm.submit();

            // Show success message
            Swal.fire({
                title: 'Saved!',
                text: 'Your changes have been saved.',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });
        }
    });
});


    document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const programId = btn.getAttribute('data-id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete the program!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('Deleteprogram.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'program_id=' + encodeURIComponent(programId)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire('Deleted!', data.message, 'success').then(() => {
                            location.reload(); // refresh page to update table
                        });
                    } else {
                        Swal.fire('Error!', data.message, 'error');
                    }
                })
                .catch(err => {
                    Swal.fire('Error!', 'Something went wrong.', 'error');
                });
            }
        });
    });
});


    const urlParams = new URLSearchParams(window.location.search);
  const msg = urlParams.get('msg');

  if (msg === 'added') {
    Swal.fire({
      icon: 'success',
      title: 'Program Added!',
      text: 'The new program has been successfully added.',
      showConfirmButton: false,
      timer: 2000,
      position: 'center'
    }).then(() => {
      // Remove ?msg=added from URL without reloading
      window.history.replaceState({}, document.title, window.location.pathname);
    });
  }


  
  // Get DOM elements
const searchInput = document.getElementById('searchProgram');
const statusFilter = document.getElementById('statusFilter');

// Function to filter table rows
function filterPrograms() {
    const searchValue = searchInput.value.toLowerCase();
    const statusValue = statusFilter.value;

    const rows = document.querySelectorAll('table tbody tr');

    rows.forEach(row => {
        // Combine all row text content for search
        const rowText = Array.from(row.children)
            .map(cell => cell.textContent.toLowerCase())
            .join(' ');

        const statusSpan = row.children[2].querySelector('span'); // Status span
        const isActive = statusSpan.classList.contains('status-active');
        const isInactive = statusSpan.classList.contains('status-inactive');

        // Check if row matches search and status filter
        const matchesSearch = rowText.includes(searchValue);

        let matchesStatus = true;
        if (statusValue === "1") {
            matchesStatus = isActive;
        } else if (statusValue === "0") {
            matchesStatus = isInactive;
        }

        // Show or hide row
        row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
    });
}

// Event listeners
searchInput.addEventListener('input', filterPrograms);
statusFilter.addEventListener('change', filterPrograms);

