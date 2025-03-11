/**
 * Debug Bar Initialization Fix
 * Addresses initialization race conditions in CI4 Debug Bar
 */
(function() {
    // Execute after a slight delay to ensure DOM is ready
    window.addEventListener('load', function() {
        setTimeout(function() {
            // Find all debug toolbar buttons
            var debugButtons = document.querySelectorAll('[data-toggle="debug"]');
            
            // Re-apply event handlers
            if (debugButtons.length) {
                debugButtons.forEach(function(btn) {
                    // Remove existing handlers to avoid duplicates
                    btn.removeEventListener('click', debugClickHandler);
                    // Add fresh handler
                    btn.addEventListener('click', debugClickHandler);
                });
                console.log('Debug toolbar handlers reinitialized');
            }
        }, 200);
    });
    
    // Handler function for debug toolbar buttons
    function debugClickHandler(e) {
        e.preventDefault();
        var target = this.getAttribute('data-target') || '#debug-bar';
        var debugbar = document.querySelector(target);
        if (debugbar) {
            debugbar.classList.toggle('minimized');
        }
    }
})();
