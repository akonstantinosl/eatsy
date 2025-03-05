<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0"><i class="fas fa-truck mr-2"></i>Select Supplier</h3>
    </div>
    <div class="card-body">
        <form action="/admin/purchases/supplier" method="post" id="supplier-form">
            <?= csrf_field() ?>

            <div class="form-group">
                <div class="input-group">
                    <select name="supplier_id" id="supplier_id" class="form-control select2" required>
                        <option value=""></option>
                        <?php foreach ($suppliers as $supplier): ?>
                            <option value="<?= esc($supplier['supplier_id']) ?>">
                                <?= esc($supplier['supplier_name']) ?> - <?= esc($supplier['supplier_phone']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <small class="form-text text-muted">
                    <i class="fas fa-info-circle"></i> Start typing to search for a supplier by name or phone number
                </small>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="/admin/purchases" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left mr-1"></i>Back to Purchases
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-arrow-right mr-1"></i>Proceed to Products
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Quick Add Supplier Card -->
<div class="card shadow-sm mt-3">
    <div class="card-header bg-light">
        <h3 class="card-title mb-0">
            <i class="fas fa-truck-loading mr-2"></i>Supplier Not Found?
        </h3>
    </div>
    <div class="card-body">
        <p class="text-muted">
            If the supplier is not in the list, you can add a new supplier before proceeding.
        </p>
        <a href="/admin/suppliers/create" class="btn btn-success btn-sm">
            <i class="fas fa-plus-circle mr-1"></i>Add New Supplier
        </a>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Initialize Select2 with bootstrap theme and enhanced search options
        $('#supplier_id').select2({
            theme: 'bootstrap',
            placeholder: 'Search for a supplier...',
            allowClear: true,
            width: '100%',
            language: {
                noResults: function() {
                    return "No supplier found";
                },
                searching: function() {
                    return "Searching...";
                }
            },
            escapeMarkup: function(markup) {
                return markup;
            },
            templateResult: formatSupplier,
            templateSelection: formatSupplierSelection
        });

        // Format search results display
        function formatSupplier(supplier) {
            if (supplier.loading) return supplier.text;
            if (!supplier.id) return supplier.text;
            
            const parts = supplier.text.split(' - ');
            const supplierName = parts[0];
            const supplierPhone = parts[1] || 'No Phone';
            
            return $(`
                <div class="d-flex align-items-center p-2">
                    <div class="avatar bg-light rounded-circle mr-3 p-2">
                        <i class="fas fa-truck text-primary"></i>
                    </div>
                    <div>
                        <div class="font-weight-bold">${supplierName}</div>
                        <div class="small text-muted">
                            <i class="fas fa-phone-alt mr-1"></i>${supplierPhone}
                        </div>
                    </div>
                </div>
            `);
        }

        // Format selected option display
        function formatSupplierSelection(supplier) {
            if (!supplier.id) return supplier.text;
            
            const parts = supplier.text.split(' - ');
            const supplierName = parts[0];
            const supplierPhone = parts[1] || 'No Phone';
            
            return $(`
                <span>
                    <i class="fas fa-truck mr-1"></i> ${supplierName} <small class="text-muted">(${supplierPhone})</small>
                </span>
            `);
        }
        
        // Form validation with SweetAlert
        $('#supplier-form').submit(function(event) {
            if (!$('#supplier_id').val()) {
                event.preventDefault();
                
                Swal.fire({
                    title: 'Selection Required',
                    text: 'Please select a supplier to continue',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            }
        });
        
        // Display SweetAlert for flash messages if they exist
        <?php if (session()->getFlashdata('error')): ?>
            Swal.fire({
                title: 'Error',
                text: '<?= session()->getFlashdata('error') ?>',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        <?php endif; ?>
    });
</script>

<style>
    /* Custom styling for Select2 */
    .select2-container--bootstrap .select2-selection--single {
        height: 38px;
        padding: 8px 12px;
        font-size: 14px;
    }
    
    .select2-container--bootstrap .select2-selection--single .select2-selection__arrow {
        top: 6px;
    }
    
    .select2-container--bootstrap .select2-results__option--highlighted[aria-selected] {
        background-color: #007bff;
    }
    
    .select2-container--bootstrap .select2-search--dropdown .select2-search__field {
        padding: 8px;
        border-radius: 4px;
    }
    
    /* Card styling */
    .card {
        box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        border-radius: 0.5rem;
    }
    
    .card-header {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }
    
    /* Animation for notifications */
    .alert {
        animation: fadeInDown 0.5s ease;
    }
    
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Styling for avatar */
    .avatar {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Button styling */
    .btn {
        border-radius: 0.25rem;
    }
    
    /* Input group styling */
    .input-group-text {
        background-color: #f8f9fa;
    }
</style>
<?= $this->endSection() ?>