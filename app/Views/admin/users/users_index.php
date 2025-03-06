<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header p-2">
        <form id="filterForm" action="<?= site_url('admin/users') ?>" method="get" class="mb-0">
            <input type="hidden" name="page" value="<?= $currentPage ?? 1 ?>">
            <input type="hidden" name="sort" value="<?= $sortField ?? 'updated_at' ?>">
            <input type="hidden" name="dir" value="<?= $sortDir ?? 'desc' ?>">
            <div class="row align-items-center">

                <div class="col-md-8 col-sm-12">
                    <div class="d-flex flex-wrap align-items-center">
                        <!-- Card Title -->
                        <h3 class="card-title m-0 mr-3 mb-2 mb-md-0">User List</h3>
                        
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
                        
                        <!-- Role Filter -->
                        <div class="mr-2 mb-2 mb-md-0" style="min-width: 120px; max-width: 150px;">
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Role</span>
                                </div>
                                <select name="role" id="role" class="form-control form-control-sm" onchange="document.getElementById('filterForm').submit()">
                                    <option value="">All</option>
                                    <option value="admin" <?= $roleFilter == 'admin' ? 'selected' : '' ?>>Admin</option>
                                    <option value="staff" <?= $roleFilter == 'staff' ? 'selected' : '' ?>>Staff</option>
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
                                    <?php if (!empty($search) || !empty($roleFilter) || $perPage != 10 || $sortField != 'updated_at' || $sortDir != 'desc'): ?>
                                        <a href="/admin/users" class="btn btn-sm btn-danger">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add User Button -->
                <div class="col-md-4 col-sm-12 text-md-right">
                    <div class="mb-2 mb-md-0">
                        <a href="/admin/users/create" class="btn btn-primary btn-sm d-flex align-items-center float-md-right">
                            <i class="fas fa-plus mr-1"></i> Add New User
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- /.card-header -->
    
    <!-- Main card body with table -->
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="15%">
                            <a href="javascript:void(0)" class="sort-link" data-sort="user_name">
                                Username 
                                <?php if($sortField == 'user_name'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort text-muted"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th width="25%">
                            <a href="javascript:void(0)" class="sort-link" data-sort="user_fullname">
                                Full Name
                                <?php if($sortField == 'user_fullname'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort text-muted"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th width="15%">
                            <a href="javascript:void(0)" class="sort-link" data-sort="user_phone">
                                Phone
                                <?php if($sortField == 'user_phone'): ?>
                                    <i class="fas fa-sort-<?= ($sortDir == 'asc') ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                    <i class="fas fa-sort text-muted"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th width="10%">Role</th>
                        <th width="30%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $startIndex = ($currentPage - 1) * $perPage + 1;
                    $displayIndex = 0;
                    $currentUserId = session()->get('user_id');
                    
                    if (!empty($users)): 
                        foreach ($users as $index => $user): 
                            // Skip the current logged-in user
                            if ($user['user_id'] == $currentUserId) {
                                continue;
                            }
                            $displayIndex++;
                            
                            // Check if this is a newly created or updated user
                            $isNewUser = isset($newUserId) && $user['user_id'] == $newUserId;
                            $isUpdatedUser = isset($updatedUserId) && $user['user_id'] == $updatedUserId;
                            $rowClass = $isNewUser ? 'table-success' : ($isUpdatedUser ? 'table-info' : '');
                    ?>
                        <tr class="<?= $rowClass ?>">
                            <td>
                                <?= $startIndex + $displayIndex - 1 ?>
                            </td>
                            <td><?= $user['user_name'] ?></td>
                            <td><?= $user['user_fullname'] ?></td>
                            <td><?= $user['user_phone'] ?></td>
                            <td>
                                <?php if ($user['user_role'] == 'admin'): ?>
                                    <span class="badge badge-primary">Admin</span>
                                <?php else: ?>
                                    <span class="badge badge-info">Staff</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="/admin/users/edit/<?= $user['user_id'] ?>" class="btn btn-warning btn-sm mr-2">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm btn-inactive" data-userid="<?= $user['user_id'] ?>" data-username="<?= $user['user_fullname'] ?>">
                                        <i class="fas fa-trash"></i> Inactive
                                    </button>
                                </div>
                                <?php if($isNewUser): ?>
                                    <span class="badge badge-success ml-2">NEW</span>
                                <?php elseif($isUpdatedUser): ?>
                                    <span class="badge badge-info ml-2">UPDATED</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php 
                        endforeach; 
                        
                        // If no users are displayed after filtering out the current user
                        if ($displayIndex == 0):
                    ?>
                        <tr>
                            <td colspan="6" class="text-center">No other active users found</td>
                        </tr>
                    <?php endif; ?>
                    
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No active users found</td>
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
                        <?php 
                        // Adjust the total count by subtracting 1 for the current user
                        $adjustedTotal = $total;
                        if (in_array($currentUserId, array_column($users, 'user_id'))) {
                            $adjustedTotal = $total - 1;
                        }
                        
                        // Show count excluding the current user
                        $displayedEnd = min($startIndex + $displayIndex - 1, $adjustedTotal);
                        ?>
                        Showing <?= $displayIndex > 0 ? $startIndex : 0 ?> to <?= $displayedEnd ?> of <?= $adjustedTotal ?> entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers float-md-right">
                        <ul class="pagination pagination-sm m-0">
                            <?php 
                            // Build the query parameters for pagination links
                            $queryParams = [];
                            if (!empty($perPage)) $queryParams['entries'] = $perPage;
                            if (!empty($roleFilter)) $queryParams['role'] = $roleFilter;
                            if (!empty($search)) $queryParams['search'] = $search;
                            if (!empty($sortField)) $queryParams['sort'] = $sortField;
                            if (!empty($sortDir)) $queryParams['dir'] = $sortDir;
                            
                            // Create the query string
                            $queryString = http_build_query($queryParams);
                            $queryPrefix = !empty($queryString) ? '&' : '';
                            
                            // Calculate total pages based on adjusted total
                            $totalPages = ceil($adjustedTotal / $perPage);
                            ?>
                        
                            <?php if ($currentPage > 1): ?>
                                <li class="paginate_button page-item previous">
                                    <a href="<?= site_url('admin/users?page=' . ($currentPage - 1) . $queryPrefix . $queryString) ?>" class="page-link">Previous</a>
                                </li>
                            <?php else: ?>
                                <li class="paginate_button page-item previous disabled">
                                    <a href="#" class="page-link">Previous</a>
                                </li>
                            <?php endif; ?>
                            
                            <?php 
                            $maxPagesToShow = 5;
                            $startPage = max(1, min($currentPage - floor($maxPagesToShow / 2), $totalPages - $maxPagesToShow + 1));
                            $endPage = min($startPage + $maxPagesToShow - 1, $totalPages);
                            
                            for ($i = $startPage; $i <= $endPage; $i++): 
                            ?>
                                <li class="paginate_button page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                                    <a href="<?= site_url('admin/users?page=' . $i . $queryPrefix . $queryString) ?>" class="page-link"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($currentPage < $totalPages): ?>
                                <li class="paginate_button page-item next">
                                    <a href="<?= site_url('admin/users?page=' . ($currentPage + 1) . $queryPrefix . $queryString) ?>" class="page-link">Next</a>
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
    <!-- /.card-body -->
</div>
<!-- /.card -->

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
        
        // SweetAlert for inactive confirmation
        const inactiveButtons = document.querySelectorAll('.btn-inactive');
        inactiveButtons.forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-userid');
                const userName = this.getAttribute('data-username');
                
                Swal.fire({
                    title: 'Confirmation',
                    text: `Are you sure you want to inactive user "${userName}"?`,
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
                        window.location.href = `/admin/users/delete/${userId}`;
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