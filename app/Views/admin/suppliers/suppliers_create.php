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
        <?php if (session()->has('errors')): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    
        <form action="/admin/suppliers/store" method="post">
            <div class="form-group">
                <label for="supplier_name">Supplier Name</label>
                <input type="text" class="form-control" id="supplier_name" name="supplier_name" value="<?= old('supplier_name') ?>" required>
            </div>

            <div class="form-group">
                <label for="supplier_phone">Phone Number</label>
                <input type="text" class="form-control" id="supplier_phone" name="supplier_phone" value="<?= old('supplier_phone') ?>" required>
            </div>

            <div class="form-group">
                <label for="supplier_address">Address</label>
                <textarea class="form-control" id="supplier_address" name="supplier_address" rows="4" required><?= old('supplier_address') ?></textarea>
            </div>

            <!-- Hidden input for status -->
            <input type="hidden" name="supplier_status" value="active">

            <button type="submit" class="btn btn-primary mr-2">Save</button>
            <a href="/admin/suppliers" class="btn btn-default">Cancel</a>
        </form>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
<?= $this->endSection() ?>
