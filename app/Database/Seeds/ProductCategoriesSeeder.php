<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductCategoriesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Kategori Makanan
            [
                'product_category_id'   => 'CAT' . str_pad('1', 6, '0', STR_PAD_LEFT),
                'product_category_name' => 'Makanan Ringan',
                'created_at'            => date('Y-m-d H:i:s'),
            ],
            [
                'product_category_id'   => 'CAT' . str_pad('2', 6, '0', STR_PAD_LEFT),
                'product_category_name' => 'Makanan Instan',
                'created_at'            => date('Y-m-d H:i:s'),
            ],
            [
                'product_category_id'   => 'CAT' . str_pad('3', 6, '0', STR_PAD_LEFT),
                'product_category_name' => 'Makanan Beku',
                'created_at'            => date('Y-m-d H:i:s'),
            ],
            
            // Kategori Minuman
            [
                'product_category_id'   => 'CAT' . str_pad('4', 6, '0', STR_PAD_LEFT),
                'product_category_name' => 'Minuman Soda',
                'created_at'            => date('Y-m-d H:i:s'),
            ],
            [
                'product_category_id'   => 'CAT' . str_pad('5', 6, '0', STR_PAD_LEFT),
                'product_category_name' => 'Minuman Teh',
                'created_at'            => date('Y-m-d H:i:s'),
            ],
            [
                'product_category_id'   => 'CAT' . str_pad('6', 6, '0', STR_PAD_LEFT),
                'product_category_name' => 'Minuman Jus',
                'created_at'            => date('Y-m-d H:i:s'),
            ]
        ];

        // Menyisipkan data ke dalam tabel product_categories
        $this->db->table('product_categories')->insertBatch($data);
    }
}
