<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Purchase Details</h3>
        <div class="card-tools">
            <?php if ($purchase['order_status'] === 'pending'): ?>
                <div class="btn-group">
                    <a href="/admin/purchases/update-status/<?= esc($purchase['purchase_id']) ?>/ordered" 
                       class="btn btn-primary btn-sm" 
                       onclick="return confirm('Are you sure you want to process this order?');">
                        <i class="fas fa-check"></i> Process Order
                    </a>
                    <a href="/admin/purchases/update-status/<?= esc($purchase['purchase_id']) ?>/cancelled" 
                       class="btn btn-danger btn-sm ml-2" 
                       onclick="return confirm('Are you sure you want to cancel this order?');">
                        <i class="fas fa-times"></i> Reject Order
                    </a>
                </div>
            <?php elseif ($purchase['order_status'] === 'ordered'): ?>
                <a href="/admin/purchases/update-status/<?= esc($purchase['purchase_id']) ?>/completed" 
                   class="btn btn-success btn-sm" 
                   onclick="return confirm('Are you sure the goods have been received? This action will update the stock and product price.');">
                    <i class="fas fa-check-double"></i> Mark as Received
                </a>
            <?php endif; ?>
            
            <a href="/admin/purchases" class="btn btn-secondary btn-sm ml-2">
                <i class="fas fa-arrow-left"></i> Back to Purchase
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
                <td><strong>Notes</strong></td>
                <td><?= empty($purchase['purchase_notes']) ? '-' : esc($purchase['purchase_notes']) ?></td>
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
                    
                    <?php if ($purchase['order_status'] === 'completed'): ?>
                        <small class="text-success ml-2">
                            <i class="fas fa-info-circle"></i> Stock and product prices have been updated.
                        </small>
                    <?php endif; ?>
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
                <?php if (empty($purchase_details)): ?>
                    <tr>
                        <td colspan="7" class="text-center">Purchase Detail not Found</td>
                    </tr>
                <?php else: ?>
                    <?php $grandTotal = 0; ?>
                    <?php foreach ($purchase_details as $index => $detail): ?>
                        <?php 
                            $totalUnits = $detail['box_bought'] * $detail['unit_per_box'];
                            $totalPrice = $detail['box_bought'] * $detail['price_per_box'];
                            $grandTotal += $totalPrice;
                        ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= esc($detail['product_name']) ?></td>
                            <td><?= esc($detail['box_bought']) ?></td>
                            <td><?= esc($detail['unit_per_box']) ?></td>
                            <td><?= esc($totalUnits) ?></td>
                            <td><?= number_format($detail['price_per_box'], 0, ',', '.') . " IDR" ?></td>
                            <td><?= number_format($totalPrice, 0, ',', '.') . " IDR" ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="6" class="text-right"><strong>Total</strong></td>
                        <td><strong><?= number_format($grandTotal, 0, ',', '.') . " IDR" ?></strong></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
