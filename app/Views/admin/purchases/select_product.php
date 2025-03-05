<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0"><i class="fas fa-boxes mr-2"></i>Select Products from <?= esc($supplier['supplier_name'] ?? 'Supplier') ?></h3>
    </div>
    <div class="card-body">
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger">
                <?= session('error') ?>
            </div>
        <?php endif; ?>

        <?php if (empty($products)): ?>
            <div class="alert alert-info">
                No products found for this supplier. <a href="/admin/products/create" class="alert-link">Add products</a> first or <a href="/admin/purchases/supplier" class="alert-link">select another supplier</a>.
            </div>
        <?php else: ?>
            <form action="/admin/purchases" method="post" id="purchase-form">
                <?= csrf_field() ?>

                <input type="hidden" name="supplier_id" value="<?= esc($supplier_id) ?>">
                <!-- Add hidden field for updated_at -->
                <input type="hidden" name="updated_at" id="updated_at" value="<?= date('Y-m-d H:i:s') ?>">

                <div id="product-section" class="table-responsive">
                    <table class="table table-bordered table-striped" id="product-table">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 35%">Product</th>
                                <th style="width: 12%">Box Bought</th>
                                <th style="width: 12%">Unit per Box</th>
                                <th style="width: 18%">Price per Box</th>
                                <th style="width: 15%">Total</th>
                                <th style="width: 8%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="product-row-0" class="product-row">
                                <td>
                                    <select name="products[0][product_id]" class="form-control product-select" required>
                                        <option value="">Select Product</option>
                                        <?php foreach ($products as $product): ?>
                                            <option value="<?= esc($product['product_id']) ?>" 
                                                data-units="<?= esc($product['product_units_per_box'] ?? 1) ?>">
                                                <?= esc($product['product_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="hidden" name="products[0][product_name]" class="product-name-input">
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" name="products[0][box_bought]" class="form-control box-bought" min="1" value="1" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">box</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" name="products[0][unit_per_box]" class="form-control unit-per-box" min="1" value="1" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">unit</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">IDR</span>
                                        </div>
                                        <input type="number" name="products[0][price_per_box]" class="form-control price-per-box" min="0" value="0" required>
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="price-display">
                                     <span class="total-price">0</span> IDR
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-sm remove-product" title="Remove product">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="bg-light">
                                <td colspan="4" class="text-right font-weight-bold pr-3">
                                    <span style="line-height: 38px;">Grand Total:</span>
                                </td>
                                <td class="text-right font-weight-bold">
                                    <div class="price-display grand-total-display text-right">
                                        <span id="grand-total">0</span> IDR
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <button type="button" id="add-product" class="btn btn-success mt-3">
                    <i class="fas fa-plus mr-1"></i> Add Product
                </button>

                <!-- Notes -->
                <div class="form-group mt-4">
                    <label for="purchase_notes">Notes</label>
                    <textarea name="purchase_notes" class="form-control" rows="3" placeholder="Additional information about this purchase..."></textarea>
                </div>

                <div class="mt-4 d-flex">
                    <button type="submit" class="btn btn-primary mr-2">
                        <i class="fas fa-check mr-1"></i> Save Purchase
                    </button>
                    <a href="/admin/purchases/supplier" class="btn btn-secondary mr-2">
                        <i class="fas fa-truck mr-1"></i> Change Supplier
                    </a>
                    <a href="/admin/purchases" class="btn btn-default" id="cancelPurchaseBtn">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- Include Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Track selected products to prevent duplicates
    const selectedProducts = new Set();
    let rowCount = 1;
    
    // Initialize Select2 for all product selects
    function initSelect2(element) {
        $(element).select2({
            placeholder: 'Search for a product...',
            allowClear: true,
            width: '100%',
            language: {
                noResults: function() {
                    return "No products found";
                },
                searching: function() {
                    return "Searching...";
                }
            }
        });
    }
    
    // Function to update product fields when selection changes
    function updateProductSelection(select) {
        const row = $(select).closest('.product-row');
        const productId = $(select).val();
        const productName = $(select).find('option:selected').text();
        const unitsPerBox = $(select).find('option:selected').data('units') || 1;
        
        // Store product name in hidden input
        row.find('.product-name-input').val(productName);
        
        // Update units per box if available from data attribute
        row.find('.unit-per-box').val(unitsPerBox);
        
        // Track selected products to avoid duplicates
        if (productId) {
            // First remove any previous selection for this row
            const previousId = row.data('selected-id');
            if (previousId) {
                selectedProducts.delete(previousId);
            }
            
            // Mark the current selection
            selectedProducts.add(productId);
            row.data('selected-id', productId);
            
            // Disable this option in other selects
            updateAvailableOptions();
        }
        
        // Calculate total for this row
        calculateRowTotal(row);
        updateGrandTotal();
    }
    
    // Update available options in all selects
    function updateAvailableOptions() {
        $('.product-select').each(function() {
            const currentSelect = $(this);
            const currentValue = currentSelect.val();
            
            // Skip the currently selected value
            currentSelect.find('option').each(function() {
                const optionValue = $(this).val();
                if (optionValue && optionValue !== currentValue) {
                    $(this).prop('disabled', selectedProducts.has(optionValue));
                }
            });
            
            // Refresh Select2 to reflect the changes
            currentSelect.select2('destroy');
            initSelect2(currentSelect);
        });
    }
    
    // Add product button functionality
    function addProductRow() {
        const newRow = $(`
            <tr id="product-row-${rowCount}" class="product-row">
                <td>
                    <select name="products[${rowCount}][product_id]" class="form-control product-select" required>
                        <option value="">Select Product</option>
                        <?php foreach ($products as $product): ?>
                            <option value="<?= esc($product['product_id']) ?>" 
                                data-units="<?= esc($product['product_units_per_box'] ?? 1) ?>">
                                <?= esc($product['product_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="products[${rowCount}][product_name]" class="product-name-input">
                </td>
                <td>
                    <div class="input-group">
                        <input type="number" name="products[${rowCount}][box_bought]" class="form-control box-bought" min="1" value="1" required>
                        <div class="input-group-append">
                            <span class="input-group-text">box</span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <input type="number" name="products[${rowCount}][unit_per_box]" class="form-control unit-per-box" min="1" value="1" required>
                        <div class="input-group-append">
                            <span class="input-group-text">unit</span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">IDR</span>
                        </div>
                        <input type="number" name="products[${rowCount}][price_per_box]" class="form-control price-per-box" min="0" value="0" required>
                    </div>
                </td>
                <td class="text-right">
                    <div class="price-display">
                        <span class="total-price">0</span> IDR
                    </div>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm remove-product" title="Remove product">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `);
        
        // Append the new row
        $('#product-table tbody').append(newRow);
        
        // Initialize Select2 for the new select
        initSelect2(newRow.find('.product-select'));
        
        // Update available options
        updateAvailableOptions();
        
        // Increment row counter
        rowCount++;
        
        return newRow;
    }
    
    // Function to calculate and display row total
    function calculateRowTotal(row) {
        const boxBought = parseInt(row.find('.box-bought').val()) || 0;
        const pricePerBox = parseFloat(row.find('.price-per-box').val()) || 0;
        const totalPrice = boxBought * pricePerBox;
        
        // Format the total price with thousands separator
        const formattedPrice = new Intl.NumberFormat('id-ID').format(totalPrice);
        row.find('.total-price').text(formattedPrice);
    }
    
    // Function to calculate and update the grand total
    function updateGrandTotal() {
        let grandTotal = 0;
        
        $('.product-row').each(function() {
            const boxBought = parseInt($(this).find('.box-bought').val()) || 0;
            const pricePerBox = parseFloat($(this).find('.price-per-box').val()) || 0;
            grandTotal += boxBought * pricePerBox;
        });
        
        // Format the grand total with thousands separator
        const formattedGrandTotal = new Intl.NumberFormat('id-ID').format(grandTotal);
        $('#grand-total').text(formattedGrandTotal);
    }
    
    // Form validation
    $('#purchase-form').submit(function(event) {
        event.preventDefault();
        
        // Check if at least one product is selected
        let hasSelectedProducts = false;
        $('.product-select').each(function() {
            if ($(this).val() !== "") {
                hasSelectedProducts = true;
                return false; // break the loop
            }
        });
        
        if (!hasSelectedProducts) {
            Swal.fire({
                title: 'Error',
                text: 'Please select at least one product.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        // Check for empty price fields
        let hasEmptyPrices = false;
        $('.product-select').each(function() {
            if ($(this).val() !== "") {
                const row = $(this).closest('.product-row');
                const pricePerBox = parseFloat(row.find('.price-per-box').val());
                
                if (pricePerBox === 0) {
                    hasEmptyPrices = true;
                    return false; // break the loop
                }
            }
        });
        
        if (hasEmptyPrices) {
            Swal.fire({
                title: 'Price Warning',
                text: 'Some products have a price of 0. Do you want to continue?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, continue',
                cancelButtonText: 'No, I\'ll fix it',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    submitForm();
                }
            });
            return;
        }
        
        // If all validation passes, show confirmation dialog
        Swal.fire({
            title: 'Save Purchase',
            text: 'Are you sure you want to save this purchase order?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, save purchase',
            cancelButtonText: 'No, review again',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form
                submitForm();
            }
        });
    });

    // Function to submit the form
    function submitForm() {
        // Format date in local timezone
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const localDateTime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        
        // Update the timestamp before submission
        $('#updated_at').val(localDateTime);
        
        // Submit the form
        $('#purchase-form')[0].submit();
    }
    
    // Initialize page
    $(document).ready(function() {
        // Initialize Select2 for existing product selects
        initSelect2($('.product-select'));
        
        // Add event handlers to product selects
        $(document).on('change', '.product-select', function() {
            updateProductSelection(this);
        });
        
        // Add event handlers for remove buttons
        $(document).on('click', '.remove-product', function() {
            const row = $(this).closest('.product-row');
            
            // If this is the only row, just clear it instead of removing
            if ($('.product-row').length === 1) {
                // Clear the selection
                const select = row.find('.product-select');
                const productId = select.val();
                if (productId) {
                    selectedProducts.delete(productId);
                    row.removeData('selected-id');
                }
                
                // Clear the fields
                select.val('').trigger('change');
                row.find('.box-bought').val('1');
                row.find('.unit-per-box').val('1');
                row.find('.price-per-box').val('0');
                row.find('.total-price').text('0');
                
                // Update grand total
                updateGrandTotal();
                
                return;
            }
            
            // Remove the product from tracking
            const productId = row.find('.product-select').val();
            if (productId) {
                selectedProducts.delete(productId);
            }
            
            // Remove the row
            row.remove();
            
            // Update all selects
            updateAvailableOptions();
            
            // Renumber remaining rows to keep indices sequential
            $('.product-row').each(function(index) {
                $(this).attr('id', `product-row-${index}`);
                $(this).find('[name^="products["]').each(function() {
                    const name = $(this).attr('name');
                    const newName = name.replace(/products\[\d+\]/, `products[${index}]`);
                    $(this).attr('name', newName);
                });
            });
            
            // Update grand total
            updateGrandTotal();
        });
        
        // Add product button click handler
        $('#add-product').click(function() {
            addProductRow();
        });
        
        // Add cancel button confirmation
        $('#cancelPurchaseBtn').click(function(event) {
            event.preventDefault();
            
            Swal.fire({
                title: 'Cancel Purchase',
                text: 'Are you sure you want to cancel this purchase? All product selections will be lost.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'No, keep editing',
                cancelButtonText: 'Yes, cancel purchase',
                reverseButtons: true
            }).then((result) => {
                if (result.isDismissed && result.dismiss === Swal.DismissReason.cancel) {
                    // Navigate to the purchases page
                    window.location.href = '/admin/purchases';
                }
            });
        });
        
        // Calculate row total when inputs change
        $(document).on('input', '.box-bought, .price-per-box', function() {
            const row = $(this).closest('.product-row');
            calculateRowTotal(row);
            updateGrandTotal();
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
    /* Select2 Styling Fixes */
    .select2-container {
        display: block;
        width: 100% !important;
    }
    
    .select2-container .select2-selection--single {
        height: 38px !important;
        padding: 6px 12px;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 24px;
        padding-left: 0;
        padding-right: 20px;
        color: #495057;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
        width: 30px;
    }
    
    .select2-dropdown {
        border-color: #80bdff;
        border-radius: 0.25rem;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        padding: 6px 12px;
        height: 38px;
    }
    
    .select2-container--default .select2-search--dropdown .select2-search__field:focus {
        outline: none;
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #007bff;
    }
    
    /* Table styling */
    .table {
        margin-bottom: 0;
    }
    
    .table th {
        background-color: #f4f6f9;
        vertical-align: middle;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
    }
    
    .table tfoot {
        background-color: #f8f9fa;
        border-top: 2px solid #dee2e6;
    }
    
    .table tfoot td {
        padding: 12px 8px;
    }
    
    .table tbody tr:nth-child(even) {
        background-color: rgba(0, 0, 0, 0.02);
    }
    
    /* Make table responsive */
    .table-responsive {
        border-radius: 0.25rem;
        overflow: hidden;
    }
    
    /* Card styling */
    .card {
        box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        border-radius: 0.3rem;
    }
    
    /* Button styling */
    .btn {
        border-radius: 0.25rem;
    }
    
    /* Input styling */
    .form-control {
        border-radius: 0.25rem;
    }
    
    .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    /* Input group styling */
    .input-group-text {
        background-color: #f4f6f9;
        border-color: #ced4da;
        font-size: 0.9rem;
    }
    
    /* Price display styling */
    .price-display {
        background-color: #f8f9fa;
        padding: 8px 12px;
        border-radius: 4px;
        border: 1px solid #ced4da;
        font-weight: 600;
        display: inline-block;
        min-width: 120px;
    }
    
    .grand-total-display {
        background-color: #e8f4ff;
        border-color: #b8daff;
    }
    
    /* Total price display */
    .total-price {
        font-weight: 600;
    }
    
    /* Grand total styling */
    #grand-total {
        font-size: 1.1rem;
        color: #007bff;
    }
    
    /* Animation for adding new rows */
    @keyframes highlightRow {
        0% {background-color: rgba(0, 123, 255, 0.1);}
        100% {background-color: transparent;}
    }
    
    .product-row:last-child {
        animation: highlightRow 1.5s ease;
    }
    
    /* Improve spacing in rows */
    .product-row td {
        vertical-align: middle;
        padding: 10px 8px;
    }
</style>
<?= $this->endSection() ?>