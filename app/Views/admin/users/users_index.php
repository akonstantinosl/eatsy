<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">User List</h3>
        <div class="card-tools">
            <a href="/admin/users/create" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add New User
            </a>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $index => $user): ?>
                    <?php if ($user['user_status'] == 'active'): ?>
                    <tr>
                        <!-- Correct row numbering -->
                        <td><?= $index + 1 ?></td>
                        <td><?= $user['user_name'] ?></td>
                        <td><?= $user['user_fullname'] ?></td>
                        <td><?= $user['user_phone'] ?></td>
                        <td>
                            <?php if ($user['user_role'] == 'admin'): ?>
                                <span class="badge badge-primary">Admin</span>
                            <?php else: ?>
                                <span class="badge badge-info">Staff</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="/admin/users/edit/<?= $user['user_id'] ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <?php if ($user['user_id'] != session()->get('user_id')): ?>
                            <a href="/admin/users/delete/<?= $user['user_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to set this user as inactive?');">
                                <i class="fas fa-trash"></i> Inactive
                            </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if (empty($users)): ?>
                <tr>
                    <td colspan="7" class="text-center">No active users found</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
<?= $this->endSection() ?>
