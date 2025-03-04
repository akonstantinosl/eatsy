<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Sales Transaction Report</h3>
        <div class="card-tools">
            <a href="<?= base_url('admin/reports/sales') ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <a href="<?= base_url('admin/reports/sales/export-pdf?' . http_build_query([
                'start_date' => $start_date,
                'end_date' => $end_date
            ])) ?>" class="btn btn-danger btn-sm ml-2" target="_blank">
                <i class="fas fa-file-pdf"></i> Export to PDF
            </a>
        </div>
    </div>
    <div class="card-body">
        <h4><?= $periodTitle ?></h4>
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> This report only includes data from completed sales transactions.
        </div>

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
                    foreach ($sales as $sale): 
                        if (empty($sale['products'])) {
                            ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($sale['created_at'])) ?></td>
                                <td><?= esc($sale['user_fullname']) ?></td>
                                <td><?= esc($sale['customer_name']) ?></td>
                                <td>No products</td>
                                <td>0</td>
                                <td><?= number_format($sale['sale_amount'], 0, ',', '.') . " IDR" ?></td>
                            </tr>
                            <?php
                        } else {
                            // Show each product on a separate row with repeated sale information
                            foreach ($sale['products'] as $index => $product): ?>
                                <tr>
                                    <td><?= date('d/m/Y H:i', strtotime($sale['created_at'])) ?></td>
                                    <td><?= esc($sale['user_fullname']) ?></td>
                                    <td><?= esc($sale['customer_name']) ?></td>
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
                        <th colspan="4" class="text-right">Total Items</th>
                        <th><?= number_format($totalItems) ?></th>
                        <th><?= number_format($totalAmount, 0, ',', '.') . " IDR" ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mt-4">
    <div class="col-lg-4 col-md-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?= number_format($totalAmount, 0, ',', '.') ?> IDR</h3>
                <p>Total Sales Amount</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= number_format($totalItems) ?></h3>
                <p>Total Items Sold</p>
            </div>
            <div class="icon">
                <i class="fas fa-cubes"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?= count($sales) ?></h3>
                <p>Total Transactions</p>
            </div>
            <div class="icon">
                <i class="fas fa-file-invoice"></i>
            </div>
        </div>
    </div>
</div>

<!-- Customer Statistics -->
<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title">Customer Statistics</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <canvas id="customerChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
            </div>
            <div class="col-md-4">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Purchases</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customerStats as $customerId => $stats): ?>
                            <tr>
                                <td><?= esc($stats['name']) ?></td>
                                <td class="text-center"><?= $stats['count'] ?></td>
                                <td class="text-right"><?= number_format($stats['amount'], 0, ',', '.') ?> IDR</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get customer data for chart
    var customerNames = [];
    var customerAmounts = [];
    var backgroundColors = [
        'rgba(54, 162, 235, 0.7)',
        'rgba(255, 99, 132, 0.7)',
        'rgba(255, 206, 86, 0.7)',
        'rgba(75, 192, 192, 0.7)',
        'rgba(153, 102, 255, 0.7)',
        'rgba(255, 159, 64, 0.7)',
        'rgba(199, 199, 199, 0.7)',
        'rgba(83, 102, 255, 0.7)',
        'rgba(40, 159, 64, 0.7)',
        'rgba(210, 199, 199, 0.7)'
    ];
    
    <?php $colorIndex = 0; foreach ($customerStats as $customerId => $stats): ?>
        customerNames.push('<?= addslashes($stats['name']) ?>');
        customerAmounts.push(<?= $stats['amount'] ?>);
    <?php endforeach; ?>
    
    // Create the customer chart
    var ctx = document.getElementById('customerChart').getContext('2d');
    var customerChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: customerNames,
            datasets: [{
                label: 'Sales Amount',
                data: customerAmounts,
                backgroundColor: backgroundColors.slice(0, customerNames.length),
                borderColor: backgroundColors.map(color => color.replace('0.7', '1')).slice(0, customerNames.length),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                },
                title: {
                    display: true,
                    text: 'Sales Amount by Customer'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var label = context.label || '';
                            var value = context.raw;
                            var total = context.dataset.data.reduce((a, b) => a + b, 0);
                            var percentage = Math.round((value / total) * 100);
                            
                            return `${label}: ${new Intl.NumberFormat('id-ID').format(value)} IDR (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
});
</script>
<?= $this->endSection() ?>