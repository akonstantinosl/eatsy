<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header p-2">
        <form id="filterForm" action="<?= base_url('products/transaction') ?>" method="get" class="mb-0">
            <input type="hidden" name="page" value="<?= $currentPage ?? 1 ?>">
            <input type="hidden" name="sort" value="<?= $sortField ?? 'product_name' ?>">
            <input type="hidden" name="dir" value="<?= $sortDir ?? 'asc' ?>">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="d-flex flex-wrap align-items-center">
                        <!-- Card Title -->
                        <h3 class="card-title m-0 mr-3 mb-2 mb-md-0">Product Transactions</h3>
                        
                        <!-- Category Filter -->
                        <div class="mr-2 mb-2 mb-md-0" style="min-width: 150px; max-width: 200px;">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Category</span>
                                </div>
                                <select name="category" id="category" class="form-control form-control-sm">
                                    <option value="">All Categories</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['product_category_id'] ?>" <?= ($categoryFilter == $category['product_category_id']) ? 'selected' : '' ?>>
                                            <?= $category['product_category_name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Search Box -->
                        <div class="mr-2 mb-2 mb-md-0" style="min-width: 200px; max-width: 300px;">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Search</span>
                                </div>
                                <input type="text" name="search" class="form-control form-control-sm" value="<?= $search ?? '' ?>" placeholder="Search products...">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-sm btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Show Entries -->
                        <div class="mr-2 mb-2 mb-md-0" style="min-width: 100px; max-width: 130px;">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Show</span>
                                </div>
                                <select name="entries" id="entries" class="form-control form-control-sm">
                                    <?php foreach ([10, 25, 50, 100] as $option): ?>
                                        <option value="<?= $option ?>" <?= $perPage == $option ? 'selected' : '' ?>><?= $option ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Reset Button -->
                        <?php if (!empty($search) || !empty($categoryFilter) || $perPage != 10 || $sortField != 'product_name' || $sortDir != 'asc'): ?>
                                <a href="<?= base_url('products/transaction') ?>" class="btn btn-sm btn-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="card-body pb-0">
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= number_format($totalSalesQuantity) ?></h3>
                        <p>Total Sales Quantity</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= number_format($totalSalesAmount, 0, ',', '.') ?></h3>
                        <p>Total Sales Amount (IDR)</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= number_format($totalPurchaseQuantity) ?></h3>
                        <p>Total Purchase Quantity</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-truck-loading"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?= number_format($totalPurchaseAmount, 0, ',', '.') ?></h3>
                        <p>Total Purchase Amount (IDR)</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calculator"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main card body with table -->
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>
                            <a href="javascript:void(0)" class="sort-link" data-sort="product_name">
                                Product Name
                                <?php if ($sortField == 'product_name'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort text-muted"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th>
                            <a href="javascript:void(0)" class="sort-link" data-sort="product_category_name">
                                Category
                                <?php if ($sortField == 'product_category_name'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort text-muted"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th>
                            <a href="javascript:void(0)" class="sort-link" data-sort="product_stock">
                                Current Stock
                                <?php if ($sortField == 'product_stock'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort text-muted"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th>
                            <a href="javascript:void(0)" class="sort-link" data-sort="sales_quantity">
                                Sales Quantity
                                <?php if ($sortField == 'sales_quantity'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort text-muted"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th>
                            <a href="javascript:void(0)" class="sort-link" data-sort="sales_amount">
                                Sales Amount
                                <?php if ($sortField == 'sales_amount'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort text-muted"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th>
                            <a href="javascript:void(0)" class="sort-link" data-sort="purchase_quantity">
                                Purchase Quantity
                                <?php if ($sortField == 'purchase_quantity'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort text-muted"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th>
                            <a href="javascript:void(0)" class="sort-link" data-sort="purchase_amount">
                                Purchase Amount
                                <?php if ($sortField == 'purchase_amount'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort text-muted"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th>
                            <a href="javascript:void(0)" class="sort-link" data-sort="profit_loss">
                                Profit/Loss
                                <?php if ($sortField == 'profit_loss'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort text-muted"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($transactions)): ?>
                        <tr>
                            <td colspan="9" class="text-center">No transaction data found</td>
                        </tr>
                    <?php else: ?>
                        <?php 
                        $startRow = ($currentPage - 1) * $perPage + 1;
                        foreach ($transactions as $index => $transaction): 
                            $profitLoss = $transaction['sales_amount'] - $transaction['purchase_amount'];
                        ?>
                            <tr>
                                <td><?= $startRow + $index ?></td>
                                <td><?= $transaction['product_name'] ?></td>
                                <td><?= $transaction['product_category_name'] ?></td>
                                <td class="text-center"><?= number_format($transaction['product_stock']) ?></td>
                                <td class="text-center"><?= number_format($transaction['sales_quantity']) ?></td>
                                <td class="text-right"><?= number_format($transaction['sales_amount'], 0, ',', '.') ?> IDR</td>
                                <td class="text-center"><?= number_format($transaction['purchase_quantity']) ?></td>
                                <td class="text-right"><?= number_format($transaction['purchase_amount'], 0, ',', '.') ?> IDR</td>
                                <td class="text-right <?= ($profitLoss >= 0) ? 'text-success' : 'text-danger' ?>">
                                    <?= number_format($profitLoss, 0, ',', '.') ?> IDR
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr class="bg-light">
                        <th colspan="4" class="text-right">TOTAL:</th>
                        <th class="text-center"><?= number_format($totalSalesQuantity) ?></th>
                        <th class="text-right"><?= number_format($totalSalesAmount, 0, ',', '.') ?> IDR</th>
                        <th class="text-center"><?= number_format($totalPurchaseQuantity) ?></th>
                        <th class="text-right"><?= number_format($totalPurchaseAmount, 0, ',', '.') ?> IDR</th>
                        <th class="text-right <?= ($totalSalesAmount - $totalPurchaseAmount >= 0) ? 'text-success' : 'text-danger' ?>">
                            <?= number_format($totalSalesAmount - $totalPurchaseAmount, 0, ',', '.') ?> IDR
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <!-- Pagination Links -->
        <div class="mt-3">
            <div class="row">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info">
                        <?php
                        // Ensure startRow is defined for pagination info
                        $startRow = ($currentPage - 1) * $perPage + 1;
                        $endRow = min($startRow + count($transactions) - 1, $total);
                        ?>
                        Showing <?= empty($transactions) ? 0 : $startRow ?> to <?= empty($transactions) ? 0 : $endRow ?> of <?= $total ?> entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers float-md-right">
                        <ul class="pagination pagination-sm m-0">
                            <?php 
                            // Build the query parameters for pagination links
                            $queryParams = [];
                            if (!empty($perPage)) $queryParams['entries'] = $perPage;
                            if (!empty($categoryFilter)) $queryParams['category'] = $categoryFilter;
                            if (!empty($search)) $queryParams['search'] = $search;
                            if (!empty($sortField)) $queryParams['sort'] = $sortField;
                            if (!empty($sortDir)) $queryParams['dir'] = $sortDir;
                            
                            // Create the query string
                            $queryString = http_build_query($queryParams);
                            $queryPrefix = !empty($queryString) ? '&' : '';
                            
                            $totalPages = ceil($total / $perPage);
                            $totalPages = max(1, $totalPages); // Ensure at least 1 page
                            ?>
                            
                            <!-- Previous page link -->
                            <?php if ($currentPage > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?= base_url('products/transaction?page=' . ($currentPage - 1) . ($queryString ? '&' . $queryString : '')) ?>">Previous</a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled">
                                    <span class="page-link">Previous</span>
                                </li>
                            <?php endif; ?>
                            
                            <?php 
                            // Dynamic pagination - show proper number of pages
                            $maxPagesToShow = 5;
                            
                            // If total pages is 1, only show page 1
                            if ($totalPages <= 1) {
                                $startPage = 1;
                                $endPage = 1;
                            } else {
                                $startPage = max(1, min($currentPage - floor($maxPagesToShow / 2), $totalPages - $maxPagesToShow + 1));
                                $startPage = max(1, $startPage); // Ensure startPage is at least 1
                                $endPage = min($startPage + $maxPagesToShow - 1, $totalPages);
                            }
                            
                            for ($i = $startPage; $i <= $endPage; $i++): 
                            ?>
                                <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= base_url('products/transaction?page=' . $i . ($queryString ? '&' . $queryString : '')) ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <!-- Next page link -->
                            <?php if ($currentPage < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?= base_url('products/transaction?page=' . ($currentPage + 1) . ($queryString ? '&' . $queryString : '')) ?>">Next</a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled">
                                    <span class="page-link">Next</span>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>

<style>
    /* Ensure the table doesn't overflow its container */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    /* Style for input groups */
    .input-group-text {
        min-width: 60px;
        display: flex;
        justify-content: center;
        background-color: #f4f6f9;
        border-color: #ced4da;
    }
    
    /* Sorting styles */
    th a.sort-link {
        color: #212529;
        text-decoration: none;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    th a.sort-link:hover {
        color: #007bff;
    }
    
    /* Optimize for smaller screens */
    @media (max-width: 768px) {
        .btn-sm {
            padding: 0.2rem 0.4rem;
            font-size: 0.75rem;
        }
    }
</style>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all the form controls that should reset the page parameter
        const formControls = document.querySelectorAll('#filterForm select, #filterForm input[type="text"]');
        
        formControls.forEach(control => {
            control.addEventListener('change', function() {
                // Reset the page to 1 when filters change
                document.querySelector('input[name="page"]').value = '1';
                document.getElementById('filterForm').submit();
            });
        });
        
        // Ensure search form submits on enter key
        document.querySelector('input[name="search"]').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('filterForm').submit();
            }
        });
        
        // Handle column sorting
        const sortLinks = document.querySelectorAll('.sort-link');
        sortLinks.forEach(link => {
            link.addEventListener('click', function() {
                const sortField = this.getAttribute('data-sort');
                const currentSort = document.querySelector('input[name="sort"]').value;
                const currentDir = document.querySelector('input[name="dir"]').value;
                
                // Determine new sort direction
                let newDir = 'asc';
                if (sortField === currentSort) {
                    // If clicking the same column, toggle direction
                    newDir = (currentDir === 'asc') ? 'desc' : 'asc';
                }
                
                // Update form values
                document.querySelector('input[name="sort"]').value = sortField;
                document.querySelector('input[name="dir"]').value = newDir;
                
                // Reset to page 1 when sort changes
                document.querySelector('input[name="page"]').value = '1';
                
                // Submit the form
                document.getElementById('filterForm').submit();
            });
        });
        
        // Display SweetAlert for flash messages if they exist
        <?php if (session()->getFlashdata('success')): ?>
            Swal.fire({
                title: 'Success!',
                text: '<?= session()->getFlashdata('success') ?>',
                icon: 'success',
            });
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('error')): ?>
            Swal.fire({
                title: 'Error!',
                text: '<?= session()->getFlashdata('error') ?>',
                icon: 'error',
            });
        <?php endif; ?>
    });
</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>