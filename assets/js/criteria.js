document.getElementById('addCriteriaForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent default form submission

    const formData = new FormData(this);

    fetch('Addcriteria.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json()) // Expect JSON from PHP
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Added!',
                text: data.message || 'Criteria added successfully.',
                confirmButtonText: 'OK'
            }).then(() => {
                // Optional: reset form or redirect
                this.reset();
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
    const editButtons = document.querySelectorAll(".criteria-action-btn.edit");

    editButtons.forEach(button => {
        button.addEventListener("click", function() {
            const id = this.dataset.id;
            const question = this.dataset.question;
            const max = this.dataset.max;
            const category = this.dataset.category;
            const state = this.dataset.state;
            const type = this.dataset.type;


            document.getElementById("edit_criteria_id").value = id;
            document.getElementById("edit_criteria_question").value = question;
            document.getElementById("edit_max_score").value = max;
            document.getElementById("edit_category").value = category;
            document.getElementById("edit_evaluation_type").value = type;
            document.getElementById("edit_use_state").value = state;
        });
    });
});
