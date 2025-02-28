<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CustomersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'customer_id'     => 'CUS' . str_pad('1', 6, '0', STR_PAD_LEFT),
                'customer_name'   => 'John Doe',
                'customer_phone'  => '081234567890',
                'customer_address'=> 'Jl. Merdeka No. 10, Jakarta Pusat',
                'customer_status' => 'active',
                'created_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'customer_id'     => 'CUS' . str_pad('2', 6, '0', STR_PAD_LEFT),
                'customer_name'   => 'Jane Smith',
                'customer_phone'  => '082345678901',
                'customer_address'=> 'Jl. Raya No. 5, Jakarta Selatan',
                'customer_status' => 'active',
                'created_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'customer_id'     => 'CUS' . str_pad('3', 6, '0', STR_PAD_LEFT),
                'customer_name'   => 'Robert Brown',
                'customer_phone'  => '085678901234',
                'customer_address'=> 'Jl. Sudirman No. 22, Bandung',
                'customer_status' => 'inactive',
                'created_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'customer_id'     => 'CUS' . str_pad('4', 6, '0', STR_PAD_LEFT),
                'customer_name'   => 'Emily White',
                'customer_phone'  => '089876543210',
                'customer_address'=> 'Jl. Agung No. 12, Surabaya',
                'customer_status' => 'active',
                'created_at'      => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('customers')->insertBatch($data);
    }
}
