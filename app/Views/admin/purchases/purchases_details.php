<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><i class="fas fa-shopping-bag mr-2"></i> Purchase Details #<?= esc($purchase['purchase_id']) ?></h3>
            <div>
                <a href="/admin/purchases" class="btn btn-sm btn-light no-print">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Purchases
                </a>
                <!-- Print button -->
                <button onclick="window.print()" class="btn btn-sm btn-light ml-2 no-print">
                    <i class="fas fa-print mr-1"></i> Print
                </button>
            </div>
        </div>
    </div>
    <div class="card-body print-content">
        <!-- Print-only header -->
        <div class="d-none d-print-block mb-4 text-center">
            <h2>Eatsy</h2>
            <h5>Purchase Order</h5>
            <p>Date: <?= date('d M Y') ?></p>
            <hr>
        </div>
        
        <!-- Purchase Overview -->
        <div class="row mb-4">
            <!-- Purchase Information -->
            <div class="col-md-6">
                <h5 class="mb-3">Purchase Information</h5>
                <table class="table table-sm table-borderless">
                    <tr>
                        <th style="width: 30%">Purchase ID:</th>
                        <td><strong><?= esc($purchase['purchase_id']) ?></strong></td>
                    </tr>
                    <tr>
                        <th>Date:</th>
                        <td><?= date('d M Y H:i', strtotime($purchase['updated_at'])) ?></td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            <?php 
                            $statusClass = '';
                            $statusText = '';

                            switch ($purchase['order_status']) {
                                case 'pending':
                                    $statusClass = 'warning';
                                    $statusText = 'Pending';
                                    break;
                                case 'ordered':
                                    $statusClass = 'info';
                                    $statusText = 'Ordered';
                                    break;
                                case 'completed':
                                    $statusClass = 'success';
                                    $statusText = 'Completed';
                                    break;
                                case 'cancelled':
                                    $statusClass = 'danger';
                                    $statusText = 'Cancelled';
                                    break;
                                default:
                                    $statusClass = 'secondary';
                                    $statusText = 'Unknown';
                            }
                            ?>
                            <span class="badge badge-<?= $statusClass ?> px-3 py-2">
                                <?= $statusText ?>
                            </span>
                            
                            <?php if ($purchase['order_status'] === 'completed'): ?>
                                <small class="text-success ml-2 no-print">
                                    <i class="fas fa-info-circle"></i> Stock and product prices have been updated.
                                </small>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Buyer:</th>
                        <td><?= esc($purchase['buyer_name']) ?></td>
                    </tr>
                </table>
            </div>
            
            <!-- Supplier Information -->
            <div class="col-md-6">
                <h5 class="mb-3">Supplier Information</h5>
                <table class="table table-sm table-borderless">
                    <tr>
                        <th style="width: 30%">Name:</th>
                        <td><strong><?= esc($purchase['supplier_name']) ?></strong></td>
                    </tr>
                    <tr>
                        <th>Contact:</th>
                        <td><?= esc($purchase['supplier_phone']) ?></td>
                    </tr>
                </table>
            </div>
        </div>
        
        <!-- Purchase Status Actions - Only visible in browser, not when printing -->
        <?php if ($purchase['order_status'] !== 'completed' && $purchase['order_status'] !== 'cancelled'): ?>
        <div class="row mb-4 no-print">
            <div class="col-12">
                <div class="alert alert-light border mb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>
                            <i class="fas fa-info-circle mr-2"></i>
                            Current status: <strong><?= $statusText ?></strong>
                        </span>
                        <div>
                            <?php if ($purchase['order_status'] === 'pending'): ?>
                                <a href="/admin/purchases/update-status/<?= esc($purchase['purchase_id']) ?>/ordered" class="btn btn-primary btn-sm status-action">
                                    <i class="fas fa-check mr-1"></i> Process Order
                                </a>
                                <button type="button" class="btn btn-danger btn-sm ml-2" id="cancelPurchaseBtn">
                                    <i class="fas fa-times mr-1"></i> Reject Order
                                </button>
                            <?php elseif ($purchase['order_status'] === 'ordered'): ?>
                                <a href="/admin/purchases/update-status/<?= esc($purchase['purchase_id']) ?>/completed" class="btn btn-success btn-sm status-action">
                                    <i class="fas fa-check-double mr-1"></i> Mark as Received
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Product Details -->
        <h5 class="mb-3">Product Details</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Unit Price</th>
                        <th class="text-right">Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($purchase_details)): ?>
                        <tr>
                            <td colspan="5" class="text-center">Purchase Detail not Found</td>
                        </tr>
                    <?php else: ?>
                        <?php $grandTotal = 0; ?>
                        <?php foreach ($purchase_details as $index => $detail): ?>
                            <?php 
                                // Calculate unit price by dividing total purchase price by quantity
                                $unitPrice = $detail['purchase_price'] / $detail['quantity_bought'];
                                $totalPrice = $detail['purchase_price']; // Purchase price is already the total
                                $grandTotal += $totalPrice;
                            ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= esc($detail['product_name']) ?></td>
                                <td class="text-center"><?= $detail['quantity_bought'] ?></td>
                                <td class="text-center"><?= number_format($unitPrice, 0, ',', '.') ?> IDR</td>
                                <td class="text-right"><?= number_format($totalPrice, 0, ',', '.') ?> IDR</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right font-weight-bold">Grand Total</td>
                        <td class="text-right font-weight-bold"><?= number_format($grandTotal, 0, ',', '.') ?> IDR</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Notes Section (if any) -->
        <?php if (!empty($purchase['purchase_notes'])): ?>
        <div class="row mb-4">
            <div class="col-12">
                <h5 class="mb-3">Notes</h5>
                <div class="card">
                    <div class="card-body bg-light">
                        <?= nl2br(esc($purchase['purchase_notes'])) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Print footer that only shows when printing -->
        <div class="d-none d-print-block mt-5 pt-5">
            <div class="row">
                <div class="col-12 text-center">
                    <hr>
                    <p>Thank you for your business!</p>
                    <p><strong>Eatsy</strong></p>
                    <p>Printed on: <?= date('d M Y H:i:s') ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Display SweetAlert for flash messages if they exist
    <?php if (session()->getFlashdata('success')): ?>
        Swal.fire({
            title: 'Success',
            text: '<?= session()->getFlashdata('success') ?>',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        Swal.fire({
            title: 'Error',
            text: '<?= session()->getFlashdata('error') ?>',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    <?php endif; ?>
    
    // Add confirmation for status change actions
    $('.status-action').click(function(e) {
        e.preventDefault();
        
        const actionUrl = $(this).attr('href');
        const actionText = $(this).text().trim();
        let confirmTitle, confirmText, confirmButtonText, confirmIcon;
        
        // Set dialog content based on the action
        if (actionText.includes('Process Order')) {
            confirmTitle = 'Process Order';
            confirmText = 'Are you sure you want to process this order?';
            confirmButtonText = 'Yes, process order';
            confirmIcon = 'info';
        } else if (actionText.includes('Mark as Received')) {
            confirmTitle = 'Mark as Received';
            confirmText = 'Are you sure the goods have been received? This action will update the stock and product price.';
            confirmButtonText = 'Yes, mark as received';
            confirmIcon = 'success';
        }
        
        Swal.fire({
            title: confirmTitle,
            text: confirmText,
            icon: confirmIcon,
            showCancelButton: true,
            confirmButtonText: confirmButtonText,
            cancelButtonText: 'No, keep current status',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = actionUrl;
            }
        });
    });
    
    // Cancel Purchase button handler with SweetAlert2 input
    $('#cancelPurchaseBtn').click(function() {
        Swal.fire({
            title: 'Reject Order',
            icon: 'warning',
            html: '<p>Are you sure you want to reject this order? This action cannot be undone.</p>' +
                  '<div class="form-group text-left">' +
                  '<label for="swal-cancel-notes">Rejection Reason:</label>' +
                  '<textarea id="swal-cancel-notes" class="form-control" placeholder="Enter reason for rejection..." rows="3"></textarea>' +
                  '</div>',
            showCancelButton: true,
            confirmButtonText: 'Yes, Reject Order',
            cancelButtonText: 'No, Keep Order',
            reverseButtons: true,
            focusCancel: true,
            preConfirm: () => {
                const cancelNotes = document.getElementById('swal-cancel-notes').value;
                if (!cancelNotes.trim()) {
                    Swal.showValidationMessage('Please provide a reason for rejection');
                }
                return { notes: cancelNotes };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const cancelUrl = '/admin/purchases/update-status/<?= esc($purchase['purchase_id']) ?>/cancelled';
                const cancelNotes = result.value.notes;
                
                // Update the purchase notes in the background using AJAX
                $.ajax({
                    url: cancelUrl,
                    type: 'GET',
                    data: {
                        cancel_notes: cancelNotes
                    },
                    success: function(response) {
                        // Reload the page after successful cancellation
                        window.location.href = '/admin/purchases/details/<?= esc($purchase['purchase_id']) ?>';
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Failed to reject the order. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    });
});
</script>

<style>
/* Fix for underline on buttons */
.alert a.btn, .alert button.btn {
    text-decoration: none !important;
}

/* Print Styles */
@media print {
    /* Hide elements we don't want to print */
    .no-print, .no-print * {
        display: none !important;
    }
    
    /* Show elements that should only appear when printing */
    .d-print-block {
        display: block !important;
    }
    
    /* General print styling */
    body {
        padding: 0;
        margin: 0;
        font-size: 12pt;
    }
    
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    
    .card-header {
        display: none !important;
    }
    
    /* Ensure page breaks don't split content awkwardly */
    .table {
        page-break-inside: auto;
    }
    
    tr {
        page-break-inside: avoid;
        page-break-after: auto;
    }
    
    /* Remove background colors and use borders for readability */
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: white !important;
    }
    
    .table-bordered {
        border: 1px solid #000 !important;
    }
    
    .table-bordered td, .table-bordered th {
        border: 1px solid #000 !important;
    }
    
    /* Badge styling for print */
    .badge-warning {
        color: #000 !important;
        background-color: transparent !important;
        border: 1px solid #000 !important;
    }
    
    .badge-success {
        color: #000 !important;
        background-color: transparent !important;
        border: 1px solid #000 !important;
    }
    
    .badge-info {
        color: #000 !important;
        background-color: transparent !important;
        border: 1px solid #000 !important;
    }
    
    .badge-danger {
        color: #000 !important;
        background-color: transparent !important;
        border: 1px solid #000 !important;
    }
    
    /* Print layout adjustments */
    .container, .container-fluid, .row, .col-12, .col-md-6 {
        padding: 0 !important;
        margin: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
    }
    
    /* Ensure the printed content uses the whole page width */
    .print-content {
        width: 100% !important;
    }
}
</style>
<?= $this->endSection() ?>