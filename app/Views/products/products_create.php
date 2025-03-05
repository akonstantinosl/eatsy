<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0">Add New Product</h3>
    </div>
    <div class="card-body">
        <?php if (session()->has('errors')): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form id="addProductForm" action="/products/store" method="post">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" class="form-control" id="product_name" name="product_name" value="<?= old('product_name') ?>" required>
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
        $('#saveBtn').on('click', function() {
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
                    $('#addProductForm').submit();
                }
            });
        });

        // Cancel Button Confirmation
        $('#cancelBtn').on('click', function(e) {
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
                    window.location.href = '/products';  // Redirect to the products page
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>

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

    /* Button styling */
    .btn {
        border-radius: 0.25rem;
    }
</style>