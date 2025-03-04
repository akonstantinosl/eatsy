<?php if (session()->get('user_role') == 'admin'): ?>
    <?= $this->extend('layout_admin') ?>
<?php elseif (session()->get('user_role') == 'staff'): ?>
    <?= $this->extend('layout_staff') ?>
<?php endif; ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Customer List</h3>
        <div class="card-tools">
            <a href="/customers/create" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add New Customer
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="25%">Name</th>
                        <th width="15%">Phone</th>
                        <th width="<?= session()->get('user_role') == 'admin' ? '35%' : '55%' ?>">Address</th>
                        <?php if (session()->get('user_role') == 'admin'): ?>
                            <th width="20%">Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $startIndex = ($currentPage - 1) * $perPage + 1;
                    if (!empty($customers)): 
                        foreach ($customers as $index => $customer): 
                    ?>
                        <tr>
                            <td><?= $startIndex + $index ?></td>
                            <td><?= esc($customer['customer_name']) ?></td>
                            <td><?= esc($customer['customer_phone']) ?></td>
                            <td><?= esc($customer['customer_address']) ?></td>
                            <?php if (session()->get('user_role') == 'admin'): ?>
                                <td>
                                    <div class="btn-group">
                                        <a href="/customers/edit/<?= esc($customer['customer_id']) ?>" class="btn btn-warning btn-sm mr-2">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="/customers/delete/<?= esc($customer['customer_id']) ?>" 
                                        class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Are you sure you want to set this customer as inactive?')">
                                            <i class="fas fa-trash"></i> Inactive
                                        </a>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php 
                        endforeach; 
                    else: 
                    ?>
                        <tr>
                            <td colspan="<?= session()->get('user_role') == 'admin' ? '5' : '4' ?>" class="text-center">No active customers found</td>
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
                        Showing <?= $startIndex ?> to <?= min($startIndex + count($customers) - 1, $total) ?> of <?= $total ?> entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers float-md-right">
                        <ul class="pagination pagination-sm m-0">
                            <?php if ($currentPage > 1): ?>
                                <li class="paginate_button page-item previous">
                                    <a href="<?= site_url('customers?page=' . ($currentPage - 1)) ?>" class="page-link">Previous</a>
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
                                    <a href="<?= site_url('customers?page=' . $i) ?>" class="page-link"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($currentPage < $totalPages): ?>
                                <li class="paginate_button page-item next">
                                    <a href="<?= site_url('customers?page=' . ($currentPage + 1)) ?>" class="page-link">Next</a>
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
    
    /* Optimize for smaller screens */
    @media (max-width: 768px) {
        .btn-sm {
            padding: 0.2rem 0.4rem;
            font-size: 0.75rem;
        }
    }
</style>
<?= $this->endSection() ?>
