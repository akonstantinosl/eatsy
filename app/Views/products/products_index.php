<?php if (session()->get('user_role') == 'admin'): ?>
    <?= $this->extend('layout_admin') ?>
<?php elseif (session()->get('user_role') == 'staff'): ?>
    <?= $this->extend('layout_staff') ?>
<?php endif; ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header p-2">
        <form id="filterForm" action="<?= site_url('/products') ?>" method="get" class="mb-0">
            <input type="hidden" name="page" value="<?= $currentPage ?? 1 ?>">
            <input type="hidden" name="sort" value="<?= $sortField ?? 'updated_at' ?>">
            <input type="hidden" name="dir" value="<?= $sortDir ?? 'desc' ?>">
            <div class="row align-items-center">

                <div class="col-md-8 col-sm-12">
                    <div class="d-flex flex-wrap align-items-center">
                        <!-- Card Title -->
                        <h3 class="card-title m-0 mr-3 mb-2 mb-md-0">Product List</h3>
                        
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
                        
                        <!-- Category Filter -->
                        <div class="mr-2 mb-2 mb-md-0" style="min-width: 120px; max-width: 150px;">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Category</span>
                                </div>
                                <select name="category" id="category" class="form-control form-control-sm" onchange="document.getElementById('filterForm').submit()">
                                    <option value="">All</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['product_category_id'] ?>" <?= $categoryFilter == $category['product_category_id'] ? 'selected' : '' ?>><?= $category['product_category_name'] ?></option>
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
                                    <?php if (!empty($search) || !empty($categoryFilter) || $perPage != 10 || $sortField != 'updated_at' || $sortDir != 'desc'): ?>
                                        <a href="/products" class="btn btn-sm btn-danger">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Product Button (for admin only) -->
                <?php if (session()->get('user_role') == 'admin'): ?>
                <div class="col-md-4 col-sm-12 text-md-right">
                    <div class="mb-2 mb-md-0">
                        <a href="/products/create" class="btn btn-primary btn-sm d-flex align-items-center float-md-right">
                            <i class="fas fa-plus mr-1"></i> Add New Product
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </form>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="productTable">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="<?= session()->get('user_role') == 'admin' ? '15%' : '20%' ?>">
                            <a href="javascript:void(0)" class="sort-link" data-sort="product_name">
                                Name
                                <?php if($sortField == 'product_name'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort text-muted"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th width="<?= session()->get('user_role') == 'admin' ? '15%' : '20%' ?>">
                            <a href="javascript:void(0)" class="sort-link" data-sort="product_category_name">
                                Category
                                <?php if($sortField == 'product_category_name'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort text-muted"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <?php if (session()->get('user_role') == 'admin'): ?>
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
                        <?php endif; ?>
                        <th width="<?= session()->get('user_role') == 'admin' ? '8%' : '15%' ?>">
                            <a href="javascript:void(0)" class="sort-link" data-sort="product_stock">
                                Stock
                                <?php if($sortField == 'product_stock'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort text-muted"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <?php if (session()->get('user_role') == 'admin'): ?>
                        <th width="12%">
                            <a href="javascript:void(0)" class="sort-link" data-sort="buying_price">
                                Buying Price
                                <?php if($sortField == 'buying_price'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort text-muted"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <?php endif; ?>
                        <th width="<?= session()->get('user_role') == 'admin' ? '12%' : '40%' ?>">
                            <a href="javascript:void(0)" class="sort-link" data-sort="selling_price">
                                Selling Price
                                <?php if($sortField == 'selling_price'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort text-muted"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <?php if (session()->get('user_role') == 'admin'): ?>
                        <th width="18%">Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $startIndex = ($currentPage - 1) * $perPage + 1;
                    if (!empty($products)):
                        foreach ($products as $index => $product): 
                            // Check if this is a newly created or updated product
                            $isNewProduct = isset($newProductId) && $product['product_id'] == $newProductId;
                            $isUpdatedProduct = isset($updatedProductId) && $product['product_id'] == $updatedProductId;
                            $rowClass = $isNewProduct ? 'table-success' : ($isUpdatedProduct ? 'table-info' : '');
                    ?>
                        <tr class="<?= $rowClass ?>">
                            <td><?= $startIndex + $index ?></td>
                            <td><?= esc($product['product_name']) ?></td>
                            <td><?= esc($product['product_category_name']) ?></td>
                            <?php if (session()->get('user_role') == 'admin'): ?>
                            <td><?= esc($product['supplier_name']) ?></td>
                            <?php endif; ?>
                            <td><?= esc($product['product_stock']) ?></td>
                            <?php if (session()->get('user_role') == 'admin'): ?>
                            <td><?= number_format($product['buying_price'], 0, ',', '.') . " IDR" ?></td>
                            <?php endif; ?>
                            <td><?= number_format($product['selling_price'], 0, ',', '.') . " IDR" ?></td>
                            <?php if (session()->get('user_role') == 'admin'): ?>
                            <td>
                                <div class="btn-group">
                                    <a href="/products/edit/<?= esc($product['product_id']) ?>" class="btn btn-warning btn-sm mr-2">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm btn-inactive" 
                                            data-productid="<?= esc($product['product_id']) ?>" 
                                            data-productname="<?= esc($product['product_name']) ?>">
                                        <i class="fas fa-trash"></i> Inactivate
                                    </button>
                                </div>
                                <?php if($isNewProduct): ?>
                                    <span class="badge badge-success ml-2">NEW</span>
                                <?php elseif($isUpdatedProduct): ?>
                                    <span class="badge badge-info ml-2">UPDATED</span>
                                <?php endif; ?>
                            </td>
                            <?php endif; ?>
                        </tr>
                    <?php 
                        endforeach;
                    else:
                    ?>
                        <tr>
                            <td colspan="<?= session()->get('user_role') == 'admin' ? '8' : '5' ?>" class="text-center">No active products found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-3 px-3 pb-3">
            <div class="row">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info" role="status" aria-live="polite">
                        Showing <?= $startIndex ?> to <?= min($startIndex + count($products) - 1, $total) ?> of <?= $total ?> entries
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
                            ?>
                        
                            <?php if ($currentPage > 1): ?>
                                <li class="paginate_button page-item previous">
                                    <a href="<?= site_url('/products?page=' . ($currentPage - 1) . $queryPrefix . $queryString) ?>" class="page-link">Previous</a>
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
                                    <a href="<?= site_url('/products?page=' . $i . $queryPrefix . $queryString) ?>" class="page-link"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($currentPage < $totalPages): ?>
                                <li class="paginate_button page-item next">
                                    <a href="<?= site_url('/products?page=' . ($currentPage + 1) . $queryPrefix . $queryString) ?>" class="page-link">Next</a>
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

<!-- CSS to help with responsiveness -->
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
        
        // SweetAlert2 untuk konfirmasi inaktivasi produk
        const inactiveButtons = document.querySelectorAll('.btn-inactive');
        inactiveButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-productid');
                const productName = this.getAttribute('data-productname');
                
                Swal.fire({
                    title: 'Confirmation',
                    text: `Are you sure you want to inactive product "${productName}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, Inactive!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true  // Tombol batal di kiri dan konfirmasi di kanan
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect ke route delete jika dikonfirmasi
                        window.location.href = `/products/delete/${productId}`;
                    }});
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