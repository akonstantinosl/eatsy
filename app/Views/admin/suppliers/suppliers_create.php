<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Add New Supplier</h3>
        <div class="card-tools">
            <a href="/admin/suppliers" class="btn btn-sm" style="background-color: #5a6268; color: white;">
                <i class="fas fa-arrow-left"></i> Back to Suppliers
            </a>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <form id="supplierForm" action="/admin/suppliers/store" method="post">
            <div class="form-group">
                <label for="supplier_name">Supplier Name</label>
                <input type="text" class="form-control <?= session()->has('errors') && isset(session('errors')['supplier_name']) ? 'is-invalid' : '' ?>" id="supplier_name" name="supplier_name" value="<?= old('supplier_name') ?>" required>
                <?php if (session()->has('errors') && isset(session('errors')['supplier_name'])): ?>
                    <div class="invalid-feedback">
                        <?= session('errors')['supplier_name'] ?>
                    </div>
                <?php endif; ?>
                <small class="text-muted">Supplier name must be unique regardless of spacing or capitalization.</small>
            </div>

            <div class="form-group">
                <label for="supplier_phone">Phone Number</label>
                <input type="text" class="form-control <?= session()->has('errors') && isset(session('errors')['supplier_phone']) ? 'is-invalid' : '' ?>" id="supplier_phone" name="supplier_phone" value="<?= old('supplier_phone') ?>" required>
                <?php if (session()->has('errors') && isset(session('errors')['supplier_phone'])): ?>
                    <div class="invalid-feedback">
                        <?= session('errors')['supplier_phone'] ?>
                    </div>
                <?php endif; ?>
                <small class="text-muted">Phone number must be unique and at least 10 digits.</small>
            </div>

            <div class="form-group">
                <label for="supplier_address">Address</label>
                <textarea class="form-control <?= session()->has('errors') && isset(session('errors')['supplier_address']) ? 'is-invalid' : '' ?>" id="supplier_address" name="supplier_address" rows="4" required><?= old('supplier_address') ?></textarea>
                <?php if (session()->has('errors') && isset(session('errors')['supplier_address'])): ?>
                    <div class="invalid-feedback">
                        <?= session('errors')['supplier_address'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Hidden input for status -->
            <input type="hidden" name="supplier_status" value="active">

            <button type="button" id="saveBtn" class="btn btn-primary mr-2"><i class="fas fa-save"></i> Save</button>
            <a href="/admin/suppliers" id="cancelBtn" class="btn btn-default"><i class="fas fa-times"></i> Cancel</a>
        </form>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof bsCustomFileInput !== 'undefined') {
            bsCustomFileInput.init();
        }

        // Basic phone number format validation
        let supplierPhoneInput = document.getElementById('supplier_phone');
        
        // Validate phone number format (only allow digits)
        supplierPhoneInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, ''); // Remove non-numeric characters
        });

        // Save Button Confirmation with basic validation
        document.getElementById('saveBtn').addEventListener('click', function() {
            // Perform basic validation before confirmation
            const name = document.getElementById('supplier_name').value.trim();
            const phone = supplierPhoneInput.value.trim();
            const address = document.getElementById('supplier_address').value.trim();
            let validationErrors = [];
            
            // Validate required fields
            if (name === '') {
                validationErrors.push('Supplier name is required.');
                document.getElementById('supplier_name').classList.add('is-invalid');
            }
            
            if (phone === '') {
                validationErrors.push('Phone number is required.');
                supplierPhoneInput.classList.add('is-invalid');
            } else if (phone.length < 10) {
                validationErrors.push('Phone number must be at least 10 digits.');
                supplierPhoneInput.classList.add('is-invalid');
            }
            
            if (address === '') {
                validationErrors.push('Address is required.');
                document.getElementById('supplier_address').classList.add('is-invalid');
            }
            
            // If there are validation errors, show them and stop
            if (validationErrors.length > 0) {
                Swal.fire({
                    title: 'Validation Error',
                    html: validationErrors.join('<br>'),
                    icon: 'error',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }
            
            // If validations pass, show confirmation dialog
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
                    document.getElementById('supplierForm').submit();
                }
            });
        });

        // Cancel Button Confirmation
        document.getElementById('cancelBtn').addEventListener('click', function(e) {
            e.preventDefault();
            
            // Check if any fields have been modified (not empty)
            const nameValue = document.getElementById('supplier_name').value.trim();
            const phoneValue = document.getElementById('supplier_phone').value.trim();
            const addressValue = document.getElementById('supplier_address').value.trim();
            
            // If any field has content, show confirmation dialog
            if (nameValue !== '' || phoneValue !== '' || addressValue !== '') {
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
            } else {
                // No changes made, just redirect without confirmation
                window.location.href = '/admin/suppliers';
            }
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