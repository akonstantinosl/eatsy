<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PurchasesSeeder extends Seeder
{
    public function run()
    {
        // Insert data untuk tabel 'purchases'
        $purchaseData = [
            [
                'purchase_id'     => 'PUR' . str_pad('1', 6, '0', STR_PAD_LEFT),
                'supplier_id'     => 'SUP' . str_pad('1', 6, '0', STR_PAD_LEFT),
                'user_id'         => 'USR' . str_pad('1', 6, '0', STR_PAD_LEFT),
                'purchase_date'   => date('Y-m-d H:i:s'),
                'purchase_amount' => 0, // Initial purchase amount is 0
                'purchase_contact'=> 'phone',
                'order_status'    => 'pending',
                'purchase_status' => 'continue',
                'purchase_notes'  => 'Urgent order for project X',
                'created_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_id'     => 'PUR' . str_pad('2', 6, '0', STR_PAD_LEFT),
                'supplier_id'     => 'SUP' . str_pad('2', 6, '0', STR_PAD_LEFT),
                'user_id'         => 'USR' . str_pad('1', 6, '0', STR_PAD_LEFT),
                'purchase_date'   => date('Y-m-d H:i:s'),
                'purchase_amount' => 0, // Initial purchase amount is 0
                'purchase_contact'=> 'email',
                'order_status'    => 'ordered',
                'purchase_status' => 'continue',
                'purchase_notes'  => 'Follow-up on previous order',
                'created_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_id'     => 'PUR' . str_pad('3', 6, '0', STR_PAD_LEFT),
                'supplier_id'     => 'SUP' . str_pad('3', 6, '0', STR_PAD_LEFT),
                'user_id'         => 'USR' . str_pad('1', 6, '0', STR_PAD_LEFT),
                'purchase_date'   => date('Y-m-d H:i:s'),
                'purchase_amount' => 0, // Initial purchase amount is 0
                'purchase_contact'=> 'email',
                'order_status'    => 'pending',
                'purchase_status' => 'continue',
                'purchase_notes'  => 'Waiting for approval',
                'created_at'      => date('Y-m-d H:i:s'),
            ],
        ];

        // Menambahkan data ke tabel 'purchases'
        $this->db->table('purchases')->insertBatch($purchaseData);
    }
}
