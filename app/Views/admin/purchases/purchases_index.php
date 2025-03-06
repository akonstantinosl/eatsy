<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header p-2">
        <form id="filterForm" action="<?= site_url('admin/purchases') ?>" method="get" class="mb-0">
            <input type="hidden" name="page" value="<?= $currentPage ?? 1 ?>">
            <input type="hidden" name="sort" value="<?= $sortField ?? 'updated_at' ?>">
            <input type="hidden" name="dir" value="<?= $sortDir ?? 'desc' ?>">
            <div class="row align-items-center">

                <div class="col-md-8 col-sm-12">
                    <div class="d-flex flex-wrap align-items-center">
                        <!-- Card Title -->
                        <h3 class="card-title m-0 mr-3 mb-2 mb-md-0">Purchase List</h3>
                        
                        <!-- Show Entries -->
                        <div class="mr-2 mb-2 mb-md-0" style="min-width: 100px; max-width: 130px;">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Show</span>
                                </div>
                                <select name="entries" id="entries" class="form-control form-control-sm" onchange="document.getElementById('filterForm').submit()">
                                    <?php foreach ([10, 25, 50, 100] as $option): ?>
                                        <option value="<?= $option ?>" <?= $perPage == $option ? 'selected' : '' ?>><?= $option ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Status Filter -->
                        <div class="mr-2 mb-2 mb-md-0" style="min-width: 120px; max-width: 150px;">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Status</span>
                                </div>
                                <select name="status" id="status" class="form-control form-control-sm" onchange="document.getElementById('filterForm').submit()">
                                    <option value="">All</option>
                                    <option value="pending" <?= $statusFilter == 'pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="ordered" <?= $statusFilter == 'ordered' ? 'selected' : '' ?>>Ordered</option>
                                    <option value="completed" <?= $statusFilter == 'completed' ? 'selected' : '' ?>>Completed</option>
                                    <option value="cancelled" <?= $statusFilter == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Search Box -->
                        <div class="mr-2 mb-2 mb-md-0" style="min-width: 200px; max-width: 300px;">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Search</span>
                                </div>
                                <input type="text" name="search" class="form-control form-control-sm" value="<?= $search ?? '' ?>">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-sm btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <?php if (!empty($search) || !empty($statusFilter) || $perPage != 10 || $sortField != 'updated_at' || $sortDir != 'desc'): ?>
                                        <a href="/admin/purchases" class="btn btn-sm btn-danger">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add New Purchase Button -->
                <div class="col-md-4 col-sm-12 text-md-right">
                    <div class="mb-2 mb-md-0">
                        <a href="/admin/purchases/supplier" class="btn btn-primary btn-sm d-flex align-items-center float-md-right">
                            <i class="fas fa-plus mr-1"></i> New Purchase
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="15%">
                            <a href="javascript:void(0)" class="sort-link" data-sort="updated_at">
                                Date
                                <?php if($sortField == 'updated_at'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort text-muted"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th width="15%">
                            <a href="javascript:void(0)" class="sort-link" data-sort="user_fullname">
                                User
                                <?php if($sortField == 'user_fullname'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort text-muted"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th width="15%">
                            <a href="javascript:void(0)" class="sort-link" data-sort="supplier_name">
                                Supplier
                                <?php if($sortField == 'supplier_name'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort text-muted"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th width="15%">
                            <a href="javascript:void(0)" class="sort-link" data-sort="supplier_phone">
                                Contact
                                <?php if($sortField == 'supplier_phone'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort text-muted"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th width="15%">
                            <a href="javascript:void(0)" class="sort-link" data-sort="purchase_amount">
                                Amount
                                <?php if($sortField == 'purchase_amount'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort text-muted"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th width="10%">
                            <a href="javascript:void(0)" class="sort-link" data-sort="order_status">
                                Status
                                <?php if($sortField == 'order_status'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort text-muted"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th width="10%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $startIndex = ($currentPage - 1) * $perPage + 1;
                    if (!empty($purchases)): 
                        foreach ($purchases as $index => $purchase): 
                            // Check if this is a newly created or updated purchase
                            $isNewPurchase = isset($newPurchaseId) && $purchase['purchase_id'] == $newPurchaseId;
                            $isUpdatedPurchase = isset($updatedPurchaseId) && $purchase['purchase_id'] == $updatedPurchaseId;
                            $rowClass = $isNewPurchase ? 'table-success' : ($isUpdatedPurchase ? 'table-info' : '');
                    ?>
                        <tr class="<?= $rowClass ?>">
                            <td><?= $startIndex + $index ?></td>
                            <td><?= date('d F Y, H:i', strtotime($purchase['updated_at'])) ?></td> 
                            <td><?= esc($purchase['user_fullname']) ?></td>
                            <td><?= esc($purchase['supplier_name']) ?></td>
                            <td><?= esc($purchase['supplier_phone']) ?></td>
                            <td><?= number_format($purchase['purchase_amount'], 0, ',', '.') . " IDR" ?></td>
                            <td>
                                <?php 
                                    $statusClass = '';
                                    $statusText = '';

                                    switch ($purchase['order_status']) {
                                        case 'pending':
                                            $statusClass = 'badge-warning';
                                            $statusText = 'Pending';
                                            break;
                                        case 'ordered':
                                            $statusClass = 'badge-info';
                                            $statusText = 'Ordered';
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
                                <a href="/admin/purchases/details/<?= esc($purchase['purchase_id']) ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <?php if($isNewPurchase): ?>
                                    <span class="badge badge-success ml-2">NEW</span>
                                <?php elseif($isUpdatedPurchase): ?>
                                    <span class="badge badge-info ml-2">UPDATED</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php 
                        endforeach; 
                    else: 
                    ?>
                        <tr>
                            <td colspan="8" class="text-center">No purchases found</td>
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
                        Showing <?= $startIndex ?> to <?= min($startIndex + count($purchases) - 1, $total) ?> of <?= $total ?> entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers float-md-right">
                        <ul class="pagination pagination-sm m-0">
                            <?php 
                            // Build the query parameters for pagination links
                            $queryParams = [];
                            if (!empty($perPage) && $perPage != 10) $queryParams['entries'] = $perPage;
                            if (!empty($statusFilter)) $queryParams['status'] = $statusFilter;
                            if (!empty($search)) $queryParams['search'] = $search;
                            if (!empty($sortField) && $sortField != 'updated_at') $queryParams['sort'] = $sortField;
                            if (!empty($sortDir) && $sortDir != 'desc') $queryParams['dir'] = $sortDir;
                            
                            // Create the query string
                            $queryString = http_build_query($queryParams);
                            $queryPrefix = !empty($queryString) ? '&' : '';
                            ?>
                            <?php if ($currentPage > 1): ?>
                                <li class="paginate_button page-item previous">
                                    <a href="<?= site_url('admin/purchases?page=' . ($currentPage - 1) . $queryPrefix . $queryString) ?>" class="page-link">Previous</a>
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
                                    <a href="<?= site_url('admin/purchases?page=' . $i . $queryPrefix . $queryString) ?>" class="page-link"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($currentPage < $totalPages): ?>
                                <li class="paginate_button page-item next">
                                    <a href="<?= site_url('admin/purchases?page=' . ($currentPage + 1) . $queryPrefix . $queryString) ?>" class="page-link">Next</a>
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
    
    /* Style for input groups */
    .input-group-text {
        width: 60px;
        display: flex;
        justify-content: center;
        background-color: #f4f6f9;
        border-color: #ced4da;
    }
    
    /* Card header padding */
    .card-header {
        padding: 0.75rem 1rem;
    }
    
    /* Fix for button alignment */
    .float-md-right {
        float: right !important;
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
    
    /* Animation for new/updated rows */
    .table-success, .table-info {
        transition: background-color 3s;
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
        
        /* Reduce input group text width on mobile */
        .input-group-text {
            width: 50px;
            padding: 0.25rem 0.5rem;
        }
        
        /* Fix alignment on mobile */
        .float-md-right {
            float: none !important;
        }
        
        .d-flex.align-items-center.float-md-right {
            justify-content: flex-start;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all the form controls that should reset the page parameter
        const formControls = document.querySelectorAll('#filterForm select, #filterForm input[type="text"]');
        
        formControls.forEach(control => {
            control.addEventListener('change', function() {
                // Reset the page to 1 when filters change
                document.querySelector('input[name="page"]').value = '1';
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
        
        // Fade out highlight effects after a delay
        setTimeout(function() {
            document.querySelectorAll('.table-success, .table-info').forEach(function(el) {
                el.style.backgroundColor = 'transparent';
            });
        }, 3000);
        
        // Display SweetAlert for flash messages if they exist
        <?php if (session()->getFlashdata('success')): ?>
            Swal.fire({
                title: 'Success!',
                text: '<?= session()->getFlashdata('success') ?>',
                icon: 'success',
                timer: 3000
            });
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('error')): ?>
            Swal.fire({
                title: 'Error!',
                text: '<?= session()->getFlashdata('error') ?>',
                icon: 'error',
                timer: 3000
            });
        <?php endif; ?>
    });
</script>
<?= $this->endSection() ?>
                                    