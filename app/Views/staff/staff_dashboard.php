<?= $this->extend('layout_staff') ?>

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
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Staff Dashboard</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="alert alert-info">
                    <h5><i class="icon fas fa-info"></i> Welcome, <?= session()->get('user_name') ?>!</h5>
                    Welcome to the Eatsy staff dashboard. From here you can process sales, add customers, and check your daily tasks.
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fas fa-money-bill-wave"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Today's Revenue</span>
                                <span class="info-box-number"><?= number_format($todayRevenue ?? 0, 0, ',', '.') ?> IDR</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fas fa-cash-register"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Transactions Today</span>
                                <span class="info-box-number"><?= $todaySales ?? 0 ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="callout callout-success">
                    <h5>Today's Tasks</h5>
                    <ul>
                        <li>Process customer transactions</li>
                        <li>Check inventory levels and restock shelves</li>
                        <li>Report any discrepancies in stock counts</li>
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

<div class="row">
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?= $todaySales ?? 0 ?></h3>
                <p>Sales Today</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="/sales" class="small-box-footer">View Sales <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
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
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= $totalProducts ?? 0 ?></h3>
                <p>Products</p>
            </div>
            <div class="icon">
                <i class="fas fa-box"></i>
            </div>
            <a href="/products" class="small-box-footer">View Products <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<!-- /.row -->

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-shopping-cart mr-1"></i>
                    Recent Sales
                </h3>
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
                            <th>Action</th>
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
                                <td>
                                    <a href="/sales/details/<?= $sale['sale_id'] ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No recent sales</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
                <a href="/sales" class="text-primary">View All Sales</a>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    Low Stock Products
                </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                    <?php if(isset($lowStockProducts) && count($lowStockProducts) > 0): ?>
                        <?php foreach($lowStockProducts as $product): ?>
                        <li class="item">
                            <div class="product-info">
                                <a href="/products/edit/<?= $product['product_id'] ?>" class="product-title">
                                    <?= $product['product_name'] ?>
                                    <span class="badge badge-warning float-right"><?= $product['product_stock'] ?> left</span>
                                </a>
                                <span class="product-description">
                                    Category: <?= $product['product_category_name'] ?>
                                </span>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="item">
                            <div class="product-info text-center py-3">
                                <span class="text-muted">No low stock products</span>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
                <a href="/products" class="text-primary">View All Products</a>
            </div>
        </div>
        <!-- /.card -->
        
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-users mr-1"></i>
                    Recent Customers
                </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Date Added</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($recentCustomers) && count($recentCustomers) > 0): ?>
                            <?php foreach($recentCustomers as $customer): ?>
                            <tr>
                                <td><a href="/customers/edit/<?= $customer['customer_id'] ?>"><?= $customer['customer_name'] ?></a></td>
                                <td><?= $customer['customer_phone'] ?></td>
                                <td><?= date('d M Y', strtotime($customer['created_at'])) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">No recent customers</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
                <a href="/customers" class="text-primary">View All Customers</a>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
<?= $this->endSection() ?>