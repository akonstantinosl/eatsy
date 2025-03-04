<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Sales List</h3>
        <div class="card-tools">
            <a href="/sales/customer" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> New Sale
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="12%">Date</th>
                        <th width="12%">Seller</th>
                        <th width="12%">Customer</th>
                        <th width="12%">Contact</th>
                        <th width="12%">Amount</th>
                        <th width="12%">Payment Method</th>
                        <th width="10%">Status</th>
                        <th width="10%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $startIndex = ($currentPage - 1) * $perPage + 1;
                    if (!empty($sales)): 
                        foreach ($sales as $index => $sale): 
                    ?>
                        <tr>
                            <td><?= $startIndex + $index ?></td>
                            <td><?= date('d F Y, H:i', strtotime($sale['created_at'])) ?></td> 
                            <td><?= esc($sale['user_fullname']) ?></td>
                            <td><?= esc($sale['customer_name']) ?></td>
                            <td><?= esc($sale['customer_phone']) ?></td>
                            <td><?= number_format($sale['sale_amount'], 0, ',', '.') . " IDR" ?></td>
                            <td>
                                <?php 
                                    $paymentMethod = '';
                                    switch ($sale['payment_method']) {
                                        case 'cash':
                                            $paymentMethod = 'Cash';
                                            break;
                                        case 'credit_card':
                                            $paymentMethod = 'Credit Card';
                                            break;
                                        case 'debit_card':
                                            $paymentMethod = 'Debit Card';
                                            break;
                                        case 'e-wallet':
                                            $paymentMethod = 'E-Wallet';
                                            break;
                                        default:
                                            $paymentMethod = 'Unknown';
                                    }
                                ?>
                                <?= $paymentMethod ?>
                            </td>
                            <td>
                                <?php 
                                    $statusClass = '';
                                    $statusText = '';

                                    switch ($sale['transaction_status']) {
                                        case 'pending':
                                            $statusClass = 'badge-warning';
                                            $statusText = 'Pending';
                                            break;
                                        case 'processing':
                                            $statusClass = 'badge-info';
                                            $statusText = 'Processing';
                                            break;
                                        case 'completed':
                                            $statusClass = 'badge-success';
                                            $statusText = 'Completed';
                                            break;
                                        case 'cancelled':
                                            $statusClass = 'badge-danger';
                                            $statusText = 'Cancelled';
                                            break;
                                        default:
                                            $statusClass = 'badge-secondary';
                                            $statusText = 'Unknown';
                                    }
                                ?>
                                <span class="badge <?= $statusClass ?>"><?= $statusText ?></span> 
                            </td>
                            <td>
                                <a href="/sales/details/<?= esc($sale['sale_id']) ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    <?php 
                        endforeach; 
                    else: 
                    ?>
                        <tr>
                            <td colspan="9" class="text-center">No sales found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Links -->
        <div class="mt-3 px-3 pb-3">
            <div class="row">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info" role="status" aria-live="polite">
                        Showing <?= $startIndex ?> to <?= min($startIndex + count($sales) - 1, $total) ?> of <?= $total ?> entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers float-md-right">
                        <ul class="pagination pagination-sm m-0">
                            <?php if ($currentPage > 1): ?>
                                <li class="paginate_button page-item previous">
                                    <a href="<?= site_url('sales?page=' . ($currentPage - 1)) ?>" class="page-link">Previous</a>
                                </li>
                            <?php else: ?>
                                <li class="paginate_button page-item previous disabled">
                                    <a href="#" class="page-link">Previous</a>
                                </li>
                            <?php endif; ?>
                            
                            <?php 
                            $totalPages = ceil($total / $perPage);
                            $maxPagesToShow = 5;
                            $startPage = max(1, min($currentPage - floor($maxPagesToShow / 2), $totalPages - $maxPagesToShow + 1));
                            $endPage = min($startPage + $maxPagesToShow - 1, $totalPages);
                            
                            for ($i = $startPage; $i <= $endPage; $i++): 
                            ?>
                                <li class="paginate_button page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                                    <a href="<?= site_url('sales?page=' . $i) ?>" class="page-link"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($currentPage < $totalPages): ?>
                                <li class="paginate_button page-item next">
                                    <a href="<?= site_url('sales?page=' . ($currentPage + 1)) ?>" class="page-link">Next</a>
                                </li>
                            <?php else: ?>
                                <li class="paginate_button page-item next disabled">
                                    <a href="#" class="page-link">Next</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add some additional CSS to help with responsiveness -->
<style>
    /* Ensure the table doesn't overflow its container */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    /* Make badges more visible */
    .badge {
        font-size: 90%;
        padding: 0.35em 0.65em;
    }
    
    /* Optimize for smaller screens */
    @media (max-width: 768px) {
        .btn-sm {
            padding: 0.2rem 0.4rem;
            font-size: 0.75rem;
        }
        
        /* Stack the date on smaller screens */
        td:nth-child(2) {
            white-space: normal;
        }
    }
</style>
<?= $this->endSection() ?>
