<?php if (session()->get('user_role') == 'admin'): ?>
    <?= $this->extend('layout_admin') ?>
<?php elseif (session()->get('user_role') == 'staff'): ?>
    <?= $this->extend('layout_staff') ?>
<?php endif; ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Add New Customer</h3>
        <div class="card-tools">
            <a href="/customers" class="btn btn-sm" style="background-color: #5a6268; color: white;">
                <i class="fas fa-arrow-left"></i> Back to Customers
            </a>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <form id="customerForm" action="/customers/store" method="post">
            <div class="form-group">
                <label for="customer_name">Customer Name</label>
                <input type="text" class="form-control <?= session()->has('errors') && isset(session('errors')['customer_name']) ? 'is-invalid' : '' ?>" id="customer_name" name="customer_name" value="<?= old('customer_name') ?>" required>
                <?php if (session()->has('errors') && isset(session('errors')['customer_name'])): ?>
                    <div class="invalid-feedback">
                        <?= session('errors')['customer_name'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="customer_phone">Phone Number</label>
                <input type="text" class="form-control <?= session()->has('errors') && isset(session('errors')['customer_phone']) ? 'is-invalid' : '' ?>" id="customer_phone" name="customer_phone" value="<?= old('customer_phone') ?>" required>
                <?php if (session()->has('errors') && isset(session('errors')['customer_phone'])): ?>
                    <div class="invalid-feedback">
                        <?= session('errors')['customer_phone'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="customer_address">Address</label>
                <textarea class="form-control <?= session()->has('errors') && isset(session('errors')['customer_address']) ? 'is-invalid' : '' ?>" id="customer_address" name="customer_address" rows="4" required><?= old('customer_address') ?></textarea>
                <?php if (session()->has('errors') && isset(session('errors')['customer_address'])): ?>
                    <div class="invalid-feedback">
                        <?= session('errors')['customer_address'] ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Hidden input for status -->
            <input type="hidden" name="customer_status" value="active">

            <button type="button" id="saveBtn" class="btn btn-primary mr-2">Save</button>
            <a href="/customers" id="cancelBtn" class="btn btn-default">Cancel</a>
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
        
        // Add input validation for phone number to ensure it's numeric
        document.getElementById('customer_phone').addEventListener('input', function(e) {
            // Replace any non-numeric characters with empty string
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Save Button Confirmation
        document.getElementById('saveBtn').addEventListener('click', function() {
            // First validate the phone input before submission
            const phoneInput = document.getElementById('customer_phone');
            if (!/^\d+$/.test(phoneInput.value)) {
                Swal.fire({
                    title: 'Validation Error',
                    text: 'The phone number field must contain only numbers.',
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
                phoneInput.focus();
                return;
            }
            
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
                    document.getElementById('customerForm').submit();
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
                    window.location.href = '/customers';  // Redirect back to the customers page
                }
            });
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