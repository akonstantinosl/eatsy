<?= $this->extend('layout_admin') ?>

<?= $this->section('content') ?>
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0"><i class="fas fa-users mr-2"></i>Select Customer</h3>
    </div>
    <div class="card-body">
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        
        <form action="/sales/customer" method="post">
            <?= csrf_field() ?>

            <div class="form-group">
                <div class="input-group">
                    <select name="customer_id" id="customer_id" class="form-control select2" required>
                        <option value=""></option>
                        <?php foreach ($customers as $customer): ?>
                            <option value="<?= esc($customer['customer_id']) ?>">
                                <?= esc($customer['customer_name']) ?> - <?= esc($customer['customer_phone']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="/sales" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left mr-1"></i>Back
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-arrow-right mr-1"></i>Next
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script>
    $(document).ready(function() {
        // Initialize Select2 dengan tema bootstrap dan opsi pencarian yang ditingkatkan
        $('#customer_id').select2({
            theme: 'bootstrap',
            allowClear: true,
            width: '100%',
            language: {
                noResults: function() {
                    return "Pelanggan tidak ditemukan";
                },
                searching: function() {
                    return "Mencari...";
                }
            },
            escapeMarkup: function(markup) {
                return markup;
            },
            templateResult: formatCustomer,
            templateSelection: formatCustomerSelection
        });

        // Format tampilan hasil pencarian
        function formatCustomer(customer) {
            if (customer.loading) return customer.text;
            if (!customer.id) return customer.text;
            
            return $(`
                <div class="d-flex align-items-center p-1">
                    <div class="avatar bg-light rounded-circle mr-3 p-2">
                        <i class="fas fa-user text-primary"></i>
                    </div>
                    <div>
                        <div class="font-weight-bold">${customer.text.split(' - ')[0]}</div>
                        <div class="small text-muted">
                            <i class="fas fa-phone-alt mr-1"></i>${customer.text.split(' - ')[1] || 'No Phone'}
                        </div>
                    </div>
                </div>
            `);
        }

        // Format tampilan pilihan yang dipilih
        function formatCustomerSelection(customer) {
            if (!customer.id) return customer.text;
            
            let customerName = customer.text.split(' - ')[0];
            let customerPhone = customer.text.split(' - ')[1] || 'No Phone';
            
            return $(`
                <span>
                    <i class="fas fa-user mr-1"></i> ${customerName} <small class="text-muted">(${customerPhone})</small>
                </span>
            `);
        }
    });
</script>

<style>
    /* Custom styling untuk Select2 */
    .select2-container--bootstrap .select2-selection--single {
        height: 38px;
        padding-top: 4px;
    }
    
    .select2-container--bootstrap .select2-selection--single .select2-selection__arrow {
        top: 4px;
    }
    
    /* Animation untuk notifikasi */
    .alert {
        animation: fadeInDown 0.5s ease;
    }
    
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Styling untuk avatar */
    .avatar {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
<?= $this->endSection() ?>