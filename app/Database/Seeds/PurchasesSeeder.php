<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PurchasesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'purchase_id'     => 'PUR' . str_pad('1', 6, '0', STR_PAD_LEFT),
                'supplier_id'     => 'SUP000001',
                'user_id'         => 'USR000001',
                'purchase_date'   => date('Y-m-d H:i:s'),
                'purchase_amount' => 150000,
                'order_status'    => 'ordered',
                'purchase_status' => 'continue',
                'purchase_notes'  => 'Pesanan untuk stok baru',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s')
            ],
            [
                'purchase_id'     => 'PUR' . str_pad('2', 6, '0', STR_PAD_LEFT),
                'supplier_id'     => 'SUP000004',
                'user_id'         => 'USR000001',
                'purchase_date'   => date('Y-m-d H:i:s'),
                'purchase_amount' => 80000,
                'order_status'    => 'pending',
                'purchase_status' => 'continue',
                'purchase_notes'  => 'Pembelian rutin',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('purchases')->insertBatch($data);
    }
}
