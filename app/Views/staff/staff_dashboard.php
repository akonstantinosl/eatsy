<?= $this->extend('layout_staff') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>15</h3>
                <p>Transactions Today</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="#" class="small-box-footer">View Orders <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>12</h3>
                <p>Total Customers</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>3</h3>
                <p>Low Stock Items</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
            <a href="#" class="small-box-footer">View Pending <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<!-- /.row -->

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
                    Welcome to the EatsyMart staff dashboard. From here you can process sales, manage inventory, and check your daily tasks.
                </div>
                
                <div class="callout callout-success">
                    <h5>Today's Tasks</h5>
                    <ul>
                        <li>Process customer transactions</li>
                        <li>Check inventory levels and restock shelves</li>
                        <li>Monitor expiry dates of products</li>
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
<?= $this->endSection() ?>