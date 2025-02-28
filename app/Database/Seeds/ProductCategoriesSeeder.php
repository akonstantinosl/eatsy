<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductCategoriesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'product_category_id'   => 'CAT' . str_pad('1', 6, '0', STR_PAD_LEFT),
                'product_category_name' => 'Makanan',
                'created_at'            => date('Y-m-d H:i:s'),
            ],
            [
                'product_category_id'   => 'CAT' . str_pad('2', 6, '0', STR_PAD_LEFT),
                'product_category_name' => 'Minuman',
                'created_at'            => date('Y-m-d H:i:s'),
            ],
            [
                'product_category_id'   => 'CAT' . str_pad('3', 6, '0', STR_PAD_LEFT),
                'product_category_name' => 'Sembako',
                'created_at'            => date('Y-m-d H:i:s'),
            ],
            [
                'product_category_id'   => 'CAT' . str_pad('4', 6, '0', STR_PAD_LEFT),
                'product_category_name' => 'Perawatan Rumah Tangga',
                'created_at'            => date('Y-m-d H:i:s'),
            ],
            [
                'product_category_id'   => 'CAT' . str_pad('5', 6, '0', STR_PAD_LEFT),
                'product_category_name' => 'Kesehatan dan Kecantikan',
                'created_at'            => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('product_categories')->insertBatch($data);
    }
}
