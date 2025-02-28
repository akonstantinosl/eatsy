<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Makanan Ringan
            [
                'product_id'        => 'PDT' . str_pad('1', 6, '0', STR_PAD_LEFT),
                'product_name'      => 'Chitato 80g',  
                'purchase_price'    => 8000,
                'selling_price'     => 10000,
                'product_stock'     => 150,
                'product_category_id'=> 'CAT000001', 
                'product_status'    => 'active',
                'supplier_id'       => 'SUP000001',
                'created_at'        => date('Y-m-d H:i:s'),
            ],
            [
                'product_id'        => 'PDT' . str_pad('2', 6, '0', STR_PAD_LEFT),
                'product_name'      => 'Taro 75g',  
                'purchase_price'    => 5000,
                'selling_price'     => 7000,
                'product_stock'     => 100,
                'product_category_id'=> 'CAT000001',
                'product_status'    => 'active',
                'supplier_id'       => 'SUP000002',
                'created_at'        => date('Y-m-d H:i:s'),
            ],
            
            // Makanan Instan
            [
                'product_id'        => 'PDT' . str_pad('3', 6, '0', STR_PAD_LEFT),
                'product_name'      => 'Indomie Goreng 75g',  
                'purchase_price'    => 3000,
                'selling_price'     => 3500,
                'product_stock'     => 200,
                'product_category_id'=> 'CAT000002',  
                'product_status'    => 'active',
                'supplier_id'       => 'SUP000003',
                'created_at'        => date('Y-m-d H:i:s'),
            ],
            [
                'product_id'        => 'PDT' . str_pad('4', 6, '0', STR_PAD_LEFT),
                'product_name'      => 'Mie Goreng ABC 80g',  
                'purchase_price'    => 2500,
                'selling_price'     => 3000,
                'product_stock'     => 150,
                'product_category_id'=> 'CAT000002',  
                'product_status'    => 'active',
                'supplier_id'       => 'SUP000004',
                'created_at'        => date('Y-m-d H:i:s'),
            ],

            // Makanan Beku
            [
                'product_id'        => 'PDT' . str_pad('5', 6, '0', STR_PAD_LEFT),
                'product_name'      => 'Ayam Fillet 1kg',  
                'purchase_price'    => 35000,
                'selling_price'     => 40000,
                'product_stock'     => 50,
                'product_category_id'=> 'CAT000003',  
                'product_status'    => 'active',
                'supplier_id'       => 'SUP000001',
                'created_at'        => date('Y-m-d H:i:s'),
            ],
            [
                'product_id'        => 'PDT' . str_pad('6', 6, '0', STR_PAD_LEFT),
                'product_name'      => 'Daging Sapi 500g',  
                'purchase_price'    => 60000,
                'selling_price'     => 70000,
                'product_stock'     => 30,
                'product_category_id'=> 'CAT000003',  
                'product_status'    => 'active',
                'supplier_id'       => 'SUP000002',
                'created_at'        => date('Y-m-d H:i:s'),
            ],
            
            // Minuman Soda
            [
                'product_id'        => 'PDT' . str_pad('7', 6, '0', STR_PAD_LEFT),
                'product_name'      => 'Coca-Cola 330ml',  
                'purchase_price'    => 6000,
                'selling_price'     => 7500,
                'product_stock'     => 250,
                'product_category_id'=> 'CAT000004',  
                'product_status'    => 'active',
                'supplier_id'       => 'SUP000003',
                'created_at'        => date('Y-m-d H:i:s'),
            ],
            [
                'product_id'        => 'PDT' . str_pad('8', 6, '0', STR_PAD_LEFT),
                'product_name'      => 'Pepsi 330ml',  
                'purchase_price'    => 6000,
                'selling_price'     => 7500,
                'product_stock'     => 200,
                'product_category_id'=> 'CAT000004',  
                'product_status'    => 'active',
                'supplier_id'       => 'SUP000004',
                'created_at'        => date('Y-m-d H:i:s'),
            ],

            // Minuman Teh
            [
                'product_id'        => 'PDT' . str_pad('9', 6, '0', STR_PAD_LEFT),
                'product_name'      => 'Teh Botol Sosro 300ml',  
                'purchase_price'    => 4000,
                'selling_price'     => 5000,
                'product_stock'     => 300,
                'product_category_id'=> 'CAT000005',  
                'product_status'    => 'active',
                'supplier_id'       => 'SUP000003',
                'created_at'        => date('Y-m-d H:i:s'),
            ],
            [
                'product_id'        => 'PDT' . str_pad('10', 6, '0', STR_PAD_LEFT),
                'product_name'      => 'Teh Gelas 250ml',  
                'purchase_price'    => 3000,
                'selling_price'     => 4000,
                'product_stock'     => 250,
                'product_category_id'=> 'CAT000005', 
                'product_status'    => 'active',
                'supplier_id'       => 'SUP000003',
                'created_at'        => date('Y-m-d H:i:s'),
            ],
            
            // Minuman Jus
            [
                'product_id'        => 'PDT' . str_pad('11', 6, '0', STR_PAD_LEFT),
                'product_name'      => 'Jus Jeruk 300ml',  
                'purchase_price'    => 8000,
                'selling_price'     => 10000,
                'product_stock'     => 100,
                'product_category_id'=> 'CAT000006',  
                'product_status'    => 'active',
                'supplier_id'       => 'SUP000004',
                'created_at'        => date('Y-m-d H:i:s'),
            ],
            [
                'product_id'        => 'PDT' . str_pad('12', 6, '0', STR_PAD_LEFT),
                'product_name'      => 'Jus Apel 250ml',  
                'purchase_price'    => 7000,
                'selling_price'     => 9000,
                'product_stock'     => 120,
                'product_category_id'=> 'CAT000006', 
                'product_status'    => 'active',
                'supplier_id'       => 'SUP000004',
                'created_at'        => date('Y-m-d H:i:s'),
            ]
        ];

        $this->db->table('products')->insertBatch($data);
    }
}
