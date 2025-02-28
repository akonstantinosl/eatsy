<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Select Products from <?= esc($supplier['supplier_name'] ?? 'Supplier') ?></h3>
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

                <div id="product-section">
                    <table class="table table-bordered" id="product-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Box Bought</th>
                                <th>Unit per Box</th>
                                <th>Price per Box</th>
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
                                                data-units="<?= esc($product['product_units_per_box'] ?? 1) ?>">
                                                <?= esc($product['product_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="hidden" name="products[0][product_name]" class="product-name-input">
                                </td>
                                <td>
                                    <input type="number" name="products[0][box_bought]" class="form-control box-bought" min="1" value="1" required>
                                </td>
                                <td>
                                    <input type="number" name="products[0][unit_per_box]" class="form-control unit-per-box" min="1" value="1" required>
                                </td>
                                <td>
                                    <input type="number" name="products[0][price_per_box]" class="form-control price-per-box" min="0" value="0" required>
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

                <!-- Notes -->
                <div class="form-group mt-3">
                    <label for="purchase_notes">Notes</label>
                    <textarea name="purchase_notes" class="form-control" rows="3"></textarea>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Save Purchase</button>
                    <a href="/admin/purchases" class="btn btn-default">Cancel</a>
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
        const unitsPerBox = select.options[select.selectedIndex].dataset.units || 1;
        
        // Store product name in hidden input
        row.querySelector('.product-name-input').value = productName;
        
        // Update units per box if available from data attribute
        row.querySelector('.unit-per-box').value = unitsPerBox;
        
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
                data-units="<?= esc($product['product_units_per_box'] ?? 1) ?>"
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
                <input type="number" name="products[${newIndex}][box_bought]" class="form-control box-bought" min="1" value="1" required>
            </td>
            <td>
                <input type="number" name="products[${newIndex}][unit_per_box]" class="form-control unit-per-box" min="1" value="1" required>
            </td>
            <td>
                <input type="number" name="products[${newIndex}][price_per_box]" class="form-control price-per-box" min="0" value="0" required>
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
    document.getElementById('purchase-form').addEventListener('submit', function(event) {
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
        }
    });
</script>
<?= $this->endSection() ?>