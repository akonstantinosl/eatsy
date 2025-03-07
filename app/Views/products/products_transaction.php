<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Product Transactions</h3>
    </div>
    <div class="card-body">
        <!-- Filter and Search Controls -->
        <form action="<?= base_url('products/transaction') ?>" method="get" class="mb-4">
            <div class="row">
                <div class="col-md-3 form-group">
                    <label for="category">Category:</label>
                    <select name="category" id="category" class="form-control">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['product_category_id'] ?>" <?= ($categoryFilter == $category['product_category_id']) ? 'selected' : '' ?>>
                                <?= $category['product_category_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3 form-group">
                    <label for="search">Search:</label>
                    <input type="text" class="form-control" id="search" name="search" value="<?= $search ?>" placeholder="Search products...">
                </div>
                <div class="col-md-3 form-group">
                    <label for="entries">Show entries:</label>
                    <select name="entries" id="entries" class="form-control">
                        <option value="10" <?= ($perPage == 10) ? 'selected' : '' ?>>10</option>
                        <option value="25" <?= ($perPage == 25) ? 'selected' : '' ?>>25</option>
                        <option value="50" <?= ($perPage == 50) ? 'selected' : '' ?>>50</option>
                        <option value="100" <?= ($perPage == 100) ? 'selected' : '' ?>>100</option>
                    </select>
                </div>
                <div class="col-md-3 mt-2 text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Apply Filters
                    </button>
                    <a href="<?= base_url('products/transaction') ?>" class="btn btn-secondary">
                        <i class="fas fa-sync"></i> Reset
                    </a>
                </div>
            </div>
        </form>

        <!-- Summary Cards -->
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

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>
                            <a href="<?= base_url('products/transaction?' . http_build_query(array_merge($_GET, ['sort' => 'product_name', 'dir' => ($sortField == 'product_name' && $sortDir == 'asc') ? 'desc' : 'asc']))) ?>" class="text-dark">
                                Product Name
                                <?php if ($sortField == 'product_name'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th>
                            <a href="<?= base_url('products/transaction?' . http_build_query(array_merge($_GET, ['sort' => 'product_category_name', 'dir' => ($sortField == 'product_category_name' && $sortDir == 'asc') ? 'desc' : 'asc']))) ?>" class="text-dark">
                                Category
                                <?php if ($sortField == 'product_category_name'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th>
                            <a href="<?= base_url('products/transaction?' . http_build_query(array_merge($_GET, ['sort' => 'product_stock', 'dir' => ($sortField == 'product_stock' && $sortDir == 'asc') ? 'desc' : 'asc']))) ?>" class="text-dark">
                                Current Stock
                                <?php if ($sortField == 'product_stock'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th>
                            <a href="<?= base_url('products/transaction?' . http_build_query(array_merge($_GET, ['sort' => 'sales_quantity', 'dir' => ($sortField == 'sales_quantity' && $sortDir == 'asc') ? 'desc' : 'asc']))) ?>" class="text-dark">
                                Sales Quantity
                                <?php if ($sortField == 'sales_quantity'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th>
                            <a href="<?= base_url('products/transaction?' . http_build_query(array_merge($_GET, ['sort' => 'sales_amount', 'dir' => ($sortField == 'sales_amount' && $sortDir == 'asc') ? 'desc' : 'asc']))) ?>" class="text-dark">
                                Sales Amount
                                <?php if ($sortField == 'sales_amount'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th>
                            <a href="<?= base_url('products/transaction?' . http_build_query(array_merge($_GET, ['sort' => 'purchase_quantity', 'dir' => ($sortField == 'purchase_quantity' && $sortDir == 'asc') ? 'desc' : 'asc']))) ?>" class="text-dark">
                                Purchase Quantity
                                <?php if ($sortField == 'purchase_quantity'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th>
                            <a href="<?= base_url('products/transaction?' . http_build_query(array_merge($_GET, ['sort' => 'purchase_amount', 'dir' => ($sortField == 'purchase_amount' && $sortDir == 'asc') ? 'desc' : 'asc']))) ?>" class="text-dark">
                                Purchase Amount
                                <?php if ($sortField == 'purchase_amount'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th>
                            <a href="<?= base_url('products/transaction?' . http_build_query(array_merge($_GET, ['sort' => 'profit_loss', 'dir' => ($sortField == 'profit_loss' && $sortDir == 'asc') ? 'desc' : 'asc']))) ?>" class="text-dark">
                                Profit/Loss
                                <?php if ($sortField == 'profit_loss'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort"></i>
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
                        $start = ($currentPage - 1) * $perPage + 1;
                        foreach ($transactions as $index => $transaction): 
                            $profitLoss = $transaction['sales_amount'] - $transaction['purchase_amount'];
                        ?>
                            <tr>
                                <td><?= $start + $index ?></td>
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

        <!-- Custom Pagination -->
        <div class="mt-3">
            <ul class="pagination justify-content-center">
                <?php if ($currentPage > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= base_url('products/transaction?' . http_build_query(array_merge($_GET, ['page' => $currentPage - 1]))) ?>">Previous</a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link">Previous</span>
                    </li>
                <?php endif; ?>
                
                <?php 
                $totalPages = ceil($total / $perPage);
                $startPage = max(1, min($currentPage - 1, $totalPages - 2));
                $endPage = min($totalPages, max($currentPage + 1, 3));
                
                for ($i = $startPage; $i <= $endPage; $i++): 
                ?>
                    <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                        <a class="page-link" href="<?= base_url('products/transaction?' . http_build_query(array_merge($_GET, ['page' => $i]))) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                
                <?php if ($currentPage < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= base_url('products/transaction?' . http_build_query(array_merge($_GET, ['page' => $currentPage + 1]))) ?>">Next</a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link">Next</span>
                    </li>
                <?php endif; ?>
            </ul>
            <div class="text-center pagination-info">
                Showing <?= $start ?> to <?= min($start + count($transactions) - 1, $total) ?> of <?= $total ?> entries
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Auto-submit form when entries dropdown changes
        $('#entries').change(function() {
            $(this).closest('form').submit();
        });
    });
</script>
<?= $this->endSection() ?>