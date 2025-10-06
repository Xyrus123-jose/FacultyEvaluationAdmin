document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".edit-btn").forEach(button => {
        button.addEventListener("click", function () {
            const id = this.dataset.id;
            const name = this.dataset.category;
            const status = this.dataset.status;

            document.getElementById("edit_old_category_id").value = id;
            document.getElementById("edit_evaluation_category").value = name;
            document.getElementById("edit_status").value = status == 1 ? "1" : "0";

            const modal = new bootstrap.Modal(document.getElementById("editCategoryModal"));
            modal.show();
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // Parse URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get("status");

    if (status === "success") {
        Swal.fire({
            icon: "success",
            title: "Category Added!",
            text: "The category has been added successfully.",
            showConfirmButton: false,
            timer: 2000
        });
    } 
    else if (status === "error") {
        Swal.fire({
            icon: "error",
            title: "Error!",
            text: "Something went wrong while adding the category."
        });
    } 
    else if (status === "incomplete") {
        Swal.fire({
            icon: "warning",
            title: "Incomplete Data",
            text: "Please fill out all required fields."
        });
    }

    // Clean up the URL (remove ?status=...)
    if (status) {
        const newUrl = window.location.pathname;
        window.history.replaceState({}, document.title, newUrl);
    }
});


document.getElementById('editCategoryForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Stop normal form submission

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to save these changes?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, save it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Send data via AJAX
            const form = document.getElementById('editCategoryForm');
            const formData = new FormData(form);

            fetch('Editcategory.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: data.message,
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        // Close modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editCategoryModal'));
                        modal.hide();

                        // Reload or refresh your table data here
                        location.reload(); // Replace this with your own table refresh function if needed
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Update Failed',
                        text: data.message,
                        confirmButtonColor: '#3085d6'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred.',
                    confirmButtonColor: '#3085d6'
                });
                console.error(error);
            });
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-btn');

    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const categoryId = this.dataset.id; // get the category id

            Swal.fire({
                title: 'Are you sure?',
                text: "This will permanently delete the category!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request to delete
                    fetch('Deletecategory.php', {
                        method: 'POST',
                        body: new URLSearchParams({ category_id: categoryId })
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
                                // Option 1: Reload page
                                window.location.reload();

                                // Option 2: Or dynamically remove the deleted row without reloading
                                // const row = btn.closest('tr');
                                // row.remove();
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
    const searchInput = document.getElementById('searchCategory');
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