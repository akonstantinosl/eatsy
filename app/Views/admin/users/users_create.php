<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Add New User</h3>
        <div class="card-tools">
            <a href="/admin/users" class="btn btn-default btn-sm">
                <i class="fas fa-arrow-left"></i> Back to Users
            </a>
        </div>
    </div>
    <!-- /.card-header -->
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
    
        <form action="/admin/users/store" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= old('username') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="fullname">Full Name</label>
                <input type="text" class="form-control" id="fullname" name="fullname" value="<?= old('fullname') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?= old('phone') ?>">
            </div>
            
            <div class="form-group">
                <label for="photo">Profile Photo</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="photo" name="photo" accept="image/*">
                        <label class="custom-file-label" for="photo">Choose file</label>
                    </div>
                </div>
                <small class="text-muted">Leave blank to use default photo</small>
            </div>
            
            <div class="form-group">
                <label for="role">Role</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="staff" <?= old('role') == 'staff' ? 'selected' : '' ?>>Staff</option>
                </select>
            </div>
            
            <div class="form-group">
                <input type="hidden" name="status" value="active"> <!-- Hidden input for status -->
            </div>
            
            <button type="submit" class="btn btn-primary" style="margin-right: 10px;">Save</button>
            <a href="/admin/users" class="btn btn-default">Cancel</a>
        </form>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
<?= $this->endSection() ?>
