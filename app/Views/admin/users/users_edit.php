<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit User</h3>
        <div class="card-tools">
            <a href="/admin/users" class="btn btn-default btn-sm" style="background-color: #5a6268; color: white;">
                <i class="fas fa-arrow-left"></i> Back to Users
            </a>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <form action="/admin/users/update/<?= $user['user_id'] ?>" method="post" enctype="multipart/form-data" id="userForm">
            <div class="row">
                <div class="col-md-9">
                <!-- Username field with error message positioned correctly -->
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control <?= session()->has('errors') && isset(session('errors')['username']) ? 'is-invalid' : '' ?>" 
                        id="username" name="username" value="<?= old('username', $user['user_name']) ?>" required data-original-value="<?= $user['user_name'] ?>">
                    <?php if (session()->has('errors') && isset(session('errors')['username'])): ?>
                        <div class="invalid-feedback">
                            <?= session('errors')['username'] ?>
                        </div>
                    <?php endif; ?>
                    <small class="text-muted">Username must be unique and at least 3 characters long</small>
                </div>

                <!-- Password field with error message positioned correctly -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control <?= session()->has('errors') && isset(session('errors')['password']) ? 'is-invalid' : '' ?>" 
                        id="password" name="password">
                    <?php if (session()->has('errors') && isset(session('errors')['password'])): ?>
                        <div class="invalid-feedback">
                            <?= session('errors')['password'] ?>
                        </div>
                    <?php endif; ?>
                    <small class="text-muted">Leave blank to keep current password</small>
                </div>

                <!-- Full Name field with error message positioned correctly -->
                <div class="form-group">
                    <label for="fullname">Full Name</label>
                    <input type="text" class="form-control <?= session()->has('errors') && isset(session('errors')['fullname']) ? 'is-invalid' : '' ?>" 
                        id="fullname" name="fullname" value="<?= old('fullname', $user['user_fullname']) ?>" required data-original-value="<?= $user['user_fullname'] ?>">
                    <?php if (session()->has('errors') && isset(session('errors')['fullname'])): ?>
                        <div class="invalid-feedback">
                            <?= session('errors')['fullname'] ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Phone field with error message positioned correctly -->
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" class="form-control <?= session()->has('errors') && isset(session('errors')['phone']) ? 'is-invalid' : '' ?>" 
                        id="phone" name="phone" value="<?= old('phone', $user['user_phone']) ?>" data-original-value="<?= $user['user_phone'] ?>">
                    <?php if (session()->has('errors') && isset(session('errors')['phone'])): ?>
                        <div class="invalid-feedback">
                            <?= session('errors')['phone'] ?>
                        </div>
                    <?php endif; ?>
                    <small class="text-muted">Phone number must be unique and at least 10 digits</small>
                </div>
                    
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control <?= session()->has('errors') && isset(session('errors')['role']) ? 'is-invalid' : '' ?>" 
                            id="role" name="role" required data-original-value="<?= $user['user_role'] ?>">
                            <option value="admin" <?= (old('role', $user['user_role']) == 'admin') ? 'selected' : '' ?>>Admin</option>
                            <option value="staff" <?= (old('role', $user['user_role']) == 'staff') ? 'selected' : '' ?>>Staff</option>
                        </select>
                        <?php if (session()->has('errors') && isset(session('errors')['role'])): ?>
                            <div class="invalid-feedback">
                                <?= session('errors')['role'] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Hidden Status Field - Keeps the current value -->
                    <input type="hidden" name="status" value="<?= old('status', $user['user_status']) ?>">
                </div>
                
                <div class="col-md-3">
                    <div class="form-group text-center">
                        <label>User Photo</label>
                        <div class="mt-2 mb-3">
                            <?php
                            // Determine if the photo is a default one stored in assets/image or a user-uploaded one
                            $photoPath = (in_array($user['user_photo'], ['default_admin.png', 'default_staff.png']))
                                ? base_url('assets/image/' . $user['user_photo'])
                                : base_url('uploads/users/' . $user['user_photo']);
                            ?>
                            <img id="preview-image" src="<?= $photoPath ?>" 
                                alt="User Photo" class="img-circle elevation-2" style="width: 150px; height: 150px; object-fit: cover;"
                                onerror="this.onerror=null; this.src='<?= base_url('assets/image/default_staff.png') ?>';">
                        </div>
                        <div class="custom-file mt-3">
                            <input type="file" class="custom-file-input <?= session()->has('errors') && isset(session('errors')['photo']) ? 'is-invalid' : '' ?>" 
                                id="photo" name="photo" accept="image/*" onchange="previewImage()">
                            <label class="custom-file-label" for="photo">Choose new photo</label>
                            <?php if (session()->has('errors') && isset(session('errors')['photo'])): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors')['photo'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <small class="text-muted">Leave blank to keep current photo</small>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="button" class="btn btn-primary mr-2" id="saveBtn">Update</button>
                <a href="/admin/users" class="btn btn-default" id="cancelBtn">Cancel</a>
            </div>
        </form>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

<script>
    function previewImage() {
        const preview = document.getElementById('preview-image');
        const file = document.getElementById('photo').files[0];
        const reader = new FileReader();
        
        reader.onloadend = function() {
            preview.src = reader.result;
        }
        
        if (file) {
            reader.readAsDataURL(file);
        } else {
            // If no file is selected, revert to current user photo
            const currentPhoto = '<?= $photoPath ?>';
            preview.src = currentPhoto;
        }
    }
    
    // Update preview image when role changes if using default image
    document.getElementById('role').addEventListener('change', function() {
        const currentPhoto = '<?= $user['user_photo'] ?>';
        // Only change preview if current photo is a default one and no new file is selected
        if ((currentPhoto === 'default_admin.png' || currentPhoto === 'default_staff.png') && 
            !document.getElementById('photo').files[0]) {
            const role = this.value;
            document.getElementById('preview-image').src = '<?= base_url('assets/image/') ?>' + 
                (role === 'admin' ? 'default_admin.png' : 'default_staff.png');
        }
    });

    // Function to check if form has been modified
    function isFormModified() {
        // Check text inputs and selects with data-original-value
        const modifiableElements = document.querySelectorAll('[data-original-value]');
        for (const element of modifiableElements) {
            if (element.value !== element.getAttribute('data-original-value')) {
                return true;
            }
        }
        
        // Check password field (any input means modification)
        if (document.getElementById('password').value !== '') {
            return true;
        }
        
        // Check if a file has been selected for upload
        if (document.getElementById('photo').files.length > 0) {
            return true;
        }
        
        return false;
    }

    // SweetAlert for Save Button Confirmation
    document.getElementById('saveBtn').addEventListener('click', function(event) {
        event.preventDefault();
        
        // Basic client-side validation
        const username = document.getElementById('username').value.trim();
        const fullname = document.getElementById('fullname').value.trim();
        const phone = document.getElementById('phone').value.trim();
        let hasErrors = false;
        let errorMessages = [];
        
        if (username === '') {
            errorMessages.push('Username is required');
            hasErrors = true;
        } else if (username.length < 3) {
            errorMessages.push('Username must be at least 3 characters long');
            hasErrors = true;
        }
        
        if (fullname === '') {
            errorMessages.push('Full Name is required');
            hasErrors = true;
        }
        
        if (phone !== '' && phone.length < 10) {
            errorMessages.push('Phone number must be at least 10 digits');
            hasErrors = true;
        }
        
        if (hasErrors) {
            Swal.fire({
                title: 'Validation Error',
                html: errorMessages.join('<br>'),
                icon: 'error',
                confirmButtonColor: '#3085d6'
            });
            return;
        }
        
        Swal.fire({
            title: 'Are you sure you want to update this user?',
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
                document.getElementById('userForm').submit();
            }
        });
    });

    // SweetAlert for Cancel Button Confirmation - only show if changes were made
    document.getElementById('cancelBtn').addEventListener('click', function(e) {
        e.preventDefault();
        
        // If the form has been modified, show confirmation dialog
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
                    window.location.href = '/admin/users';  // Redirect back to users page
                }
            });
        } else {
            // If no changes were made, just redirect without confirmation
            window.location.href = '/admin/users';
        }
    });

    // Initialize BS Custom File Input
    document.addEventListener('DOMContentLoaded', function() {
        bsCustomFileInput.init();
        
        // Add phone number format validation
        document.getElementById('phone').addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, ''); // Remove non-numeric characters
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