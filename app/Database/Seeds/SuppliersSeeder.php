<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SuppliersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'supplier_id'     => 'SUP' . str_pad('1', 6, '0', STR_PAD_LEFT),  
                'supplier_name'   => 'PT Sumber Makmur Sejahtera',  
                'supplier_phone'  => '02123456789',
                'supplier_address'=> 'Jl. Raya Kebon Jeruk No. 45, Jakarta Barat',
                'supplier_status' => 'active',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'supplier_id'     => 'SUP' . str_pad('2', 6, '0', STR_PAD_LEFT),  
                'supplier_name'   => 'CV Mitra Abadi',  
                'supplier_phone'  => '02198765432',
                'supplier_address'=> 'Jl. Pahlawan No. 10, Jakarta Timur',
                'supplier_status' => 'active',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'supplier_id'     => 'SUP' . str_pad('3', 6, '0', STR_PAD_LEFT),  
                'supplier_name'   => 'PT Indah Raya Persada',  
                'supplier_phone'  => '08123450001',
                'supplier_address'=> 'Jl. Sudirman No. 20, Bandung',
                'supplier_status' => 'active',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'supplier_id'     => 'SUP' . str_pad('4', 6, '0', STR_PAD_LEFT),  
                'supplier_name'   => 'PT Agro Maju Lestari',  
                'supplier_phone'  => '08987654321',
                'supplier_address'=> 'Jl. Agung No. 8, Surabaya',
                'supplier_status' => 'active',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'supplier_id'     => 'SUP' . str_pad('5', 6, '0', STR_PAD_LEFT),  
                'supplier_name'   => 'PT Sentosa Jaya',  
                'supplier_phone'  => '02157891234',
                'supplier_address'=> 'Jl. Gatot Subroto Km 5, Tangerang',
                'supplier_status' => 'active',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'supplier_id'     => 'SUP' . str_pad('6', 6, '0', STR_PAD_LEFT),  
                'supplier_name'   => 'CV Berkah Utama',  
                'supplier_phone'  => '08567891234',
                'supplier_address'=> 'Jl. Ahmad Yani No. 123, Semarang',
                'supplier_status' => 'inactive',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'supplier_id'     => 'SUP' . str_pad('7', 6, '0', STR_PAD_LEFT),  
                'supplier_name'   => 'PT Sukses Mandiri',  
                'supplier_phone'  => '02198761234',
                'supplier_address'=> 'Jl. Diponegoro No. 56, Yogyakarta',
                'supplier_status' => 'active',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'supplier_id'     => 'SUP' . str_pad('8', 6, '0', STR_PAD_LEFT),  
                'supplier_name'   => 'PT Karya Bersama',  
                'supplier_phone'  => '08123456789',
                'supplier_address'=> 'Jl. Pemuda No. 78, Malang',
                'supplier_status' => 'active',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'supplier_id'     => 'SUP' . str_pad('9', 6, '0', STR_PAD_LEFT),  
                'supplier_name'   => 'CV Maju Jaya',  
                'supplier_phone'  => '02134567890',
                'supplier_address'=> 'Jl. Veteran No. 45, Medan',
                'supplier_status' => 'inactive',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'supplier_id'     => 'SUP' . str_pad('10', 6, '0', STR_PAD_LEFT),  
                'supplier_name'   => 'PT Global Distribusi Indonesia',  
                'supplier_phone'  => '08765432100',
                'supplier_address'=> 'Jl. Thamrin No. 88, Makassar',
                'supplier_status' => 'active',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('suppliers')->insertBatch($data);
    }
}