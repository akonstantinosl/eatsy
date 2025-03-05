<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('swal_success')): ?>
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Profile Updated',
                text: '<?= session()->getFlashdata('swal_success') ?>',
                showConfirmButton: true
            });
        });
    </script>
<?php endif; ?>

<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-primary">
            <div class="inner">
                <h3><?= $totalUsers ?? 0 ?></h3>
                <p>Users</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="/admin/users" class="small-box-footer">Manage Users <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?= $totalSuppliers ?? 0 ?></h3>
                <p>Suppliers</p>
            </div>
            <div class="icon">
                <i class="fas fa-truck"></i>
            </div>
            <a href="/admin/suppliers" class="small-box-footer">Manage Suppliers <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= $totalCustomers ?? 0 ?></h3>
                <p>Customers</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-friends"></i>
            </div>
            <a href="/customers" class="small-box-footer">Manage Customers <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?= $totalProducts ?? 0 ?></h3>
                <p>Products</p>
            </div>
            <div class="icon">
                <i class="fas fa-box"></i>
            </div>
            <a href="/products" class="small-box-footer">Manage Products <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<!-- /.row -->

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-line mr-1"></i>
                    Sales Overview
                </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                    <p class="text-success text-xl">
                        <i class="fas fa-shopping-cart"></i>
                    </p>
                    <p class="d-flex flex-column text-right">
                        <span class="font-weight-bold">
                            <?= $monthlySales ?? 0 ?>
                        </span>
                        <span class="text-muted">Monthly Sales</span>
                    </p>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-0">
                    <p class="text-danger text-xl">
                        <i class="fas fa-chart-pie"></i>
                    </p>
                    <p class="d-flex flex-column text-right">
                        <span class="font-weight-bold">
                            <?= $monthlyRevenue ? number_format($monthlyRevenue, 0, ',', '.') . " IDR" : '0 IDR' ?>
                        </span>
                        <span class="text-muted">Revenue This Month</span>
                    </p>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
                <a href="/admin/reports/sales" class="text-primary">View Sales Report</a>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-box-open mr-1"></i>
                    Inventory Status
                </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                    <p class="text-primary text-xl">
                        <i class="fas fa-boxes"></i>
                    </p>
                    <p class="d-flex flex-column text-right">
                        <span class="font-weight-bold">
                            <?= $lowStockCount ?? 0 ?>
                        </span>
                        <span class="text-muted">Low Stock Items</span>
                    </p>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-0">
                    <p class="text-warning text-xl">
                        <i class="fas fa-truck-loading"></i>
                    </p>
                    <p class="d-flex flex-column text-right">
                        <span class="font-weight-bold">
                            <?= $pendingPurchases ?? 0 ?>
                        </span>
                        <span class="text-muted">Pending Purchases</span>
                    </p>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
                <a href="/admin/purchases" class="text-primary">View Purchases</a>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recent Transactions</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($recentSales) && count($recentSales) > 0): ?>
                            <?php foreach($recentSales as $sale): ?>
                            <tr>
                                <td><?= $sale['sale_id'] ?></td>
                                <td><?= $sale['customer_name'] ?></td>
                                <td><?= date('d M Y', strtotime($sale['created_at'])) ?></td>
                                <td><?= number_format($sale['sale_amount'], 0, ',', '.') . " IDR" ?></td>
                                <td>
                                    <?php if($sale['transaction_status'] == 'completed'): ?>
                                        <span class="badge bg-success">Completed</span>
                                    <?php elseif($sale['transaction_status'] == 'processing'): ?>
                                        <span class="badge bg-primary">Processing</span>
                                    <?php elseif($sale['transaction_status'] == 'pending'): ?>
                                        <span class="badge bg-warning">Pending</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Cancelled</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No recent transactions</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
                <a href="/sales" class="text-primary">View All Transactions</a>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
<?= $this->endSection() ?>