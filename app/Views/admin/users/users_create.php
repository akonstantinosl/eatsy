<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0">Add New Product</h3>
    </div>
    <div class="card-body">
        <form id="addProductForm" action="/products/store" method="post">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" class="form-control <?= session()->has('errors') && isset(session('errors')['product_name']) ? 'is-invalid' : '' ?>" id="product_name" name="product_name" value="<?= old('product_name') ?>" required>
                <?php if (session()->has('errors') && isset(session('errors')['product_name'])): ?>
                    <div class="invalid-feedback">
                        <?= session('errors')['product_name'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="product_category_id">Category</label>
                <select class="form-control select2" id="product_category_id" name="product_category_id" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['product_category_id'] ?>" <?= old('product_category_id') == $category['product_category_id'] ? 'selected' : '' ?>>
                            <?= $category['product_category_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="supplier_id">Supplier</label>
                <select class="form-control select2" id="supplier_id" name="supplier_id" required>
                    <option value="">Select Supplier</option>
                    <?php foreach ($suppliers as $supplier): ?>
                        <option value="<?= $supplier['supplier_id'] ?>" <?= old('supplier_id') == $supplier['supplier_id'] ? 'selected' : '' ?>>
                            <?= $supplier['supplier_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="button" id="saveBtn" class="btn btn-primary mr-2">Save</button>
            <a href="/products" id="cancelBtn" class="btn btn-default">Cancel</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Initialize Select2 for category and supplier dropdowns with search functionality
        $('#product_category_id').select2({
            theme: 'bootstrap',
            placeholder: 'Search for a category...',
            allowClear: true,
            width: '100%',
            language: {
                noResults: function() {
                    return "No category found";
                },
                searching: function() {
                    return "Searching...";
                }
            },
            escapeMarkup: function(markup) {
                return markup;
            }
        });

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
            }
        });

        // Save Button Confirmation
        document.getElementById('saveBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Are you sure you want to save?',
                text: 'You can review and edit the information before saving.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, save it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('addProductForm').submit();
                }
            });
        });

        // Cancel Button Confirmation
        document.getElementById('cancelBtn').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure you want to cancel?',
                text: 'Any changes you made will not be saved!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, cancel it!',
                cancelButtonText: 'Continue editing',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/products';  // Redirect back to products page
                }
            });
        });

        // Display SweetAlert for validation errors if they exist
        <?php if (session()->has('errors')): ?>
            let errorMessages = [];
            <?php foreach (session('errors') as $field => $error): ?>
                errorMessages.push('<?= esc($error) ?>');
            <?php endforeach; ?>
            
            Swal.fire({
                title: 'Validation Error',
                html: errorMessages.join('<br>'),
                icon: 'error',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        <?php endif; ?>

        // Display SweetAlert for success message if it exists
        <?php if (session()->has('success')): ?>
            Swal.fire({
                title: 'Success!',
                text: '<?= session()->getFlashdata('success') ?>',
                icon: 'success',
                timer: 3000,
                timerProgressBar: true
            });
        <?php endif; ?>
    });
</script>
<?= $this->endSection() ?>
