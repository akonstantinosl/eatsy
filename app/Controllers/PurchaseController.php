<?php

namespace App\Controllers;

use App\Models\PurchaseModel;
use App\Models\PurchaseDetailModel;
use App\Models\ProductModel;
use App\Models\SupplierModel;
use App\Models\UserModel; 
use CodeIgniter\Controller;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchaseModel = new PurchaseModel();
        $userModel = new UserModel();
        $supplierModel = new SupplierModel();

        // Set pagination configuration
        $pager = \Config\Services::pager();
        
        // Get current page from the request, default to 1 if not set
        $page = $this->request->getGet('page') ?? 1;
        
        // Get entries per page (default to 10 if not set)
        $perPage = (int)($this->request->getGet('entries') ?? 10);
        
        // Validate perPage to only be 10, 25, 50, or 100
        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }
        
        // Get status filter (if any)
        $statusFilter = $this->request->getGet('status');
        
        // Get search term (if any)
        $search = $this->request->getGet('search');
        
        // Get sort field and direction
        $sortField = $this->request->getGet('sort') ?? 'updated_at';
        $sortDir = $this->request->getGet('dir') ?? 'desc';
        
        // Validate sort field to prevent SQL injection
        $validSortFields = [
            'updated_at',
            'created_at',
            'user_fullname',
            'supplier_name',
            'supplier_phone',
            'purchase_amount',
            'order_status'
        ];
        
        if (!in_array($sortField, $validSortFields)) {
            $sortField = 'updated_at';
        }
        
        // Validate sort direction
        if (!in_array($sortDir, ['asc', 'desc'])) {
            $sortDir = 'desc';
        }
        
        // Base query
        $query = $purchaseModel;
        
        // Apply status filter if set
        if ($statusFilter && in_array($statusFilter, ['pending', 'ordered', 'completed', 'cancelled'])) {
            $query = $query->where('order_status', $statusFilter);
        }
        
        // Always join tables for searching and sorting
        $query = $query->join('users', 'purchases.user_id = users.user_id')
        ->join('suppliers', 'purchases.supplier_id = suppliers.supplier_id')
        ->select('purchases.*, users.user_fullname, suppliers.supplier_name, suppliers.supplier_phone');
        
        // Apply search filter if set
        if ($search) {
            $query = $query->groupStart()
                          ->like('users.user_fullname', $search) // Buyer search
                          ->orLike('suppliers.supplier_name', $search) // Supplier search
                          ->orLike('suppliers.supplier_phone', $search) // Contact search
                          ->groupEnd();
        }
        
        // Get total count based on filters
        $totalPurchases = $query->countAllResults(false);
        
        // Add sorting based on selected field
        switch ($sortField) {
            case 'user_fullname':
                $query = $query->orderBy('users.user_fullname', $sortDir);
                break;
            case 'supplier_name':
                $query = $query->orderBy('suppliers.supplier_name', $sortDir);
                break;
            case 'supplier_phone':
                $query = $query->orderBy('suppliers.supplier_phone', $sortDir);
                break;
            case 'purchase_amount':
                $query = $query->orderBy('purchases.purchase_amount', $sortDir);
                break;
            case 'order_status':
                $query = $query->orderBy('purchases.order_status', $sortDir);
                break;
            case 'created_at':
                $query = $query->orderBy('purchases.created_at', $sortDir);
                break;
            default:
                $query = $query->orderBy('purchases.updated_at', $sortDir);
                break;
        }
        
        // Get paginated purchases based on filters
        $purchases = $query->limit($perPage, ($page - 1) * $perPage)
                    ->findAll();

        // Get user and supplier information for each purchase
        foreach ($purchases as &$purchase) {
            // Get buyer name based on user_id (already joined but keep just in case)
            $user = $userModel->find($purchase['user_id']);
            $purchase['user_fullname'] = $user ? $user['user_fullname'] : 'Unknown';

            // Get supplier name and phone based on supplier_id (already joined but keep just in case)
            $supplier = $supplierModel->find($purchase['supplier_id']);
            $purchase['supplier_name'] = $supplier ? $supplier['supplier_name'] : 'Unknown';
            $purchase['supplier_phone'] = $supplier ? $supplier['supplier_phone'] : 'No Phone';
        }

        // Create pager links
        $pager->setPath('admin/purchases');
        
        // Get newly created or updated purchase IDs from flash data
        $newPurchaseId = session()->getFlashdata('new_purchase_id');
        $updatedPurchaseId = session()->getFlashdata('updated_purchase_id');
        
        // Pass data to the view
        return view('admin/purchases/purchases_index', [
            'purchases' => $purchases,
            'pager' => $pager,
            'currentPage' => $page,
            'perPage' => $perPage,
            'total' => $totalPurchases,
            'statusFilter' => $statusFilter,
            'search' => $search,
            'sortField' => $sortField,
            'sortDir' => $sortDir,
            'newPurchaseId' => $newPurchaseId,
            'updatedPurchaseId' => $updatedPurchaseId
        ]);
    }

    public function details($purchaseId)
    {
        $purchaseModel = new PurchaseModel();
        $purchaseDetailModel = new PurchaseDetailModel();
        $userModel = new UserModel();
        $supplierModel = new SupplierModel();
        $productModel = new ProductModel();

        // Mendapatkan data purchase berdasarkan ID
        $data['purchase'] = $purchaseModel->find($purchaseId);

        // Jika data purchase tidak ditemukan, redirect dengan pesan error
        if (!$data['purchase']) {
            return redirect()->to('/admin/purchases')->with('error', 'Purchase not found.');
        }

        // Mendapatkan nama pembeli (buyer) berdasarkan user_id
        $user = $userModel->find($data['purchase']['user_id']);
        $data['purchase']['buyer_name'] = $user ? $user['user_fullname'] : 'Unknown Buyer';

        // Mendapatkan nama supplier berdasarkan supplier_id
        $supplier = $supplierModel->find($data['purchase']['supplier_id']);
        $data['purchase']['supplier_name'] = $supplier ? $supplier['supplier_name'] : 'Unknown';
        $data['purchase']['supplier_phone'] = $supplier ? $supplier['supplier_phone'] : 'Unknown';

        // Mendapatkan detail pembelian berdasarkan purchase_id
        $data['purchase_details'] = $purchaseDetailModel->where('purchase_id', $purchaseId)->findAll();

        // Menambahkan nama produk ke dalam setiap detail pembelian
        foreach ($data['purchase_details'] as &$detail) {
            // Mendapatkan data produk berdasarkan product_id
            $product = $productModel->find($detail['product_id']);
            // Menambahkan nama produk ke dalam data detail pembelian
            $detail['product_name'] = $product ? $product['product_name'] : 'Unknown Product';
        }

        // Menampilkan view dengan data purchase dan detailnya
        return view('admin/purchases/purchases_details', $data);
    }

    public function selectSupplier()
    {
        $supplierModel = new SupplierModel();
        
        $data['suppliers'] = $supplierModel->where('supplier_status', 'active')->findAll();
        
        return view('admin/purchases/select_supplier', $data);
    }

    public function storeSupplier()
    {
        $supplierId = $this->request->getPost('supplier_id');
        session()->set('selected_supplier', $supplierId);

        return redirect()->to("/admin/purchases/products/{$supplierId}");
    }

    public function selectProducts($supplierId)
    {
        $productModel = new ProductModel();
        $supplierModel = new SupplierModel();
    
        // Fetch supplier data
        $data['supplier'] = $supplierModel->find($supplierId);
        if (!$data['supplier']) {
            return redirect()->to('/admin/purchases/supplier')->with('error', 'Supplier not found.');
        }
        
        $data['supplier_id'] = $supplierId;
        $data['products'] = $productModel->where('supplier_id', $supplierId)
                                         ->where('product_status', 'active')
                                         ->findAll();
    
        return view('admin/purchases/select_product', $data);
    }

    public function store()
    {
        // Get the POST data for the purchase
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

        // Generate a unique purchase_id by checking existing ones
        $purchaseModel = new PurchaseModel();
        $purchaseDetailModel = new PurchaseDetailModel();
        $productModel = new ProductModel();

        // Find the last purchase and increment the number for the new purchase
        $lastPurchase = $purchaseModel->orderBy('purchase_id', 'desc')->first();
        $lastPurchaseId = $lastPurchase ? $lastPurchase['purchase_id'] : 'PUR000000';
        $purchaseNumber = (int) substr($lastPurchaseId, 3) + 1;
        $purchaseId = 'PUR' . str_pad($purchaseNumber, 6, '0', STR_PAD_LEFT);

        // Get logged-in user_id from session
        $userId = session()->get('user_id'); // Assuming user_id is stored in the session

        // Get current timestamp for created_at and updated_at
        $currentTimestamp = date('Y-m-d H:i:s');
        
        // Use the timestamp from the form if available
        if (!empty($postData['updated_at'])) {
            $currentTimestamp = $postData['updated_at'];
        }

        // Prepare the purchase data - explicitly set both created_at and updated_at
        $purchaseData = [
            'purchase_id' => $purchaseId,
            'supplier_id' => $postData['supplier_id'],
            'user_id'     => $userId, 
            'purchase_notes' => $postData['purchase_notes'] ?? '',
            'order_status' => 'pending', 
            'purchase_status' => 'continue',
            'purchase_amount' => 0, // Will calculate later
            'created_at' => $currentTimestamp,
            'updated_at' => $currentTimestamp
        ];

        // Start transaction
        $db = \Config\Database::connect();
        $db->transStart();

        // Insert the purchase record - make sure to explicitly allow the timestamp fields
        try {
            $purchaseModel->protect(false); // Disable field protection
            $purchaseModel->insert($purchaseData);
            $purchaseModel->protect(true); // Re-enable field protection
        } catch (\Exception $e) {
            log_message('error', 'Purchase Insert Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error inserting purchase: ' . $e->getMessage());
        }
        
        $totalAmount = 0;
        $purchaseDetails = [];

        // Find the last purchase detail id and increment it
        $lastPurchaseDetail = $purchaseDetailModel->orderBy('purchase_detail_id', 'desc')->first();
        $lastPurchaseDetailId = $lastPurchaseDetail ? $lastPurchaseDetail['purchase_detail_id'] : 'PUD000000';
        $purchaseDetailNumber = (int) substr($lastPurchaseDetailId, 3) + 1;

        // Process each product in the purchase
        foreach ($selectedProducts as $index => $product) {
            // Get product data to store the name
            $productData = $productModel->find($product['product_id']);
            if (!$productData) {
                continue; // Skip if product not found
            }

            // Calculate the total price for each product - FIXED VARIABLE NAMES
            $quantityBought = (int)$product['quantity_bought'];
            $pricePerUnit = (float)$product['price_per_unit'];
            $totalPrice = $quantityBought * $pricePerUnit;

            // Generate unique purchase detail ID
            $purchaseDetailId = 'PUD' . str_pad($purchaseDetailNumber++, 6, '0', STR_PAD_LEFT);

            // Insert the product details into the purchase_details table - UPDATED FIELD NAMES
            try {
                $purchaseDetailModel->protect(false); // Disable field protection
                $purchaseDetailModel->insert([
                    'purchase_detail_id' => $purchaseDetailId,
                    'purchase_id' => $purchaseId,
                    'product_id' => $product['product_id'],
                    'quantity_bought' => $quantityBought,
                    'price_per_unit' => $pricePerUnit,
                    'created_at' => $currentTimestamp,
                    'updated_at' => $currentTimestamp
                ]);
                $purchaseDetailModel->protect(true); // Re-enable field protection
            } catch (\Exception $e) {
                log_message('error', 'Purchase Detail Insert Error: ' . $e->getMessage());
                $db->transRollback();
                return redirect()->back()->with('error', 'Error inserting purchase detail: ' . $e->getMessage());
            }

            // Add to total amount
            $totalAmount += $totalPrice;

            // Add product detail for the view - UPDATED FIELD NAMES
            $purchaseDetails[] = [
                'product_name' => $productData['product_name'],
                'quantity_bought' => $quantityBought,
                'price_per_unit' => $pricePerUnit,
                'total_price' => $totalPrice
            ];
        }

        // Update purchase amount after adding details
        try {
            $purchaseModel->protect(false); // Disable field protection
            $purchaseModel->update($purchaseId, [
                'purchase_amount' => $totalAmount,
                'updated_at' => $currentTimestamp
            ]);
            $purchaseModel->protect(true); // Re-enable field protection
        } catch (\Exception $e) {
            log_message('error', 'Purchase Update Error: ' . $e->getMessage());
            $db->transRollback();
            return redirect()->back()->with('error', 'Error updating purchase amount: ' . $e->getMessage());
        }

        // Commit the transaction
        $db->transComplete();

        // Check if transaction was successful
        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Failed to add purchase.');
        }

        // Store purchase details in session for display
        session()->setFlashdata('purchase_details', $purchaseDetails);
        session()->setFlashdata('success', 'Purchase successfully added with ID: ' . $purchaseId);
        session()->setFlashdata('new_purchase_id', $purchaseId);

        // Redirect to the purchase details page
        return redirect()->to('/admin/purchases/details/' . $purchaseId);
    }

    public function updateStatus($purchaseId, $newStatus)
    {
        // Verify the purchase ID exists
        $purchaseModel = new PurchaseModel();
        $purchase = $purchaseModel->find($purchaseId);
        
        if (!$purchase) {
            return redirect()->to('/admin/purchases')->with('error', 'Purchase not found.');
        }
        
        // Verify the new status is valid
        $validStatuses = ['ordered', 'cancelled', 'completed'];
        if (!in_array($newStatus, $validStatuses)) {
            return redirect()->to('/admin/purchases/details/' . $purchaseId)->with('error', 'Invalid status.');
        }
        
        // Check current status and validate the transition
        $currentStatus = $purchase['order_status'];
        
        // Only allow specific transitions
        if ($currentStatus === 'pending' && in_array($newStatus, ['ordered', 'cancelled'])) {
            // Allow transition from pending to ordered or cancelled
        } else if ($currentStatus === 'ordered' && $newStatus === 'completed') {
            // Allow transition from ordered to completed
        } else {
            return redirect()->to('/admin/purchases/details/' . $purchaseId)
                ->with('error', 'Invalid status transition from ' . $currentStatus . ' to ' . $newStatus);
        }
        
        // Start transaction
        $db = \Config\Database::connect();
        $db->transStart();
        
        // Prepare update data
        $updateData = [
            'order_status' => $newStatus,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // If cancelling, add the cancel notes
        if ($newStatus === 'cancelled') {
            // Check for cancel notes from either POST or GET
            $cancelNotes = $this->request->getPost('cancel_notes');
            if (empty($cancelNotes)) {
                $cancelNotes = $this->request->getGet('cancel_notes');
            }
            
            // If cancel notes provided, append them to existing notes or set them as notes
            if (!empty($cancelNotes)) {
                $existingNotes = $purchase['purchase_notes'] ?? '';
                $updateData['purchase_notes'] = $existingNotes 
                    ? $existingNotes . "\n\n" . $cancelNotes
                    : $cancelNotes;
            }
        }
        
        // Update the purchase status
        $purchaseModel->update($purchaseId, $updateData);
        
        // If status is completed, update product stock and price
        if ($newStatus === 'completed') {
            $this->updateProductStockAndPrice($purchaseId);
        }
        
        // Complete the transaction
        $db->transComplete();
        
        // Check if transaction was successful
        if ($db->transStatus() === false) {
            return redirect()->to('/admin/purchases/details/' . $purchaseId)
                ->with('error', 'Failed to update purchase status.');
        }
        
        // Set flash data for highlighting updated purchase
        session()->setFlashdata('updated_purchase_id', $purchaseId);
        
        return redirect()->to('/admin/purchases/details/' . $purchaseId)
            ->with('success', 'Purchase status updated to ' . ucfirst($newStatus));
    }
    
    private function updateProductStockAndPrice($purchaseId)
    {
        $purchaseDetailModel = new PurchaseDetailModel();
        $productModel = new ProductModel();
        
        // Get all purchase details for this purchase
        $purchaseDetails = $purchaseDetailModel->where('purchase_id', $purchaseId)->findAll();
        
        foreach ($purchaseDetails as $detail) {
            // Get the current product data
            $product = $productModel->find($detail['product_id']);
            
            if (!$product) {
                continue; // Skip if product not found
            }
            
            // Calculate new units to add to stock - UPDATED FIELD NAMES
            $newUnits = $detail['quantity_bought']; 
            
            // Calculate total purchase cost for this item - UPDATED FIELD NAMES
            $purchaseCost = $detail['quantity_bought'] * $detail['price_per_unit'];
            
            // Calculate the new average purchase price
            $currentTotalValue = $product['purchase_price'] * $product['product_stock'];
            $newTotalValue = $currentTotalValue + $purchaseCost;
            $newTotalUnits = $product['product_stock'] + $newUnits;
            
            // Guard against division by zero
            $newAveragePrice = $newTotalUnits > 0 ? $newTotalValue / $newTotalUnits : 0;
            
            // Update the product
            $productModel->update($detail['product_id'], [
                'product_stock' => $newTotalUnits,
                'purchase_price' => $newAveragePrice,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        
        // Log the stock update activity
        log_message('info', "Product stock updated for purchase ID: {$purchaseId}");
    }
}