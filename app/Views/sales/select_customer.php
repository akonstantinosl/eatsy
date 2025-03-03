<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Select Customer</h3>
    </div>
    <div class="card-body">
        <form action="/sales/customer" method="post">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="customer_id">Customer</label>
                <select name="customer_id" id="customer_id" class="form-control" required>
                    <option value="">Select Customer</option>
                    <?php foreach ($customers as $customer): ?>
                        <option value="<?= esc($customer['customer_id']) ?>"><?= esc($customer['customer_name']) ?> - <?= esc($customer['customer_phone']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary mr-2">Next</button>
            <a href="/sales" class="btn btn-default">Cancel</a>
        </form>
    </div>
</div>
<?= $this->endSection() ?>