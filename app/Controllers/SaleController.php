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
        
        // Get entries per page (default to 10 if not set)
        $perPage = (int)($this->request->getGet('entries') ?? 10);
        
        // Validate perPage to only be 10, 25, or 50
        if (!in_array($perPage, [10, 25, 50])) {
            $perPage = 10;
        }
        
        // Get status filter (if any)
        $statusFilter = $this->request->getGet('status');
        
        // Get search term (if any)
        $search = $this->request->getGet('search');
        
        // Get sort field and direction
        $sortField = $this->request->getGet('sort') ?? 'updated_at';
        $sortDir = $this->request->getGet('dir') ?? 'desc';
        
        // Define allowed sort fields
        $allowedSortFields = [
            'updated_at', 'created_at', 'user_fullname', 'customer_name', 
            'customer_phone', 'sale_amount', 'payment_method', 
            'transaction_status'
        ];
        
        // Validate sort field
        if (!in_array($sortField, $allowedSortFields)) {
            $sortField = 'updated_at';
        }
        
        // Validate sort direction
        if (!in_array($sortDir, ['asc', 'desc'])) {
            $sortDir = 'desc';
        }
        
        // Base query
        $query = $saleModel;
        
        // Apply status filter if set
        if ($statusFilter && in_array($statusFilter, ['pending', 'processing', 'completed', 'cancelled'])) {
            $query = $query->where('transaction_status', $statusFilter);
        }
        
        // Always join tables for searching and sorting
        $query = $query->join('users', 'sales.user_id = users.user_id')
                    ->join('customers', 'sales.customer_id = customers.customer_id')
                    ->select('sales.*, users.user_fullname, customers.customer_name, customers.customer_phone');
        
        // Apply search if set
        if ($search) {
            $query = $query->groupStart()
                        ->like('users.user_fullname', $search) // User search
                        ->orLike('customers.customer_name', $search) // Customer search
                        ->orLike('customers.customer_phone', $search) // Contact search
                    ->groupEnd();
        }
        
        // Get total count based on filters
        $totalSales = $query->countAllResults(false);
        
        // Add sorting based on selected field
        switch ($sortField) {
            case 'user_fullname':
                $query = $query->orderBy('users.user_fullname', $sortDir);
                break;
            case 'customer_name':
                $query = $query->orderBy('customers.customer_name', $sortDir);
                break;
            case 'customer_phone':
                $query = $query->orderBy('customers.customer_phone', $sortDir);
                break;
            case 'sale_amount':
                $query = $query->orderBy('sales.sale_amount', $sortDir);
                break;
            case 'payment_method':
                $query = $query->orderBy('sales.payment_method', $sortDir);
                break;
            case 'transaction_status':
                $query = $query->orderBy('sales.transaction_status', $sortDir);
                break;
            case 'created_at':
                $query = $query->orderBy('sales.created_at', $sortDir);
                break;
            default:
                $query = $query->orderBy('sales.updated_at', $sortDir);
                break;
        }
        
        // Get paginated sales based on filters
        $sales = $query->limit($perPage, ($page - 1) * $perPage)
                    ->findAll();
        
        // Initialize current time for comparison
        $currentTime = new \DateTime();
        
        // Prepare arrays to hold IDs of new and updated sales
        $newSaleIds = [];
        $updatedSaleIds = [];
        
        // Loop through all sales to check timestamps
        foreach ($sales as $sale) {
            $updatedAt = new \DateTime($sale['updated_at']);
            $interval = $currentTime->diff($updatedAt);
            
            // Convert interval to minutes
            $minutesDiff = $interval->days * 24 * 60 + $interval->h * 60 + $interval->i;
            
            // If the sale was updated in the last 5 minutes
            if ($minutesDiff <= 5) {
                if ($sale['transaction_status'] === 'pending') {
                    // Mark as new sale
                    $newSaleIds[] = $sale['sale_id'];
                } else if (in_array($sale['transaction_status'], ['cancelled', 'processing', 'completed'])) {
                    // Mark as updated sale
                    $updatedSaleIds[] = $sale['sale_id'];
                }
            }
        }
        
        // Create pager links
        $pager->setPath('sales');
        
        // Pass data to the view
        return view('sales/sales_index', [
            'sales' => $sales,
            'pager' => $pager,
            'currentPage' => $page,
            'perPage' => $perPage,
            'total' => $totalSales,
            'statusFilter' => $statusFilter,
            'search' => $search,
            'sortField' => $sortField,
            'sortDir' => $sortDir,
            'newSaleIds' => $newSaleIds,
            'updatedSaleIds' => $updatedSaleIds
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

        // Get user name based on user_id
        $user = $userModel->find($data['sale']['user_id']);
        $data['sale']['user_name'] = $user ? $user['user_fullname'] : 'Unknown User';

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

        // Get current timestamp for both created_at and updated_at
        $currentTimestamp = date('Y-m-d H:i:s');

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
            'created_at' => $currentTimestamp,
            'updated_at' => $currentTimestamp // Explicitly set updated_at for new transactions
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
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp // Use the same timestamp
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
        $saleModel->update($saleId, [
            'sale_amount' => $totalAmount,
            'updated_at' => $currentTimestamp // Ensure updated_at is consistent
        ]);

        // Commit the transaction
        $db->transComplete();

        // Check if transaction was successful
        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Failed to add sale.');
        }

        // Store success message in flash data
        session()->setFlashdata('success', "Sale successfully added with ID: {$saleId}");

        // Redirect to sale details page instead of index
        return redirect()->to("/sales/details/{$saleId}");
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
        
        // Generate the current timestamp
        $currentTimestamp = date('Y-m-d H:i:s');
        
        // Update the sale status and updated_at timestamp
        $updateData = [
            'transaction_status' => $newStatus,
            'updated_at' => $currentTimestamp // Always update timestamp when status changes
        ];
        
        // If cancellation has notes, add them to the sale_notes
        if ($newStatus === 'cancelled' && $this->request->getGet('cancel_notes')) {
            $cancelNotes = "CANCELLATION: " . $this->request->getGet('cancel_notes');
            if (!empty($sale['sale_notes'])) {
                $updateData['sale_notes'] = $sale['sale_notes'] . "\n\n" . $cancelNotes;
            } else {
                $updateData['sale_notes'] = $cancelNotes;
            }
        }
        
        $db->table('sales')
        ->where('sale_id', $saleId)
        ->update($updateData);
        
        // If status is completed, update product stock
        if ($newStatus === 'completed') {
            $this->updateProductStock($saleId, $currentTimestamp);
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
    
    private function updateProductStock($saleId, $timestamp = null)
    {
        $saleDetailModel = new SaleDetailModel();
        $productModel = new ProductModel();
        
        // If no timestamp is provided, use current time
        if ($timestamp === null) {
            $timestamp = date('Y-m-d H:i:s');
        }
        
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
            
            // Update the product stock with the timestamp
            $productModel->update($detail['product_id'], [
                'product_stock' => $newStock,
                'updated_at' => $timestamp
            ]);
            
            // Also update the sale detail record with the same timestamp
            $saleDetailModel->update($detail['sale_detail_id'], [
                'updated_at' => $timestamp
            ]);
        }
        
        // Log the stock update activity
        log_message('info', "Product stock updated for sale ID: {$saleId}");
    }
}