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

        // Mendapatkan semua data purchase
        $data['purchases'] = $purchaseModel->findAll();

        // Mendapatkan nama supplier, nama user dan kontak (supplier_phone) untuk setiap purchase
        foreach ($data['purchases'] as &$purchase) {
            // Ambil nama user berdasarkan user_id
            $user = $userModel->find($purchase['user_id']);
            $purchase['user_fullname'] = $user ? $user['user_fullname'] : 'Unknown';

            // Ambil nama supplier berdasarkan supplier_id
            $supplier = $supplierModel->find($purchase['supplier_id']);
            $purchase['supplier_name'] = $supplier ? $supplier['supplier_name'] : 'Unknown';
            $purchase['supplier_phone'] = $supplier ? $supplier['supplier_phone'] : 'No Phone';
        }

        // Menampilkan view dengan data pembelian
        return view('admin/purchases/purchases_index', $data);
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
        
        // Fetch all products associated with the selected supplier
        $data['supplier_id'] = $supplierId;
        $data['products'] = $productModel->where('supplier_id', $supplierId)->findAll();
    
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

        // Prepare the purchase data
        $purchaseData = [
            'purchase_id' => $purchaseId,
            'supplier_id' => $postData['supplier_id'],
            'user_id'     => $userId, // Get the user_id from the session
            'purchase_notes' => $postData['purchase_notes'] ?? '',
            'order_status' => 'pending', // Default status
            'purchase_status' => 'continue',
            'purchase_amount' => 0, // Will calculate later
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Start transaction
        $db = \Config\Database::connect();
        $db->transStart();

        // Save the purchase to the purchases table
        $purchaseModel->insert($purchaseData);
        
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

            // Calculate the total price for each product
            $boxBought = (int)$product['box_bought'];
            $pricePerBox = (float)$product['price_per_box'];
            $totalPrice = $boxBought * $pricePerBox;

            // Generate unique purchase detail ID
            $purchaseDetailId = 'PUD' . str_pad($purchaseDetailNumber++, 6, '0', STR_PAD_LEFT);

            // Insert the product details into the purchase_details table
            $purchaseDetailModel->insert([
                'purchase_detail_id' => $purchaseDetailId,
                'purchase_id' => $purchaseId,
                'product_id' => $product['product_id'],
                'box_bought' => $boxBought,
                'unit_per_box' => $product['unit_per_box'],
                'price_per_box' => $pricePerBox,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            // Add to total amount
            $totalAmount += $totalPrice;

            // Add product detail for the view
            $purchaseDetails[] = [
                'product_name' => $productData['product_name'],
                'box_bought' => $boxBought,
                'unit_per_box' => $product['unit_per_box'],
                'price_per_box' => $pricePerBox,
                'total_price' => $totalPrice
            ];
        }

        // Update purchase amount after adding details
        $purchaseModel->update($purchaseId, ['purchase_amount' => $totalAmount]);

        // Commit the transaction
        $db->transComplete();

        // Check if transaction was successful
        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Failed to add purchase.');
        }

        // Store purchase details in session for display
        session()->setFlashdata('purchase_details', $purchaseDetails);
        session()->setFlashdata('success', 'Purchase successfully added with ID: ' . $purchaseId);

        return redirect()->to('/admin/purchases');
    }
}