<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>150</h3>
                <p>Daily Sales</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>
                <p>Bounce Rate</p>
            </div>
            <div class="icon">
                <i class="fas fa-chart-bar"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>44</h3>
                <p>User Registrations</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <a href="/admin/users" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>65</h3>
                <p>Unique Visitors</p>
            </div>
            <div class="icon">
                <i class="fas fa-chart-pie"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<!-- /.row -->

<!-- Purchase Transaction Grid -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recent Purchase Transactions</h3>
                <div class="card-tools">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-filter"></i> Filter Period
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item filter-period" href="#" data-period="today">Today</a>
                            <a class="dropdown-item filter-period" href="#" data-period="week">This Week</a>
                            <a class="dropdown-item filter-period" href="#" data-period="month">This Month</a>
                            <a class="dropdown-item filter-period" href="#" data-period="year">This Year</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= base_url('admin/reports/purchases') ?>">Custom Report</a>
                        </div>
                    </div>
                    <a href="#" id="export-pdf" class="btn btn-sm btn-danger ml-2">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table id="purchaseGridTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Buyer</th>
                            <th>Supplier</th>
                            <th>Contact</th>
                            <th>Products</th>
                            <th>Amount</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody id="purchase-transactions-body">
                        <tr>
                            <td colspan="8" class="text-center">Loading transactions...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Quick Start</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="alert alert-info">
                    <h5><i class="icon fas fa-info"></i> Welcome!</h5>
                    Welcome to the Eatsy admin dashboard. From here you can manage users, inventory, and monitor your retail store's performance.
                </div>
                
                <div class="callout callout-success">
                    <h5>Quick Start</h5>
                    <p>To get started, you can:</p>
                    <ul>
                        <li>Manage users by clicking on the User Management link in the sidebar</li>
                        <li>View sales reports and analytics from the dashboard widgets</li>
                        <li>Manage inventory and track stock levels</li>
                        <li>Configure system settings from the Settings menu</li>
                    </ul>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

<!-- Script untuk menampilkan data transaksi pembelian -->
<script>
$(document).ready(function() {
    // Load data awal (default: this month)
    loadPurchaseTransactions('month');
    
    // Filter berdasarkan periode
    $('.filter-period').click(function(e) {
        e.preventDefault();
        var period = $(this).data('period');
        loadPurchaseTransactions(period);
    });
    
    // Export PDF berdasarkan periode yang aktif
    $('#export-pdf').click(function(e) {
        e.preventDefault();
        var activePeriod = $('#purchaseGridTable').data('active-period') || 'month';
        window.location.href = "<?= base_url('admin/reports/purchases/export-pdf') ?>?period=" + activePeriod;
    });
    
    // Fungsi untuk memuat data transaksi berdasarkan periode
    function loadPurchaseTransactions(period) {
        $('#purchase-transactions-body').html('<tr><td colspan="8" class="text-center">Loading transactions...</td></tr>');
        
        $.ajax({
            url: "<?= base_url('admin/ajax/purchase-transactions') ?>",
            type: "GET",
            data: { period: period },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    var transactions = response.data;
                    var html = '';
                    
                    if (transactions.length > 0) {
                        $.each(transactions, function(index, item) {
                            html += '<tr>';
                            html += '<td>' + (index + 1) + '</td>';
                            html += '<td>' + item.date + '</td>';
                            html += '<td>' + item.buyer + '</td>';
                            html += '<td>' + item.supplier + '</td>';
                            html += '<td>' + item.contact + '</td>';
                            html += '<td>' + item.products + '</td>';
                            html += '<td>' + item.amount + '</td>';
                            html += '<td>' + (item.note || '-') + '</td>';
                            html += '</tr>';
                        });
                    } else {
                        html = '<tr><td colspan="8" class="text-center">No transactions found for the selected period</td></tr>';
                    }
                    
                    $('#purchase-transactions-body').html(html);
                    $('#purchaseGridTable').data('active-period', period);
                } else {
                    $('#purchase-transactions-body').html('<tr><td colspan="8" class="text-center">Error loading data: ' + response.message + '</td></tr>');
                }
            },
            error: function() {
                $('#purchase-transactions-body').html('<tr><td colspan="8" class="text-center">Failed to load transactions. Please try again.</td></tr>');
            }
        });
    }
});
</script>
<?= $this->endSection() ?>