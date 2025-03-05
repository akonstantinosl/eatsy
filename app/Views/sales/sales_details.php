<?php if (session()->get('user_role') == 'admin'): ?>
    <?= $this->extend('layout_admin') ?>
<?php elseif (session()->get('user_role') == 'staff'): ?>
    <?= $this->extend('layout_staff') ?>
<?php endif; ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Sale Details</h3>
        <div class="card-tools">
            <?php if ($sale['transaction_status'] === 'pending'): ?>
                <div class="btn-group">
                    <a href="/sales/update-status/<?= esc($sale['sale_id']) ?>/processing" 
                       class="btn btn-primary btn-sm" 
                       onclick="return confirm('Are you sure you want to process this sale?');">
                        <i class="fas fa-check"></i> Process Sale
                    </a>
                    <a href="/sales/update-status/<?= esc($sale['sale_id']) ?>/cancelled" 
                       class="btn btn-danger btn-sm ml-2" 
                       onclick="return confirm('Are you sure you want to cancel this sale?');">
                        <i class="fas fa-times"></i> Cancel Sale
                    </a>
                </div>
            <?php elseif ($sale['transaction_status'] === 'processing'): ?>
                <a href="/sales/update-status/<?= esc($sale['sale_id']) ?>/completed" 
                   class="btn btn-success btn-sm" 
                   onclick="return confirm('Are you sure you want to complete this sale? This action will update the stock.');">
                    <i class="fas fa-check-double"></i> Complete Sale
                </a>
            <?php endif; ?>
            
            <a href="/sales" class="btn btn-secondary btn-sm ml-2">
                <i class="fas fa-arrow-left"></i> Back to Sales
            </a>
        </div>
    </div>
    <div class="card-body">
        
        <!-- Sale Overview Table -->
        <h5>Sale Overview</h5>
        <table class="table table-bordered table-striped">
            <tr>
                <td><strong>Date</strong></td>
                <td><?= date('d F Y, H:i', strtotime($sale['created_at'])) ?></td> 
            </tr>
            <tr>
                <td><strong>Seller</strong></td>
                <td><?= esc($sale['seller_name']) ?></td>
            </tr>
            <tr>
                <td><strong>Customer</strong></td>
                <td><?= esc($sale['customer_name']) ?></td>
            </tr>
            <tr>
                <td><strong>Contact</strong></td>
                <td><?= esc($sale['customer_phone']) ?></td>
            </tr>
            <tr>
                <td><strong>Payment Method</strong></td>
                <td>
                    <?php 
                        $paymentMethod = '';
                        switch ($sale['payment_method']) {
                            case 'cash':
                                $paymentMethod = 'Cash';
                                break;
                            case 'credit_card':
                                $paymentMethod = 'Credit Card';
                                break;
                            case 'debit_card':
                                $paymentMethod = 'Debit Card';
                                break;
                            case 'e-wallet':
                                $paymentMethod = 'E-Wallet';
                                break;
                            default:
                                $paymentMethod = 'Unknown';
                        }
                    ?>
                    <?= $paymentMethod ?>
                </td>
            </tr>
            <tr>
                <td><strong>Notes</strong></td>
                <td><?= empty($sale['sale_notes']) ? '-' : esc($sale['sale_notes']) ?></td>
            </tr>
            <tr>
                <td><strong>Status</strong></td>
                <td>
                    <?php 
                        $statusClass = '';
                        $statusText = '';

                        switch ($sale['transaction_status']) {
                            case 'pending':
                                $statusClass = 'badge-warning';
                                $statusText = 'Pending';
                                break;
                            case 'processing':
                                $statusClass = 'badge-info';
                                $statusText = 'Processing';
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
                    
                    <?php if ($sale['transaction_status'] === 'completed'): ?>
                        <small class="text-success ml-2">
                            <i class="fas fa-info-circle"></i> Product stock has been updated.
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
                    <th>Quantity</th>
                    <th>Price per Unit</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($sale_details)): ?>
                    <tr>
                        <td colspan="5" class="text-center">Sale Detail not Found</td>
                    </tr>
                <?php else: ?>
                    <?php $grandTotal = 0; ?>
                    <?php foreach ($sale_details as $index => $detail): ?>
                        <?php 
                            $totalPrice = $detail['quantity_sold'] * $detail['price_per_unit'];
                            $grandTotal += $totalPrice;
                        ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= esc($detail['product_name']) ?></td>
                            <td><?= esc($detail['quantity_sold']) ?></td>
                            <td><?= number_format($detail['price_per_unit'], 0, ',', '.') . " IDR" ?></td>
                            <td><?= number_format($totalPrice, 0, ',', '.') . " IDR" ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4" class="text-right"><strong>Total</strong></td>
                        <td><strong><?= number_format($grandTotal, 0, ',', '.') . " IDR" ?></strong></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>