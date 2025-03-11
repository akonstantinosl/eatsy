<?= $this->extend('layout_admin') ?>

<?= $this->section('styles') ?>
<style>
    /* Component Architecture Core */
    .customer-select-container .select2-container--bootstrap4 {
        width: 100% !important;
    }
    
    /* Left-positioned Dropdown Indicator */
    .customer-select-container .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
        position: absolute;
        top: 50%;
        left: 12px;
        right: auto;
        transform: translateY(-50%);
        pointer-events: none;
        width: 20px;
        height: 20px;
        z-index: 2;
    }
    
    /* Selection Container Refinement */
    .customer-select-container .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
        padding-left: 38px;
        padding-right: 12px;
        line-height: calc(2.25rem + 2px - 2px);
        color: #495057;
    }
    
    /* Base Container Architecture */
    .customer-select-container .select2-container--bootstrap4 .select2-selection {
        height: calc(2.25rem + 2px);
        border-radius: 0.25rem;
        border: 1px solid #ced4da;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        background-color: #fff;
    }
    
    /* Interactive State Management */
    .customer-select-container .select2-container--bootstrap4.select2-container--focus .select2-selection,
    .customer-select-container .select2-container--bootstrap4.select2-container--open .select2-selection {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    /* Critical Fix: Icon Color State Preservation */
    .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered .customer-icon {
        color: #007bff !important;
    }
    
    /* Critical Fix: Phone Number Contrast Preservation */
    .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered .customer-phone {
        color: #6c757d !important;
        opacity: 0.85;
    }
    
    /* Dropdown State Contrast Management */
    .select2-container--bootstrap4 .select2-results__option .customer-phone {
        color: #6c757d;
    }
    
    .select2-container--bootstrap4 .select2-results__option .customer-icon {
        color: #007bff;
    }
    
    /* Selection State Override for Results */
    .select2-container--bootstrap4 .select2-results__option--highlighted[aria-selected] .customer-phone {
        color: rgba(255, 255, 255, 0.85) !important;
    }
    
    .select2-container--bootstrap4 .select2-results__option--highlighted[aria-selected] .customer-icon {
        color: #fff !important;
    }
    
    /* Semantic Content Architecture */
    .customer-details {
        display: flex;
        flex-direction: column;
    }
    
    .customer-name {
        font-weight: 500;
        color: inherit;
    }
    
    .customer-metadata {
        display: flex;
        align-items: center;
        font-size: 0.875rem;
    }
    
    /* Avatar Component Architecture */
    .customer-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(0, 123, 255, 0.1);
        color: #007bff;
        margin-right: 0.75rem;
        flex-shrink: 0;
    }
    
    /* Dropdown Panel Enhancement */
    .select2-container--bootstrap4 .select2-dropdown {
        border-color: #80bdff;
        border-radius: 0.25rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    /* Results List Optimization */
    .select2-container--bootstrap4 .select2-results__option {
        padding: 0.5rem 0.75rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    
    .select2-container--bootstrap4 .select2-results__option:last-child {
        border-bottom: none;
    }
    
    /* Card Component System */
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: none;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
        transition: box-shadow 0.2s ease-in-out;
    }
    
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding: 1rem 1.25rem;
        border-top-left-radius: 0.5rem !important;
        border-top-right-radius: 0.5rem !important;
    }
    
    .card-header.bg-primary {
        background: linear-gradient(135deg, #007bff 0%, #0062cc 100%) !important;
    }
    
    /* Action Controls System */
    .btn-action-container {
        display: flex;
        justify-content: space-between;
        gap: 0.5rem;
        margin-top: 1.5rem;
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.375rem 0.75rem;
        font-weight: 500;
        border-radius: 0.25rem;
        transition: all 0.15s ease-in-out;
    }
    
    .btn i {
        margin-right: 0.375rem;
    }
    
    /* Helper Components */
    .text-helper {
        color: #6c757d;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
    }
    
    .text-helper i {
        margin-right: 0.375rem;
        color: #007bff;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0"><i class="fas fa-users mr-2"></i>Select Customer</h3>
    </div>
    <div class="card-body">
        <form action="/sales/customer" method="post" id="customer-form">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="customer_id" class="font-weight-medium">Customer</label>
                <div class="customer-select-container">
                    <select name="customer_id" id="customer_id" class="form-control select2" required>
                        <option value=""></option>
                        <?php foreach ($customers as $customer): ?>
                            <option value="<?= esc($customer['customer_id']) ?>">
                                <?= esc($customer['customer_name']) ?> - <?= esc($customer['customer_phone']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="text-helper">
                    <i class="fas fa-info-circle"></i>
                    <span>Start typing to search for a customer by name or phone number </span>
                </div>
            </div>

            <div class="btn-action-container">
                <a href="/sales" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i>Back to Sales
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-arrow-right"></i>Proceed to Products
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Quick Add Customer Card -->
<div class="card shadow-sm mt-4">
    <div class="card-header bg-light">
        <h3 class="card-title mb-0">
            <i class="fas fa-user-plus mr-2"></i>New Customer
        </h3>
    </div>
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div class="flex-grow-1">
                <p class="mb-0">
                    Can't find the customer you're looking for? Add them to your database before proceeding.
                </p>
            </div>
            <div class="ml-3">
                <a href="/customers/create" class="btn btn-success">
                    <i class="fas fa-plus-circle"></i>Add Customer
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
/**
 * Customer Selection Module
 * 
 * Implements an enterprise-grade selection component with state-preserved
 * visual elements and optimized information architecture.
 */
$(document).ready(function() {
    // Component Configuration Architecture
    const SELECT2_CONFIG = {
        theme: 'bootstrap4',
        width: '100%',
        allowClear: true,
        placeholder: {
            id: '',
            text: 'Select or search for a customer'
        },
        dropdownParent: $('.content-wrapper'),
        escapeMarkup: markup => markup,
        language: {
            noResults: () => "No matching customers found",
            searching: () => "Searching customer database...",
            removeAllItems: () => "Clear selection"
        },
        templateResult: formatCustomerResult,
        templateSelection: formatCustomerSelection
    };
    
    // Component Initialization
    $('#customer_id').select2(SELECT2_CONFIG);
    
    /**
     * Formats search result items with semantic structure and
     * optimized information hierarchy
     * 
     * @param {Object} customer - The customer data object
     * @returns {jQuery|String} Formatted result template
     */
    function formatCustomerResult(customer) {
        if (customer.loading) return customer.text;
        if (!customer.id) return customer.text;
        
        // Parse customer data with structured approach
        const parts = customer.text.split(' - ');
        const name = parts[0];
        const phone = parts[1] || 'No phone number';
        
        // Construct semantically structured template
        return $(`
            <div class="d-flex align-items-center py-1">
                <div class="customer-avatar">
                    <i class="fas fa-user customer-icon"></i>
                </div>
                <div class="customer-details">
                    <div class="customer-name">${name}</div>
                    <div class="customer-metadata">
                        <i class="fas fa-phone-alt customer-icon mr-1"></i>
                        <span class="customer-phone">${phone}</span>
                    </div>
                </div>
            </div>
        `);
    }
    
    /**
     * Formats the selected customer with preserved visual hierarchy
     * and consistent state management
     * 
     * @param {Object} customer - The selected customer data
     * @returns {jQuery|String} Formatted selection template
     */
    function formatCustomerSelection(customer) {
        if (!customer.id) return customer.text;
        
        // Parse customer data with structured approach
        const parts = customer.text.split(' - ');
        const name = parts[0];
        const phone = parts[1] || 'No phone number';
        
        // Construct semantically enriched template with state preservation
        return $(`
            <span>
                <i class="fas fa-user customer-icon mr-1"></i>
                <span class="customer-name">${name}</span>
                <span class="customer-phone">(${phone})</span>
            </span>
        `);
    }
    
    /**
     * Form validation with contextual feedback
     */
    $('#customer-form').on('submit', function(e) {
        if (!$('#customer_id').val()) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Customer Required',
                text: 'Please select a customer to proceed with this sale',
                icon: 'warning',
                confirmButtonText: 'Understood',
                confirmButtonColor: '#007bff'
            });
        }
    });
    
    // Process server-side messages with consistent patterns
    <?php if (session()->getFlashdata('error')): ?>
        Swal.fire({
            title: 'Error',
            text: '<?= session()->getFlashdata('error') ?>',
            icon: 'error',
            confirmButtonText: 'OK',
            confirmButtonColor: '#007bff'
        });
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('success')): ?>
        Swal.fire({
            title: 'Success',
            text: '<?= session()->getFlashdata('success') ?>',
            icon: 'success',
            confirmButtonText: 'Continue',
            confirmButtonColor: '#007bff'
        });
    <?php endif; ?>
});
</script>
<?= $this->endSection() ?>