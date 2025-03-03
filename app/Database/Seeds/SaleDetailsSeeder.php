<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SaleDetailsSeeder extends Seeder
{
    public function run()
    {
        $saleDetailData = [
            [
                'sale_detail_id' => 'SLD' . str_pad('1', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000001', 
                'product_id'     => 'PDT000001', 
                'quantity_sold'  => 5,
                'price_per_unit' => 50000,
                'created_at'     => date('Y-m-d H:i:s')
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('2', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000001',  
                'product_id'     => 'PDT000005',  
                'quantity_sold'  => 3,
                'price_per_unit' => 100000,
                'created_at'     => date('Y-m-d H:i:s')
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('3', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000002',
                'product_id'     => 'PDT000008',  
                'quantity_sold'  => 2,
                'price_per_unit' => 75000,
                'created_at'     => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('sale_details')->insertBatch($saleDetailData);

        // Update 'sale_amount' di tabel 'sales' berdasarkan data di tabel 'sale_details'
        $this->db->query("
            UPDATE sales
            SET sale_amount = (
                SELECT SUM(price_per_unit * quantity_sold)
                FROM sale_details
                WHERE sale_details.sale_id = sales.sale_id
            )
        ");
    }
}
