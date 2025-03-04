<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title"><i class="fas fa-chart-line mr-2"></i>Sales Transaction Report</h3>
    </div>
    <div class="card-body">
        <form action="<?= base_url('admin/reports/sales/generate') ?>" method="post" id="sales-report-form">
            <?= csrf_field() ?>
            
            <!-- Hidden field to always use custom period -->
            <input type="hidden" name="period" value="custom">
            
            <!-- Quick Date Range Selectors -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="card bg-light">
                        <div class="card-body py-2">
                            <p class="mb-1"><strong>Quick Date Range:</strong></p>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-secondary" data-range="today">Today</button>
                                <button type="button" class="btn btn-outline-secondary" data-range="yesterday">Yesterday</button>
                                <button type="button" class="btn btn-outline-secondary" data-range="this-week">This Week</button>
                                <button type="button" class="btn btn-outline-secondary" data-range="last-week">Last Week</button>
                                <button type="button" class="btn btn-outline-secondary" data-range="this-month">This Month</button>
                                <button type="button" class="btn btn-outline-secondary" data-range="last-month">Last Month</button>
                                <button type="button" class="btn btn-outline-secondary" data-range="this-year">This Year</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="start_date"><i class="fas fa-calendar-alt mr-1"></i>From Date:</label>
                        <div class="input-group date">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            </div>
                            <input type="date" name="start_date" id="start_date" class="form-control" required>
                        </div>
                        <small class="form-text text-muted">Select the start date for your report period</small>
                    </div>
                </div>
                
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="end_date"><i class="fas fa-calendar-alt mr-1"></i>To Date:</label>
                        <div class="input-group date">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            </div>
                            <input type="date" name="end_date" id="end_date" class="form-control" required>
                        </div>
                        <small class="form-text text-muted">Select the end date for your report period</small>
                    </div>
                </div>
                
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="invisible">Generate</label> <!-- Invisible label to match height with other columns -->
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-file-alt mr-1"></i> Generate Report
                        </button>
                        <small class="form-text text-muted invisible">Placeholder</small> <!-- Invisible text to match height -->
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set default date values (current month)
        const today = new Date();
        const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        
        document.getElementById('start_date').value = formatDate(firstDay);
        document.getElementById('end_date').value = formatDate(lastDay);
        
        // Date range quick selectors
        document.querySelectorAll('[data-range]').forEach(button => {
            button.addEventListener('click', function() {
                const range = this.getAttribute('data-range');
                const [start, end] = getDateRange(range);
                
                document.getElementById('start_date').value = formatDate(start);
                document.getElementById('end_date').value = formatDate(end);
            });
        });
        
        // Form submission with date validation
        document.getElementById('sales-report-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const startDate = new Date(document.getElementById('start_date').value);
            const endDate = new Date(document.getElementById('end_date').value);
            
            // Validate dates
            if (isNaN(startDate.getTime()) || isNaN(endDate.getTime())) {
                Swal.fire({
                    title: 'Invalid Date',
                    text: 'Please select valid start and end dates',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }
            
            if (startDate > endDate) {
                Swal.fire({
                    title: 'Date Range Error',
                    text: 'Start date must be before or equal to end date',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }
            
            // Check if date range is more than a year
            const oneYear = 365 * 24 * 60 * 60 * 1000;
            if (endDate - startDate > oneYear) {
                Swal.fire({
                    title: 'Large Date Range',
                    text: 'The selected period is more than a year. This may take longer to process. Do you want to continue?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, generate report',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            } else {
                // Show loading state
                Swal.fire({
                    title: 'Generating Report',
                    text: 'Please wait while we generate your sales report...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                this.submit();
            }
        });
        
        // Display SweetAlert for flash messages if they exist
        <?php if (session()->has('error')): ?>
            Swal.fire({
                title: 'Report Error',
                text: '<?= session('error') ?>',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        <?php endif; ?>
        
        // Helper function to format date as YYYY-MM-DD
        function formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }
        
        // Helper function to get date ranges
        function getDateRange(range) {
            const today = new Date();
            let start, end;
            
            switch(range) {
                case 'today':
                    start = new Date();
                    end = new Date();
                    break;
                case 'yesterday':
                    start = new Date();
                    start.setDate(start.getDate() - 1);
                    end = new Date(start);
                    break;
                case 'this-week':
                    start = new Date();
                    start.setDate(start.getDate() - start.getDay());
                    end = new Date();
                    break;
                case 'last-week':
                    start = new Date();
                    start.setDate(start.getDate() - start.getDay() - 7);
                    end = new Date(start);
                    end.setDate(end.getDate() + 6);
                    break;
                case 'this-month':
                    start = new Date(today.getFullYear(), today.getMonth(), 1);
                    end = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                    break;
                case 'last-month':
                    start = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                    end = new Date(today.getFullYear(), today.getMonth(), 0);
                    break;
                case 'this-year':
                    start = new Date(today.getFullYear(), 0, 1);
                    end = new Date(today.getFullYear(), 11, 31);
                    break;
                default:
                    start = new Date(today.getFullYear(), today.getMonth(), 1);
                    end = new Date(today.getFullYear(), today.getMonth() + 1, 0);
            }
            
            return [start, end];
        }
    });
</script>

<style>
    /* Card styling */
    .card {
        border-radius: 0.5rem;
    }
    
    .card-header {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }
    
    /* Form control styling */
    .form-control {
        border-radius: 0.25rem;
    }
    
    .input-group-text {
        background-color: #f8f9fa;
    }
    
    /* Button styling */
    .btn {
        border-radius: 0.25rem;
    }
    
    /* Alert styling */
    .alert {
        border-radius: 0.5rem;
    }
    
    /* Quick date range buttons */
    .btn-group .btn {
        transition: all 0.2s;
    }
    
    .btn-group .btn:hover {
        background-color: #e2e6ea;
    }
</style>
<?= $this->endSection() ?>