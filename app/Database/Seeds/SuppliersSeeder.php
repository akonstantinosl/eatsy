<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SuppliersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'supplier_id'    => 'SUP' . str_pad('1', 6, '0', STR_PAD_LEFT),  
                'supplier_name'  => 'PT Sumber Makmur Sejahtera',  
                'supplier_phone' => '02123456789',
                'supplier_address'=> 'Jl. Raya No. 45, Jakarta Barat',
                'supplier_status'=> 'active',
                'created_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'supplier_id'    => 'SUP' . str_pad('2', 6, '0', STR_PAD_LEFT),  
                'supplier_name'  => 'PT Toko Distributor Sejahtera',  
                'supplier_phone' => '02198765432',
                'supplier_address'=> 'Jl. Pahlawan No. 10, Jakarta Timur',
                'supplier_status'=> 'active',
                'created_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'supplier_id'    => 'SUP' . str_pad('3', 6, '0', STR_PAD_LEFT),  
                'supplier_name'  => 'PT Indah Raya',  
                'supplier_phone' => '08123450001',
                'supplier_address'=> 'Jl. Sudirman No. 20, Bandung',
                'supplier_status'=> 'active',
                'created_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'supplier_id'    => 'SUP' . str_pad('4', 6, '0', STR_PAD_LEFT),  
                'supplier_name'  => 'PT Agro Maju Lestari',  
                'supplier_phone' => '08987654321',
                'supplier_address'=> 'Jl. Agung No. 8, Surabaya',
                'supplier_status'=> 'active',
                'created_at'     => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('suppliers')->insertBatch($data);
    }
}
