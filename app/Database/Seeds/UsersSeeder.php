<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // 2 Admin
            [
                'user_id'       => 'USR' . str_pad('1', 6, '0', STR_PAD_LEFT),
                'user_name'     => 'ahmad',
                'user_password' => password_hash('ahmad', PASSWORD_DEFAULT),
                'user_role'     => 'admin',
                'user_fullname' => 'Ahmad Firdaus',
                'user_phone'    => '081234567890',
                'user_photo'    => 'default_admin.png',
                'user_status'   => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'user_id'       => 'USR' . str_pad('2', 6, '0', STR_PAD_LEFT),
                'user_name'     => 'budi',
                'user_password' => password_hash('budi', PASSWORD_DEFAULT),
                'user_role'     => 'admin',
                'user_fullname' => 'Budi Santoso',
                'user_phone'    => '081234567891',
                'user_photo'    => 'default_admin.png',
                'user_status'   => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            
            // 8 Staff
            [
                'user_id'       => 'USR' . str_pad('3', 6, '0', STR_PAD_LEFT),
                'user_name'     => 'citra',
                'user_password' => password_hash('citra', PASSWORD_DEFAULT),
                'user_role'     => 'staff',
                'user_fullname' => 'Citra Dewi',
                'user_phone'    => '082345678901',
                'user_photo'    => 'default_staff.png',
                'user_status'   => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'user_id'       => 'USR' . str_pad('4', 6, '0', STR_PAD_LEFT),
                'user_name'     => 'deni',
                'user_password' => password_hash('deni', PASSWORD_DEFAULT),
                'user_role'     => 'staff',
                'user_fullname' => 'Deni Kurniawan',
                'user_phone'    => '082345678902',
                'user_photo'    => 'default_staff.png',
                'user_status'   => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'user_id'       => 'USR' . str_pad('5', 6, '0', STR_PAD_LEFT),
                'user_name'     => 'eka',
                'user_password' => password_hash('eka', PASSWORD_DEFAULT),
                'user_role'     => 'staff',
                'user_fullname' => 'Eka Putri',
                'user_phone'    => '082345678903',
                'user_photo'    => 'default_staff.png',
                'user_status'   => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'user_id'       => 'USR' . str_pad('6', 6, '0', STR_PAD_LEFT),
                'user_name'     => 'fandi',
                'user_password' => password_hash('fandi', PASSWORD_DEFAULT),
                'user_role'     => 'staff',
                'user_fullname' => 'Fandi Ahmad',
                'user_phone'    => '082345678904',
                'user_photo'    => 'default_staff.png',
                'user_status'   => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'user_id'       => 'USR' . str_pad('7', 6, '0', STR_PAD_LEFT),
                'user_name'     => 'gita',
                'user_password' => password_hash('gita', PASSWORD_DEFAULT),
                'user_role'     => 'staff',
                'user_fullname' => 'Gita Safitri',
                'user_phone'    => '082345678905',
                'user_photo'    => 'default_staff.png',
                'user_status'   => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'user_id'       => 'USR' . str_pad('8', 6, '0', STR_PAD_LEFT),
                'user_name'     => 'hadi',
                'user_password' => password_hash('hadi', PASSWORD_DEFAULT),
                'user_role'     => 'staff',
                'user_fullname' => 'Hadi Prasetyo',
                'user_phone'    => '082345678906',
                'user_photo'    => 'default_staff.png',
                'user_status'   => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'user_id'       => 'USR' . str_pad('9', 6, '0', STR_PAD_LEFT),
                'user_name'     => 'indah',
                'user_password' => password_hash('indah', PASSWORD_DEFAULT),
                'user_role'     => 'staff',
                'user_fullname' => 'Indah Permata',
                'user_phone'    => '082345678907',
                'user_photo'    => 'default_staff.png',
                'user_status'   => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'user_id'       => 'USR' . str_pad('10', 6, '0', STR_PAD_LEFT),
                'user_name'     => 'joko',
                'user_password' => password_hash('joko', PASSWORD_DEFAULT),
                'user_role'     => 'staff',
                'user_fullname' => 'Joko Widodo',
                'user_phone'    => '082345678908',
                'user_photo'    => 'default_staff.png',
                'user_status'   => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}