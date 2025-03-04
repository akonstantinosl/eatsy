<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Profit Report</h3>
    </div>
    <div class="card-body">
        <form action="<?= base_url('admin/reports/profit/generate') ?>" method="post">
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
        
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> This report will calculate profit by comparing sales and purchase data for the selected period.
                    </div>
                </div>
            </div>
        </form>
        
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger mt-3">
                <?= session('error') ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
