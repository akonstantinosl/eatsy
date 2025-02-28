<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PurchaseDetailsSeeder extends Seeder
{
    public function run()
    {
        $purchaseDetailData = [
            [
                'purchase_detail_id' => 'PUD' . str_pad('1', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000001', 
                'product_id'         => 'PDT000001', 
                'box_bought'         => 10,
                'unit_per_box'       => 20,
                'price_per_box'      => 8000,
                'created_at'         => date('Y-m-d H:i:s')
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('2', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000001',  
                'product_id'         => 'PDT000005',  
                'box_bought'         => 5,
                'unit_per_box'       => 15,
                'price_per_box'      => 35000,
                'created_at'         => date('Y-m-d H:i:s')
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('3', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000002',
                'product_id'         => 'PDT000008',  
                'box_bought'         => 8,
                'unit_per_box'       => 10,
                'price_per_box'      => 6000,
                'created_at'         => date('Y-m-d H:i:s')
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('4', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000002',
                'product_id'         => 'PDT000011',  
                'box_bought'         => 5,
                'unit_per_box'       => 20,
                'price_per_box'      => 8000,
                'created_at'         => date('Y-m-d H:i:s')
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('5', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000002',
                'product_id'         => 'PDT000012',  
                'box_bought'         => 7,
                'unit_per_box'       => 30,
                'price_per_box'      => 7000,
                'created_at'         => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('purchase_details')->insertBatch($purchaseDetailData);

        // Update 'purchase_amount' di tabel 'purchases' berdasarkan data di tabel 'purchase_details'
        $this->db->query("
            UPDATE purchases
            SET purchase_amount = (
                SELECT SUM(price_per_box * box_bought)
                FROM purchase_details
                WHERE purchase_details.purchase_id = purchases.purchase_id
            )
        ");
    }
}
