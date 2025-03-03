<?php

namespace App\Controllers;

use App\Models\PurchaseModel;
use App\Models\PurchaseDetailModel;
use App\Models\ProductModel;
use App\Models\SupplierModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class AjaxController extends Controller
{
    /**
     * Mengambil data transaksi pembelian berdasarkan periode
     */
    public function getPurchaseTransactions()
    {
        if (!session()->get('logged_in') || session()->get('user_role') != 'admin') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized access'
            ]);
        }
        
        $period = $this->request->getGet('period');
        
        // Inisialisasi model yang dibutuhkan
        $purchaseModel = new PurchaseModel();
        $userModel = new UserModel();
        $supplierModel = new SupplierModel();
        $purchaseDetailModel = new PurchaseDetailModel();
        $productModel = new ProductModel();
        
        // Tentukan filter berdasarkan periode
        switch ($period) {
            case 'today':
                $purchaseModel->where('DATE(created_at)', date('Y-m-d'));
                break;
                
            case 'week':
                $startOfWeek = date('Y-m-d', strtotime('monday this week'));
                $endOfWeek = date('Y-m-d', strtotime('sunday this week'));
                $purchaseModel->where('created_at >=', $startOfWeek . ' 00:00:00')
                             ->where('created_at <=', $endOfWeek . ' 23:59:59');
                break;
                
            case 'month':
                $purchaseModel->where('MONTH(created_at)', date('m'))
                             ->where('YEAR(created_at)', date('Y'));
                break;
                
            case 'year':
                $purchaseModel->where('YEAR(created_at)', date('Y'));
                break;
                
            default:
                // Default: this month
                $purchaseModel->where('MONTH(created_at)', date('m'))
                             ->where('YEAR(created_at)', date('Y'));
        }
        
        // Ambil data pembelian
        $purchases = $purchaseModel->orderBy('created_at', 'DESC')->findAll(10); // Limit 10 terakhir
        
        $result = [];
        
        foreach ($purchases as $purchase) {
            // Ambil data user (buyer)
            $user = $userModel->find($purchase['user_id']);
            $buyer = $user ? $user['user_fullname'] : 'Unknown';
            
            // Ambil data supplier
            $supplier = $supplierModel->find($purchase['supplier_id']);
            $supplierName = $supplier ? $supplier['supplier_name'] : 'Unknown';
            $contactPhone = $supplier ? $supplier['supplier_phone'] : 'No Phone';
            
            // Ambil detail produk
            $purchaseDetails = $purchaseDetailModel->where('purchase_id', $purchase['purchase_id'])->findAll();
            $products = [];
            
            foreach ($purchaseDetails as $detail) {
                $product = $productModel->find($detail['product_id']);
                if ($product) {
                    $totalUnits = $detail['box_bought'] * $detail['unit_per_box'];
                    $products[] = $totalUnits . ' ' . $product['product_name'];
                }
            }
            
            $productText = empty($products) ? '-' : implode(', ', $products);
            
            // Format data untuk response
            $result[] = [
                'date' => date('d/m/Y H:i', strtotime($purchase['created_at'])),
                'buyer' => $buyer,
                'supplier' => $supplierName,
                'contact' => $contactPhone,
                'products' => $productText,
                'amount' => number_format($purchase['purchase_amount'], 0, ',', '.') . " IDR",
                'note' => $purchase['purchase_notes']
            ];
        }
        
        return $this->response->setJSON([
            'success' => true,
            'data' => $result
        ]);
    }
}