// Fix for the "btn is null" error
document.addEventListener('DOMContentLoaded', function() {
    // Defensive programming approach - check if element exists before operating on it
    const initializeButtons = function() {
        // Find all buttons that might be initialized
        const actionButtons = document.querySelectorAll('[data-action]');
        
        if (actionButtons.length > 0) {
            actionButtons.forEach(btn => {
                // Safe initialization of buttons
                if (btn) {
                    btn.addEventListener('click', function(e) {
                        const action = this.dataset.action;
                        switch(action) {
                            case 'delete':
                                confirmDelete(this.dataset.url);
                                break;
                            // Add other action cases as needed
                        }
                    });
                }
            });
        }
    };

    // Function to handle delete confirmations
    const confirmDelete = function(url) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    };

    // Initialize Select2 for any select elements with the select2 class
    if ($.fn.select2) {
        .select2({
            theme: 'bootstrap4'
        });
    }

    // Initialize BS Custom File Input for file inputs
    if (typeof bsCustomFileInput !== 'undefined') {
        bsCustomFileInput.init();
    }

    // Initialize AdminLTE components safely
    if (typeof $.fn.Sidebar !== 'undefined') {
        .on('click', function() {
            if (typeof .data('lte.pushmenu') !== 'undefined') {
                .data('lte.pushmenu').toggle();
            }
        });
    }

    // Call the button initialization
    initializeButtons();
});
