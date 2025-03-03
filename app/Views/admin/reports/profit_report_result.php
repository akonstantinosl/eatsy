<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Profit Report</h3>
        <div class="card-tools">
            <a href="<?= base_url('admin/reports/profit') ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <a href="<?= base_url('admin/reports/profit/export-pdf?start_date=' . $start_date . '&end_date=' . $end_date) ?>" class="btn btn-sm btn-danger ml-2">
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
                        <th>Product</th>
                        <th>Sales Qty</th>
                        <th>Sales Amount</th>
                        <th>Purchase Qty</th>
                        <th>Purchase Amount</th>
                        <th>Profit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($profitData as $item): ?>
                        <tr>
                            <td><?= $item['product_name'] ?></td>
                            <td class="text-center"><?= $item['sales_quantity'] ?></td>
                            <td class="text-right"><?= number_format($item['sales_amount'], 0, ',', '.') ?> IDR</td>
                            <td class="text-center"><?= $item['purchase_quantity'] ?></td>
                            <td class="text-right"><?= number_format($item['purchase_amount'], 0, ',', '.') ?> IDR</td>
                            <td class="text-right <?= ($item['profit'] >= 0) ? 'text-success' : 'text-danger' ?>">
                                <?= number_format($item['profit'], 0, ',', '.') ?> IDR
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="font-weight-bold">
                        <td>TOTAL</td>
                        <td></td>
                        <td class="text-right"><?= number_format($totalSales, 0, ',', '.') ?> IDR</td>
                        <td></td>
                        <td class="text-right"><?= number_format($totalPurchases, 0, ',', '.') ?> IDR</td>
                        <td class="text-right <?= ($totalProfit >= 0) ? 'text-success' : 'text-danger' ?>">
                            <?= number_format($totalProfit, 0, ',', '.') ?> IDR
                        </td>
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
                <h3><?= number_format($totalSales, 0, ',', '.') ?> IDR</h3>
                <p>Total Sales</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= number_format($totalPurchases, 0, ',', '.') ?> IDR</h3>
                <p>Total Purchases</p>
            </div>
            <div class="icon">
                <i class="fas fa-truck-loading"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6">
        <div class="small-box <?= ($totalProfit >= 0) ? 'bg-success' : 'bg-danger' ?>">
            <div class="inner">
                <h3><?= number_format($totalProfit, 0, ',', '.') ?> IDR</h3>
                <p>Total Profit</p>
            </div>
            <div class="icon">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
    </div>
</div>

<!-- Profit Chart -->
<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title">Profit Chart</h3>
    </div>
    <div class="card-body">
        <canvas id="profitChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the canvas element
    var ctx = document.getElementById('profitChart').getContext('2d');
    
    // Extract data for chart
    var products = [];
    var profits = [];
    var salesData = [];
    var purchasesData = [];
    var backgroundColors = [];
    
    <?php foreach ($profitData as $item): ?>
        products.push('<?= addslashes($item['product_name']) ?>');
        profits.push(<?= $item['profit'] ?>);
        salesData.push(<?= $item['sales_amount'] ?>);
        purchasesData.push(<?= $item['purchase_amount'] ?>);
        
        // Set color based on profit (green for profit, red for loss)
        if (<?= $item['profit'] ?> >= 0) {
            backgroundColors.push('rgba(40, 167, 69, 0.7)');
        } else {
            backgroundColors.push('rgba(220, 53, 69, 0.7)');
        }
    <?php endforeach; ?>
    
    // Create the chart
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: products,
            datasets: [
                {
                    label: 'Sales',
                    data: salesData,
                    backgroundColor: 'rgba(0, 123, 255, 0.7)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Purchases',
                    data: purchasesData,
                    backgroundColor: 'rgba(255, 193, 7, 0.7)',
                    borderColor: 'rgba(255, 193, 7, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Profit',
                    data: profits,
                    backgroundColor: backgroundColors,
                    borderColor: backgroundColors.map(color => color.replace('0.7', '1')),
                    borderWidth: 1,
                    type: 'bar'
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Amount (IDR)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Products'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Sales, Purchases, and Profit by Product'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat('id-ID').format(context.parsed.y) + ' IDR';
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });
});
</script>
<?= $this->endSection() ?>
