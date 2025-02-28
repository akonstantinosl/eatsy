<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Supplier List</h3>
        <div class="card-tools">
            <a href="/admin/suppliers/create" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add New Supplier
            </a>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($suppliers as $index => $supplier): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= esc($supplier['supplier_name']) ?></td>
                        <td><?= esc($supplier['supplier_phone']) ?></td>
                        <td><?= esc($supplier['supplier_address']) ?></td>
                        <td>
                            <a href="/admin/suppliers/edit/<?= esc($supplier['supplier_id']) ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <!-- Update the form to use GET method for supplier deletion -->
                            <a href="/admin/suppliers/delete/<?= esc($supplier['supplier_id']) ?>" 
                            class="btn btn-danger btn-sm" 
                            onclick="return confirm('Are you sure you want to set this supplier as inactive?')">
                                <i class="fas fa-trash"></i> Inactive
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
