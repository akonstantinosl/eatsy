<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Purchase Transaction Report</h3>
        <div class="card-tools">
            <a href="<?= base_url('admin/reports/purchases') ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <a href="<?= base_url('admin/reports/purchases/export-pdf?' . http_build_query([
                'start_date' => $start_date,
                'end_date' => $end_date
            ])) ?>" class="btn btn-danger btn-sm ml-2" target="_blank">
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
                        <th>Buyer</th>
                        <th>Supplier</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $totalAmount = 0;
                    foreach ($purchases as $purchase): 
                        $totalAmount += $purchase['purchase_amount'];
                        
                        if (empty($purchase['products'])) {
                            ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($purchase['created_at'])) ?></td>
                                <td><?= esc($purchase['user_fullname']) ?></td>
                                <td><?= esc($purchase['supplier_name']) ?></td>
                                <td>No products</td>
                                <td>0</td>
                                <td><?= number_format($purchase['purchase_amount'], 0, ',', '.') . " IDR" ?></td>
                            </tr>
                            <?php
                        } else {
                            // Show each product on a separate row with repeated purchase information
                            foreach ($purchase['products'] as $index => $product): ?>
                                <tr>
                                    <td><?= date('d/m/Y H:i', strtotime($purchase['created_at'])) ?></td>
                                    <td><?= esc($purchase['user_fullname']) ?></td>
                                    <td><?= esc($purchase['supplier_name']) ?></td>
                                    <td><?= esc($product['product_name']) ?></td>
                                    <td><?= $product['quantity'] ?></td>
                                    <td><?= number_format($product['amount'], 0, ',', '.') . " IDR" ?></td>
                                </tr>
                            <?php 
                            endforeach;
                        }
                    endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-right">Total Amount</th>
                        <th><?= number_format($totalAmount, 0, ',', '.') . " IDR" ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
