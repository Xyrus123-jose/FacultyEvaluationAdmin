document.getElementById('addCriteriaForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent normal form submission

    const formData = new FormData(this);

    fetch('Addcriteria.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Added!',
                text: data.message || 'Criteria added successfully.',
                confirmButtonText: 'OK'
            }).then(() => {
                // ✅ Reload the page after success
                window.location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Something went wrong!',
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Unable to submit form. Please try again later.'
        });
    });
});

document.addEventListener("DOMContentLoaded", function() {
  var editModalEl = document.getElementById('editCriteriaModal');
  if (!editModalEl) return;

  // --- When opening modal ---
  editModalEl.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;

    // Get data from button
    var id = button.getAttribute('data-id') || '';
    var question = button.getAttribute('data-question') || '';
    var max = button.getAttribute('data-max') || '';
    var category = button.getAttribute('data-category') || '';
    var use_state = button.getAttribute('data-use_state') || '';

    // Populate modal fields
    document.getElementById('edit_criteria_id').value = id;
    document.getElementById('edit_criteria_question').value = question;
    document.getElementById('edit_max_score').value = max;
    document.getElementById('edit_category').value = category;
    document.getElementById('edit_use_state').value = use_state;
  });

  // --- Handle form submission ---
  var editForm = document.getElementById('editCriteriaForm');
  if (editForm) {
    editForm.addEventListener('submit', function(e) {
      e.preventDefault();

      // SweetAlert confirmation
      Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to save the changes to this criterion?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, save it!',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          // Proceed with AJAX submit
          var formData = new FormData(editForm);

          fetch(editForm.action, { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
              if (data.status === 'success') {
                Swal.fire({
                  icon: 'success',
                  title: 'Updated!',
                  text: data.message || 'Criteria updated successfully.',
                  confirmButtonColor: '#3085d6'
                }).then(() => {
                  var modalInstance = bootstrap.Modal.getInstance(editModalEl);
                  if (modalInstance) modalInstance.hide();
                  location.reload();
                });
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Error!',
                  text: data.message || 'Update failed.',
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
  }
});


document.addEventListener('DOMContentLoaded', function() {
  // Listen for delete button clicks
  document.querySelectorAll('.criteria-action-btn.delete').forEach(button => {
    button.addEventListener('click', function() {
      const criteriaId = this.getAttribute('data-id');

      Swal.fire({
        title: 'Are you sure?',
        text: "This action will permanently delete the selected criterion.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          // Send delete request to PHP
          fetch('Deletecriteria.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `criteria_id=${criteriaId}`
          })
          .then(res => res.json())
          .then(data => {
            if (data.status === 'success') {
              Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: data.message || 'Criterion deleted successfully.',
                confirmButtonColor: '#3085d6'
              }).then(() => {
                location.reload(); // refresh the table or page
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: data.message || 'Unable to delete criterion.',
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
});
