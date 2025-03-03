<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Sales Transaction Report</h3>
    </div>
    <div class="card-body">
        <form action="<?= base_url('admin/reports/sales/generate') ?>" method="post">
            <?= csrf_field() ?>
            
            <!-- Hidden field to always use custom period -->
            <input type="hidden" name="period" value="custom">
            
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="start_date">From Date:</label>
                        <div class="input-group date">
                            <input type="date" name="start_date" id="start_date" class="form-control" required>
                            <div class="input-group-append">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="end_date">To Date:</label>
                        <div class="input-group date">
                            <input type="date" name="end_date" id="end_date" class="form-control" required>
                            <div class="input-group-append">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-2 d-flex align-items-end">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Generate Report</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    // Set default dates (current month)
    var date = new Date();
    var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
    var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
    
    // Format dates for input fields (YYYY-MM-DD)
    var formatDateForInput = function(date) {
        var month = ("0" + (date.getMonth() + 1)).slice(-2);
        var day = ("0" + date.getDate()).slice(-2);
        return date.getFullYear() + "-" + month + "-" + day;
    };
    
    // Set the default values for start and end date fields
    $('#start_date').val(formatDateForInput(firstDay));
    $('#end_date').val(formatDateForInput(lastDay));
    
    // Form validation
    $('form').submit(function(event) {
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        
        if (!startDate || !endDate) {
            alert('Please select both start and end dates for the report.');
            event.preventDefault();
            return false;
        }
    });
});
</script>

<?= $this->endSection() ?>
