<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">User List</h3>
        <div class="card-tools">
            <a href="/admin/users/create" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add New User
            </a>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="15%">Username</th>
                        <th width="25%">Full Name</th>
                        <th width="15%">Phone</th>
                        <th width="10%">Role</th>
                        <th width="30%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $startIndex = ($currentPage - 1) * $perPage + 1;
                    if (!empty($users)): 
                        foreach ($users as $index => $user): 
                    ?>
                        <tr>
                            <td><?= $startIndex + $index ?></td>
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
                                    <?php if ($user['user_id'] != session()->get('user_id')): ?>
                                    <a href="/admin/users/delete/<?= $user['user_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to set this user as inactive?');">
                                        <i class="fas fa-trash"></i> Inactive
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php 
                        endforeach; 
                    else: 
                    ?>
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
                        Showing <?= $startIndex ?> to <?= min($startIndex + count($users) - 1, $total) ?> of <?= $total ?> entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers float-md-right">
                        <ul class="pagination pagination-sm m-0">
                            <?php if ($currentPage > 1): ?>
                                <li class="paginate_button page-item previous">
                                    <a href="<?= site_url('admin/users?page=' . ($currentPage - 1)) ?>" class="page-link">Previous</a>
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
                                    <a href="<?= site_url('admin/users?page=' . $i) ?>" class="page-link"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($currentPage < $totalPages): ?>
                                <li class="paginate_button page-item next">
                                    <a href="<?= site_url('admin/users?page=' . ($currentPage + 1)) ?>" class="page-link">Next</a>
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
