<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Select Products</h3>
    </div>
    <div class="card-body">
        <form action="/admin/purchases" method="post">
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
                        <select name="products[0][product_id]" class="form-control product-select" required onchange="updateProductSelection(0)">
                            <option value="">Select Product</option>
                            <?php foreach ($products as $product): ?>
                                <option value="<?= esc($product['product_id']) ?>"><?= esc($product['product_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <input type="number" name="products[0][box_bought]" class="form-control" min="1" value="1" required>
                    </td>
                    <td>
                        <input type="number" name="products[0][unit_per_box]" class="form-control" min="1" value="1" required>
                    </td>
                    <td>
                        <input type="number" name="products[0][price_per_box]" class="form-control" min="0" value="0" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeProduct(0)">Remove</button>
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
    </div>
</div>

<script>
    // Dynamically add products to the form
    document.getElementById('add-product').addEventListener('click', function() {
        const productRows = document.querySelectorAll('.product-row').length;
        const productRow = document.createElement('tr');
        productRow.classList.add('product-row');
        productRow.innerHTML = `
            <td>
                <select name="products[${productRows}][product_id]" class="form-control product-select" required onchange="updateProductSelection(${productRows})">
                    <option value="">Select Product</option>
                    <?php foreach ($products as $product): ?>
                        <option value="<?= esc($product['product_id']) ?>"><?= esc($product['product_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td>
                <input type="number" name="products[${productRows}][box_bought]" class="form-control" min="1" value="1" required>
            </td>
            <td>
                <input type="number" name="products[${productRows}][unit_per_box]" class="form-control" min="1" value="1" required>
            </td>
            <td>
                <input type="number" name="products[${productRows}][price_per_box]" class="form-control" min="0" value="0" required>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeProduct(${productRows})">Remove</button>
            </td>
        `;
        document.getElementById('product-table').appendChild(productRow);
    });

    // Remove product row
    function removeProduct(index) {
        const selectedProductId = document.querySelectorAll('.product-row')[index].querySelector('select').value;
        document.querySelectorAll('.product-row')[index].remove();

        // Enable previously disabled options
        const productSelects = document.querySelectorAll('.product-select');
        productSelects.forEach(select => {
            const options = select.querySelectorAll('option');
            options.forEach(option => {
                option.disabled = false;
                if (option.value === selectedProductId) {
                    option.selected = false;
                }
            });
        });

        // Re-enable the product if it was removed
        updateProductSelection();
    }

    // Function to handle product selection
    function updateProductSelection(rowIndex) {
        const productSelect = document.querySelectorAll('.product-select')[rowIndex];
        const selectedProductId = productSelect.value;

        // Disable the selected product in all other select elements
        const productSelects = document.querySelectorAll('.product-select');
        productSelects.forEach(select => {
            const options = select.querySelectorAll('option');
            options.forEach(option => {
                option.disabled = false;
                if (option.value === selectedProductId) {
                    option.disabled = true;
                }
            });
        });
    }

    // Ensure the form has at least one product selected before submission
    document.querySelector('form').addEventListener('submit', function(event) {
        const productSelects = document.querySelectorAll('.product-select');
        const selectedProducts = Array.from(productSelects).some(select => select.value !== "");

        if (!selectedProducts) {
            alert("Please select at least one product.");
            event.preventDefault();
        }
    });
</script>

<?= $this->endSection() ?>
