<?php if (session()->get('user_role') == 'admin'): ?>
    <?= $this->extend('layout_admin') ?>
<?php elseif (session()->get('user_role') == 'staff'): ?>
    <?= $this->extend('layout_staff') ?>
<?php endif; ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Customer</h3>
        <div class="card-tools">
            <a href="/customers" class="btn btn-sm" style="background-color: #5a6268; color: white;">
                <i class="fas fa-arrow-left"></i> Back to Customers
            </a>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <form id="customerForm" action="/customers/update/<?= $customer['customer_id'] ?>" method="post">
            <div class="form-group">
                <label for="customer_name">Customer Name</label>
                <input type="text" class="form-control <?= session()->has('errors') && isset(session('errors')['customer_name']) ? 'is-invalid' : '' ?>" id="customer_name" name="customer_name" value="<?= old('customer_name', $customer['customer_name']) ?>" required data-original-value="<?= $customer['customer_name'] ?>">
                <?php if (session()->has('errors') && isset(session('errors')['customer_name'])): ?>
                    <div class="invalid-feedback">
                        <?= session('errors')['customer_name'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="customer_phone">Phone Number</label>
                <input type="text" class="form-control <?= session()->has('errors') && isset(session('errors')['customer_phone']) ? 'is-invalid' : '' ?>" id="customer_phone" name="customer_phone" value="<?= old('customer_phone', $customer['customer_phone']) ?>" required data-original-value="<?= $customer['customer_phone'] ?>">
                <?php if (session()->has('errors') && isset(session('errors')['customer_phone'])): ?>
                    <div class="invalid-feedback">
                        <?= session('errors')['customer_phone'] ?>
                    </div>
                <?php endif; ?>
                <small class="text-muted">Phone number must be unique and at least 10 digits.</small>
            </div>

            <div class="form-group">
                <label for="customer_address">Address</label>
                <textarea class="form-control <?= session()->has('errors') && isset(session('errors')['customer_address']) ? 'is-invalid' : '' ?>" id="customer_address" name="customer_address" rows="4" required data-original-value="<?= $customer['customer_address'] ?>"><?= old('customer_address', $customer['customer_address']) ?></textarea>
                <?php if (session()->has('errors') && isset(session('errors')['customer_address'])): ?>
                    <div class="invalid-feedback">
                        <?= session('errors')['customer_address'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Hidden input for status (can't be edited) -->
            <input type="hidden" name="customer_status" value="<?= $customer['customer_status'] ?>">

            <button type="button" id="saveBtn" class="btn btn-primary mr-2"><i class="fas fa-save"></i> Update</button>
            <a href="/customers" id="cancelBtn" class="btn btn-default"><i class="fas fa-times"></i> Cancel</a>
        </form>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize any form plugins if necessary
        if (typeof bsCustomFileInput !== 'undefined') {
            bsCustomFileInput.init();
        }
        
        // Store original values for comparison
        let originalName = '<?= addslashes($customer['customer_name']) ?>';
        let originalPhone = '<?= $customer['customer_phone'] ?>';
        let originalAddress = '<?= addslashes($customer['customer_address']) ?>';
        
        // Add input validation for phone number to ensure it's numeric
        document.getElementById('customer_phone').addEventListener('input', function(e) {
            // Replace any non-numeric characters with empty string
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Function to check if form has been modified
        function isFormModified() {
            const nameChanged = document.getElementById('customer_name').value.trim() !== originalName;
            const phoneChanged = document.getElementById('customer_phone').value.trim() !== originalPhone;
            const addressChanged = document.getElementById('customer_address').value.trim() !== originalAddress;
            
            return nameChanged || phoneChanged || addressChanged;
        }

        // Save Button Confirmation
        document.getElementById('saveBtn').addEventListener('click', function() {
            // First validate the phone input before submission
            const phoneInput = document.getElementById('customer_phone');
            const nameInput = document.getElementById('customer_name');
            const addressInput = document.getElementById('customer_address');
            let hasErrors = false;
            let errorMessages = [];
            
            // Validate required fields
            if (nameInput.value.trim() === '') {
                errorMessages.push('Customer name is required.');
                nameInput.classList.add('is-invalid');
                hasErrors = true;
            }
            
            if (phoneInput.value.trim() === '') {
                errorMessages.push('Phone number is required.');
                phoneInput.classList.add('is-invalid');
                hasErrors = true;
            } else if (phoneInput.value.trim().length < 10) {
                errorMessages.push('Phone number must be at least 10 digits.');
                phoneInput.classList.add('is-invalid');
                hasErrors = true;
            }
            
            if (addressInput.value.trim() === '') {
                errorMessages.push('Address is required.');
                addressInput.classList.add('is-invalid');
                hasErrors = true;
            }
            
            if (hasErrors) {
                Swal.fire({
                    title: 'Validation Error',
                    html: errorMessages.join('<br>'),
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
                return;
            }
            
            Swal.fire({
                title: 'Are you sure you want to update?',
                text: 'You can review and edit the information before updating.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('customerForm').submit();
                }
            });
        });

        // Cancel Button Confirmation - only show if changes were made
        document.getElementById('cancelBtn').addEventListener('click', function(e) {
            e.preventDefault();
            
            // Check if any values have changed
            if (isFormModified()) {
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
                        window.location.href = '/customers';  // Redirect back to the customers page
                    }
                });
            } else {
                // No changes, just redirect
                window.location.href = '/customers';
            }
        });

        // Display SweetAlert for error message if it exists (single error message)
        <?php if (session()->has('error')): ?>
            Swal.fire({
                title: 'Error!',
                text: '<?= session()->getFlashdata('error') ?>',
                icon: 'error',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        <?php endif; ?>

        // Display SweetAlert for validation errors if they exist (multiple error messages)
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