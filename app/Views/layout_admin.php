<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Admin Dashboard' ?> | Eatsy</title>

    <!-- Source Sans Pro Font (Local) -->
    <link rel="stylesheet" href="<?= base_url('assets/fonts/source-sans-pro/source-sans-pro.css') ?>">
    
    <!-- Font Awesome (Local) -->
    <link rel="stylesheet" href="<?= base_url('assets/css/fontawesome/all.min.css') ?>">
    
    <!-- Bootstrap CSS (Local) -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap/bootstrap.min.css') ?>">
    
    <!-- AdminLTE CSS - You'll need to download this separately if not already done -->
    <link rel="stylesheet" href="<?= base_url('assets/css/adminlte/adminlte.min.css') ?>">
    
    <!-- SweetAlert2 (Local) -->
    <link rel="stylesheet" href="<?= base_url('assets/css/sweetalert2/sweetalert2.min.css') ?>">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/select2/select2.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/select2/select2-bootstrap4.min.css') ?>">

    <!-- Additional CSS -->
    <?= $this->renderSection('styles') ?>
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/admin/dashboard" class="nav-link">Home</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- User Dropdown Menu -->
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <?php
                        // Determine if the photo is a default one stored in assets/image or a user-uploaded one
                        $userPhoto = session()->get('user_photo');
                        $photoPath = (in_array($userPhoto, ['default_admin.png', 'default_staff.png']))
                            ? base_url('assets/image/' . $userPhoto)
                            : base_url('uploads/users/' . $userPhoto);
                        ?>
                        <img src="<?= $photoPath ?>" class="user-image img-circle elevation-2" alt="User Image">
                        <span class="d-none d-md-inline"><?= session()->get('user_name') ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- User image -->
                        <li class="user-header bg-primary">
                            <img src="<?= $photoPath ?>" class="img-circle elevation-2" alt="User Image">
                            <p>
                                <?= session()->get('user_fullname') ?>
                                <small><?= ucfirst(session()->get('user_role')) ?></small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                        <a href="/profile/edit" class="btn btn-default btn-flat">Profile</a>
                            <a href="/logout" class="btn btn-default btn-flat float-right">Sign out</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="/admin/dashboard" class="brand-link">
                <span class="brand-text font-weight-light">Eatsy</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= $photoPath ?>" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                    <a href="/profile/edit" class="d-block"><?= session()->get('user_name') ?> (Admin)</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="/admin/dashboard" class="nav-link <?= (current_url() == base_url('admin/dashboard')) ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/admin/users" class="nav-link <?= (strpos(current_url(), base_url('admin/users')) !== false) ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Users</p>
                            </a>
                        </li>

                        <!-- Products Menu -->
                        <li class="nav-item has-treeview <?= (strpos(current_url(), base_url('admin/products')) !== false) ? 'menu-open' : '' ?>">
                            <a href="#" class="nav-link <?= (strpos(current_url(), base_url('admin/products')) !== false) ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-cube"></i>
                                <p>
                                    Products
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <!-- All Products -->
                                <li class="nav-item">
                                    <a href="/products" class="nav-link <?= (current_url() == base_url('admin/products')) ? 'active' : '' ?>">
                                        <i class="fas fa-boxes nav-icon"></i>
                                        <p>All Products</p>
                                    </a>
                                </li>
                                <!-- Product Transactions (Combined Purchases and Sales) -->
                                <li class="nav-item">
                                    <a href="/products/transaction" class="nav-link <?= (current_url() == base_url('products/transaction')) ? 'active' : '' ?>">
                                        <i class="fas fa-exchange-alt nav-icon"></i>
                                        <p>Product Transactions</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="/admin/suppliers" class="nav-link <?= (strpos(current_url(), base_url('admin/suppliers')) !== false) ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-truck"></i>
                                <p>Suppliers</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/customers" class="nav-link <?= (strpos(current_url(), base_url('/customers')) !== false) ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Customers</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/admin/purchases/" class="nav-link <?= (current_url() == base_url('admin/products/purchase')) ? 'active' : '' ?>">
                                <i class="fas fa-cart-plus nav-icon"></i>
                                <p>Purchases</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/sales" class="nav-link <?= (current_url() == base_url('admin/products/sales')) ? 'active' : '' ?>">
                                <i class="fas fa-cash-register nav-icon"></i>
                                <p>Sales</p>
                            </a>
                        </li>

                        <!-- Reports Menu -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-chart-bar"></i>
                                <p>
                                    Reports
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                            <li class="nav-item">
                                    <a href="<?= base_url('admin/reports/purchases') ?>" class="nav-link">
                                        <i class="fas fa-cart-plus nav-icon"></i>
                                        <p>Purchase Reports</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('admin/reports/sales') ?>" class="nav-link">
                                        <i class="fas fa-cash-register nav-icon"></i>
                                        <p>Sale Reports</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('admin/reports/profit') ?>" class="nav-link">
                                        <i class="fas fa-money-bill-wave nav-icon"></i>
                                        <p>Profit Reports</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <!-- <div class="col-sm-6">
                            <h1 class="m-0"><?= $title ?? 'Dashboard' ?></h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                                <?php if (isset($breadcrumb)): ?>
                                    <?php foreach ($breadcrumb as $item): ?>
                                        <li class="breadcrumb-item <?= $item['active'] ? 'active' : '' ?>">
                                            <?php if (!$item['active']): ?>
                                                <a href="<?= $item['url'] ?>"><?= $item['title'] ?></a>
                                            <?php else: ?>
                                                <?= $item['title'] ?>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li class="breadcrumb-item active"><?= $title ?? 'Dashboard' ?></li>
                                <?php endif; ?>
                            </ol>
                        </div> -->
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <!-- <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?= session()->getFlashdata('success') ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?= session()->getFlashdata('error') ?>
                    </div>
                    <?php endif; ?> -->
                    
                    <?= $this->renderSection('content') ?>
                </div>
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; <?= date('Y') ?> Eatsy.</strong> All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery (Local) -->
    <script src="<?= base_url('assets/js/jquery/jquery.min.js') ?>"></script>
    
    <!-- Bootstrap JS (Local) -->
    <script src="<?= base_url('assets/js/bootstrap/bootstrap.bundle.min.js') ?>"></script>
    
    <!-- AdminLTE App (You'll need to download this separately) -->
    <script src="<?= base_url('assets/js/adminlte/adminlte.min.js') ?>"></script>
    
    <!-- SweetAlert2 (Local) -->
    <script src="<?= base_url('assets/js/sweetalert2/sweetalert2.all.min.js') ?>"></script>

    <!-- BS Custom File Input (Local) -->
    <script src="<?= base_url('assets/js/bs-custom-file-input/bs-custom-file-input.min.js') ?>"></script>

    <!-- Chart.js (Local) -->
    <script src="<?= base_url('assets/js/chartjs/chart.umd.min.js') ?>"></script>

    <!-- Select2 -->
    <script src="<?= base_url('assets/js/select2/select2.full.min.js') ?>"></script>

    <!-- Additional scripts -->
    <?= $this->renderSection('scripts') ?>
</body>
</html>

