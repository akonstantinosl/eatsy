<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Admin Dashboard' ?> | Eatsy</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
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
                <li class="nav-item">
                    <a class="nav-link" href="/logout" role="button">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
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
                    <div class="info">
                        <a href="#" class="d-block"><?= session()->get('user_name') ?> (Admin)</a>
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
                                <a href="/admin/products" class="nav-link <?= (current_url() == base_url('admin/products')) ? 'active' : '' ?>">
                                    <i class="fas fa-boxes nav-icon"></i>
                                    <p>All Products</p>
                                </a>
                            </li>
                            <!-- Categories -->
                            <!-- <li class="nav-item">
                                <a href="/admin/products/categories" class="nav-link <?= (current_url() == base_url('admin/products/categories')) ? 'active' : '' ?>">
                                    <i class="fas fa-tags nav-icon"></i>
                                    <p>Product Categories</p>
                                </a>
                            </li> -->
                            <!-- Product Purchase -->
                            <li class="nav-item">
                                <a href="/admin/purchases/" class="nav-link <?= (current_url() == base_url('admin/products/purchase')) ? 'active' : '' ?>">
                                    <i class="fas fa-cart-plus nav-icon"></i>
                                    <p>Product Purchases</p>
                                </a>
                            </li>
                            <!-- Sales -->
                            <li class="nav-item">
                                <a href="/sales" class="nav-link <?= (current_url() == base_url('admin/products/sales')) ? 'active' : '' ?>">
                                    <i class="fas fa-cash-register nav-icon"></i>
                                    <p>Product Sales</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="/customers" class="nav-link <?= (strpos(current_url(), base_url('/customers')) !== false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Customers</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/admin/suppliers" class="nav-link <?= (strpos(current_url(), base_url('admin/suppliers')) !== false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-truck"></i>
                            <p>Suppliers</p>
                        </a>
                    </li>
                </ul>
            </nav>

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
                    <?php if (session()->getFlashdata('success')): ?>
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
                    <?php endif; ?>
                    
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

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>
    <!-- Additional scripts -->
    <?= $this->renderSection('scripts') ?>
</body>
</html>