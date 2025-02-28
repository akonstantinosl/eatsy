<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Makanan
            [
                'product_id'        => 'PDT' . str_pad('1', 6, '0', STR_PAD_LEFT),
                'product_name'      => 'Indomie Goreng',  
                'purchase_price'    => 3000,
                'selling_price'     => 3500,
                'product_stock'     => 0,
                'product_category_id'=> 'CAT000001',  // Kategori Makanan
                'product_status'    => 'active',
                'supplier_id'       => 'SUP000001',
                'unit_per_box'      => 30, 
                'box_purchase_price'=> 3000 * 30,
                'box_selling_price' => 3500 * 30 * 0.95,
                'box_bought'        => 10,
                'created_at'        => date('Y-m-d H:i:s'),
            ],
            [
                'product_id'        => 'PDT' . str_pad('2', 6, '0', STR_PAD_LEFT),
                'product_name'      => 'Mie Goreng ABC',  
                'purchase_price'    => 2500,
                'selling_price'     => 3000,
                'product_stock'     => 0,
                'product_category_id'=> 'CAT000001',  // Kategori Makanan
                'product_status'    => 'active',
                'supplier_id'       => 'SUP000002',
                'unit_per_box'      => 30, 
                'box_purchase_price'=> 2500 * 30,
                'box_selling_price' => 3000 * 30 * 0.95,
                'box_bought'        => 8,
                'created_at'        => date('Y-m-d H:i:s'),
            ],
            // Minuman
            [
                'product_id'        => 'PDT' . str_pad('3', 6, '0', STR_PAD_LEFT),
                'product_name'      => 'Teh Botol Sosro',  
                'purchase_price'    => 6500,
                'selling_price'     => 8000,
                'product_stock'     => 0,
                'product_category_id'=> 'CAT000002',  // Kategori Minuman
                'product_status'    => 'active',
                'supplier_id'       => 'SUP000003',
                'unit_per_box'      => 24,
                'box_purchase_price'=> 6500 * 24,
                'box_selling_price' => 8000 * 24 * 0.95,
                'box_bought'        => 15,
                'created_at'        => date('Y-m-d H:i:s'),
            ],
            [
                'product_id'        => 'PDT' . str_pad('4', 6, '0', STR_PAD_LEFT),
                'product_name'      => 'Coca-Cola',  
                'purchase_price'    => 10000,
                'selling_price'     => 12000,
                'product_stock'     => 0,
                'product_category_id'=> 'CAT000002',  // Kategori Minuman
                'product_status'    => 'active',
                'supplier_id'       => 'SUP000004',
                'unit_per_box'      => 24,
                'box_purchase_price'=> 10000 * 24,
                'box_selling_price' => 12000 * 24 * 0.95,
                'box_bought'        => 12,
                'created_at'        => date('Y-m-d H:i:s'),
            ],
            // Sembako
            [
                'product_id'        => 'PDT' . str_pad('5', 6, '0', STR_PAD_LEFT),
                'product_name'      => 'Gula Pasir 1kg ABC',  
                'purchase_price'    => 9500,
                'selling_price'     => 12000,
                'product_stock'     => 0,
                'product_category_id'=> 'CAT000003',  // Kategori Sembako
                'product_status'    => 'active',
                'supplier_id'       => 'SUP000001',
                'unit_per_box'      => 10,
                'box_purchase_price'=> 9500 * 10,
                'box_selling_price' => 12000 * 10 * 0.95,
                'box_bought'        => 5,
                'created_at'        => date('Y-m-d H:i:s'),
            ],
            [
                'product_id'        => 'PDT' . str_pad('6', 6, '0', STR_PAD_LEFT),
                'product_name'      => 'Beras 5kg Super Premium',  
                'purchase_price'    => 45000,
                'selling_price'     => 50000,
                'product_stock'     => 0,
                'product_category_id'=> 'CAT000003',  // Kategori Sembako
                'product_status'    => 'active',
                'supplier_id'       => 'SUP000003',
                'unit_per_box'      => 10,
                'box_purchase_price'=> 45000 * 10,
                'box_selling_price' => 50000 * 10 * 0.95,
                'box_bought'        => 7,
                'created_at'        => date('Y-m-d H:i:s'),
            ],
            // Perawatan Rumah Tangga
            [
                'product_id'        => 'PDT' . str_pad('7', 6, '0', STR_PAD_LEFT),
                'product_name'      => 'Sabun Cuci Piring Sunlight',  
                'purchase_price'    => 4000,
                'selling_price'     => 5000,
                'product_stock'     => 0,
                'product_category_id'=> 'CAT000004',  // Kategori Perawatan Rumah Tangga
                'product_status'    => 'active',
                'supplier_id'       => 'SUP000002',
                'unit_per_box'      => 24,
                'box_purchase_price'=> 4000 * 24,
                'box_selling_price' => 5000 * 24 * 0.95,
                'box_bought'        => 10,
                'created_at'        => date('Y-m-d H:i:s'),
            ],
            // Kesehatan dan Kecantikan
            [
                'product_id'        => 'PDT' . str_pad('8', 6, '0', STR_PAD_LEFT),
                'product_name'      => 'Shampoo Pantene',  
                'purchase_price'    => 20000,
                'selling_price'     => 25000,
                'product_stock'     => 0,
                'product_category_id'=> 'CAT000005',  // Kategori Kesehatan dan Kecantikan
                'product_status'    => 'active',
                'supplier_id'       => 'SUP000004',
                'unit_per_box'      => 12,
                'box_purchase_price'=> 20000 * 12,
                'box_selling_price' => 25000 * 12 * 0.95,
                'box_bought'        => 5,
                'created_at'        => date('Y-m-d H:i:s'),
            ]
        ];

        // Insert data ke tabel products
        $this->db->table('products')->insertBatch($data);

        // Menambahkan stok produk berdasarkan box yang dibeli
        foreach ($data as $product) {
            // Menghitung stok berdasarkan jumlah box yang dibeli dan unit per box
            $new_stock = $product['box_bought'] * $product['unit_per_box'];
            
            // Update stok produk setelah pembelian
            $this->db->table('products')
                ->set('product_stock', 'product_stock + ' . $new_stock, false)
                ->where('product_id', $product['product_id'])
                ->update();
        }
    }
}
