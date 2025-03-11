<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0"><i class="fas fa-shopping-cart mr-2"></i>Select Products for <?= esc($customer['customer_name'] ?? 'Customer') ?></h3>
    </div>
    <div class="card-body">
        <?php if (empty($products)): ?>
            <div class="alert alert-info">
                No products found in stock. <a href="/sales/customer" class="alert-link">Select another customer</a>.
            </div>
        <?php else: ?>
            <form action="/sales" method="post" id="sale-form">
                <?= csrf_field() ?>

                <input type="hidden" name="customer_id" value="<?= esc($customer_id) ?>">
                <!-- Add hidden input for updated_at timestamp -->
                <input type="hidden" name="updated_at" id="updated_at" value="<?= date('Y-m-d H:i:s') ?>">

                <div id="product-section" class="table-responsive">
                    <table class="table table-bordered table-striped" id="product-table">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 35%">Product</th>
                                <th style="width: 15%">Available Stock</th>
                                <th style="width: 15%">Quantity</th>
                                <th style="width: 20%">Price per Unit</th>
                                <th style="width: 10%">Total</th>
                                <th style="width: 5%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="product-row-0" class="product-row">
                                <td>
                                    <select name="products[0][product_id]" class="form-control product-select" required>
                                        <option value="">Select Product</option>
                                        <?php foreach ($products as $product): ?>
                                            <option value="<?= esc($product['product_id']) ?>" 
                                                data-stock="<?= esc($product['product_stock']) ?>"
                                                data-price="<?= esc($product['selling_price']) ?>">
                                                <?= esc($product['product_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="hidden" name="products[0][product_name]" class="product-name-input">
                                </td>
                                <td class="text-center">
                                    <div class="stock-display">
                                        <span class="available-stock">0</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" name="products[0][quantity_sold]" class="form-control quantity-sold" min="1" value="1" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">unit</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="price-display">
                                        <span class="price-per-unit">0</span> IDR
                                    </div>
                                    <input type="hidden" name="products[0][price_per_unit]" class="price-per-unit-input" value="0">
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
                                    <div class="price-display grand-total-display">
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

                <!-- Payment Method -->
                <div class="form-group mt-4">
                    <label for="payment_method">Payment Method</label>
                    <select name="payment_method" class="form-control" required>
                        <option value="cash">Cash</option>
                        <option value="credit_card">Credit Card</option>
                        <option value="debit_card">Debit Card</option>
                        <option value="e-wallet">E-Wallet</option>
                    </select>
                </div>

                <!-- Notes -->
                <div class="form-group mt-3">
                    <label for="sale_notes">Notes</label>
                    <textarea name="sale_notes" class="form-control" rows="3" placeholder="Additional information about this sale..."></textarea>
                </div>

                <div class="mt-4 d-flex">
                    <button type="submit" class="btn btn-primary mr-2">
                        <i class="fas fa-check mr-1"></i> Complete Sale
                    </button>
                    <a href="/sales/customer" class="btn btn-secondary mr-2">
                        <i class="fas fa-user mr-1"></i> Change Customer
                    </a>
                    <a href="/sales" class="btn btn-default">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

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
        const availableStock = $(select).find('option:selected').data('stock') || 0;
        const sellingPrice = $(select).find('option:selected').data('price') || 0;
        
        // Store product name in hidden input
        row.find('.product-name-input').val(productName);
        
        // Update available stock display
        row.find('.available-stock').text(availableStock);
        
        // Update price per unit display and hidden input
        const formattedPrice = new Intl.NumberFormat('id-ID').format(sellingPrice);
        row.find('.price-per-unit').text(formattedPrice);
        row.find('.price-per-unit-input').val(sellingPrice);
        
        // Update quantity limits based on available stock
        const quantityInput = row.find('.quantity-sold');
        quantityInput.attr('max', availableStock);
        
        // If quantity is more than stock, reduce it
        if (parseInt(quantityInput.val()) > parseInt(availableStock)) {
            quantityInput.val(availableStock);
        }
        
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
                                data-stock="<?= esc($product['product_stock']) ?>"
                                data-price="<?= esc($product['selling_price']) ?>">
                                <?= esc($product['product_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="products[${rowCount}][product_name]" class="product-name-input">
                </td>
                <td class="text-center">
                    <div class="stock-display">
                        <span class="available-stock">0</span>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <input type="number" name="products[${rowCount}][quantity_sold]" class="form-control quantity-sold" min="1" value="1" required>
                        <div class="input-group-append">
                            <span class="input-group-text">unit</span>
                        </div>
                    </div>
                </td>
                <td class="text-center">
                    <div class="price-display">
                        <span class="price-per-unit">0</span> IDR
                    </div>
                    <input type="hidden" name="products[${rowCount}][price_per_unit]" class="price-per-unit-input" value="0">
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
                row.find('.available-stock').text('0');
                row.find('.quantity-sold').val('1').attr('max', '');
                row.find('.price-per-unit').text('0');
                row.find('.price-per-unit-input').val('0');
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
        
        // Form validation
        $('#sale-form').submit(function(event) {
            event.preventDefault();
            
            // Update timestamp before submission
            $('#updated_at').val(new Date().toISOString().slice(0, 19).replace('T', ' '));
            
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
            
            // Check if quantities exceed available stock
            let hasStockIssue = false;
            let errorMessage = '';
            
            $('.product-select').each(function() {
                if ($(this).val() !== "") {
                    const row = $(this).closest('.product-row');
                    const availableStock = parseInt($(this).find('option:selected').data('stock'));
                    const quantitySold = parseInt(row.find('.quantity-sold').val());
                    
                    if (quantitySold > availableStock) {
                        hasStockIssue = true;
                        const productName = $(this).find('option:selected').text();
                        errorMessage = `Not enough stock for ${productName}. Available: ${availableStock}.`;
                        return false; // break the loop
                    }
                }
            });
            
            if (hasStockIssue) {
                Swal.fire({
                    title: 'Stock Error',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }
            
            // If all validation passes, show confirmation dialog
            Swal.fire({
                title: 'Complete Sale',
                text: 'Are you sure you want to complete this sale?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, complete sale',
                cancelButtonText: 'No, review again',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form
                    this.submit();
                }
            });
        });
        
        // Add cancel button confirmation
        $('a[href="/sales"]').click(function(event) {
            event.preventDefault();
            
            Swal.fire({
                title: 'Cancel Sale',
                text: 'Are you sure you want to cancel this sale? All product selections will be lost.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'No, keep editing',
                cancelButtonText: 'Yes, cancel sale',
                reverseButtons: true
            }).then((result) => {
                if (result.isDismissed && result.dismiss === Swal.DismissReason.cancel) {
                    // Navigate to the sales page
                    window.location.href = '/sales';
                }
            });
        });
        
        // Calculate row total when inputs change
        $(document).on('input', '.quantity-sold', function() {
            const row = $(this).closest('.product-row');
            calculateRowTotal(row);
            updateGrandTotal();
            
            // Check stock limits
            checkStockLimits($(this));
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
    
    // Function to check stock limits
    function checkStockLimits(input) {
        const row = input.closest('.product-row');
        const productSelect = row.find('.product-select');
        
        if (productSelect.val() !== "") {
            const availableStock = parseInt(productSelect.find('option:selected').data('stock'));
            const quantitySold = parseInt(input.val());
            
            if (quantitySold > availableStock) {
                const productName = productSelect.find('option:selected').text();
                
                Swal.fire({
                    title: 'Stock Warning',
                    text: `You've entered ${quantitySold} units for "${productName}" but only ${availableStock} units are available in stock.`,
                    icon: 'warning',
                    confirmButtonText: 'Adjust to maximum'
                }).then((result) => {
                    if (result.isConfirmed) {
                        input.val(availableStock);
                        calculateRowTotal(row);
                        updateGrandTotal();
                    }
                });
            }
        }
    }
    
    // Function to calculate and display row total
    function calculateRowTotal(row) {
        const quantitySold = parseInt(row.find('.quantity-sold').val()) || 0;
        const pricePerUnit = parseFloat(row.find('.price-per-unit-input').val()) || 0;
        const totalPrice = quantitySold * pricePerUnit;
        
        // Format the total price with thousands separator
        const formattedPrice = new Intl.NumberFormat('id-ID').format(totalPrice);
        row.find('.total-price').text(formattedPrice);
    }
    
    // Function to calculate and update the grand total
    function updateGrandTotal() {
        let grandTotal = 0;
        
        $('.product-row').each(function() {
            const quantitySold = parseInt($(this).find('.quantity-sold').val()) || 0;
            const pricePerUnit = parseFloat($(this).find('.price-per-unit-input').val()) || 0;
            grandTotal += quantitySold * pricePerUnit;
        });
        
        // Format the grand total with thousands separator
        const formattedGrandTotal = new Intl.NumberFormat('id-ID').format(grandTotal);
        $('#grand-total').text(formattedGrandTotal);
    }
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
    
    /* Stock display styling */
    .stock-display {
        background-color: #f8f9fa;
        padding: 8px 12px;
        border-radius: 4px;
        border: 1px solid #ced4da;
        font-weight: 600;
        display: inline-block;
        min-width: 60px;
    }
    
    /* Available stock display */
    .available-stock {
        font-weight: 600;
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
        width: 100%;
        text-align: right;
    }
    
    .grand-total-display {
        background-color: #e8f4ff;
        border-color: #b8daff;
        width: 100%;
        min-width: 120px;
    }
    
    /* Total price display */
    .total-price, .price-per-unit {
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
    
    /* Memperbaiki posisi vertical dari label Grand Total */
    tfoot tr td span {
        vertical-align: middle;
    }
    
    /* Tambahan padding untuk label text Grand Total */
    tfoot td.text-right.font-weight-bold.pr-3 {
        padding-right: 15px !important;
    }
</style>
<?= $this->endSection() ?>