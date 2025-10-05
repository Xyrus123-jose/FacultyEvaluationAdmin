
function previewFile(event) {
  const reader = new FileReader();
  reader.onload = function(){
    document.getElementById('previewImage').src = reader.result;
  };
  reader.readAsDataURL(event.target.files[0]);
}



document.addEventListener('DOMContentLoaded', function() {
    const archiveButtons = document.querySelectorAll('.archive-btn');

    archiveButtons.forEach(button => {
        button.addEventListener('click', function() {
            const studentId = this.getAttribute('data-id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This student will be archived!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, archive it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to archive page
                    window.location.href = 'archive_student.php?id=' + studentId;
                }
            });
        });
    });
});


