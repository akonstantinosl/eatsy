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
                'user_name'     => 'adminahmad',
                'user_password' => password_hash('Ahm@d#2025Secure!', PASSWORD_DEFAULT),
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
                'user_name'     => 'adminbudi',
                'user_password' => password_hash('Bud1_S@ntoso#2025!', PASSWORD_DEFAULT),
                'user_role'     => 'admin',
                'user_fullname' => 'Budi Santoso',
                'user_phone'    => '081234567891',
                'user_photo'    => 'default_admin.png',
                'user_status'   => 'inactive',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            
            // 8 Staff
            [
                'user_id'       => 'USR' . str_pad('3', 6, '0', STR_PAD_LEFT),
                'user_name'     => 'staffcitra',
                'user_password' => password_hash('C1tr@Dew1#2025$', PASSWORD_DEFAULT),
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
                'user_name'     => 'staffdeni',
                'user_password' => password_hash('Den1_Kurn1@wan#2025!', PASSWORD_DEFAULT),
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
                'user_name'     => 'staffeka',
                'user_password' => password_hash('Ek@Putr1#2025$', PASSWORD_DEFAULT),
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
                'user_name'     => 'stafffandi',
                'user_password' => password_hash('F@nd1_Ahmad#2025!', PASSWORD_DEFAULT),
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
                'user_name'     => 'staffratna',
                'user_password' => password_hash('R@tn4_Sari#2025!', PASSWORD_DEFAULT),
                'user_role'     => 'staff',
                'user_fullname' => 'Ratna Sari',
                'user_phone'    => '082345678905',
                'user_photo'    => 'default_staff.png',
                'user_status'   => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'user_id'       => 'USR' . str_pad('8', 6, '0', STR_PAD_LEFT),
                'user_name'     => 'staffhadi',
                'user_password' => password_hash('H@d1_Pr@s3tyo#2025!', PASSWORD_DEFAULT),
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
                'user_name'     => 'staffindah',
                'user_password' => password_hash('1nd@h_P3rm@ta#2025!', PASSWORD_DEFAULT),
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
                'user_name'     => 'staffrendi',
                'user_password' => password_hash('R3nd1_Purn@ma#2025!', PASSWORD_DEFAULT),
                'user_role'     => 'staff',
                'user_fullname' => 'Rendi Purnama',
                'user_phone'    => '082345678908',
                'user_photo'    => 'default_staff.png',
                'user_status'   => 'inactive',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}