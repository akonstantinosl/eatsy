<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Purchase List</h3>
        <div class="card-tools">
            <a href="/admin/purchases/supplier" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add New Purchase
            </a>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table id="purchaseTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Buyer</th>
                    <th>Supplier</th>
                    <th>Contact</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($purchases as $index => $purchase): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= date('d F Y, H:i', strtotime($purchase['purchase_date'])) ?></td> 
                        <td><?= esc($purchase['user_fullname']) ?></td>
                        <td><?= esc($purchase['supplier_name']) ?></td>
                        <td><?= esc($purchase['supplier_phone']) ?></td>
                        <td><?= number_format($purchase['purchase_amount'], 0, ',', '.') . " IDR" ?></td>
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
                        <td>
                            <a href="/admin/purchases/details/<?= esc($purchase['purchase_id']) ?>" class="btn btn-info btn-sm">
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
        $('#purchaseTable').DataTable();
    });
</script>
<?= $this->endSection() ?>
