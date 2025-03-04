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
                'box_bought'         => 10,
                'unit_per_box'       => 20,
                'price_per_box'      => 8000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('2', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000001',
                'product_id'         => 'PDT000002',
                'box_bought'         => 8,
                'unit_per_box'       => 24,
                'price_per_box'      => 5000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('3', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000001',
                'product_id'         => 'PDT000005',
                'box_bought'         => 5,
                'unit_per_box'       => 10,
                'price_per_box'      => 35000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            
            // Purchase 2 (2 produk)
            [
                'purchase_detail_id' => 'PUD' . str_pad('4', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000002',
                'product_id'         => 'PDT000002',
                'box_bought'         => 12,
                'unit_per_box'       => 24,
                'price_per_box'      => 5000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('5', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000002',
                'product_id'         => 'PDT000006',
                'box_bought'         => 4,
                'unit_per_box'       => 8,
                'price_per_box'      => 60000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            
            // Purchase 3 (3 produk)
            [
                'purchase_detail_id' => 'PUD' . str_pad('6', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000003',
                'product_id'         => 'PDT000007',
                'box_bought'         => 15,
                'unit_per_box'       => 24,
                'price_per_box'      => 6000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('7', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000003',
                'product_id'         => 'PDT000008',
                'box_bought'         => 12,
                'unit_per_box'       => 24,
                'price_per_box'      => 6000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('8', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000003',
                'product_id'         => 'PDT000018',
                'box_bought'         => 10,
                'unit_per_box'       => 24,
                'price_per_box'      => 6500,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            
            // Purchase 4 (2 produk)
            [
                'purchase_detail_id' => 'PUD' . str_pad('9', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000004',
                'product_id'         => 'PDT000009',
                'box_bought'         => 20,
                'unit_per_box'       => 24,
                'price_per_box'      => 4000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('10', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000004',
                'product_id'         => 'PDT000010',
                'box_bought'         => 25,
                'unit_per_box'       => 30,
                'price_per_box'      => 3000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            
            // Purchase 5 (2 produk)
            [
                'purchase_detail_id' => 'PUD' . str_pad('11', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000005',
                'product_id'         => 'PDT000013',
                'box_bought'         => 8,
                'unit_per_box'       => 10,
                'price_per_box'      => 25000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('12', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000005',
                'product_id'         => 'PDT000014',
                'box_bought'         => 6,
                'unit_per_box'       => 10,
                'price_per_box'      => 20000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            
            // Purchase 6 (3 produk)
            [
                'purchase_detail_id' => 'PUD' . str_pad('13', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000006',
                'product_id'         => 'PDT000003',
                'box_bought'         => 15,
                'unit_per_box'       => 40,
                'price_per_box'      => 7500,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('14', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000006',
                'product_id'         => 'PDT000006',
                'box_bought'         => 10,
                'unit_per_box'       => 24,
                'price_per_box'      => 3000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('15', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000006',
                'product_id'         => 'PDT000008',
                'box_bought'         => 8,
                'unit_per_box'       => 24,
                'price_per_box'      => 6000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            
            // Purchase 7 (2 produk)
            [
                'purchase_detail_id' => 'PUD' . str_pad('16', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000007',
                'product_id'         => 'PDT000026',
                'box_bought'         => 10,
                'unit_per_box'       => 24,
                'price_per_box'      => 7000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('17', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000007',
                'product_id'         => 'PDT000029',
                'box_bought'         => 12,
                'unit_per_box'       => 24,
                'price_per_box'      => 5000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            
            // Purchase 8 (3 produk)
            [
                'purchase_detail_id' => 'PUD' . str_pad('18', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000008',
                'product_id'         => 'PDT000001',
                'box_bought'         => 8,
                'unit_per_box'       => 20,
                'price_per_box'      => 8000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('19', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000008',
                'product_id'         => 'PDT000003',
                'box_bought'         => 10,
                'unit_per_box'       => 24,
                'price_per_box'      => 7500,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('20', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000008',
                'product_id'         => 'PDT000004',
                'box_bought'         => 12,
                'unit_per_box'       => 24,
                'price_per_box'      => 6000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            
            // Purchase 9 (2 produk)
            [
                'purchase_detail_id' => 'PUD' . str_pad('21', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000009',
                'product_id'         => 'PDT000021',
                'box_bought'         => 15,
                'unit_per_box'       => 24,
                'price_per_box'      => 4000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('22', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000009',
                'product_id'         => 'PDT000023',
                'box_bought'         => 12,
                'unit_per_box'       => 24,
                'price_per_box'      => 4000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            
            // Purchase 10 (2 produk)
            [
                'purchase_detail_id' => 'PUD' . str_pad('23', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000010',
                'product_id'         => 'PDT000006',
                'box_bought'         => 5,
                'unit_per_box'       => 8,
                'price_per_box'      => 60000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('24', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000010',
                'product_id'         => 'PDT000008',
                'box_bought'         => 10,
                'unit_per_box'       => 24,
                'price_per_box'      => 6000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            
            // Purchase 11 (2 produk) - Ordered
            [
                'purchase_detail_id' => 'PUD' . str_pad('25', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000011',
                'product_id'         => 'PDT000001',
                'box_bought'         => 12,
                'unit_per_box'       => 20,
                'price_per_box'      => 8000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('26', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000011',
                'product_id'         => 'PDT000005',
                'box_bought'         => 6,
                'unit_per_box'       => 10,
                'price_per_box'      => 35000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            
            // Purchase 12 (2 produk) - Ordered
            [
                'purchase_detail_id' => 'PUD' . str_pad('27', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000012',
                'product_id'         => 'PDT000007',
                'box_bought'         => 18,
                'unit_per_box'       => 24,
                'price_per_box'      => 6000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('28', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000012',
                'product_id'         => 'PDT000019',
                'box_bought'         => 15,
                'unit_per_box'       => 24,
                'price_per_box'      => 6500,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            
            // Purchase 13 (2 produk) - Ordered
            [
                'purchase_detail_id' => 'PUD' . str_pad('29', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000013',
                'product_id'         => 'PDT000011',
                'box_bought'         => 7,
                'unit_per_box'       => 10,
                'price_per_box'      => 35000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('30', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000013',
                'product_id'         => 'PDT000015',
                'box_bought'         => 8,
                'unit_per_box'       => 10,
                'price_per_box'      => 18000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            
            // Purchase 14 (2 produk) - Ordered
            [
                'purchase_detail_id' => 'PUD' . str_pad('31', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000014',
                'product_id'         => 'PDT000026',
                'box_bought'         => 12,
                'unit_per_box'       => 24,
                'price_per_box'      => 7000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('32', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000014',
                'product_id'         => 'PDT000030',
                'box_bought'         => 10,
                'unit_per_box'       => 24,
                'price_per_box'      => 7000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            
            // Purchase 15 (2 produk) - Ordered
            [
                'purchase_detail_id' => 'PUD' . str_pad('33', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000015',
                'product_id'         => 'PDT000021',
                'box_bought'         => 20,
                'unit_per_box'       => 24,
                'price_per_box'      => 4000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('34', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000015',
                'product_id'         => 'PDT000025',
                'box_bought'         => 15,
                'unit_per_box'       => 24,
                'price_per_box'      => 4500,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            
            // Purchase 16 (2 produk) - Ordered
            [
                'purchase_detail_id' => 'PUD' . str_pad('35', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000016',
                'product_id'         => 'PDT000002',
                'box_bought'         => 15,
                'unit_per_box'       => 24,
                'price_per_box'      => 5000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('36', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000016',
                'product_id'         => 'PDT000004',
                'box_bought'         => 12,
                'unit_per_box'       => 24,
                'price_per_box'      => 6000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            
            // Purchase 17 (2 produk) - Ordered
            [
                'purchase_detail_id' => 'PUD' . str_pad('37', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000017',
                'product_id'         => 'PDT000003',
                'box_bought'         => 18,
                'unit_per_box'       => 40,
                'price_per_box'      => 7500,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('38', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000017',
                'product_id'         => 'PDT000006',
                'box_bought'         => 12,
                'unit_per_box'       => 24,
                'price_per_box'      => 3000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            
            // Purchase 18 (2 produk) - Ordered
            [
                'purchase_detail_id' => 'PUD' . str_pad('39', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000018',
                'product_id'         => 'PDT000016',
                'box_bought'         => 20,
                'unit_per_box'       => 24,
                'price_per_box'      => 6000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('40', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000018',
                'product_id'         => 'PDT000018',
                'box_bought'         => 18,
                'unit_per_box'       => 24,
                'price_per_box'      => 6500,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            
            // Purchase 19 (2 produk) - Ordered
            [
                'purchase_detail_id' => 'PUD' . str_pad('41', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000019',
                'product_id'         => 'PDT000013',
                'box_bought'         => 10,
                'unit_per_box'       => 10,
                'price_per_box'      => 25000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('42', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000019',
                'product_id'         => 'PDT000014',
                'box_bought'         => 8,
                'unit_per_box'       => 10,
                'price_per_box'      => 20000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            
            // Purchase 20 (2 produk) - Ordered
            [
                'purchase_detail_id' => 'PUD' . str_pad('43', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000020',
                'product_id'         => 'PDT000027',
                'box_bought'         => 15,
                'unit_per_box'       => 24,
                'price_per_box'      => 7500,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('44', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000020',
                'product_id'         => 'PDT000028',
                'box_bought'         => 12,
                'unit_per_box'       => 24,
                'price_per_box'      => 6500,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            
            // Purchase 21 (2 produk) - Pending
            [
                'purchase_detail_id' => 'PUD' . str_pad('45', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000021',
                'product_id'         => 'PDT000001',
                'box_bought'         => 15,
                'unit_per_box'       => 20,
                'price_per_box'      => 8000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('46', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000021',
                'product_id'         => 'PDT000004',
                'box_bought'         => 12,
                'unit_per_box'       => 24,
                'price_per_box'      => 6000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            
            // Purchase 22 (2 produk) - Pending
            [
                'purchase_detail_id' => 'PUD' . str_pad('47', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000022',
                'product_id'         => 'PDT000007',
                'box_bought'         => 20,
                'unit_per_box'       => 24,
                'price_per_box'      => 6000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('48', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000022',
                'product_id'         => 'PDT000020',
                'box_bought'         => 15,
                'unit_per_box'       => 24,
                'price_per_box'      => 7000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            
            // Purchase 23 (2 produk) - Pending
            [
                'purchase_detail_id' => 'PUD' . str_pad('49', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000023',
                'product_id'         => 'PDT000011',
                'box_bought'         => 8,
                'unit_per_box'       => 10,
                'price_per_box'      => 35000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('50', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000023',
                'product_id'         => 'PDT000013',
                'box_bought'         => 10,
                'unit_per_box'       => 10,
                'price_per_box'      => 25000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            
            // Purchase 24 (2 produk) - Pending
            [
                'purchase_detail_id' => 'PUD' . str_pad('51', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000024',
                'product_id'         => 'PDT000026',
                'box_bought'         => 15,
                'unit_per_box'       => 24,
                'price_per_box'      => 7000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('52', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000024',
                'product_id'         => 'PDT000028',
                'box_bought'         => 12,
                'unit_per_box'       => 24,
                'price_per_box'      => 6500,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            
            // Purchase 25 (2 produk) - Pending
            [
                'purchase_detail_id' => 'PUD' . str_pad('53', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000025',
                'product_id'         => 'PDT000021',
                'box_bought'         => 18,
                'unit_per_box'       => 24,
                'price_per_box'      => 4000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('54', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000025',
                'product_id'         => 'PDT000023',
                'box_bought'         => 15,
                'unit_per_box'       => 24,
                'price_per_box'      => 4000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            
            // Purchase 26 (2 produk) - Cancelled
            [
                'purchase_detail_id' => 'PUD' . str_pad('55', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000026',
                'product_id'         => 'PDT000002',
                'box_bought'         => 10,
                'unit_per_box'       => 24,
                'price_per_box'      => 5000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('56', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000026',
                'product_id'         => 'PDT000004',
                'box_bought'         => 8,
                'unit_per_box'       => 24,
                'price_per_box'      => 6000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            
            // Purchase 27 (2 produk) - Cancelled
            [
                'purchase_detail_id' => 'PUD' . str_pad('57', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000027',
                'product_id'         => 'PDT000008',
                'box_bought'         => 15,
                'unit_per_box'       => 24,
                'price_per_box'      => 6000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('58', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000027',
                'product_id'         => 'PDT000009',
                'box_bought'         => 12,
                'unit_per_box'       => 24,
                'price_per_box'      => 4000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            
            // Purchase 28 (2 produk) - Cancelled
            [
                'purchase_detail_id' => 'PUD' . str_pad('59', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000028',
                'product_id'         => 'PDT000006',
                'box_bought'         => 8,
                'unit_per_box'       => 24,
                'price_per_box'      => 3000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('60', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000028',
                'product_id'         => 'PDT000016',
                'box_bought'         => 15,
                'unit_per_box'       => 24,
                'price_per_box'      => 6000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            
            // Purchase 29 (2 produk) - Cancelled
            [
                'purchase_detail_id' => 'PUD' . str_pad('61', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000029',
                'product_id'         => 'PDT000014',
                'box_bought'         => 6,
                'unit_per_box'       => 10,
                'price_per_box'      => 20000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('62', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000029',
                'product_id'         => 'PDT000015',
                'box_bought'         => 5,
                'unit_per_box'       => 10,
                'price_per_box'      => 18000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            
            // Purchase 30 (2 produk) - Cancelled
            [
                'purchase_detail_id' => 'PUD' . str_pad('63', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000030',
                'product_id'         => 'PDT000027',
                'box_bought'         => 10,
                'unit_per_box'       => 24,
                'price_per_box'      => 7500,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
            [
                'purchase_detail_id' => 'PUD' . str_pad('64', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR000030',
                'product_id'         => 'PDT000030',
                'box_bought'         => 8,
                'unit_per_box'       => 24,
                'price_per_box'      => 7000,
                'created_at'         => date('Y-m-d H:i:s'),
                'updated_at'         => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('purchase_details')->insertBatch($data);

        // Update 'purchase_amount' di tabel 'purchases' berdasarkan data di tabel 'purchase_details'
        $this->db->query("
            UPDATE purchases
            SET purchase_amount = (
                SELECT SUM(price_per_box * box_bought)
                FROM purchase_details
                WHERE purchase_details.purchase_id = purchases.purchase_id
            )
        ");
    }
}