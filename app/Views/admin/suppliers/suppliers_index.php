<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header p-2">
        <form id="filterForm" action="<?= site_url('admin/suppliers') ?>" method="get" class="mb-0">
            <input type="hidden" name="page" value="<?= $currentPage ?? 1 ?>">
            <div class="row align-items-center">

                <div class="col-md-8 col-sm-12">
                    <div class="d-flex flex-wrap align-items-center">
                        <!-- Card Title -->
                        <h3 class="card-title m-0 mr-3 mb-2 mb-md-0">Supplier List</h3>
                        
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
                                    <?php if (!empty($search) || $perPage != 10): ?>
                                        <a href="/admin/suppliers" class="btn btn-sm btn-danger">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Supplier Button -->
                <div class="col-md-4 col-sm-12 text-md-right">
                    <div class="mb-2 mb-md-0">
                        <a href="/admin/suppliers/create" class="btn btn-primary btn-sm d-flex align-items-center float-md-right">
                            <i class="fas fa-plus mr-1"></i> Add New Supplier
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
                        <th width="25%">Name</th>
                        <th width="15%">Phone</th>
                        <th width="35%">Address</th>
                        <th width="20%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $startIndex = ($currentPage - 1) * $perPage + 1;
                    if (!empty($suppliers)): 
                        foreach ($suppliers as $index => $supplier): 
                    ?>
                        <tr>
                            <td><?= $startIndex + $index ?></td>
                            <td><?= esc($supplier['supplier_name']) ?></td>
                            <td><?= esc($supplier['supplier_phone']) ?></td>
                            <td><?= esc($supplier['supplier_address']) ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="/admin/suppliers/edit/<?= esc($supplier['supplier_id']) ?>" class="btn btn-warning btn-sm mr-2">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm btn-inactive" 
                                            data-supplierid="<?= esc($supplier['supplier_id']) ?>" 
                                            data-suppliername="<?= esc($supplier['supplier_name']) ?>">
                                        <i class="fas fa-trash"></i> Inactive
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php 
                        endforeach; 
                    else: 
                    ?>
                        <tr>
                            <td colspan="5" class="text-center">No active suppliers found</td>
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
                        Showing <?= $startIndex ?> to <?= min($startIndex + count($suppliers) - 1, $total) ?> of <?= $total ?> entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers float-md-right">
                        <ul class="pagination pagination-sm m-0">
                            <?php 
                            // Build the query parameters for pagination links
                            $queryParams = [];
                            if (!empty($perPage)) $queryParams['entries'] = $perPage;
                            if (!empty($search)) $queryParams['search'] = $search;
                            
                            // Create the query string
                            $queryString = http_build_query($queryParams);
                            $queryPrefix = !empty($queryString) ? '&' : '';
                            ?>
                        
                            <?php if ($currentPage > 1): ?>
                                <li class="paginate_button page-item previous">
                                    <a href="<?= site_url('admin/suppliers?page=' . ($currentPage - 1) . $queryPrefix . $queryString) ?>" class="page-link">Previous</a>
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
                                    <a href="<?= site_url('admin/suppliers?page=' . $i . $queryPrefix . $queryString) ?>" class="page-link"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($currentPage < $totalPages): ?>
                                <li class="paginate_button page-item next">
                                    <a href="<?= site_url('admin/suppliers?page=' . ($currentPage + 1) . $queryPrefix . $queryString) ?>" class="page-link">Next</a>
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
    
    /* Optimize for smaller screens */
    @media (max-width: 768px) {
        .btn-sm {
            padding: 0.2rem 0.4rem;
            font-size: 0.75rem;
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
    // Reset page parameter when search or filter changes
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
        
        // SweetAlert for inactive confirmation
        const inactiveButtons = document.querySelectorAll('.btn-inactive');
        inactiveButtons.forEach(button => {
            button.addEventListener('click', function() {
                const supplierId = this.getAttribute('data-supplierid');
                const supplierName = this.getAttribute('data-suppliername');
                
                Swal.fire({
                    title: 'Confirmation',
                    text: `Are you sure you want to set supplier "${supplierName}" as inactive?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, Inactive!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true  // This will put Cancel on the left and Yes on the right
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to delete route if confirmed
                        window.location.href = `/admin/suppliers/delete/${supplierId}`;
                    }
                });
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