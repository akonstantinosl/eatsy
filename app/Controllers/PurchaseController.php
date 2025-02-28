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
        $supplierModel = new SupplierModel();

        // Mendapatkan semua data purchase dengan informasi supplier
        $data['purchases'] = $purchaseModel->findAll();

        // Mendapatkan nama supplier untuk setiap purchase
        foreach ($data['purchases'] as &$purchase) {
            $supplier = $supplierModel->find($purchase['supplier_id']);
            $purchase['supplier_name'] = $supplier ? $supplier['supplier_name'] : 'Unknown';

            // Tentukan kontak berdasarkan purchase_contact
            if ($purchase['purchase_contact'] === 'phone') {
                $purchase['contact'] = $supplier ? $supplier['supplier_phone'] : 'No Phone';
            } elseif ($purchase['purchase_contact'] === 'email') {
                $purchase['contact'] = $supplier ? $supplier['supplier_email'] : 'No Email';
            } else {
                $purchase['contact'] = 'Unknown Contact';
            }
        }

        // Menampilkan view dengan data pembelian
        return view('admin/purchases/purchases_index', $data);
    }

    public function details($purchaseId)
    {
        $purchaseModel = new PurchaseModel();
        $purchaseDetailModel = new PurchaseDetailModel();
        $productModel = new ProductModel();
        $supplierModel = new SupplierModel(); 

        // Mendapatkan data purchase berdasarkan ID
        $data['purchase'] = $purchaseModel->find($purchaseId);

        // Mendapatkan nama supplier berdasarkan supplier_id
        $supplier = $supplierModel->find($data['purchase']['supplier_id']);
        $data['purchase']['supplier_name'] = $supplier ? $supplier['supplier_name'] : 'Unknown'; 

        // Tentukan kontak berdasarkan purchase_contact
        if ($data['purchase']['purchase_contact'] === 'phone') {
            $data['purchase']['contact'] = $supplier ? $supplier['supplier_phone'] : 'No Phone';
        } elseif ($data['purchase']['purchase_contact'] === 'email') {
            $data['purchase']['contact'] = $supplier ? $supplier['supplier_email'] : 'No Email';
        } else {
            $data['purchase']['contact'] = 'Unknown Contact';
        }

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
        
        return view('admin/purchases/select_suppliers', $data);
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
    
        // Mendapatkan supplier berdasarkan supplierId
        $supplier = $supplierModel->find($supplierId);
    
        // Mengecek apakah supplier ada dan memiliki email, jika tidak, gunakan telepon
        if ($supplier) {
            if (!empty($supplier['supplier_email'])) {
                $contact = $supplier['supplier_email']; 
            } else {
                $contact = $supplier['supplier_phone']; 
            }
        } else {
            $contact = 'No Contact Available';
        }
    
        // Fetch all products associated with the selected supplier
        $data['supplier_id'] = $supplierId;
        $data['products'] = $productModel->where('supplier_id', $supplierId)->findAll();
        $data['contact'] = $contact;  // Menambahkan informasi kontak ke data
    
        return view('admin/purchases/select_products', $data);
    }
    public function storeProducts()
    {
        $purchaseModel = new PurchaseModel();
        $purchaseDetailModel = new PurchaseDetailModel();
        $userModel = new UserModel();  // Declare the user model

        // Retrieve the logged-in user's ID from the session
        $userId = session()->get('user_id');
        
        // Check if user_id exists in the session
        if (!$userId) {
            // Redirect or show an error if no user is logged in
            return redirect()->to('/login')->with('error', 'Please log in to continue.');
        }

        // Retrieve other POST data
        $supplierId = $this->request->getPost('supplier_id');
        $purchaseContact = $this->request->getPost('purchase_contact');
        $purchaseNotes = $this->request->getPost('purchase_notes');
        $products = $this->request->getPost('products');

        // Tentukan status purchase berdasarkan role user
        $user = $userModel->find($userId);
        $purchaseStatus = ($user && $user['user_role'] === 'admin') ? 'ordered' : 'pending';

        // Calculate the total purchase amount and prepare purchase details
        $purchaseAmount = 0;
        $purchaseDetails = [];

        // Generate new purchase_id dynamically
        $lastPurchase = $purchaseModel->orderBy('purchase_id', 'desc')->first(); // Get the last inserted purchase record

        if ($lastPurchase) {
            // Extract the last number from the 'purchase_id' (assuming 'PUR' is a fixed prefix)
            $lastId = substr($lastPurchase['purchase_id'], 3); // Get part after 'PUR'
            $newId = str_pad((int)$lastId + 1, 6, '0', STR_PAD_LEFT);  // Increment and pad to 6 digits
            $purchaseId = 'PUR' . $newId;  // Generate new 'purchase_id'
        } else {
            // If no purchase data exists, start from 'PUR000001'
            $purchaseId = 'PUR000001';
        }

        // Process products and calculate prices
        foreach ($products as $product) {
            $productId = $product['product_id'];
            $purchasePrice = ($product['purchase_type'] === 'box') ? 0 : $product['purchase_price'];
            $quantityUnit = ($product['purchase_type'] === 'box') ? 0 : $product['quantity_unit'];
            $boxPurchasePrice = ($product['purchase_type'] === 'unit') ? 0 : $product['box_purchase_price'];
            $quantityBox = ($product['purchase_type'] === 'unit') ? 0 : $product['quantity_box'];

            $totalPrice = ($purchasePrice * $quantityUnit) + ($boxPurchasePrice * $quantityBox);
            $purchaseAmount += $totalPrice;

            $purchaseDetails[] = [
                'purchase_id' => $purchaseId, // Correct purchase_id is assigned here
                'product_id' => $productId,
                'purchase_type' => $product['purchase_type'],
                'quantity_unit' => $quantityUnit,
                'quantity_box' => $quantityBox,
                'purchase_price' => $purchasePrice,
                'box_purchase_price' => $boxPurchasePrice,
            ];
        }

        // Prepare data for the purchase table
        $purchaseData = [
            'purchase_id' => $purchaseId,  // New unique purchase_id
            'user_id' => $userId,  // Set the logged-in user's ID here
            'supplier_id' => $supplierId,
            'purchase_date' => date('Y-m-d H:i:s'),
            'purchase_amount' => $purchaseAmount,
            'purchase_contact' => $purchaseContact,
            'order_status' => 'pending',
            'purchase_status' => $purchaseStatus,
            'purchase_notes' => $purchaseNotes,
        ];

        // Save purchase data first
        $purchaseModel->save($purchaseData);

        // Insert purchase details after purchase data is inserted
        $purchaseDetailModel->insertBatch($purchaseDetails);

        // Redirect to the purchases page
        return redirect()->to('/admin/purchases');
    }
}
