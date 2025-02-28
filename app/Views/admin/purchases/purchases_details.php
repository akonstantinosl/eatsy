<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <div class="card-tools">
            <a href="/admin/purchases" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back to Purchases List
            </a>
        </div>
    </div>
    <div class="card-body">
        
        <!-- Purchase Overview Table -->
        <h5>Purchase Overview</h5>
        <table class="table table-bordered table-striped">
            <tr>
                <td><strong>Date</strong></td>
                <td><?= date('d F Y, H:i', strtotime($purchase['created_at'])) ?></td> 
            </tr>
            <tr>
                <td><strong>Buyer</strong></td>
                <td><?= esc($purchase['buyer_name']) ?></td>
            </tr>
            <tr>
                <td><strong>Supplier</strong></td>
                <td><?= esc($purchase['supplier_name']) ?></td>
            </tr>
            <tr>
                <td><strong>Contact</strong></td>
                <td><?= esc($purchase['supplier_phone']) ?></td>
            </tr>
            <tr>
                <td><strong>Amount</strong></td>
                <td><?= number_format($purchase['purchase_amount'], 0, ',', '.') . " IDR" ?></td>
            </tr>
            <tr>
                <td><strong>Notes</strong></td>
                <td><?= esc($purchase['purchase_notes']) ?></td>
            </tr>
            <tr>
                <td><strong>Status</strong></td>
                <td>
                    <?php 
                        $statusClass = '';
                        $statusText = '';

                        switch ($purchase['order_status']) {
                            case 'pending':
                                $statusClass = 'badge-warning';
                                $statusText = 'Pending';
                                break;
                            case 'ordered':
                                $statusClass = 'badge-info';
                                $statusText = 'Ordered';
                                break;
                            case 'completed':
                                $statusClass = 'badge-success';
                                $statusText = 'Completed';
                                break;
                            case 'cancelled':
                                $statusClass = 'badge-danger';
                                $statusText = 'Cancelled';
                                break;
                            default:
                                $statusClass = 'badge-secondary';
                                $statusText = 'Unknown';
                        }
                    ?>
                    <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                </td>
            </tr>
        </table>
        
        <div class="mt-4"></div> 

        <!-- Product Details Table -->
        <h5>Product Details</h5>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Box Bought</th>
                    <th>Unit per Box</th>
                    <th>Price per Box</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($purchase_details as $index => $detail): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= esc($detail['product_name']) ?></td>
                        <td><?= esc($detail['box_bought']) ?></td>
                        <td><?= esc($detail['unit_per_box']) ?></td>
                        <td><?= number_format($detail['price_per_box'], 0, ',', '.') . " IDR" ?></td>
                        <td><?= number_format($detail['box_bought'] * $detail['price_per_box'], 0, ',', '.') . " IDR" ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
