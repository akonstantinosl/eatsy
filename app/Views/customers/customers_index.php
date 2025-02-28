<?php if (session()->get('user_role') == 'admin'): ?>
    <?= $this->extend('layout_admin') ?>
<?php elseif (session()->get('user_role') == 'staff'): ?>
    <?= $this->extend('layout_staff') ?>
<?php endif; ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Customer List</h3>
        <div class="card-tools">
            <a href="/customers/create" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add New customer
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
                    <?php if (session()->get('user_role') == 'admin'): ?>
                        <th>Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $index => $customer): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= esc($customer['customer_name']) ?></td>
                        <td><?= esc($customer['customer_phone']) ?></td>
                        <td><?= esc($customer['customer_address']) ?></td>
                        <?php if (session()->get('user_role') == 'admin'): ?>
                            <td>
                                <a href="/customers/edit/<?= esc($customer['customer_id']) ?>" class="btn btn-warning btn-sm mr-2">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <!-- Update the form to use GET method for customer deletion -->
                                <a href="/customers/delete/<?= esc($customer['customer_id']) ?>" 
                                class="btn btn-danger btn-sm" 
                                onclick="return confirm('Are you sure you want to set this customer as inactive?')">
                                    <i class="fas fa-trash"></i> Inactive
                                </a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
