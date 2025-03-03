<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SalesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'sale_id'        => 'SAL' . str_pad('1', 6, '0', STR_PAD_LEFT),
                'customer_id'    => 'CUS000001',
                'user_id'        => 'USR000001',
                'sale_amount'    => 300000,
                'payment_method' => 'cash',
                'transaction_status' => 'pending',
                'sale_status'    => 'continue',
                'sale_notes'     => 'Pembelian pertama oleh customer',
                'created_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'sale_id'        => 'SAL' . str_pad('2', 6, '0', STR_PAD_LEFT),
                'customer_id'    => 'CUS000002',
                'user_id'        => 'USR000001',
                'sale_amount'    => 150000,
                'payment_method' => 'credit_card',
                'transaction_status' => 'processing',
                'sale_status'    => 'continue',
                'sale_notes'     => 'Pembelian menggunakan kartu kredit',
                'created_at'     => date('Y-m-d H:i:s'),
            ]
        ];

        $this->db->table('sales')->insertBatch($data);
    }
}
