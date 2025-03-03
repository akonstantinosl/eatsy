<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Select Products for <?= esc($customer['customer_name'] ?? 'Customer') ?></h3>
    </div>
    <div class="card-body">
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger">
                <?= session('error') ?>
            </div>
        <?php endif; ?>

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
                                <td>
                                    <span class="available-stock">0</span>
                                </td>
                                <td>
                                    <input type="number" name="products[0][quantity_sold]" class="form-control quantity-sold" min="1" value="1" required>
                                </td>
                                <td>
                                    <input type="number" name="products[0][price_per_unit]" class="form-control price-per-unit" min="0" value="0" required>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm remove-product">Remove</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <button type="button" id="add-product" class="btn btn-success mt-3">
                    Add Product
                </button>

                <!-- Payment Method -->
                <div class="form-group mt-3">
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

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary mr-2">Complete Sale</button>
                    <a href="/sales" class="btn btn-default">Cancel</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<script>
    // Track selected products to prevent duplicates
    const selectedProducts = new Set();
    
    // Function to update product fields when selection changes
    function updateProductSelection(select) {
        const row = select.closest('.product-row');
        const productId = select.value;
        const productName = select.options[select.selectedIndex].text;
        const availableStock = select.options[select.selectedIndex].dataset.stock || 0;
        const sellingPrice = select.options[select.selectedIndex].dataset.price || 0;
        
        // Store product name in hidden input
        row.querySelector('.product-name-input').value = productName;
        
        // Update available stock display
        row.querySelector('.available-stock').textContent = availableStock;
        
        // Update price per unit if available from data attribute
        row.querySelector('.price-per-unit').value = sellingPrice;
        
        // Update quantity limits based on available stock
        const quantityInput = row.querySelector('.quantity-sold');
        quantityInput.max = availableStock;
        
        // If quantity is more than stock, reduce it
        if (parseInt(quantityInput.value) > parseInt(availableStock)) {
            quantityInput.value = availableStock;
        }
        
        // Track selected products to avoid duplicates
        if (productId) {
            selectedProducts.add(productId);
        }
    }
    
    // Setup initial product selections
    document.querySelectorAll('.product-select').forEach(select => {
        select.addEventListener('change', function() {
            updateProductSelection(this);
        });
    });
    
    // Dynamically add products to the form
    document.getElementById('add-product').addEventListener('click', function() {
        const productRows = document.querySelectorAll('.product-row');
        const newIndex = productRows.length;
        const productRow = document.createElement('tr');
        productRow.classList.add('product-row');
        productRow.id = `product-row-${newIndex}`;
        
        // Create product options, filtering out already selected ones
        let productOptions = '<option value="">Select Product</option>';
        <?php foreach ($products as $product): ?>
            productOptions += `<option value="<?= esc($product['product_id']) ?>" 
                data-stock="<?= esc($product['product_stock']) ?>"
                data-price="<?= esc($product['selling_price']) ?>"
                ${selectedProducts.has("<?= esc($product['product_id']) ?>") ? 'disabled' : ''}>
                <?= esc($product['product_name']) ?>
            </option>`;
        <?php endforeach; ?>
        
        productRow.innerHTML = `
            <td>
                <select name="products[${newIndex}][product_id]" class="form-control product-select" required>
                    ${productOptions}
                </select>
                <input type="hidden" name="products[${newIndex}][product_name]" class="product-name-input">
            </td>
            <td>
                <span class="available-stock">0</span>
            </td>
            <td>
                <input type="number" name="products[${newIndex}][quantity_sold]" class="form-control quantity-sold" min="1" value="1" required>
            </td>
            <td>
                <input type="number" name="products[${newIndex}][price_per_unit]" class="form-control price-per-unit" min="0" value="0" required>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm remove-product">Remove</button>
            </td>
        `;
        
        document.querySelector('#product-table tbody').appendChild(productRow);
        
        // Add event listener to the new select element
        const newSelect = productRow.querySelector('.product-select');
        newSelect.addEventListener('change', function() {
            updateProductSelection(this);
        });
        
        // Add event listener to the new remove button
        productRow.querySelector('.remove-product').addEventListener('click', function() {
            removeProduct(this);
        });
    });
    
    // Remove product row
    function removeProduct(button) {
        const row = button.closest('.product-row');
        const select = row.querySelector('.product-select');
        const productId = select.value;
        
        // Remove from tracking set
        if (productId) {
            selectedProducts.delete(productId);
        }
        
        // Remove the row
        row.remove();
        
        // Update all selects to re-enable the removed option
        document.querySelectorAll('.product-select').forEach(select => {
            Array.from(select.options).forEach(option => {
                if (option.value === productId) {
                    option.disabled = false;
                }
            });
        });
        
        // Renumber remaining rows to keep indices sequential
        const productRows = document.querySelectorAll('.product-row');
        productRows.forEach((row, index) => {
            row.id = `product-row-${index}`;
            row.querySelectorAll('[name^="products["]').forEach(input => {
                const name = input.name;
                const newName = name.replace(/products\[\d+\]/, `products[${index}]`);
                input.name = newName;
            });
        });
    }
    
    // Add event listeners to initial remove buttons
    document.querySelectorAll('.remove-product').forEach(button => {
        button.addEventListener('click', function() {
            removeProduct(this);
        });
    });
    
    // Form validation
    document.getElementById('sale-form').addEventListener('submit', function(event) {
        const productSelects = document.querySelectorAll('.product-select');
        let hasSelectedProducts = false;
        
        productSelects.forEach(select => {
            if (select.value !== "") {
                hasSelectedProducts = true;
            }
        });
        
        if (!hasSelectedProducts) {
            event.preventDefault();
            alert("Please select at least one product.");
            return;
        }
        
        // Check if quantities exceed available stock
        let hasStockIssue = false;
        
        productSelects.forEach(select => {
            if (select.value !== "") {
                const row = select.closest('.product-row');
                const availableStock = parseInt(select.options[select.selectedIndex].dataset.stock);
                const quantitySold = parseInt(row.querySelector('.quantity-sold').value);
                
                if (quantitySold > availableStock) {
                    hasStockIssue = true;
                    const productName = select.options[select.selectedIndex].text;
                    alert(`Not enough stock for ${productName}. Available: ${availableStock}.`);
                }
            }
        });
        
        if (hasStockIssue) {
            event.preventDefault();
        }
    });
</script>
<?= $this->endSection() ?>