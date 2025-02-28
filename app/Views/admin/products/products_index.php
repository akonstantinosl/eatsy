<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Product List</h3>
        <div class="card-tools">
            <a href="/admin/products/create" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add New Product
            </a>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Supplier</th>
                    <th>Stock</th>
                    <th>Purchase Price</th>
                    <th>Selling Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $index => $product): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= esc($product['product_name']) ?></td>
                        <td><?= esc($product['product_category_name']) ?></td>
                        <td><?= esc($product['supplier_name']) ?></td>
                        <td><?= esc($product['product_stock']) ?></td>
                        <td><?= number_format($product['purchase_price'], 0, ',', '.') . " IDR" ?></td>
                        <td><?= number_format($product['selling_price'], 0, ',', '.') . " IDR" ?></td>
                        <td>
                            <a href="/admin/products/edit/<?= esc($product['product_id']) ?>" class="btn btn-warning btn-sm mr-2">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="/admin/products/delete/<?= esc($product['product_id']) ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Are you sure you want to deactivate this product?')">
                                <i class="fas fa-trash"></i> Inactivate
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
