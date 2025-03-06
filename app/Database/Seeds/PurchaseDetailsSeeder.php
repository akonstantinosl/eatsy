<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PurchaseDetailsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Purchase 1 (3 produk)
            [
                'purchase_detail_id' => 'PUD' . str_pad('1', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000001',
                'product_id'         => 'PDT000001',
                'quantity_bought'    => 200,
                'price_per_unit'     => 8400, 
                'created_at'         => '2025-01-05 10:15:30',
                'updated_at'         => '2025-01-05 14:30:00',
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('2', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000001',
                'product_id'         => 'PDT000002',
                'quantity_bought'    => 192,
                'price_per_unit'     => 5250,
                'created_at'         => '2025-01-05 10:15:30',
                'updated_at'         => '2025-01-05 14:30:00',
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('3', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000001',
                'product_id'         => 'PDT000005',
                'quantity_bought'    => 50,
                'price_per_unit'     => 24500,
                'created_at'         => '2025-01-05 10:15:30',
                'updated_at'         => '2025-01-05 14:30:00',
            ],
            
            // Purchase 2 (2 produk)
            [
                'purchase_detail_id' => 'PUD' . str_pad('4', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000002',
                'product_id'         => 'PDT000002',
                'quantity_bought'    => 288,
                'price_per_unit'     => 5250,
                'created_at'         => '2025-01-07 09:20:15',
                'updated_at'         => '2025-01-07 13:45:00',
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('5', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000002',
                'product_id'         => 'PDT000006',
                'quantity_bought'    => 32,
                'price_per_unit'     => 42000,
                'created_at'         => '2025-01-07 09:20:15',
                'updated_at'         => '2025-01-07 13:45:00',
            ],
            
            // Purchase 3 (3 produk)
            [
                'purchase_detail_id' => 'PUD' . str_pad('6', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000003',
                'product_id'         => 'PDT000007',
                'quantity_bought'    => 360,
                'price_per_unit'     => 4200,
                'created_at'         => '2025-01-10 11:30:00',
                'updated_at'         => '2025-01-10 16:00:00',
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('7', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000003',
                'product_id'         => 'PDT000008',
                'quantity_bought'    => 288,
                'price_per_unit'     => 4200,
                'created_at'         => '2025-01-10 11:30:00',
                'updated_at'         => '2025-01-10 16:00:00',
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('8', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000003',
                'product_id'         => 'PDT000018',
                'quantity_bought'    => 240,
                'price_per_unit'     => 4550,
                'created_at'         => '2025-01-10 11:30:00',
                'updated_at'         => '2025-01-10 16:00:00',
            ],
            
            // Purchase 4 (2 produk)
            [
                'purchase_detail_id' => 'PUD' . str_pad('9', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000004',
                'product_id'         => 'PDT000009',
                'quantity_bought'    => 480,
                'price_per_unit'     => 2800,
                'created_at'         => '2025-01-12 08:45:00',
                'updated_at'         => '2025-01-12 11:30:00',
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('10', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000004',
                'product_id'         => 'PDT000010',
                'quantity_bought'    => 750,
                'price_per_unit'     => 2100,
                'created_at'         => '2025-01-12 08:45:00',
                'updated_at'         => '2025-01-12 11:30:00',
            ],
            
            // Purchase 5 (2 produk)
            [
                'purchase_detail_id' => 'PUD' . str_pad('11', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000005',
                'product_id'         => 'PDT000013',
                'quantity_bought'    => 80,
                'price_per_unit'     => 17500,
                'created_at'         => '2025-01-15 13:20:00',
                'updated_at'         => '2025-01-15 17:00:00',
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('12', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000005',
                'product_id'         => 'PDT000014',
                'quantity_bought'    => 60,
                'price_per_unit'     => 14000,
                'created_at'         => '2025-01-15 13:20:00',
                'updated_at'         => '2025-01-15 17:00:00',
            ],
            
            // Purchase 6 (3 produk)
            [
                'purchase_detail_id' => 'PUD' . str_pad('13', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000006',
                'product_id'         => 'PDT000003',
                'quantity_bought'    => 600,
                'price_per_unit'     => 5250,
                'created_at'         => '2025-01-18 09:30:00',
                'updated_at'         => '2025-01-18 12:15:00',
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('14', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000006',
                'product_id'         => 'PDT000006',
                'quantity_bought'    => 240,
                'price_per_unit'     => 2100,
                'created_at'         => '2025-01-18 09:30:00',
                'updated_at'         => '2025-01-18 12:15:00',
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('15', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000006',
                'product_id'         => 'PDT000008',
                'quantity_bought'    => 192,
                'price_per_unit'     => 4200,
                'created_at'         => '2025-01-18 09:30:00',
                'updated_at'         => '2025-01-18 12:15:00',
            ],
            
            // Purchase 7 (2 produk)
            [
                'purchase_detail_id' => 'PUD' . str_pad('16', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000007',
                'product_id'         => 'PDT000026',
                'quantity_bought'    => 240,
                'price_per_unit'     => 4900,
                'created_at'         => '2025-01-20 14:00:00',
                'updated_at'         => '2025-01-20 16:30:00',
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('17', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000007',
                'product_id'         => 'PDT000029',
                'quantity_bought'    => 288,
                'price_per_unit'     => 3500,
                'created_at'         => '2025-01-20 14:00:00',
                'updated_at'         => '2025-01-20 16:30:00',
            ],
            
            // Purchase 8 (3 produk)
            [
                'purchase_detail_id' => 'PUD' . str_pad('18', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000008',
                'product_id'         => 'PDT000001',
                'quantity_bought'    => 160,
                'price_per_unit'     => 8400,
                'created_at'         => '2025-01-22 10:45:00',
                'updated_at'         => '2025-01-22 14:00:00',
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('19', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000008',
                'product_id'         => 'PDT000003',
                'quantity_bought'    => 240,
                'price_per_unit'     => 5250,
                'created_at'         => '2025-01-22 10:45:00',
                'updated_at'         => '2025-01-22 14:00:00',
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('20', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000008',
                'product_id'         => 'PDT000004',
                'quantity_bought'    => 288,
                'price_per_unit'     => 4200,
                'created_at'         => '2025-01-22 10:45:00',
                'updated_at'         => '2025-01-22 14:00:00',
            ],
            
            // Purchase 9 (2 produk)
            [
                'purchase_detail_id' => 'PUD' . str_pad('21', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000009',
                'product_id'         => 'PDT000021',
                'quantity_bought'    => 360,
                'price_per_unit'     => 2800,
                'created_at'         => '2025-01-25 09:15:00',
                'updated_at'         => '2025-01-25 13:30:00',
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('22', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000009',
                'product_id'         => 'PDT000023',
                'quantity_bought'    => 288,
                'price_per_unit'     => 2800,
                'created_at'         => '2025-01-25 09:15:00',
                'updated_at'         => '2025-01-25 13:30:00',
            ],
            
            // Purchase 10 (2 produk)
            [
                'purchase_detail_id' => 'PUD' . str_pad('23', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000010',
                'product_id'         => 'PDT000006',
                'quantity_bought'    => 40,
                'price_per_unit'     => 42000,
                'created_at'         => '2025-01-28 11:00:00',
                'updated_at'         => '2025-01-28 15:45:00',
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('24', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000010',
                'product_id'         => 'PDT000008',
                'quantity_bought'    => 240,
                'price_per_unit'     => 4200,
                'created_at'         => '2025-01-28 11:00:00',
                'updated_at'         => '2025-01-28 15:45:00',
            ],
            
            // Purchase 11 (2 produk) - Ordered
            [
                'purchase_detail_id' => 'PUD' . str_pad('25', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000011',
                'product_id'         => 'PDT000001',
                'quantity_bought'    => 240,
                'price_per_unit'     => 8400,
                'created_at'         => '2025-02-02 08:30:00',
                'updated_at'         => '2025-02-02 10:15:00',
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('26', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000011',
                'product_id'         => 'PDT000005',
                'quantity_bought'    => 60,
                'price_per_unit'     => 24500,
                'created_at'         => '2025-02-02 08:30:00',
                'updated_at'         => '2025-02-02 10:15:00',
            ],
            
            // Purchase 12 (2 produk) - Ordered
            [
                'purchase_detail_id' => 'PUD' . str_pad('27', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000012',
                'product_id'         => 'PDT000007',
                'quantity_bought'    => 432,
                'price_per_unit'     => 4200,
                'created_at'         => '2025-02-05 09:45:00',
                'updated_at'         => '2025-02-05 11:30:00',
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('28', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000012',
                'product_id'         => 'PDT000019',
                'quantity_bought'    => 360,
                'price_per_unit'     => 4550,
                'created_at'         => '2025-02-05 09:45:00',
                'updated_at'         => '2025-02-05 11:30:00',
            ],
            
            // Purchase 13 (2 produk) - Ordered
            [
                'purchase_detail_id' => 'PUD' . str_pad('29', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000013',
                'product_id'         => 'PDT000011',
                'quantity_bought'    => 70,
                'price_per_unit'     => 24500,
                'created_at'         => '2025-02-08 13:00:00',
                'updated_at'         => '2025-02-08 14:45:00',
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('30', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000013',
                'product_id'         => 'PDT000015',
                'quantity_bought'    => 80,
                'price_per_unit'     => 12600,
                'created_at'         => '2025-02-08 13:00:00',
                'updated_at'         => '2025-02-08 14:45:00',
            ],
            
            // Purchase 14 (2 produk) - Ordered
            [
                'purchase_detail_id' => 'PUD' . str_pad('31', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000014',
                'product_id'         => 'PDT000026',
                'quantity_bought'    => 288,
                'price_per_unit'     => 4900,
                'created_at'         => '2025-02-10 10:30:00',
                'updated_at'         => '2025-02-10 12:15:00',
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('32', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000014',
                'product_id'         => 'PDT000030',
                'quantity_bought'    => 240,
                'price_per_unit'     => 4900,
                'created_at'         => '2025-02-10 10:30:00',
                'updated_at'         => '2025-02-10 12:15:00',
            ],
            
            // Purchase 15 (2 produk) - Ordered
            [
                'purchase_detail_id' => 'PUD' . str_pad('33', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000015',
                'product_id'         => 'PDT000021',
                'quantity_bought'    => 480,
                'price_per_unit'     => 2800,
                'created_at'         => '2025-02-12 14:15:00',
                'updated_at'         => '2025-02-12 16:00:00',
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('34', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000015',
                'product_id'         => 'PDT000025',
                'quantity_bought'    => 360,
                'price_per_unit'     => 3150,
                'created_at'         => '2025-02-12 14:15:00',
                'updated_at'         => '2025-02-12 16:00:00',
            ],
            
            // Purchase 16 (2 produk) - Ordered
            [
                'purchase_detail_id' => 'PUD' . str_pad('35', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000016',
                'product_id'         => 'PDT000002',
                'quantity_bought'    => 360,
                'price_per_unit'     => 5250,
                'created_at'         => '2025-02-15 09:00:00',
                'updated_at'         => '2025-02-15 10:45:00',
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('36', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000016',
                'product_id'         => 'PDT000004',
                'quantity_bought'    => 288,
                'price_per_unit'     => 4200,
                'created_at'         => '2025-02-15 09:00:00',
                'updated_at'         => '2025-02-15 10:45:00',
            ],
            
            // Purchase 17 (2 produk) - Ordered
            [
                'purchase_detail_id' => 'PUD' . str_pad('37', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000017',
                'product_id'         => 'PDT000003',
                'quantity_bought'    => 720,
                'price_per_unit'     => 5250,
                'created_at'         => '2025-02-18 11:30:00',
                'updated_at'         => '2025-02-18 13:15:00',
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('38', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000017',
                'product_id'         => 'PDT000006',
                'quantity_bought'    => 288,
                'price_per_unit'     => 2100,
                'created_at'         => '2025-02-18 11:30:00',
                'updated_at'         => '2025-02-18 13:15:00',
            ],
            
            // Purchase 18 (2 produk) - Ordered
            [
                'purchase_detail_id' => 'PUD' . str_pad('39', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000018',
                'product_id'         => 'PDT000016',
                'quantity_bought'    => 480,
                'price_per_unit'     => 4200,
                'created_at'         => '2025-02-20 13:45:00',
                'updated_at'         => '2025-02-20 15:30:00',
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('40', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000018',
                'product_id'         => 'PDT000018',
                'quantity_bought'    => 432,
                'price_per_unit'     => 4550,
                'created_at'         => '2025-02-20 13:45:00',
                'updated_at'         => '2025-02-20 15:30:00',
            ],
            
            // Purchase 19 (2 produk) - Ordered
            [
                'purchase_detail_id' => 'PUD' . str_pad('41', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000019',
                'product_id'         => 'PDT000013',
                'quantity_bought'    => 100,
                'price_per_unit'     => 17500,
                'created_at'         => '2025-02-22 10:15:00',
                'updated_at'         => '2025-02-22 12:00:00',
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('42', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000019',
                'product_id'         => 'PDT000014',
                'quantity_bought'    => 80,
                'price_per_unit'     => 14000,
                'created_at'         => '2025-02-22 10:15:00',
                'updated_at'         => '2025-02-22 12:00:00',
            ],
            
            // Purchase 20 (2 produk) - Ordered
            [
                'purchase_detail_id' => 'PUD' . str_pad('43', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000020',
                'product_id'         => 'PDT000027',
                'quantity_bought'    => 360,
                'price_per_unit'     => 5250,
                'created_at'         => '2025-02-25 14:30:00',
                'updated_at'         => '2025-02-25 16:15:00',
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('44', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000020',
                'product_id'         => 'PDT000028',
                'quantity_bought'    => 288,
                'price_per_unit'     => 4550,
                'created_at'         => '2025-02-25 14:30:00',
                'updated_at'         => '2025-02-25 16:15:00',
            ],
            
            // Purchase 21 (2 produk) - Pending
            [
                'purchase_detail_id' => 'PUD' . str_pad('45', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000021',
                'product_id'         => 'PDT000001',
                'quantity_bought'    => 300,
                'price_per_unit'     => 8400,
                'created_at'         => '2025-03-01 09:30:00',
                'updated_at'         => '2025-03-01 09:30:00',
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('46', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000021',
                'product_id'         => 'PDT000004',
                'quantity_bought'    => 288,
                'price_per_unit'     => 4200,
                'created_at'         => '2025-03-01 09:30:00',
                'updated_at'         => '2025-03-01 09:30:00',
            ],
            
            // Purchase 22 (2 produk) - Pending
            [
                'purchase_detail_id' => 'PUD' . str_pad('47', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000022',
                'product_id'         => 'PDT000007',
                'quantity_bought'    => 480,
                'price_per_unit'     => 4200,
                'created_at'         => '2025-03-02 10:45:00',
                'updated_at'         => '2025-03-02 10:45:00',
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('48', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000022',
                'product_id'         => 'PDT000020',
                'quantity_bought'    => 360,
                'price_per_unit'     => 4900,
                'created_at'         => '2025-03-02 10:45:00',
                'updated_at'         => '2025-03-02 10:45:00',
            ],
            
            // Purchase 23 (2 produk) - Pending
            [
                'purchase_detail_id' => 'PUD' . str_pad('49', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000023',
                'product_id'         => 'PDT000011',
                'quantity_bought'    => 80,
                'price_per_unit'     => 24500,
                'created_at'         => '2025-03-03 13:15:00',
                'updated_at'         => '2025-03-03 13:15:00',
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('50', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000023',
                'product_id'         => 'PDT000013',
                'quantity_bought'    => 100,
                'price_per_unit'     => 17500,
                'created_at'         => '2025-03-03 13:15:00',
                'updated_at'         => '2025-03-03 13:15:00',
            ],
            
            // Purchase 24 (2 produk) - Pending
            [
                'purchase_detail_id' => 'PUD' . str_pad('51', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000024',
                'product_id'         => 'PDT000026',
                'quantity_bought'    => 360,
                'price_per_unit'     => 4900,
                'created_at'         => '2025-03-03 15:30:00',
                'updated_at'         => '2025-03-03 15:30:00',
            ],
            [                'purchase_detail_id' => 'PUD' . str_pad('52', 6, '0', STR_PAD_LEFT),
            'purchase_id'        => 'PUR000024',
            'product_id'         => 'PDT000028',
            'quantity_bought'    => 288,
            'price_per_unit'     => 4550,
            'created_at'         => '2025-03-03 15:30:00',
            'updated_at'         => '2025-03-03 15:30:00',
        ],
        
        // Purchase 25 (2 produk) - Pending
        [
            'purchase_detail_id' => 'PUD' . str_pad('53', 6, '0', STR_PAD_LEFT),
            'purchase_id'        => 'PUR000025',
            'product_id'         => 'PDT000021',
            'quantity_bought'    => 432,
            'price_per_unit'     => 2800,
            'created_at'         => '2025-03-04 08:45:00',
            'updated_at'         => '2025-03-04 08:45:00',
        ],
        [
            'purchase_detail_id' => 'PUD' . str_pad('54', 6, '0', STR_PAD_LEFT),
            'purchase_id'        => 'PUR000025',
            'product_id'         => 'PDT000023',
            'quantity_bought'    => 360,
            'price_per_unit'     => 2800,
            'created_at'         => '2025-03-04 08:45:00',
            'updated_at'         => '2025-03-04 08:45:00',
        ],
        
        // Purchase 26 (2 produk) - Cancelled
        [
            'purchase_detail_id' => 'PUD' . str_pad('55', 6, '0', STR_PAD_LEFT),
            'purchase_id'        => 'PUR000026',
            'product_id'         => 'PDT000002',
            'quantity_bought'    => 240,
            'price_per_unit'     => 5250,
            'created_at'         => '2025-01-08 10:00:00',
            'updated_at'         => '2025-01-08 14:30:00',
        ],
        [
            'purchase_detail_id' => 'PUD' . str_pad('56', 6, '0', STR_PAD_LEFT),
            'purchase_id'        => 'PUR000026',
            'product_id'         => 'PDT000004',
            'quantity_bought'    => 192,
            'price_per_unit'     => 4200,
            'created_at'         => '2025-01-08 10:00:00',
            'updated_at'         => '2025-01-08 14:30:00',
        ],
        
        // Purchase 27 (2 produk) - Cancelled
        [
            'purchase_detail_id' => 'PUD' . str_pad('57', 6, '0', STR_PAD_LEFT),
            'purchase_id'        => 'PUR000027',
            'product_id'         => 'PDT000008',
            'quantity_bought'    => 360,
            'price_per_unit'     => 4200,
            'created_at'         => '2025-01-16 09:15:00',
            'updated_at'         => '2025-01-16 11:45:00',
        ],
        [
            'purchase_detail_id' => 'PUD' . str_pad('58', 6, '0', STR_PAD_LEFT),
            'purchase_id'        => 'PUR000027',
            'product_id'         => 'PDT000009',
            'quantity_bought'    => 288,
            'price_per_unit'     => 2800,
            'created_at'         => '2025-01-16 09:15:00',
            'updated_at'         => '2025-01-16 11:45:00',
        ],
        
        // Purchase 28 (2 produk) - Cancelled
        [
            'purchase_detail_id' => 'PUD' . str_pad('59', 6, '0', STR_PAD_LEFT),
            'purchase_id'        => 'PUR000028',
            'product_id'         => 'PDT000006',
            'quantity_bought'    => 192,
            'price_per_unit'     => 2100,
            'created_at'         => '2025-01-24 13:30:00',
            'updated_at'         => '2025-01-24 16:00:00',
        ],
        [
            'purchase_detail_id' => 'PUD' . str_pad('60', 6, '0', STR_PAD_LEFT),
            'purchase_id'        => 'PUR000028',
            'product_id'         => 'PDT000016',
            'quantity_bought'    => 360,
            'price_per_unit'     => 4200,
            'created_at'         => '2025-01-24 13:30:00',
            'updated_at'         => '2025-01-24 16:00:00',
        ],
        
        // Purchase 29 (2 produk) - Cancelled
        [
            'purchase_detail_id' => 'PUD' . str_pad('61', 6, '0', STR_PAD_LEFT),
            'purchase_id'        => 'PUR000029',
            'product_id'         => 'PDT000014',
            'quantity_bought'    => 60,
            'price_per_unit'     => 14000,
            'created_at'         => '2025-02-06 11:00:00',
            'updated_at'         => '2025-02-06 13:15:00',
        ],
        [
            'purchase_detail_id' => 'PUD' . str_pad('62', 6, '0', STR_PAD_LEFT),
            'purchase_id'        => 'PUR000029',
            'product_id'         => 'PDT000015',
            'quantity_bought'    => 50,
            'price_per_unit'     => 12600,
            'created_at'         => '2025-02-06 11:00:00',
            'updated_at'         => '2025-02-06 13:15:00',
        ],
        
        // Purchase 30 (2 produk) - Cancelled
        [
            'purchase_detail_id' => 'PUD' . str_pad('63', 6, '0', STR_PAD_LEFT),
            'purchase_id'        => 'PUR000030',
            'product_id'         => 'PDT000027',
            'quantity_bought'    => 240,
            'price_per_unit'     => 5250,
            'created_at'         => '2025-02-14 14:45:00',
            'updated_at'         => '2025-02-14 16:30:00',
        ],
        [
            'purchase_detail_id' => 'PUD' . str_pad('64', 6, '0', STR_PAD_LEFT),
            'purchase_id'        => 'PUR000030',
            'product_id'         => 'PDT000030',
            'quantity_bought'    => 192,
            'price_per_unit'     => 4900,
            'created_at'         => '2025-02-14 14:45:00',
            'updated_at'         => '2025-02-14 16:30:00',
        ],
    ];

    $this->db->table('purchase_details')->insertBatch($data);

    // Update 'purchase_amount' di tabel 'purchases' berdasarkan data di tabel 'purchase_details'
    $this->db->query("
        UPDATE purchases
        SET purchase_amount = (
            SELECT SUM(price_per_unit * quantity_bought)
            FROM purchase_details
            WHERE purchase_details.purchase_id = purchases.purchase_id
        )
    ");
}
}