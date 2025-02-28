<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Select Products</h3>
        <div class="card-tools">
            <a href="/admin/purchases/supplier" class="btn btn-default btn-sm">
                <i class="fas fa-arrow-left"></i> Back to Select Supplier
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="/admin/purchases" method="post">
            <?= csrf_field() ?>

            <input type="hidden" name="supplier_id" value="<?= esc($supplier_id) ?>">

            <!-- Dynamic Product Selection -->
            <div id="product-section">
                <table class="table table-bordered" id="product-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Purchase Type</th>
                            <th>Quantity (Unit)</th>
                            <th>Quantity (Box)</th>
                            <th>Price (Unit)</th>
                            <th>Price (Box)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="product-row-0" class="product-row">
                            <td>
                                <select name="products[0][product_id]" class="form-control product-select" required onchange="showQuantityAndPrice(0)">
                                    <option value="">Select Product</option>
                                    <?php foreach ($products as $product): ?>
                                        <option value="<?= esc($product['product_id']) ?>"><?= esc($product['product_name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <select name="products[0][purchase_type]" class="form-control" id="purchase_type_0" required onchange="togglePriceFields(0)">
                                    <option value="">Select Purchase Type</option>
                                    <option value="unit">Unit</option>
                                    <option value="box">Box</option>
                                    <option value="unit,box">Both</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="products[0][quantity_unit]" class="form-control" min="0" value="0" disabled>
                            </td>
                            <td>
                                <input type="number" name="products[0][quantity_box]" class="form-control" min="0" value="0" disabled>
                            </td>
                            <td>
                                <input type="number" name="products[0][purchase_price]" class="form-control" min="0" disabled>
                            </td>
                            <td>
                                <input type="number" name="products[0][box_purchase_price]" class="form-control" min="0" disabled>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeProduct(0)" disabled>
                                    <i class="fas"></i> Remove
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <button type="button" id="add-product" class="btn btn-success mt-3">
                <i class="fas"></i> Add Product
            </button>

            <!-- Notes -->
            <div class="form-group mt-3">
                <label for="purchase_notes">Notes</label>
                <textarea name="purchase_notes" class="form-control" rows="3"></textarea>
            </div>

            <!-- Buttons aligned -->
            <div class="mt-3">
                <button type="submit" class="btn btn-primary" style="margin-right: 10px;">Save Purchase</button>
                <a href="/admin/purchases" class="btn btn-default">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
    let productIndex = 1;
    let selectedProducts = [];

    // Function to show quantity and price fields when a product is selected
    function showQuantityAndPrice(index) {
        const purchaseTypeField = document.getElementById('purchase_type_' + index);
        const quantityPriceFields = document.getElementById('product-row-' + index).querySelectorAll('.quantity-price-fields');

        // Show the quantity and price fields when purchase type is selected
        if (purchaseTypeField.value) {
            for (let field of quantityPriceFields) {
                field.style.display = 'block';
            }
        } else {
            for (let field of quantityPriceFields) {
                field.style.display = 'none';
            }
        }

        // Update the availability of products in other rows
        updateProductOptions();
    }

    // Function to toggle the visibility of quantity and price fields based on the purchase type
    function togglePriceFields(index) {
        const purchaseType = document.getElementById('purchase_type_' + index).value;
        const quantityUnitField = document.querySelector('[name="products[' + index + '][quantity_unit]"]');
        const quantityBoxField = document.querySelector('[name="products[' + index + '][quantity_box]"]');
        const purchasePriceField = document.querySelector('[name="products[' + index + '][purchase_price]"]');
        const boxPurchasePriceField = document.querySelector('[name="products[' + index + '][box_purchase_price]"]');

        // Enable or disable fields based on purchase type
        if (purchaseType === 'unit' || purchaseType === 'unit,box') {
            quantityUnitField.disabled = false;
            purchasePriceField.disabled = false;
        } else {
            quantityUnitField.disabled = true;
            purchasePriceField.disabled = true;
        }

        if (purchaseType === 'box' || purchaseType === 'unit,box') {
            quantityBoxField.disabled = false;
            boxPurchasePriceField.disabled = false;
        } else {
            quantityBoxField.disabled = true;
            boxPurchasePriceField.disabled = true;
        }

        // Update the availability of products in other rows
        updateProductOptions();
    }

    // Function to update available product options dynamically
    function updateProductOptions() {
        // Collect all selected products
        selectedProducts = [];
        const productSelects = document.querySelectorAll('.product-select');
        
        productSelects.forEach((select) => {
            if (select.value) {
                selectedProducts.push(select.value);
            }
        });

        // Disable options that are already selected
        const productSelectsArray = Array.from(productSelects);
        productSelectsArray.forEach((select) => {
            const options = select.querySelectorAll('option');
            options.forEach((option) => {
                if (selectedProducts.includes(option.value) && option.value !== select.value) {
                    option.disabled = true;
                } else {
                    option.disabled = false;
                }
            });
        });
    }

    // Add new product row dynamically
    document.getElementById('add-product').addEventListener('click', function() {
        const productRow = document.createElement('tr');
        productRow.classList.add('product-row');
        productRow.id = 'product-row-' + productIndex;

        productRow.innerHTML = `
            <td>
                <select name="products[${productIndex}][product_id]" class="form-control product-select" required onchange="showQuantityAndPrice(${productIndex})">
                    <option value="">Select Product</option>
                    <?php foreach ($products as $product): ?>
                        <option value="<?= esc($product['product_id']) ?>"><?= esc($product['product_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </td>

            <td>
                <select name="products[${productIndex}][purchase_type]" class="form-control" id="purchase_type_${productIndex}" required onchange="togglePriceFields(${productIndex})">
                    <option value="">Select Purchase Type</option>
                    <option value="unit">Unit</option>
                    <option value="box">Box</option>
                    <option value="unit,box">Both</option>
                </select>
            </td>

            <td>
                <input type="number" name="products[${productIndex}][quantity_unit]" class="form-control" min="0" value="0" disabled>
            </td>

            <td>
                <input type="number" name="products[${productIndex}][quantity_box]" class="form-control" min="0" value="0" disabled>
            </td>

            <td>
                <input type="number" name="products[${productIndex}][purchase_price]" class="form-control" min="0" disabled>
            </td>

            <td>
                <input type="number" name="products[${productIndex}][box_purchase_price]" class="form-control" min="0" disabled>
            </td>

            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeProduct(${productIndex})"><i></i> Remove</button>
            </td>
        `;
        
        document.getElementById('product-table').appendChild(productRow);
        productIndex++;

        // Update the product options after adding a new row
        updateProductOptions();
    });

    // Remove product row dynamically
    function removeProduct(index) {
        const productRow = document.getElementById('product-row-' + index);
        if (productIndex > 1) {
            productRow.remove();
            updateProductOptions(); // Update the product options after removing a row
        }
    }
</script>

<?= $this->endSection() ?>
