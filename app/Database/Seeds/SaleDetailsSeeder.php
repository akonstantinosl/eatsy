<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SaleDetailsSeeder extends Seeder
{
    public function run()
    {
        $saleDetailData = [
            // Detail untuk SAL000001 (3 produk)
            [
                'sale_detail_id' => 'SLD' . str_pad('1', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000001', 
                'product_id'     => 'PDT000001', 
                'quantity_sold'  => 5,
                'price_per_unit' => 25000,
                'created_at'     => '2025-01-05 10:15:00',
                'updated_at'     => '2025-01-05 10:15:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('2', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000001',  
                'product_id'     => 'PDT000005',  
                'quantity_sold'  => 3,
                'price_per_unit' => 35000,
                'created_at'     => '2025-01-05 10:15:00',
                'updated_at'     => '2025-01-05 10:15:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('3', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000001',  
                'product_id'     => 'PDT000010',  
                'quantity_sold'  => 2,
                'price_per_unit' => 45000,
                'created_at'     => '2025-01-05 10:15:00',
                'updated_at'     => '2025-01-05 10:15:00',
            ],
            
            // Detail untuk SAL000002 (2 produk)
            [
                'sale_detail_id' => 'SLD' . str_pad('4', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000002',
                'product_id'     => 'PDT000008',  
                'quantity_sold'  => 4,
                'price_per_unit' => 30000,
                'created_at'     => '2025-01-06 14:20:00',
                'updated_at'     => '2025-01-06 14:20:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('5', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000002',
                'product_id'     => 'PDT000015',  
                'quantity_sold'  => 2,
                'price_per_unit' => 50000,
                'created_at'     => '2025-01-06 14:20:00',
                'updated_at'     => '2025-01-06 14:20:00',
            ],
            
            // Detail untuk SAL000003 (3 produk)
            [
                'sale_detail_id' => 'SLD' . str_pad('6', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000003',
                'product_id'     => 'PDT000003',  
                'quantity_sold'  => 6,
                'price_per_unit' => 20000,
                'created_at'     => '2025-01-08 09:45:00',
                'updated_at'     => '2025-01-08 09:45:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('7', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000003',
                'product_id'     => 'PDT000007',  
                'quantity_sold'  => 3,
                'price_per_unit' => 40000,
                'created_at'     => '2025-01-08 09:45:00',
                'updated_at'     => '2025-01-08 09:45:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('8', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000003',
                'product_id'     => 'PDT000012',  
                'quantity_sold'  => 2,
                'price_per_unit' => 55000,
                'created_at'     => '2025-01-08 09:45:00',
                'updated_at'     => '2025-01-08 09:45:00',
            ],
            
            // Detail untuk SAL000004 (2 produk)
            [
                'sale_detail_id' => 'SLD' . str_pad('9', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000004',
                'product_id'     => 'PDT000020',  
                'quantity_sold'  => 5,
                'price_per_unit' => 28000,
                'created_at'     => '2025-01-10 16:30:00',
                'updated_at'     => '2025-01-10 16:30:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('10', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000004',
                'product_id'     => 'PDT000025',  
                'quantity_sold'  => 3,
                'price_per_unit' => 42000,
                'created_at'     => '2025-01-10 16:30:00',
                'updated_at'     => '2025-01-10 16:30:00',
            ],
            
            // Detail untuk SAL000005 (3 produk)
            [
                'sale_detail_id' => 'SLD' . str_pad('11', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000005',
                'product_id'     => 'PDT000002',  
                'quantity_sold'  => 8,
                'price_per_unit' => 18000,
                'created_at'     => '2025-01-12 11:20:00',
                'updated_at'     => '2025-01-12 11:20:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('12', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000005',
                'product_id'     => 'PDT000009',  
                'quantity_sold'  => 4,
                'price_per_unit' => 32000,
                'created_at'     => '2025-01-12 11:20:00',
                'updated_at'     => '2025-01-12 11:20:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('13', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000005',
                'product_id'     => 'PDT000014',  
                'quantity_sold'  => 2,
                'price_per_unit' => 60000,
                'created_at'     => '2025-01-12 11:20:00',
                'updated_at'     => '2025-01-12 11:20:00',
            ],
            
            // Detail untuk SAL000006 (2 produk)
            [
                'sale_detail_id' => 'SLD' . str_pad('14', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000006',
                'product_id'     => 'PDT000004',  
                'quantity_sold'  => 5,
                'price_per_unit' => 35000,
                'created_at'     => '2025-01-15 13:10:00',
                'updated_at'     => '2025-01-15 13:10:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('15', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000006',
                'product_id'     => 'PDT000018',  
                'quantity_sold'  => 3,
                'price_per_unit' => 48000,
                'created_at'     => '2025-01-15 13:10:00',
                'updated_at'     => '2025-01-15 13:10:00',
            ],
            
            // Detail untuk SAL000007 (3 produk)
            [
                'sale_detail_id' => 'SLD' . str_pad('16', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000007',
                'product_id'     => 'PDT000006',  
                'quantity_sold'  => 4,
                'price_per_unit' => 22000,
                'created_at'     => '2025-01-18 10:05:00',
                'updated_at'     => '2025-01-18 10:05:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('17', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000007',
                'product_id'     => 'PDT000011',  
                'quantity_sold'  => 2,
                'price_per_unit' => 38000,
                'created_at'     => '2025-01-18 10:05:00',
                'updated_at'     => '2025-01-18 10:05:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('18', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000007',
                'product_id'     => 'PDT000016',  
                'quantity_sold'  => 3,
                'price_per_unit' => 45000,
                'created_at'     => '2025-01-18 10:05:00',
                'updated_at'     => '2025-01-18 10:05:00',
            ],
            
            // Detail untuk SAL000008 (2 produk)
            [
                'sale_detail_id' => 'SLD' . str_pad('19', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000008',
                'product_id'     => 'PDT000013',  
                'quantity_sold'  => 6,
                'price_per_unit' => 30000,
                'created_at'     => '2025-01-20 15:40:00',
                'updated_at'     => '2025-01-20 15:40:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('20', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000008',
                'product_id'     => 'PDT000022',  
                'quantity_sold'  => 4,
                'price_per_unit' => 52000,
                'created_at'     => '2025-01-20 15:40:00',
                'updated_at'     => '2025-01-20 15:40:00',
            ],
            
            // Detail untuk SAL000009 (3 produk)
            [
                'sale_detail_id' => 'SLD' . str_pad('21', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000009',
                'product_id'     => 'PDT000017',  
                'quantity_sold'  => 5,
                'price_per_unit' => 27000,
                'created_at'     => '2025-01-22 09:30:00',
                'updated_at'     => '2025-01-22 09:30:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('22', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000009',
                'product_id'     => 'PDT000023',  
                'quantity_sold'  => 3,
                'price_per_unit' => 40000,
                'created_at'     => '2025-01-22 09:30:00',
                'updated_at'     => '2025-01-22 09:30:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('23', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000009',
                'product_id'     => 'PDT000028',  
                'quantity_sold'  => 2,
                'price_per_unit' => 55000,
                'created_at'     => '2025-01-22 09:30:00',
                'updated_at'     => '2025-01-22 09:30:00',
            ],
            
            // Detail untuk SAL000010 (2 produk)
            [
                'sale_detail_id' => 'SLD' . str_pad('24', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000010',
                'product_id'     => 'PDT000019',  
                'quantity_sold'  => 7,
                'price_per_unit' => 32000,
                'created_at'     => '2025-01-25 14:15:00',
                'updated_at'     => '2025-01-25 14:15:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('25', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000010',
                'product_id'     => 'PDT000024',  
                'quantity_sold'  => 4,
                'price_per_unit' => 47000,
                'created_at'     => '2025-01-25 14:15:00',
                'updated_at'     => '2025-01-25 14:15:00',
            ],
            
            // Detail untuk SAL000011 (2 produk)
            [
                'sale_detail_id' => 'SLD' . str_pad('26', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000011',
                'product_id'     => 'PDT000021',  
                'quantity_sold'  => 5,
                'price_per_unit' => 29000,
                'created_at'     => '2025-01-26 11:30:00',
                'updated_at'     => '2025-01-26 11:30:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('27', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000011',
                'product_id'     => 'PDT000026',  
                'quantity_sold'  => 3,
                'price_per_unit' => 43000,
                'created_at'     => '2025-01-26 11:30:00',
                'updated_at'     => '2025-01-26 11:30:00',
            ],
            
            // Detail untuk SAL000012 (3 produk)
            [
                'sale_detail_id' => 'SLD' . str_pad('28', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000012',
                'product_id'     => 'PDT000002',  
                'quantity_sold'  => 6,
                'price_per_unit' => 18000,
                'created_at'     => '2025-01-27 13:45:00',
                'updated_at'     => '2025-01-27 13:45:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('29', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000012',
                'product_id'     => 'PDT000007',  
                'quantity_sold'  => 4,
                'price_per_unit' => 40000,
                'created_at'     => '2025-01-27 13:45:00',
                'updated_at'     => '2025-01-27 13:45:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('30', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000012',
                'product_id'     => 'PDT000014',  
                'quantity_sold'  => 2,
                'price_per_unit' => 60000,
                'created_at'     => '2025-01-27 13:45:00',
                'updated_at'     => '2025-01-27 13:45:00',
            ],
            
            // Detail untuk SAL000013 (2 produk)
            [
                'sale_detail_id' => 'SLD' . str_pad('31', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000013',
                'product_id'     => 'PDT000003',  
                'quantity_sold'  => 5,
                'price_per_unit' => 20000,
                'created_at'     => '2025-01-28 10:20:00',
                'updated_at'     => '2025-01-28 10:20:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('32', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000013',
                'product_id'     => 'PDT000012',  
                'quantity_sold'  => 3,
                'price_per_unit' => 55000,
                'created_at'     => '2025-01-28 10:20:00',
                'updated_at'     => '2025-01-28 10:20:00',
            ],
            
            // Detail untuk SAL000014 (3 produk)
            [
                'sale_detail_id' => 'SLD' . str_pad('33', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000014',
                'product_id'     => 'PDT000005',  
                'quantity_sold'  => 4,
                'price_per_unit' => 35000,
                'created_at'     => '2025-01-29 15:10:00',
                'updated_at'     => '2025-01-29 15:10:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('34', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000014',
                'product_id'     => 'PDT000010',  
                'quantity_sold'  => 2,
                'price_per_unit' => 45000,
                'created_at'     => '2025-01-29 15:10:00',
                'updated_at'     => '2025-01-29 15:10:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('35', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000014',
                'product_id'     => 'PDT000015',  
                'quantity_sold'  => 3,
                'price_per_unit' => 50000,
                'created_at'     => '2025-01-29 15:10:00',
                'updated_at'     => '2025-01-29 15:10:00',
            ],
            
            // Detail untuk SAL000015 (2 produk)
            [
                'sale_detail_id' => 'SLD' . str_pad('36', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000015',
                'product_id'     => 'PDT000008',  
                'quantity_sold'  => 6,
                'price_per_unit' => 30000,
                'created_at'     => '2025-01-30 09:40:00',
                'updated_at'     => '2025-01-30 09:40:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('37', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000015',
                'product_id'     => 'PDT000018',  
                'quantity_sold'  => 4,
                'price_per_unit' => 48000,
                'created_at'     => '2025-01-30 09:40:00',
                'updated_at'     => '2025-01-30 09:40:00',
            ],
            
            // Detail untuk SAL000016 (3 produk)
            [
                'sale_detail_id' => 'SLD' . str_pad('38', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000016',
                'product_id'     => 'PDT000004',  
                'quantity_sold'  => 5,
                'price_per_unit' => 35000,
                'created_at'     => '2025-01-31 12:25:00',
                'updated_at'     => '2025-01-31 12:25:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('39', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000016',
                'product_id'     => 'PDT000009',  
                'quantity_sold'  => 3,
                'price_per_unit' => 32000,
                'created_at'     => '2025-01-31 12:25:00',
                'updated_at'     => '2025-01-31 12:25:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('40', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000016',
                'product_id'     => 'PDT000020',  
                'quantity_sold'  => 2,
                'price_per_unit' => 28000,
                'created_at'     => '2025-01-31 12:25:00',
                'updated_at'     => '2025-01-31 12:25:00',
            ],
            
            // Detail untuk SAL000017 (2 produk)
            [
                'sale_detail_id' => 'SLD' . str_pad('41', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000017',
                'product_id'     => 'PDT000006',  
                'quantity_sold'  => 7,
                'price_per_unit' => 22000,
                'created_at'     => '2025-02-01 14:50:00',
                'updated_at'     => '2025-02-01 14:50:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('42', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000017',
                'product_id'     => 'PDT000016',  
                'quantity_sold'  => 3,
                'price_per_unit' => 45000,
                'created_at'     => '2025-02-01 14:50:00',
                'updated_at'     => '2025-02-01 14:50:00',
            ],
            
            // Detail untuk SAL000018 (3 produk)
            [
                'sale_detail_id' => 'SLD' . str_pad('43', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000018',
                'product_id'     => 'PDT000011',  
                'quantity_sold'  => 4,
                'price_per_unit' => 38000,
                'created_at'     => '2025-02-02 10:35:00',
                'updated_at'     => '2025-02-02 10:35:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('44', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000018',
                'product_id'     => 'PDT000017',  
                'quantity_sold'  => 2,
                'price_per_unit' => 27000,
                'created_at'     => '2025-02-02 10:35:00',
                'updated_at'     => '2025-02-02 10:35:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('45', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000018',
                'product_id'     => 'PDT000022',  
                'quantity_sold'  => 3,
                'price_per_unit' => 52000,
                'created_at'     => '2025-02-02 10:35:00',
                'updated_at'     => '2025-02-02 10:35:00',
            ],
            
            // Detail untuk SAL000019 (2 produk)
            [
                'sale_detail_id' => 'SLD' . str_pad('46', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000019',
                'product_id'     => 'PDT000013',  
                'quantity_sold'  => 5,
                'price_per_unit' => 30000,
                'created_at'     => '2025-02-03 13:15:00',
                'updated_at'     => '2025-02-03 13:15:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('47', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000019',
                'product_id'     => 'PDT000023',  
                'quantity_sold'  => 3,
                'price_per_unit' => 40000,
                'created_at'     => '2025-02-03 13:15:00',
                'updated_at'     => '2025-02-03 13:15:00',
            ],
            
            // Detail untuk SAL000020 (3 produk)
            [
                'sale_detail_id' => 'SLD' . str_pad('48', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000020',
                'product_id'     => 'PDT000019',  
                'quantity_sold'  => 4,
                'price_per_unit' => 32000,
                'created_at'     => '2025-02-04 15:30:00',
                'updated_at'     => '2025-02-04 15:30:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('49', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000020',
                'product_id'     => 'PDT000024',  
                'quantity_sold'  => 2,
                'price_per_unit' => 47000,
                'created_at'     => '2025-02-04 15:30:00',
                'updated_at'     => '2025-02-04 15:30:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('50', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000020',
                'product_id'     => 'PDT000028',  
                'quantity_sold'  => 2,
                'price_per_unit' => 55000,
                'created_at'     => '2025-02-04 15:30:00',
                'updated_at'     => '2025-02-04 15:30:00',
            ],
            
            // Detail untuk SAL000021 (2 produk)
            [
                'sale_detail_id' => 'SLD' . str_pad('51', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000021',
                'product_id'     => 'PDT000021',  
                'quantity_sold'  => 6,
                'price_per_unit' => 29000,
                'created_at'     => '2025-02-05 09:20:00',
                'updated_at'     => '2025-02-05 09:20:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('52', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000021',
                'product_id'     => 'PDT000026',  
                'quantity_sold'  => 3,
                'price_per_unit' => 43000,
                'created_at'     => '2025-02-05 09:20:00',
                'updated_at'     => '2025-02-05 09:20:00',
            ],
            
            // Detail untuk SAL000022 (3 produk)
            [
                'sale_detail_id' => 'SLD' . str_pad('53', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000022',
                'product_id'     => 'PDT000001',  
                'quantity_sold'  => 5,
                'price_per_unit' => 25000,
                'created_at'     => '2025-02-06 11:45:00',
                'updated_at'     => '2025-02-06 11:45:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('54', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000022',
                'product_id'     => 'PDT000007',  
                'quantity_sold'  => 3,
                'price_per_unit' => 40000,
                'created_at'     => '2025-02-06 11:45:00',
                'updated_at'     => '2025-02-06 11:45:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('55', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000022',
                'product_id'     => 'PDT000012',  
                'quantity_sold'  => 2,
                'price_per_unit' => 55000,
                'created_at'     => '2025-02-06 11:45:00',
                'updated_at'     => '2025-02-06 11:45:00',
            ],
            
            // Detail untuk SAL000023 (2 produk)
            [
                'sale_detail_id' => 'SLD' . str_pad('56', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000023',
                'product_id'     => 'PDT000003',  
                'quantity_sold'  => 6,
                'price_per_unit' => 20000,
                'created_at'     => '2025-02-07 14:05:00',
                'updated_at'     => '2025-02-07 14:05:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('57', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000023',
                'product_id'     => 'PDT000014',  
                'quantity_sold'  => 4,
                'price_per_unit' => 60000,
                'created_at'     => '2025-02-07 14:05:00',
                'updated_at'     => '2025-02-07 14:05:00',
            ],
            
            // Detail untuk SAL000024 (3 produk)
            [
                'sale_detail_id' => 'SLD' . str_pad('58', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000024',
                'product_id'     => 'PDT000005',  
                'quantity_sold'  => 5,
                'price_per_unit' => 35000,
                'created_at'     => '2025-02-08 10:50:00',
                'updated_at'     => '2025-02-08 10:50:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('59', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000024',
                'product_id'     => 'PDT000015',  
                'quantity_sold'  => 2,
                'price_per_unit' => 50000,
                'created_at'     => '2025-02-08 10:50:00',
                'updated_at'     => '2025-02-08 10:50:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('60', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000024',
                'product_id'     => 'PDT000025',  
                'quantity_sold'  => 3,
                'price_per_unit' => 42000,
                'created_at'     => '2025-02-08 10:50:00',
                'updated_at'     => '2025-02-08 10:50:00',
            ],
            
            // Detail untuk SAL000025 (2 produk)
            [
                'sale_detail_id' => 'SLD' . str_pad('61', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000025',
                'product_id'     => 'PDT000008',  
                'quantity_sold'  => 4,
                'price_per_unit' => 30000,
                'created_at'     => '2025-02-09 13:30:00',
                'updated_at'     => '2025-02-09 13:30:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('62', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000025',
                'product_id'     => 'PDT000018',  
                'quantity_sold'  => 3,
                'price_per_unit' => 48000,
                'created_at'     => '2025-02-09 13:30:00',
                'updated_at'     => '2025-02-09 13:30:00',
            ],
            
            // Detail untuk SAL000026 (3 produk) - Cancelled
            [
                'sale_detail_id' => 'SLD' . str_pad('63', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000026',
                'product_id'     => 'PDT000002',  
                'quantity_sold'  => 7,
                'price_per_unit' => 18000,
                'created_at'     => '2025-02-10 09:15:00',
                'updated_at'     => '2025-02-10 09:15:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('64', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000026',
                'product_id'     => 'PDT000009',  
                'quantity_sold'  => 4,
                'price_per_unit' => 32000,
                'created_at'     => '2025-02-10 09:15:00',
                'updated_at'     => '2025-02-10 09:15:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('65', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000026',
                'product_id'     => 'PDT000020',  
                'quantity_sold'  => 3,
                'price_per_unit' => 28000,
                'created_at'     => '2025-02-10 09:15:00',
                'updated_at'     => '2025-02-10 09:15:00',
            ],
            
            // Detail untuk SAL000027 (2 produk) - Cancelled
            [
                'sale_detail_id' => 'SLD' . str_pad('66', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000027',
                'product_id'     => 'PDT000004',  
                'quantity_sold'  => 5,
                'price_per_unit' => 35000,
                'created_at'     => '2025-02-11 14:40:00',
                'updated_at'     => '2025-02-11 14:40:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('67', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000027',
                'product_id'     => 'PDT000016',  
                'quantity_sold'  => 3,
                'price_per_unit' => 45000,
                'created_at'     => '2025-02-11 14:40:00',
                'updated_at'     => '2025-02-11 14:40:00',
            ],
            
            // Detail untuk SAL000028 (3 produk) - Cancelled
            [
                'sale_detail_id' => 'SLD' . str_pad('68', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000028',
                'product_id'     => 'PDT000006',  
                'quantity_sold'  => 6,
                'price_per_unit' => 22000,
                'created_at'     => '2025-02-12 10:25:00',
                'updated_at'     => '2025-02-12 10:25:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('69', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000028',
                'product_id'     => 'PDT000011',  
                'quantity_sold'  => 3,
                'price_per_unit' => 38000,
                'created_at'     => '2025-02-12 10:25:00',
                'updated_at'     => '2025-02-12 10:25:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('70', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000028',
                'product_id'     => 'PDT000022',  
                'quantity_sold'  => 2,
                'price_per_unit' => 52000,
                'created_at'     => '2025-02-12 10:25:00',
                'updated_at'     => '2025-02-12 10:25:00',
            ],
            
            // Detail untuk SAL000029 (2 produk) - Cancelled
            [
                'sale_detail_id' => 'SLD' . str_pad('71', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000029',
                'product_id'     => 'PDT000013',  
                'quantity_sold'  => 5,
                'price_per_unit' => 30000,
                'created_at'     => '2025-02-13 13:10:00',
                'updated_at'     => '2025-02-13 13:10:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('72', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000029',
                'product_id'     => 'PDT000023',  
                'quantity_sold'  => 4,
                'price_per_unit' => 40000,
                'created_at'     => '2025-02-13 13:10:00',
                'updated_at'     => '2025-02-13 13:10:00',
            ],
            
            // Detail untuk SAL000030 (3 produk) - Cancelled
            [
                'sale_detail_id' => 'SLD' . str_pad('73', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000030',
                'product_id'     => 'PDT000017',  
                'quantity_sold'  => 6,
                'price_per_unit' => 27000,
                'created_at'     => '2025-02-14 15:50:00',
                'updated_at'     => '2025-02-14 15:50:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('74', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000030',
                'product_id'     => 'PDT000024',  
                'quantity_sold'  => 3,
                'price_per_unit' => 47000,
                'created_at'     => '2025-02-14 15:50:00',
                'updated_at'     => '2025-02-14 15:50:00',
            ],
            [
                'sale_detail_id' => 'SLD' . str_pad('75', 6, '0', STR_PAD_LEFT),
                'sale_id'        => 'SAL000030',
                'product_id'     => 'PDT000028',  
                'quantity_sold'  => 2,
                'price_per_unit' => 55000,
                'created_at'     => '2025-02-14 15:50:00',
                'updated_at'     => '2025-02-14 15:50:00',
            ],
        ];

        $this->db->table('sale_details')->insertBatch($saleDetailData);

        // Update 'sale_amount' di tabel 'sales' berdasarkan data di tabel 'sale_details'
        $this->db->query("
            UPDATE sales
            SET sale_amount = (
                SELECT SUM(price_per_unit * quantity_sold)
                FROM sale_details
                WHERE sale_details.sale_id = sales.sale_id
            )
        ");
    }
}