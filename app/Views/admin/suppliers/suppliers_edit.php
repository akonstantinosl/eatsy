<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Supplier</h3>
        <div class="card-tools">
            <a href="/admin/suppliers" class="btn btn-sm" style="background-color: #5a6268; color: white;">
                <i class="fas fa-arrow-left"></i> Back to Suppliers
            </a>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <form id="supplierForm" action="/admin/suppliers/update/<?= $supplier['supplier_id'] ?>" method="post">
            <div class="form-group">
                <label for="supplier_name">Supplier Name</label>
                <input type="text" class="form-control <?= session()->has('errors') && isset(session('errors')['supplier_name']) ? 'is-invalid' : '' ?>" id="supplier_name" name="supplier_name" value="<?= old('supplier_name', $supplier['supplier_name']) ?>" required>
                <?php if (session()->has('errors') && isset(session('errors')['supplier_name'])): ?>
                    <div class="invalid-feedback">
                        <?= session('errors')['supplier_name'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="supplier_phone">Phone Number</label>
                <input type="text" class="form-control <?= session()->has('errors') && isset(session('errors')['supplier_phone']) ? 'is-invalid' : '' ?>" id="supplier_phone" name="supplier_phone" value="<?= old('supplier_phone', $supplier['supplier_phone']) ?>" required>
                <?php if (session()->has('errors') && isset(session('errors')['supplier_phone'])): ?>
                    <div class="invalid-feedback">
                        <?= session('errors')['supplier_phone'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="supplier_address">Address</label>
                <textarea class="form-control <?= session()->has('errors') && isset(session('errors')['supplier_address']) ? 'is-invalid' : '' ?>" id="supplier_address" name="supplier_address" rows="4" required><?= old('supplier_address', $supplier['supplier_address']) ?></textarea>
                <?php if (session()->has('errors') && isset(session('errors')['supplier_address'])): ?>
                    <div class="invalid-feedback">
                        <?= session('errors')['supplier_address'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Hidden input for status (can't be edited) -->
            <input type="hidden" name="supplier_status" value="<?= $supplier['supplier_status'] ?>">

            <button type="button" id="saveBtn" class="btn btn-primary mr-2">Update</button>
            <a href="/admin/suppliers" id="cancelBtn" class="btn btn-default">Cancel</a>
        </form>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

<script>
    // Save Button Confirmation
    document.getElementById('saveBtn').addEventListener('click', function() {
        Swal.fire({
            title: 'Are you sure you want to update this supplier?',
            text: 'You can review and edit the information before saving.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, update it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('supplierForm').submit();
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
                window.location.href = '/admin/suppliers';  // Redirect back to suppliers page
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        bsCustomFileInput.init();

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
