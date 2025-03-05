<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0"><i class="fas fa-file-invoice mr-2"></i> Sale Details #<?= esc($sale['sale_id']) ?></h3>
                    <div>
                        <a href="/sales" class="btn btn-sm btn-light no-print">
                            <i class="fas fa-arrow-left mr-1"></i> Back to Sales
                        </a>
                        <!-- Simplified print button -->
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
                    <h5>Sale Receipt</h5>
                    <p>Date: <?= date('d M Y') ?></p>
                    <hr>
                </div>
                
                <div class="row mb-4">
                    <!-- Sale Information -->
                    <div class="col-md-6">
                        <h5 class="mb-3">Sale Information</h5>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th style="width: 30%">Sale ID:</th>
                                <td><strong><?= esc($sale['sale_id']) ?></strong></td>
                            </tr>
                            <tr>
                                <th>Date:</th>
                                <td><?= date('d M Y H:i', strtotime($sale['updated_at'])) ?></td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    <?php 
                                    $statusClasses = [
                                        'pending' => 'warning',
                                        'processing' => 'info',
                                        'completed' => 'success',
                                        'cancelled' => 'danger'
                                    ];
                                    $statusClass = $statusClasses[$sale['transaction_status']] ?? 'secondary';
                                    ?>
                                    <span class="badge badge-<?= $statusClass ?> px-3 py-2">
                                        <?= ucfirst($sale['transaction_status']) ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Payment Method:</th>
                                <td><?= ucfirst(str_replace('_', ' ', $sale['payment_method'])) ?></td>
                            </tr>
                            <tr>
                                <th>Seller:</th>
                                <td><?= esc($sale['seller_name']) ?></td>
                            </tr>
                        </table>
                    </div>
                    
                    <!-- Customer Information -->
                    <div class="col-md-6">
                        <h5 class="mb-3">Customer Information</h5>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th style="width: 30%">Name:</th>
                                <td><strong><?= esc($sale['customer_name']) ?></strong></td>
                            </tr>
                            <tr>
                                <th>Phone:</th>
                                <td><?= esc($sale['customer_phone']) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <!-- Sale Status Actions - Only visible in browser, not when printing -->
                <?php if ($sale['transaction_status'] !== 'completed' && $sale['transaction_status'] !== 'cancelled'): ?>
                <div class="row mb-4 no-print">
                    <div class="col-12">
                        <div class="alert alert-light border mb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Current status: <strong><?= ucfirst($sale['transaction_status']) ?></strong>
                                </span>
                                <div>
                                    <?php if ($sale['transaction_status'] === 'pending'): ?>
                                        <a href="/sales/update-status/<?= esc($sale['sale_id']) ?>/processing" class="btn btn-primary btn-sm status-action">
                                            <i class="fas fa-clock mr-1"></i> Mark as Processing
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm ml-2" id="cancelSaleBtn">
                                            <i class="fas fa-times mr-1"></i> Cancel Sale
                                        </button>
                                    <?php elseif ($sale['transaction_status'] === 'processing'): ?>
                                        <a href="/sales/update-status/<?= esc($sale['sale_id']) ?>/completed" class="btn btn-success btn-sm status-action">
                                            <i class="fas fa-check mr-1"></i> Mark as Completed
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Sale Items -->
                <h5 class="mb-3">Sale Items</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th class="text-center">Price per Unit</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($sale_details as $detail): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= esc($detail['product_name']) ?></td>
                                    <td class="text-center"><?= number_format($detail['price_per_unit'], 0, ',', '.') ?> IDR</td>
                                    <td class="text-center"><?= $detail['quantity_sold'] ?></td>
                                    <td class="text-right"><?= number_format($detail['price_per_unit'] * $detail['quantity_sold'], 0, ',', '.') ?> IDR</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right font-weight-bold">Grand Total:</td>
                                <td class="text-right font-weight-bold"><?= number_format($sale['sale_amount'], 0, ',', '.') ?> IDR</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <!-- Notes Section (if any) -->
                <?php if (!empty($sale['sale_notes'])): ?>
                <div class="row mt-4">
                    <div class="col-12">
                        <h5 class="mb-3">Notes</h5>
                        <div class="card">
                            <div class="card-body bg-light">
                                <?= nl2br(esc($sale['sale_notes'])) ?>
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
                            <p>Thank you for chossing our products</p>
                            <p><strong>Eatsy</strong></p>
                            <p>Printed on: <?= date('d M Y H:i:s') ?></p>
                        </div>
                    </div>
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
        if (actionText.includes('Processing')) {
            confirmTitle = 'Start Processing';
            confirmText = 'Are you sure you want to change the status to Processing?';
            confirmButtonText = 'Yes, start processing';
            confirmIcon = 'info';
        } else if (actionText.includes('Completed')) {
            confirmTitle = 'Mark as Completed';
            confirmText = 'Are you sure you want to mark this sale as Completed? This will update the product inventory.';
            confirmButtonText = 'Yes, complete sale';
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
    
    // Cancel Sale button handler with SweetAlert2 input
    $('#cancelSaleBtn').click(function() {
        Swal.fire({
            title: 'Cancel Sale',
            icon: 'warning',
            html: '<p>Are you sure you want to cancel this sale? This action cannot be undone.</p>' +
                  '<div class="form-group text-left">' +
                  '<label for="swal-cancel-notes">Cancellation Reason:</label>' +
                  '<textarea id="swal-cancel-notes" class="form-control" placeholder="Enter reason for cancellation..." rows="3"></textarea>' +
                  '</div>',
            showCancelButton: true,
            confirmButtonText: 'Yes, Cancel Sale',
            cancelButtonText: 'No, Keep Sale',
            reverseButtons: true,
            focusCancel: true,
            preConfirm: () => {
                const cancelNotes = document.getElementById('swal-cancel-notes').value;
                if (!cancelNotes.trim()) {
                    Swal.showValidationMessage('Please provide a reason for cancellation');
                }
                return { notes: cancelNotes };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const cancelUrl = '/sales/update-status/<?= esc($sale['sale_id']) ?>/cancelled';
                const cancelNotes = result.value.notes;
                
                // Update the sale notes in the background using AJAX
                $.ajax({
                    url: cancelUrl,
                    type: 'GET',
                    data: {
                        cancel_notes: cancelNotes
                    },
                    success: function(response) {
                        // Reload the page after successful cancellation
                        window.location.href = '/sales/details/<?= esc($sale['sale_id']) ?>';
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Failed to cancel the sale. Please try again.',
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