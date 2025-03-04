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

                <div id="product-section">
                    <table class="table table-bordered" id="product-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Available Stock</th>
                                <th>Quantity</th>
                                <th>Price per Unit</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="product-row-0" class="product-row">
                                <td>
                                    <select name="products[0][product_id]" class="form-control product-select select2" required>
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
                                <td>
                                    <span class="available-stock">0</span>
                                </td>
                                <td>
                                    <input type="number" name="products[0][quantity_sold]" class="form-control quantity-sold" min="1" value="1" required>
                                </td>
                                <td>
                                    <input type="hidden" name="products[0][price_per_unit]" class="price-per-unit-input" value="0">
                                    <span class="price-per-unit">0</span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm remove-product">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
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
                    <textarea name="sale_notes" class="form-control" rows="3"></textarea>
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
            theme: 'bootstrap',
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
        
        // Update price per unit (in both span and hidden input)
        row.find('.price-per-unit').text(sellingPrice);
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
        });
        
        // Add product button
        $('#add-product').click(function() {
            const newRow = $(`
                <tr id="product-row-${rowCount}" class="product-row">
                    <td>
                        <select name="products[${rowCount}][product_id]" class="form-control product-select select2" required>
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
                    <td>
                        <span class="available-stock">0</span>
                    </td>
                    <td>
                        <input type="number" name="products[${rowCount}][quantity_sold]" class="form-control quantity-sold" min="1" value="1" required>
                    </td>
                    <td>
                        <input type="hidden" name="products[${rowCount}][price_per_unit]" class="price-per-unit-input" value="0">
                        <span class="price-per-unit">0</span>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-product">
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
        });
        
        // Form validation
        $('#sale-form').submit(function(event) {
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
            
            // If all validation passes, submit the form
            this.submit();
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
    // Add event listener for quantity changes
    $(document).on('input', '.quantity-sold', function() {
        const row = $(this).closest('.product-row');
        const productSelect = row.find('.product-select');
        
        if (productSelect.val() !== "") {
            const availableStock = parseInt(productSelect.find('option:selected').data('stock'));
            const quantitySold = parseInt($(this).val());
            
            if (quantitySold > availableStock) {
                const productName = productSelect.find('option:selected').text();
                
                Swal.fire({
                    title: 'Stock Warning',
                    text: `You've entered ${quantitySold} units for "${productName}" but only ${availableStock} units are available in stock.`,
                    icon: 'warning',
                    confirmButtonText: 'Adjust to maximum'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).val(availableStock);
                    }
                });
            }
        }
    });
</script>

<style>
    /* Select2 Styling */
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
    
    /* Table styling */
    .table th {
        background-color: #f4f6f9;
    }
    
    /* Card styling */
    .card {
        box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    }
    
    /* Available stock display */
    .available-stock {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        background-color: #f8f9fa;
        border-radius: 0.25rem;
        font-weight: 600;
    }
    
    /* Price display */
    .price-per-unit {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        background-color: #f8f9fa;
        border-radius: 0.25rem;
        font-weight: 600;
    }
</style>
<?= $this->endSection() ?>