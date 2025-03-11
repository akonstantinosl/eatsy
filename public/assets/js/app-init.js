/**
 * Custom initialization script for Eatsy application
 * Ensures proper component loading sequence and handles debugging tools
 */
document.addEventListener('DOMContentLoaded', function() {
    // Initialize any custom components
    initializeComponents();
    
    // Fix for debugbar initialization
    fixDebugBarInit();
    
    // Initialize SweetAlert hooks
    initializeSweetAlertHooks();
});

/**
 * Initialize application components
 */
function initializeComponents() {
    // Safely initialize Bootstrap components
    if (typeof $.fn.tooltip !== 'undefined') {
        $('[data-toggle="tooltip"]').tooltip();
    }
    
    // Initialize custom file inputs if present
    if (typeof bsCustomFileInput !== 'undefined') {
        bsCustomFileInput.init();
    }
    
    // Other component initializations
    console.log('Application components initialized successfully');
}

/**
 * Fix for debugbar initialization issues
 */
function fixDebugBarInit() {
    // Safely check for debugbar elements
    if (document.querySelector('#toolbarContainer')) {
        // Add a small delay to ensure the DOM is fully processed
        setTimeout(function() {
            // Patch for btn is null error
            var debugbarBtn = document.querySelector('#debug-icon');
            if (debugbarBtn) {
                // Ensure event handlers are properly set
                debugbarBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    var debugbar = document.querySelector('#debug-bar');
                    if (debugbar) {
                        debugbar.classList.toggle('minimized');
                    }
                });
            }
        }, 100);
    }
}

/**
 * Initialize SweetAlert hooks for form validations and responses
 */
function initializeSweetAlertHooks() {
    if (typeof Swal !== 'undefined') {
        // Add global SweetAlert configuration
        Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false
        });
        
        // Hook into form submissions if needed
        var forms = document.querySelectorAll('form');
        forms.forEach(function(form) {
            // Add your custom form handling logic here if needed
        });
    }
}
