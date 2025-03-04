<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Sales Transaction Report</h3>
        <div class="card-tools">
            <a href="<?= base_url('admin/reports/sales') ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <a href="<?= base_url('admin/reports/sales/export-pdf?start_date=' . $start_date . '&end_date=' . $end_date) ?>" class="btn btn-sm btn-danger ml-2">
                <i class="fas fa-file-pdf"></i> Export to PDF
            </a>
        </div>
    </div>
    <div class="card-body">
        <h4><?= $periodTitle ?></h4>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Seller</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $totalAmount = 0;
                    foreach ($sales as $sale): 
                        $totalAmount += $sale['sale_amount'];
                        
                        if (empty($sale['products'])): ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($sale['created_at'])) ?></td>
                                <td><?= $sale['user_fullname'] ?></td>
                                <td><?= $sale['customer_name'] ?></td>
                                <td>No products</td>
                                <td>0</td>
                                <td><?= number_format($sale['sale_amount'], 0, ',', '.') ?> IDR</td>
                            </tr>
                        <?php else:
                            foreach ($sale['products'] as $product): ?>
                                <tr>
                                    <td><?= date('d/m/Y H:i', strtotime($sale['created_at'])) ?></td>
                                    <td><?= $sale['user_fullname'] ?></td>
                                    <td><?= $sale['customer_name'] ?></td>
                                    <td><?= $product['product_name'] ?></td>
                                    <td><?= $product['quantity'] ?></td>
                                    <td><?= number_format($product['amount'], 0, ',', '.') ?> IDR</td>
                                </tr>
                            <?php endforeach;
                        endif;
                    endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-right">Total Amount:</th>
                        <th><?= number_format($totalAmount, 0, ',', '.') ?> IDR</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
