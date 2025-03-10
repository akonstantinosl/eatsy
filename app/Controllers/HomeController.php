<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\SupplierModel;
use App\Models\CustomerModel;
use App\Models\ProductModel;
use App\Models\SaleModel;
use App\Models\PurchaseModel;

class HomeController extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    
    /**
     * Load user data into session for consistent display across layouts
     */
    protected function loadUserData()
    {
        // Get user data for navbar and sidebar if not already in session
        if (!session()->get('user_fullname') || !session()->get('user_photo')) {
            $userData = $this->userModel->find(session()->get('user_id'));
            if ($userData) {
                // Store user data in session
                session()->set('user_fullname', $userData['user_fullname']);
                
                // Set default photo based on user role if none exists
                if (empty($userData['user_photo'])) {
                    $defaultPhoto = (session()->get('user_role') == 'admin') ? 'default_admin.png' : 'default_staff.png';
                    session()->set('user_photo', $defaultPhoto);
                } else {
                    session()->set('user_photo', $userData['user_photo']);
                }
            } else {
                // Set default values if user data not found
                session()->set('user_fullname', session()->get('user_name'));
                $defaultPhoto = (session()->get('user_role') == 'admin') ? 'default_admin.png' : 'default_staff.png';
                session()->set('user_photo', $defaultPhoto);
            }
        }
    }
    
    public function index()
    {
        return view('landing_page');
    }
    
    public function adminDashboard()
    {
        if (!session()->get('logged_in') || session()->get('user_role') != 'admin') {
            return redirect()->to('login');
        }
        
        // Load user data into session
        $this->loadUserData();
        
        // Initialize models
        $supplierModel = new SupplierModel();
        $customerModel = new CustomerModel();
        $productModel = new ProductModel();
        $saleModel = new SaleModel();
        $purchaseModel = new PurchaseModel();
        
        // Get counts for dashboard widgets
        $data['totalUsers'] = $this->userModel->countAll();
        $data['totalSuppliers'] = $supplierModel->countAll();
        $data['totalCustomers'] = $customerModel->countAll();
        $data['totalProducts'] = $productModel->countAll();
        
        // Get count of low stock items (example threshold of 10)
        $data['lowStockCount'] = $productModel->where('product_stock <', 10)->countAllResults();
        
        // Get pending purchases count
        $data['pendingPurchases'] = $purchaseModel->where('order_status', 'pending')->countAllResults();
        
        // Calculate monthly sales count
        $currentMonth = date('Y-m');
        $data['monthlySales'] = $saleModel->where('MONTH(created_at)', date('m'))
                                          ->where('YEAR(created_at)', date('Y'))
                                          ->countAllResults();
        
        // Calculate monthly revenue
        $monthlyRevenue = $saleModel->selectSum('sale_amount')
                                    ->where('MONTH(created_at)', date('m'))
                                    ->where('YEAR(created_at)', date('Y'))
                                    ->where('transaction_status', 'completed')
                                    ->first();
        $data['monthlyRevenue'] = $monthlyRevenue['sale_amount'] ?? 0;
        
        // Get recent sales for the table
        $data['recentSales'] = $saleModel->select('sales.*, customers.customer_name')
                                         ->join('customers', 'customers.customer_id = sales.customer_id')
                                         ->orderBy('sales.created_at', 'DESC')
                                         ->limit(5)
                                         ->find();
        
        return view('admin/admin_dashboard', $data);
    }
    
    public function staffDashboard()
    {
        if (!session()->get('logged_in') || session()->get('user_role') != 'staff') {
            return redirect()->to('login');
        }
        
        // Load user data into session
        $this->loadUserData();
        
        // Get current user ID
        $userId = session()->get('user_id');
        
        // Initialize models
        $customerModel = new CustomerModel();
        $productModel = new ProductModel();
        $saleModel = new SaleModel();
        
        // Get counts for dashboard widgets
        $data['totalCustomers'] = $customerModel->countAll();
        $data['totalProducts'] = $productModel->countAll();
        
        // Get count of today's sales for this staff member only
        $todayDate = date('Y-m-d');
        $data['todaySales'] = $saleModel->where('DATE(created_at)', $todayDate)
                                        ->where('user_id', $userId)
                                        ->countAllResults();
        
        // Calculate today's revenue for this staff member only
        $todayRevenue = $saleModel->selectSum('sale_amount')
                                  ->where('DATE(created_at)', $todayDate)
                                  ->where('transaction_status', 'completed')
                                  ->where('user_id', $userId)
                                  ->first();
        $data['todayRevenue'] = $todayRevenue['sale_amount'] ?? 0;
        
        // Get recent sales for the table - only for this staff member
        $data['recentSales'] = $saleModel->select('sales.*, customers.customer_name')
                                         ->join('customers', 'customers.customer_id = sales.customer_id')
                                         ->where('sales.user_id', $userId)
                                         ->orderBy('sales.created_at', 'DESC')
                                         ->limit(8)
                                         ->find();
        
        // Get low stock products with category info
        $data['lowStockProducts'] = $productModel->select('products.*, product_categories.product_category_name')
                                                ->join('product_categories', 'product_categories.product_category_id = products.product_category_id')
                                                ->where('products.product_stock <', 10)
                                                ->where('products.product_status', 'active')
                                                ->orderBy('products.product_stock', 'ASC')
                                                ->limit(3)
                                                ->find();
        
        // Get recent customers
        $data['recentCustomers'] = $customerModel->where('customer_status', 'active')
                                                ->orderBy('created_at', 'DESC')
                                                ->limit(3)
                                                ->find();
        
        return view('staff/staff_dashboard', $data);
    }    
}