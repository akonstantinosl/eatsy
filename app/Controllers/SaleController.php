<?php

namespace App\Controllers;

use App\Models\SaleModel;
use App\Models\SaleDetailModel;
use App\Models\ProductModel;
use App\Models\CustomerModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class SaleController extends Controller
{
    public function index()
    {
        $saleModel = new SaleModel();
        $userModel = new UserModel();
        $customerModel = new CustomerModel();

        // Set pagination configuration
        $pager = \Config\Services::pager();
        
        // Get current page from the request, default to 1 if not set
        $page = $this->request->getGet('page') ?? 1;
        
        // Set items per page
        $perPage = 10;
        
        // Get total count of sales
        $totalSales = $saleModel->countAllResults();
        
        // Get paginated sales
        $sales = $saleModel
               ->orderBy('created_at', 'DESC')
               ->limit($perPage, ($page - 1) * $perPage)
               ->findAll();

        // Get user and customer information for each sale
        foreach ($sales as &$sale) {
            // Get user fullname based on user_id
            $user = $userModel->find($sale['user_id']);
            $sale['user_fullname'] = $user ? $user['user_fullname'] : 'Unknown';

            // Get customer name and phone based on customer_id
            $customer = $customerModel->find($sale['customer_id']);
            $sale['customer_name'] = $customer ? $customer['customer_name'] : 'Unknown';
            $sale['customer_phone'] = $customer ? $customer['customer_phone'] : 'No Phone';
        }

        // Create pager links
        $pager->setPath('sales');
        
        // Pass data to the view
        return view('sales/sales_index', [
            'sales' => $sales,
            'pager' => $pager,
            'currentPage' => $page,
            'perPage' => $perPage,
            'total' => $totalSales
        ]);
    }

    public function details($saleId)
    {
        $saleModel = new SaleModel();
        $saleDetailModel = new SaleDetailModel();
        $userModel = new UserModel();
        $customerModel = new CustomerModel();
        $productModel = new ProductModel();

        // Get sale data by ID
        $data['sale'] = $saleModel->find($saleId);

        // If sale not found, redirect with error message
        if (!$data['sale']) {
            return redirect()->to('/sales')->with('error', 'Sale not found.');
        }

        // Get seller name based on user_id
        $user = $userModel->find($data['sale']['user_id']);
        $data['sale']['seller_name'] = $user ? $user['user_fullname'] : 'Unknown Seller';

        // Get customer information based on customer_id
        $customer = $customerModel->find($data['sale']['customer_id']);
        $data['sale']['customer_name'] = $customer ? $customer['customer_name'] : 'Unknown';
        $data['sale']['customer_phone'] = $customer ? $customer['customer_phone'] : 'Unknown';

        // Get sale details based on sale_id
        $data['sale_details'] = $saleDetailModel->where('sale_id', $saleId)->findAll();

        // Add product name to each sale detail
        foreach ($data['sale_details'] as &$detail) {
            // Get product data based on product_id
            $product = $productModel->find($detail['product_id']);
            // Add product name to sale detail data
            $detail['product_name'] = $product ? $product['product_name'] : 'Unknown Product';
        }

        // Display view with sale and detail data
        return view('sales/sales_details', $data);
    }

    public function selectCustomer()
    {
        $customerModel = new CustomerModel();
        
        $data['customers'] = $customerModel->where('customer_status', 'active')->findAll();
        
        return view('sales/select_customer', $data);
    }

    public function storeCustomer()
    {
        $customerId = $this->request->getPost('customer_id');
        session()->set('selected_customer', $customerId);

        return redirect()->to("/sales/products/{$customerId}");
    }

    public function selectProducts($customerId)
    {
        $productModel = new ProductModel();
        $customerModel = new CustomerModel();
    
        // Fetch customer data
        $data['customer'] = $customerModel->find($customerId);
        if (!$data['customer']) {
            return redirect()->to('/sales/customer')->with('error', 'Customer not found.');
        }
        
        $data['customer_id'] = $customerId;
        $data['products'] = $productModel->where('product_status', 'active')
                                        ->where('product_stock >', 0)
                                        ->findAll();
    
        return view('sales/select_product', $data);
    }    

    public function store()
    {
        // Get the POST data for the sale
        $postData = $this->request->getPost();

        // Ensure 'products' exists and is an array
        if (empty($postData['products']) || !is_array($postData['products'])) {
            return redirect()->back()->with('error', 'Please select at least one product.');
        }

        // Filter out any empty product entries
        $selectedProducts = array_filter($postData['products'], function($product) {
            return !empty($product['product_id']);
        });

        if (empty($selectedProducts)) {
            return redirect()->back()->with('error', 'Please select at least one product.');
        }

        // Generate a unique sale_id by checking existing ones
        $saleModel = new SaleModel();
        $saleDetailModel = new SaleDetailModel();
        $productModel = new ProductModel();

        // Find the last sale and increment the number for the new sale
        $lastSale = $saleModel->orderBy('sale_id', 'desc')->first();
        $lastSaleId = $lastSale ? $lastSale['sale_id'] : 'SAL000000';
        $saleNumber = (int) substr($lastSaleId, 3) + 1;
        $saleId = 'SAL' . str_pad($saleNumber, 6, '0', STR_PAD_LEFT);

        // Get logged-in user_id from session
        $userId = session()->get('user_id'); // Assuming user_id is stored in the session

        // Prepare the sale data
        $saleData = [
            'sale_id' => $saleId,
            'customer_id' => $postData['customer_id'],
            'user_id' => $userId,
            'sale_amount' => 0, // Will calculate later
            'payment_method' => $postData['payment_method'] ?? 'cash',
            'transaction_status' => 'pending', // Default status
            'sale_status' => 'continue',
            'sale_notes' => $postData['sale_notes'] ?? '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Start transaction
        $db = \Config\Database::connect();
        $db->transStart();

        // Save the sale to the sales table
        $saleModel->insert($saleData);
        
        $totalAmount = 0;
        $saleDetails = [];

        // Find the last sale detail id and increment it
        $lastSaleDetail = $saleDetailModel->orderBy('sale_detail_id', 'desc')->first();
        $lastSaleDetailId = $lastSaleDetail ? $lastSaleDetail['sale_detail_id'] : 'SLD000000';
        $saleDetailNumber = (int) substr($lastSaleDetailId, 3) + 1;

        // Process each product in the sale
        foreach ($selectedProducts as $index => $product) {
            // Get product data to store the name and check stock
            $productData = $productModel->find($product['product_id']);
            if (!$productData) {
                continue; // Skip if product not found
            }

            // Check if enough stock is available
            $quantitySold = (int)$product['quantity_sold'];
            if ($quantitySold > $productData['product_stock']) {
                $db->transRollback();
                return redirect()->back()->with('error', "Not enough stock for {$productData['product_name']}. Available: {$productData['product_stock']}");
            }

            // Calculate the total price for each product
            $pricePerUnit = (float)$product['price_per_unit'];
            $totalPrice = $quantitySold * $pricePerUnit;

            // Generate unique sale detail ID
            $saleDetailId = 'SLD' . str_pad($saleDetailNumber++, 6, '0', STR_PAD_LEFT);

            // Insert the product details into the sale_details table
            $saleDetailModel->insert([
                'sale_detail_id' => $saleDetailId,
                'sale_id' => $saleId,
                'product_id' => $product['product_id'],
                'quantity_sold' => $quantitySold,
                'price_per_unit' => $pricePerUnit,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            // Add to total amount
            $totalAmount += $totalPrice;

            // Add product detail for the view
            $saleDetails[] = [
                'product_name' => $productData['product_name'],
                'quantity_sold' => $quantitySold,
                'price_per_unit' => $pricePerUnit,
                'total_price' => $totalPrice
            ];
        }

        // Update sale amount after adding details
        $saleModel->update($saleId, ['sale_amount' => $totalAmount]);

        // Commit the transaction
        $db->transComplete();

        // Check if transaction was successful
        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Failed to add sale.');
        }

        // Store sale details in session for display
        session()->setFlashdata('sale_details', $saleDetails);
        session()->setFlashdata('success', 'Sale successfully added with ID: ' . $saleId);

        return redirect()->to('/sales');
    }

    public function updateStatus($saleId, $newStatus)
    {
        // Verify the sale ID exists
        $saleModel = new SaleModel();
        $sale = $saleModel->find($saleId);
        
        if (!$sale) {
            return redirect()->to('/sales')->with('error', 'Sale not found.');
        }
        
        // Verify the new status is valid
        $validStatuses = ['processing', 'completed', 'cancelled'];
        if (!in_array($newStatus, $validStatuses)) {
            return redirect()->to('/sales/details/' . $saleId)->with('error', 'Invalid status.');
        }
        
        // Check current status and validate the transition
        $currentStatus = $sale['transaction_status'];
        
        // Only allow specific transitions
        if ($currentStatus === 'pending' && in_array($newStatus, ['processing', 'cancelled'])) {
            // Allow transition from pending to processing or cancelled
        } else if ($currentStatus === 'processing' && $newStatus === 'completed') {
            // Allow transition from processing to completed
        } else {
            return redirect()->to('/sales/details/' . $saleId)
                ->with('error', 'Invalid status transition from ' . $currentStatus . ' to ' . $newStatus);
        }
        
        // Start transaction
        $db = \Config\Database::connect();
        $db->transStart();
        
        // Update the sale status
        $saleModel->update($saleId, [
            'transaction_status' => $newStatus,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        
        // If status is completed, update product stock
        if ($newStatus === 'completed') {
            $this->updateProductStock($saleId);
        }
        
        // Complete the transaction
        $db->transComplete();
        
        // Check if transaction was successful
        if ($db->transStatus() === false) {
            return redirect()->to('/sales/details/' . $saleId)
                ->with('error', 'Failed to update sale status.');
        }
        
        return redirect()->to('/sales/details/' . $saleId)
            ->with('success', 'Sale status updated to ' . ucfirst($newStatus));
    }
    
    private function updateProductStock($saleId)
    {
        $saleDetailModel = new SaleDetailModel();
        $productModel = new ProductModel();
        
        // Get all sale details for this sale
        $saleDetails = $saleDetailModel->where('sale_id', $saleId)->findAll();
        
        foreach ($saleDetails as $detail) {
            // Get the current product data
            $product = $productModel->find($detail['product_id']);
            
            if (!$product) {
                continue; // Skip if product not found
            }
            
            // Calculate new stock after sale
            $newStock = $product['product_stock'] - $detail['quantity_sold'];
            
            // Update the product stock
            $productModel->update($detail['product_id'], [
                'product_stock' => $newStock,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        
        // Log the stock update activity
        log_message('info', "Product stock updated for sale ID: {$saleId}");
    }
}