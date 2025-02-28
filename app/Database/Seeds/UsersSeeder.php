<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id'       => 'USR' . str_pad('1', 6, '0', STR_PAD_LEFT),
                'user_name'     => 'admin',
                'user_password' => password_hash('admin', PASSWORD_DEFAULT),
                'user_role'     => 'admin',
                'user_fullname' => 'Administrator',
                'user_phone'    => '081234567890',
                'user_photo'    => 'default_admin.png',
                'user_status'   => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'user_id'       => 'USR' . str_pad('2', 6, '0', STR_PAD_LEFT),
                'user_name'     => 'reza',
                'user_password' => password_hash('rezatoko', PASSWORD_DEFAULT),
                'user_role'     => 'staff',
                'user_fullname' => 'Reza Toko',
                'user_phone'    => '089876543210',
                'user_photo'    => 'default_staff.png',
                'user_status'   => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}