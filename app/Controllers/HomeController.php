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
    public function index()
    {
        return view('landing_page');
    }
    
    public function adminDashboard()
    {
        if (!session()->get('logged_in') || session()->get('user_role') != 'admin') {
            return redirect()->to('login');
        }
        
        // Initialize models
        $userModel = new UserModel();
        $supplierModel = new SupplierModel();
        $customerModel = new CustomerModel();
        $productModel = new ProductModel();
        $saleModel = new SaleModel();
        $purchaseModel = new PurchaseModel();
        
        // Get counts for dashboard widgets
        $data['totalUsers'] = $userModel->countAll();
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
        
        // Initialize models
        $customerModel = new CustomerModel();
        $productModel = new ProductModel();
        $saleModel = new SaleModel();
        
        // Get counts for dashboard widgets
        $data['totalCustomers'] = $customerModel->countAll();
        $data['totalProducts'] = $productModel->countAll();
        
        // Get count of today's sales
        $todayDate = date('Y-m-d');
        $data['todaySales'] = $saleModel->where('DATE(created_at)', $todayDate)->countAllResults();
        
        // Calculate today's revenue
        $todayRevenue = $saleModel->selectSum('sale_amount')
                                  ->where('DATE(created_at)', $todayDate)
                                  ->where('transaction_status', 'completed')
                                  ->first();
        $data['todayRevenue'] = $todayRevenue['sale_amount'] ?? 0;
        
        // Get recent sales for the table
        $data['recentSales'] = $saleModel->select('sales.*, customers.customer_name')
                                         ->join('customers', 'customers.customer_id = sales.customer_id')
                                         ->orderBy('sales.created_at', 'DESC')
                                         ->limit(5)
                                         ->find();
        
        // Get low stock products with category info
        $data['lowStockProducts'] = $productModel->select('products.*, product_categories.product_category_name')
                                                ->join('product_categories', 'product_categories.product_category_id = products.product_category_id')
                                                ->where('products.product_stock <', 10)
                                                ->where('products.product_status', 'active')
                                                ->orderBy('products.product_stock', 'ASC')
                                                ->limit(5)
                                                ->find();
        
        // Get recent customers
        $data['recentCustomers'] = $customerModel->where('customer_status', 'active')
                                                ->orderBy('created_at', 'DESC')
                                                ->limit(2)
                                                ->find();
        
        return view('staff/staff_dashboard', $data);
    }
}