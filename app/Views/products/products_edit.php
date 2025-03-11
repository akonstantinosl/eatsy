<?= $this->extend('layout_admin') ?>

<?= $this->section('styles') ?>
<!-- Product Edit Interface Styling -->
<style>
    /* Core Component Architecture */
    .select2-container--bootstrap4 {
        width: 100% !important;
    }
    
    /* Select2 Left Arrow Positioning Enhancement */
    .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
        position: absolute;
        top: 50%;
        left: 10px;
        right: auto;
        transform: translateY(-50%);
        height: 26px;
        width: 20px;
        z-index: 1;
    }
    
    /* Text Content Alignment Adjustment */
    .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
        padding-left: 32px;
        padding-right: 8px;
        line-height: calc(2.25rem + 2px - 2px);
    }
    
    /* Container Architecture */
    .select2-container--bootstrap4 .select2-selection {
        height: calc(2.25rem + 2px);
        border-radius: 0.25rem;
        border: 1px solid #ced4da;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    
    /* Interactive States */
    .select2-container--bootstrap4.select2-container--focus .select2-selection,
    .select2-container--bootstrap4.select2-container--open .select2-selection {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    /* Arrow Behavior Enhancement */
    .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow b {
        border-color: #6c757d transparent transparent transparent;
        border-width: 5px 4px 0 4px;
    }
    
    /* Dropdown Refinement */
    .select2-container--bootstrap4 .select2-dropdown {
        border-color: #80bdff;
        border-radius: 0.25rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    /* Form Architecture */
    .form-group label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #495057;
    }
    
    .form-control {
        height: calc(2.25rem + 2px);
    }
    
    .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    /* Card Component Enhancement */
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border-radius: 0.5rem;
        border: none;
    }
    
    .card-header {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }
    
    /* Validation States */
    .is-invalid + .select2-container--bootstrap4 .select2-selection {
        border-color: #dc3545;
    }
    
    .invalid-feedback {
        display: block;
        margin-top: 0.25rem;
    }
    
    /* Action Controls */
    .action-container {
        display: flex;
        gap: 0.5rem;
        margin-top: 1.5rem;
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        font-weight: 400;
        border-radius: 0.25rem;
        padding: 0.375rem 0.75rem;
    }
    
    .btn i {
        margin-right: 0.5rem;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0">Edit Product</h3>
    </div>
    <div class="card-body">
        <?php if (session()->has('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form id="editProductForm" action="/products/update/<?= $product['product_id'] ?>" method="post">
            <?= csrf_field() ?>

            <!-- Product Name Field -->
            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="product_name" 
                    name="product_name" 
                    value="<?= old('product_name', $product['product_name']) ?>" 
                    placeholder="Enter product name"
                    required
                >
            </div>

            <!-- Category Selection Field -->
            <div class="form-group">
                <label for="product_category_id">Category</label>
                <select class="form-control select2" id="product_category_id" name="product_category_id" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option 
                            value="<?= $category['product_category_id'] ?>" 
                            <?= (old('product_category_id', $product['product_category_id']) == $category['product_category_id']) ? 'selected' : '' ?>
                        >
                            <?= $category['product_category_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Supplier Selection Field -->
            <div class="form-group">
                <label for="supplier_id">Supplier</label>
                <select class="form-control select2" id="supplier_id" name="supplier_id" required>
                    <option value="">Select Supplier</option>
                    <?php foreach ($suppliers as $supplier): ?>
                        <option 
                            value="<?= $supplier['supplier_id'] ?>" 
                            <?= (old('supplier_id', $product['supplier_id']) == $supplier['supplier_id']) ? 'selected' : '' ?>
                        >
                            <?= $supplier['supplier_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Selling Price Field -->
            <div class="form-group">
                <label for="selling_price">Selling Price</label>
                <div class="input-group">
                    <input 
                        type="number" 
                        class="form-control" 
                        id="selling_price" 
                        name="selling_price" 
                        value="<?= old('selling_price', $product['selling_price']) ?>" 
                        placeholder="Enter selling price"
                        min="0"
                        required
                    >
                    <div class="input-group-append">
                        <span class="input-group-text">IDR</span>
                    </div>
                </div>
                <small class="text-muted">Enter the selling price in Indonesian Rupiah (IDR). Price must be zero or positive.</small>
            </div>

            <!-- Form Actions -->
            <div class="action-container">
                <button type="button" id="updateBtn" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="/products" id="cancelBtn" class="btn btn-default">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
/**
 * Product Edit Module
 * 
 * Implements enhanced Select2 integration with left-aligned dropdown indicators
 * and comprehensive form validation architecture with state management.
 */
$(document).ready(function() {
    // Store original values for state comparison
    const originalValues = {
        product_name: '<?= addslashes($product['product_name']) ?>',
        product_category_id: '<?= $product['product_category_id'] ?>',
        supplier_id: '<?= $product['supplier_id'] ?>',
        selling_price: '<?= $product['selling_price'] ?>'
    };
    
    // Core Configuration
    const SELECT2_CONFIG = {
        theme: 'bootstrap4',
        width: '100%',
        allowClear: true,
        minimumResultsForSearch: 5,
        escapeMarkup: markup => markup,
        dropdownParent: $('.content-wrapper'),
        language: {
            noResults: () => "No matches found",
            searching: () => "Searching...",
            inputTooShort: () => "Please enter at least 1 character",
        }
    };
    
    // Component Initialization
    initializeFormComponents();
    registerEventHandlers();
    
    /**
     * Initializes all form components with proper configuration
     */
    function initializeFormComponents() {
        // Category Dropdown Initialization
        $('#product_category_id').select2({
            ...SELECT2_CONFIG,
            placeholder: 'Search for a category...',
        });
        
        // Supplier Dropdown Initialization
        $('#supplier_id').select2({
            ...SELECT2_CONFIG,
            placeholder: 'Search for a supplier...',
        });
    }
    
    /**
     * Registers event handlers for form interaction
     */
    function registerEventHandlers() {
        // Update Button Handler
        $('#updateBtn').on('click', handleUpdateAction);
        
        // Cancel Button Handler
        $('#cancelBtn').on('click', handleCancelAction);
        
        // Form Field Change Tracking
        $('#editProductForm :input').on('input change', function() {
            $(this).removeClass('is-invalid')
                   .siblings('.invalid-feedback').remove();
        });
        
        // Selling Price Validation
        $('#selling_price').on('input', validateSellingPrice);
    }
    
    /**
     * Validates selling price input in real-time
     */
    function validateSellingPrice() {
        const price = $(this).val();
        if (price < 0) {
            Swal.fire({
                title: 'Invalid Price',
                text: 'Selling price cannot be negative',
                icon: 'error',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            }).then(() => {
                $(this).val('0');
                $(this).focus();
            });
        }
    }
    
    /**
     * Handles the update button action with validation
     */
    function handleUpdateAction() {
        if (!validateForm()) return;
        
        // Display confirmation dialog
        Swal.fire({
            title: 'Update Product',
            text: 'Are you sure you want to update this product?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, update it',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            focusConfirm: false
        }).then((result) => {
            if (result.isConfirmed) {
                $('#editProductForm').submit();
            }
        });
    }
    
    /**
     * Handles the cancel button action with unsaved changes detection
     */
    function handleCancelAction(e) {
        e.preventDefault();
        
        // Check for form modifications
        const hasChanges = detectFormChanges();
        
        if (hasChanges) {
            // Display confirmation for unsaved changes
            Swal.fire({
                title: 'Discard Changes',
                text: 'You have unsaved changes. Are you sure you want to leave this page?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, discard changes',
                cancelButtonText: 'Continue editing',
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/products';
                }
            });
        } else {
            // No changes, redirect immediately
            window.location.href = '/products';
        }
    }
    
    /**
     * Detects changes in form fields compared to original values
     * @returns {Boolean} True if changes detected
     */
    function detectFormChanges() {
        return $('#product_name').val() !== originalValues.product_name ||
               $('#product_category_id').val() !== originalValues.product_category_id ||
               $('#supplier_id').val() !== originalValues.supplier_id ||
               $('#selling_price').val() !== originalValues.selling_price;
    }
    
    /**
     * Validates all form fields and displays validation errors
     * @returns {Boolean} True if validation passes
     */
    function validateForm() {
        let isValid = true;
        
        // Product Name Validation
        if (!$('#product_name').val().trim()) {
            markFieldInvalid($('#product_name'), 'Product name is required');
            isValid = false;
        }
        
        // Category Validation
        if (!$('#product_category_id').val()) {
            markFieldInvalid($('#product_category_id'), 'Category selection is required');
            isValid = false;
        }
        
        // Supplier Validation
        if (!$('#supplier_id').val()) {
            markFieldInvalid($('#supplier_id'), 'Supplier selection is required');
            isValid = false;
        }
        
        // Selling Price Validation
        const price = $('#selling_price').val();
        if (price === '' || price === null) {
            markFieldInvalid($('#selling_price'), 'Selling price is required');
            isValid = false;
        } else if (parseFloat(price) < 0) {
            markFieldInvalid($('#selling_price'), 'Selling price cannot be negative');
            isValid = false;
        }
        
        return isValid;
    }
    
    /**
     * Marks a field as invalid with appropriate feedback
     * @param {jQuery} field - The field element to mark
     * @param {String} message - The validation error message
     */
    function markFieldInvalid(field, message) {
        field.addClass('is-invalid');
        
        if (!field.next('.invalid-feedback').length) {
            $('<div class="invalid-feedback"></div>')
                .text(message)
                .insertAfter(field);
        }
    }
});
</script>
<?= $this->endSection() ?>