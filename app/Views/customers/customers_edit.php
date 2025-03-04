<?php if (session()->get('user_role') == 'admin'): ?>
    <?= $this->extend('layout_admin') ?>
<?php elseif (session()->get('user_role') == 'staff'): ?>
    <?= $this->extend('layout_staff') ?>
<?php endif; ?>


<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit customer</h3>
        <div class="card-tools">
            <a href="/customers" class="btn btn-sm" style="background-color: #5a6268; color: white;">
                <i class="fas fa-arrow-left"></i> Back to customers
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
    
        <form action="/customers/update/<?= $customer['customer_id'] ?>" method="post">
            <div class="form-group">
                <label for="customer_name">Customer Name</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?= old('customer_name', $customer['customer_name']) ?>" required>
            </div>

            <div class="form-group">
                <label for="customer_phone">Phone Number</label>
                <input type="text" class="form-control" id="customer_phone" name="customer_phone" value="<?= old('customer_phone', $customer['customer_phone']) ?>" required>
            </div>

            <div class="form-group">
                <label for="customer_address">Address</label>
                <textarea class="form-control" id="customer_address" name="customer_address" rows="4" required><?= old('customer_address', $customer['customer_address']) ?></textarea>
            </div>

            <!-- Hidden input for status (can't be edited) -->
            <input type="hidden" name="customer_status" value="<?= $customer['customer_status'] ?>">

            <button type="submit" class="btn btn-primary mr-2">Update</button>
            <a href="/customers" class="btn btn-default">Cancel</a>
        </form>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
<?= $this->endSection() ?>
