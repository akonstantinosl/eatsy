<?= $this->extend('layout_landing') ?>

<?= $this->section('content') ?>
<!-- Hero Section -->
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="mb-4">EatsyMart Retail Management System</h1>
                <p class="lead">Simplified retail/minimarket management solution for modern businesses. Streamline operations, manage inventory, and boost efficiency.</p>
                <a href="/login" class="btn btn-primary btn-lg mt-3">Get Started</a>
            </div>
            <div class="col-md-6">
                <img src="https://via.placeholder.com/600x400" alt="Retail Management" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="container my-5" id="features">
    <div class="text-center mb-5">
        <h2>Our Features</h2>
        <p class="lead">Discover what makes EatsyMart the perfect solution for your retail business</p>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="feature-box shadow-sm">
                <i class="fas fa-users fa-3x mb-4 text-primary"></i>
                <h4>User Management</h4>
                <p>Easily manage staff accounts with different roles and permissions.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-box shadow-sm">
                <i class="fas fa-boxes fa-3x mb-4 text-primary"></i>
                <h4>Inventory Management</h4>
                <p>Create and update your product inventory with just a few clicks.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-box shadow-sm">
                <i class="fas fa-cash-register fa-3x mb-4 text-primary"></i>
                <h4>Sales Processing</h4>
                <p>Streamline sales transactions and customer checkout from start to finish.</p>
            </div>
        </div>
    </div>
</div>

<!-- About Section -->
<div class="bg-light py-5" id="about">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2>About EatsyMart</h2>
                <p>EatsyMart is a comprehensive retail management system designed to help minimarket and retail store owners streamline their operations, improve efficiency, and boost profitability.</p>
                <p>Our team of retail industry experts and software developers have created a solution that addresses the unique challenges faced by retail businesses of all sizes.</p>
            </div>
            <div class="col-md-6">
                <img src="https://via.placeholder.com/600x400" alt="About Us" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<!-- Contact Section -->
<div class="container my-5" id="contact">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="m-0">Contact Us</h4>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Your Name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Your Email">
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" rows="4" placeholder="Your Message"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>