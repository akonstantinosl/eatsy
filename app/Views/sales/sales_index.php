<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Sales List</h3>
        <div class="card-tools">
            <a href="/sales/customer" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> New Sale
            </a>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table id="salesTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Seller</th>
                    <th>Customer</th>
                    <th>Contact</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sales as $index => $sale): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= date('d F Y, H:i', strtotime($sale['created_at'])) ?></td> 
                        <td><?= esc($sale['user_fullname']) ?></td>
                        <td><?= esc($sale['customer_name']) ?></td>
                        <td><?= esc($sale['customer_phone']) ?></td>
                        <td><?= number_format($sale['sale_amount'], 0, ',', '.') . " IDR" ?></td>
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
                        </td>
                        <td>
                            <a href="/sales/details/<?= esc($sale['sale_id']) ?>" class="btn btn-info btn-sm mr-2">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#salesTable').DataTable();
    });
</script>
<?= $this->endSection() ?>