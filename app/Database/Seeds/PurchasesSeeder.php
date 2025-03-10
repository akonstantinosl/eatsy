<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PurchasesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'purchase_id'      => 'PUR' . str_pad('1', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000001',
                'user_id'          => 'USR000001',
                'purchase_amount'  => 0,
                'order_status'     => 'ordered',
                'purchase_status'  => 'continue',
                'purchase_notes'   => 'Pembelian rutin bulanan',
                'created_at'       => '2025-01-05 10:15:30',
                'updated_at'       => '2025-01-05 14:30:00',
            ],
            [
                'purchase_id'      => 'PUR' . str_pad('2', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000002',
                'user_id'          => 'USR000002',
                'purchase_amount'  => 0,
                'order_status'     => 'pending',
                'purchase_status'  => 'continue',
                'purchase_notes'   => 'Restock produk makanan ringan',
                'created_at'       => '2025-01-07 09:20:15',
                'updated_at'       => '2025-01-07 13:45:00',
            ],
            [
                'purchase_id'      => 'PUR' . str_pad('3', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000003',
                'user_id'          => 'USR000001',
                'purchase_amount'  => 0,
                'order_status'     => 'cancelled',
                'purchase_status'  => 'continue',
                'purchase_notes'   => 'Pembelian minuman soda',
                'created_at'       => '2025-01-10 11:30:00',
                'updated_at'       => '2025-01-10 16:00:00',
            ],
            [
                'purchase_id'      => 'PUR' . str_pad('4', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000004',
                'user_id'          => 'USR000001',
                'purchase_amount'  => 0,
                'order_status'     => 'ordered',
                'purchase_status'  => 'continue',
                'purchase_notes'   => 'Restock minuman teh',
                'created_at'       => '2025-01-12 08:45:00',
                'updated_at'       => '2025-01-12 11:30:00',
            ],
            [
                'purchase_id'      => 'PUR' . str_pad('5', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000005',
                'user_id'          => 'USR000002',
                'purchase_amount'  => 0,
                'order_status'     => 'pending',
                'purchase_status'  => 'continue',
                'purchase_notes'   => 'Pembelian makanan beku',
                'created_at'       => '2025-01-15 13:20:00',
                'updated_at'       => '2025-01-15 17:00:00',
            ],
            [
                'purchase_id'      => 'PUR' . str_pad('6', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000006',
                'user_id'          => 'USR000001',
                'purchase_amount'  => 0,
                'order_status'     => 'cancelled',
                'purchase_status'  => 'continue',
                'purchase_notes'   => 'Pembelian makanan instan',
                'created_at'       => '2025-01-18 09:30:00',
                'updated_at'       => '2025-01-18 12:15:00',
            ],
            [
                'purchase_id'      => 'PUR' . str_pad('7', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000007',
                'user_id'          => 'USR000001',
                'purchase_amount'  => 0,
                'order_status'     => 'ordered',
                'purchase_status'  => 'continue',
                'purchase_notes'   => 'Restock minuman jus',
                'created_at'       => '2025-01-20 14:00:00',
                'updated_at'       => '2025-01-20 16:30:00',
            ],
            [
                'purchase_id'      => 'PUR' . str_pad('8', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000008',
                'user_id'          => 'USR000002',
                'purchase_amount'  => 0,
                'order_status'     => 'pending',
                'purchase_status'  => 'continue',
                'purchase_notes'   => 'Pembelian makanan ringan',
                'created_at'       => '2025-01-22 10:45:00',
                'updated_at'       => '2025-01-22 14:00:00',
            ],
            [
                'purchase_id'      => 'PUR' . str_pad('9', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000009',
                'user_id'          => 'USR000001',
                'purchase_amount'  => 0,
                'order_status'     => 'cancelled',
                'purchase_status'  => 'continue',
                'purchase_notes'   => 'Restock produk minuman',
                'created_at'       => '2025-01-25 09:15:00',
                'updated_at'       => '2025-01-25 13:30:00',
            ],
            [
                'purchase_id'      => 'PUR' . str_pad('10', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000010',
                'user_id'          => 'USR000001',
                'purchase_amount'  => 0,
                'order_status'     => 'ordered',
                'purchase_status'  => 'continue',
                'purchase_notes'   => 'Pembelian makanan instan',
                'created_at'       => '2025-01-28 11:00:00',
                'updated_at'       => '2025-01-28 15:45:00',
            ],
            [
                'purchase_id'      => 'PUR' . str_pad('11', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000001',
                'user_id'          => 'USR000002',
                'purchase_amount'  => 0,
                'order_status'     => 'ordered',
                'purchase_status'  => 'continue',
                'purchase_notes'   => 'Pembelian makanan ringan',
                'created_at'       => '2025-02-02 08:30:00',
                'updated_at'       => '2025-02-02 10:15:00',
            ],
            [
                'purchase_id'      => 'PUR' . str_pad('12', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000003',
                'user_id'          => 'USR000001',
                'purchase_amount'  => 0,
                'order_status'     => 'ordered',
                'purchase_status'  => 'continue',
                'purchase_notes'   => 'Restock minuman soda',
                'created_at'       => '2025-02-05 09:45:00',
                'updated_at'       => '2025-02-05 11:30:00',
            ],
            [
                'purchase_id'      => 'PUR' . str_pad('13', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000005',
                'user_id'          => 'USR000001',
                'purchase_amount'  => 0,
                'order_status'     => 'ordered',
                'purchase_status'  => 'continue',
                'purchase_notes'   => 'Pembelian makanan beku',
                'created_at'       => '2025-02-08 13:00:00',
                'updated_at'       => '2025-02-08 14:45:00',
            ],
            [
                'purchase_id'      => 'PUR' . str_pad('14', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000007',
                'user_id'          => 'USR000002',
                'purchase_amount'  => 0,
                'order_status'     => 'ordered',
                'purchase_status'  => 'continue',
                'purchase_notes'   => 'Restock minuman jus',
                'created_at'       => '2025-02-10 10:30:00',
                'updated_at'       => '2025-02-10 12:15:00',
            ],
            [
                'purchase_id'      => 'PUR' . str_pad('15', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000009',
                'user_id'          => 'USR000001',
                'purchase_amount'  => 0,
                'order_status'     => 'ordered',
                'purchase_status'  => 'continue',
                'purchase_notes'   => 'Pembelian minuman teh',
                'created_at'       => '2025-02-12 14:15:00',
                'updated_at'       => '2025-02-12 16:00:00',
            ],
            [
                'purchase_id'      => 'PUR' . str_pad('16', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000002',
                'user_id'          => 'USR000001',
                'purchase_amount'  => 0,
                'order_status'     => 'ordered',
                'purchase_status'  => 'continue',
                'purchase_notes'   => 'Restock makanan ringan',
                'created_at'       => '2025-02-15 09:00:00',
                'updated_at'       => '2025-02-15 10:45:00',
            ],
            [
                'purchase_id'      => 'PUR' . str_pad('17', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000004',
                'user_id'          => 'USR000002',
                'purchase_amount'  => 0,
                'order_status'     => 'ordered',
                'purchase_status'  => 'continue',
                'purchase_notes'   => 'Pembelian makanan instan',
                'created_at'       => '2025-02-18 11:30:00',
                'updated_at'       => '2025-02-18 13:15:00',
            ],
            [
                'purchase_id'      => 'PUR' . str_pad('18', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000006',
                'user_id'          => 'USR000001',
                'purchase_amount'  => 0,
                'order_status'     => 'ordered',
                'purchase_status'  => 'continue',
                'purchase_notes'   => 'Restock minuman soda',
                'created_at'       => '2025-02-20 13:45:00',
                'updated_at'       => '2025-02-20 15:30:00',
            ],
            [
                'purchase_id'      => 'PUR' . str_pad('19', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000008',
                'user_id'          => 'USR000001',
                'purchase_amount'  => 0,
                'order_status'     => 'ordered',
                'purchase_status'  => 'continue',
                'purchase_notes'   => 'Pembelian makanan beku',
                'created_at'       => '2025-02-22 10:15:00',
                'updated_at'       => '2025-02-22 12:00:00',
            ],
            [
                'purchase_id'      => 'PUR' . str_pad('20', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000010',
                'user_id'          => 'USR000002',
                'purchase_amount'  => 0,
                'order_status'     => 'ordered',
                'purchase_status'  => 'continue',
                'purchase_notes'   => 'Restock minuman jus',
                'created_at'       => '2025-02-25 14:30:00',
                'updated_at'       => '2025-02-25 16:15:00',
            ],
            [
                'purchase_id'      => 'PUR' . str_pad('21', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000001',
                'user_id'          => 'USR000001',
                'purchase_amount'  => 0,
                'order_status'     => 'pending',
                'purchase_status'  => 'continue',
                'purchase_notes'   => 'Pembelian makanan ringan',
                'created_at'       => '2025-03-01 09:30:00',
                'updated_at'       => '2025-03-01 09:30:00',
            ],
            [
                'purchase_id'      => 'PUR' . str_pad('22', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000003',
                'user_id'          => 'USR000002',
                'purchase_amount'  => 0,
                'order_status'     => 'pending',
                'purchase_status'  => 'continue',
                'purchase_notes'   => 'Restock minuman soda',
                'created_at'       => '2025-03-02 10:45:00',
                'updated_at'       => '2025-03-02 10:45:00',
            ],
            [
                'purchase_id'      => 'PUR' . str_pad('23', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000005',
                'user_id'          => 'USR000001',
                'purchase_amount'  => 0,
                'order_status'     => 'pending',
                'purchase_status'  => 'continue',
                'purchase_notes'   => 'Pembelian makanan beku',
                'created_at'       => '2025-03-03 13:15:00',
                'updated_at'       => '2025-03-03 13:15:00',
            ],
            [
                'purchase_id'      => 'PUR' . str_pad('24', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000007',
                'user_id'          => 'USR000001',
                'purchase_amount'  => 0,
                'order_status'     => 'pending',
                'purchase_status'  => 'continue',
                'purchase_notes'   => 'Restock minuman jus',
                'created_at'       => '2025-03-03 15:30:00',
                'updated_at'       => '2025-03-03 15:30:00',
            ],
            [
                'purchase_id'      => 'PUR' . str_pad('25', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000009',
                'user_id'          => 'USR000002',
                'purchase_amount'  => 0,
                'order_status'     => 'pending',
                'purchase_status'  => 'continue',
                'purchase_notes'   => 'Pembelian minuman teh',
                'created_at'       => '2025-03-04 08:45:00',
                'updated_at'       => '2025-03-04 08:45:00',
            ],
            
            [
                'purchase_id'      => 'PUR' . str_pad('26', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000002',
                'user_id'          => 'USR000001',
                'purchase_amount'  => 0,
                'order_status'     => 'cancelled',
                'purchase_status'  => 'cancel',
                'purchase_notes'   => 'Dibatalkan: Harga tidak sesuai kesepakatan',
                'created_at'       => '2025-01-08 10:00:00',
                'updated_at'       => '2025-01-08 14:30:00',
            ],
            [
                'purchase_id'      => 'PUR' . str_pad('27', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000004',
                'user_id'          => 'USR000001',
                'purchase_amount'  => 0,
                'order_status'     => 'cancelled',
                'purchase_status'  => 'cancel',
                'purchase_notes'   => 'Dibatalkan: Stok supplier kosong',
                'created_at'       => '2025-01-16 09:15:00',
                'updated_at'       => '2025-01-16 11:45:00',
            ],
            [
                'purchase_id'      => 'PUR' . str_pad('28', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000006',
                'user_id'          => 'USR000002',
                'purchase_amount'  => 0,
                'order_status'     => 'cancelled',
                'purchase_status'  => 'cancel',
                'purchase_notes'   => 'Dibatalkan: Barang tidak sesuai spesifikasi',
                'created_at'       => '2025-01-24 13:30:00',
                'updated_at'       => '2025-01-24 16:00:00',
            ],
            [
                'purchase_id'      => 'PUR' . str_pad('29', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000008',
                'user_id'          => 'USR000001',
                'purchase_amount'  => 0,
                'order_status'     => 'cancelled',
                'purchase_status'  => 'cancel',
                'purchase_notes'   => 'Dibatalkan: Kesalahan input pesanan',
                'created_at'       => '2025-02-06 11:00:00',
                'updated_at'       => '2025-02-06 13:15:00',
            ],
            [
                'purchase_id'      => 'PUR' . str_pad('30', 6, '0', STR_PAD_LEFT),
                'supplier_id'      => 'SUP000010',
                'user_id'          => 'USR000001',
                'purchase_amount'  => 0,
                'order_status'     => 'cancelled',
                'purchase_status'  => 'cancel',
                'purchase_notes'   => 'Dibatalkan: Perubahan rencana pembelian',
                'created_at'       => '2025-02-14 14:45:00',
                'updated_at'       => '2025-02-14 16:30:00',
            ],
        ];

        $this->db->table('purchases')->insertBatch($data);
    }
}