<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PurchaseDetailsSeeder extends Seeder
{
    public function run()
    {
        // Insert data untuk tabel 'purchase_details'
        $purchaseDetailData = [
            // Pembelian dengan hanya unit
            [
                'purchase_detail_id' => 'PRD' . str_pad('1', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR' . str_pad('1', 6, '0', STR_PAD_LEFT),
                'product_id'         => 'PDT' . str_pad('1', 6, '0', STR_PAD_LEFT),
                'purchase_type'      => 'unit',
                'quantity_unit'      => 100,
                'quantity_box'       => 0,
                'purchase_price'     => 5000,
                'box_purchase_price' => 0,
                'created_at'         => date('Y-m-d H:i:s'),
            ],
            // Pembelian dengan hanya box
            [
                'purchase_detail_id' => 'PRD' . str_pad('2', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR' . str_pad('1', 6, '0', STR_PAD_LEFT),
                'product_id'         => 'PDT' . str_pad('5', 6, '0', STR_PAD_LEFT),
                'purchase_type'      => 'box',
                'quantity_unit'      => 0,
                'quantity_box'       => 10,
                'purchase_price'     => 0,
                'box_purchase_price' => 50000,
                'created_at'         => date('Y-m-d H:i:s'),
            ],
            // Pembelian dengan unit dan box
            [
                'purchase_detail_id' => 'PRD' . str_pad('3', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR' . str_pad('2', 6, '0', STR_PAD_LEFT),
                'product_id'         => 'PDT' . str_pad('2', 6, '0', STR_PAD_LEFT),
                'purchase_type'      => 'unit,box', // Menggunakan keduanya
                'quantity_unit'      => 50,
                'quantity_box'       => 5,
                'purchase_price'     => 10000,
                'box_purchase_price' => 50000,
                'created_at'         => date('Y-m-d H:i:s'),
            ],
            // Pembelian hanya unit, dengan harga lebih tinggi
            [
                'purchase_detail_id' => 'PRD' . str_pad('4', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR' . str_pad('2', 6, '0', STR_PAD_LEFT),
                'product_id'         => 'PDT' . str_pad('7', 6, '0', STR_PAD_LEFT),
                'purchase_type'      => 'unit',
                'quantity_unit'      => 200,
                'quantity_box'       => 0,
                'purchase_price'     => 10000,
                'box_purchase_price' => 0,
                'created_at'         => date('Y-m-d H:i:s'),
            ],
            // Pembelian hanya box, dengan harga lebih tinggi
            [
                'purchase_detail_id' => 'PRD' . str_pad('5', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR' . str_pad('3', 6, '0', STR_PAD_LEFT),
                'product_id'         => 'PDT' . str_pad('3', 6, '0', STR_PAD_LEFT),
                'purchase_type'      => 'box',
                'quantity_unit'      => 0,
                'quantity_box'       => 15,
                'purchase_price'     => 0,
                'box_purchase_price' => 70000,
                'created_at'         => date('Y-m-d H:i:s'),
            ],
            // Pembelian dengan unit dan box, dengan harga lebih tinggi
            [
                'purchase_detail_id' => 'PRD' . str_pad('6', 6, '0', STR_PAD_LEFT),
                'purchase_id'        => 'PUR' . str_pad('3', 6, '0', STR_PAD_LEFT),
                'product_id'         => 'PDT' . str_pad('6', 6, '0', STR_PAD_LEFT),
                'purchase_type'      => 'unit,box', // Menggunakan keduanya
                'quantity_unit'      => 80,
                'quantity_box'       => 3,
                'purchase_price'     => 12000,
                'box_purchase_price' => 60000,
                'created_at'         => date('Y-m-d H:i:s'),
            ],
        ];

        // Menambahkan data ke tabel 'purchase_details'
        $this->db->table('purchase_details')->insertBatch($purchaseDetailData);

        // Update 'purchase_amount' di tabel 'purchases' berdasarkan data di tabel 'purchase_details'
        $this->db->query("
            UPDATE purchases SET purchase_amount = (
                SELECT SUM(
                    (quantity_unit * purchase_price) + (quantity_box * box_purchase_price)
                )
                FROM purchase_details
                WHERE purchase_details.purchase_id = purchases.purchase_id
            )
        ");
    }
}
