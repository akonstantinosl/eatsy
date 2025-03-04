<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SalesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // 10 transaksi dengan status completed
            [
                'sale_id'           => 'SAL' . str_pad('1', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000001',
                'user_id'           => 'USR000001',
                'sale_amount'       => 0, // Akan diupdate berdasarkan sale_details
                'payment_method'    => 'cash',
                'transaction_status'=> 'completed',
                'sale_status'       => 'continue',
                'sale_notes'        => 'Pembelian tunai oleh pelanggan tetap',
                'created_at'        => '2025-01-05 10:15:00',
                'updated_at'        => '2025-01-05 10:30:00',
            ],
            [
                'sale_id'           => 'SAL' . str_pad('2', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000003',
                'user_id'           => 'USR000002',
                'sale_amount'       => 0,
                'payment_method'    => 'credit_card',
                'transaction_status'=> 'completed',
                'sale_status'       => 'continue',
                'sale_notes'        => 'Pembayaran dengan kartu kredit BCA',
                'created_at'        => '2025-01-06 14:20:00',
                'updated_at'        => '2025-01-06 14:35:00',
            ],
            [
                'sale_id'           => 'SAL' . str_pad('3', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000005',
                'user_id'           => 'USR000001',
                'sale_amount'       => 0,
                'payment_method'    => 'debit_card',
                'transaction_status'=> 'completed',
                'sale_status'       => 'continue',
                'sale_notes'        => 'Pembelian rutin bulanan',
                'created_at'        => '2025-01-08 09:45:00',
                'updated_at'        => '2025-01-08 10:00:00',
            ],
            [
                'sale_id'           => 'SAL' . str_pad('4', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000008',
                'user_id'           => 'USR000003',
                'sale_amount'       => 0,
                'payment_method'    => 'e-wallet',
                'transaction_status'=> 'completed',
                'sale_status'       => 'continue',
                'sale_notes'        => 'Pembayaran menggunakan GoPay',
                'created_at'        => '2025-01-10 16:30:00',
                'updated_at'        => '2025-01-10 16:45:00',
            ],
            [
                'sale_id'           => 'SAL' . str_pad('5', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000010',
                'user_id'           => 'USR000002',
                'sale_amount'       => 0,
                'payment_method'    => 'cash',
                'transaction_status'=> 'completed',
                'sale_status'       => 'continue',
                'sale_notes'        => 'Pembelian untuk stok toko',
                'created_at'        => '2025-01-12 11:20:00',
                'updated_at'        => '2025-01-12 11:35:00',
            ],
            [
                'sale_id'           => 'SAL' . str_pad('6', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000012',
                'user_id'           => 'USR000001',
                'sale_amount'       => 0,
                'payment_method'    => 'credit_card',
                'transaction_status'=> 'completed',
                'sale_status'       => 'continue',
                'sale_notes'        => 'Pembayaran dengan kartu kredit Mandiri',
                'created_at'        => '2025-01-15 13:10:00',
                'updated_at'        => '2025-01-15 13:25:00',
            ],
            [
                'sale_id'           => 'SAL' . str_pad('7', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000015',
                'user_id'           => 'USR000003',
                'sale_amount'       => 0,
                'payment_method'    => 'e-wallet',
                'transaction_status'=> 'completed',
                'sale_status'       => 'continue',
                'sale_notes'        => 'Pembayaran menggunakan OVO',
                'created_at'        => '2025-01-18 10:05:00',
                'updated_at'        => '2025-01-18 10:20:00',
            ],
            [
                'sale_id'           => 'SAL' . str_pad('8', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000018',
                'user_id'           => 'USR000002',
                'sale_amount'       => 0,
                'payment_method'    => 'debit_card',
                'transaction_status'=> 'completed',
                'sale_status'       => 'continue',
                'sale_notes'        => 'Pembelian untuk event perusahaan',
                'created_at'        => '2025-01-20 15:40:00',
                'updated_at'        => '2025-01-20 15:55:00',
            ],
            [
                'sale_id'           => 'SAL' . str_pad('9', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000020',
                'user_id'           => 'USR000001',
                'sale_amount'       => 0,
                'payment_method'    => 'cash',
                'transaction_status'=> 'completed',
                'sale_status'       => 'continue',
                'sale_notes'        => 'Pembelian dengan diskon loyalitas',
                'created_at'        => '2025-01-22 09:30:00',
                'updated_at'        => '2025-01-22 09:45:00',
            ],
            [
                'sale_id'           => 'SAL' . str_pad('10', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000022',
                'user_id'           => 'USR000003',
                'sale_amount'       => 0,
                'payment_method'    => 'e-wallet',
                'transaction_status'=> 'completed',
                'sale_status'       => 'continue',
                'sale_notes'        => 'Pembayaran menggunakan Dana',
                'created_at'        => '2025-01-25 14:15:00',
                'updated_at'        => '2025-01-25 14:30:00',
            ],
            
            // 10 transaksi dengan status processing
            [
                'sale_id'           => 'SAL' . str_pad('11', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000002',
                'user_id'           => 'USR000002',
                'sale_amount'       => 0,
                'payment_method'    => 'credit_card',
                'transaction_status'=> 'processing',
                'sale_status'       => 'continue',
                'sale_notes'        => 'Menunggu verifikasi pembayaran',
                'created_at'        => '2025-01-26 11:30:00',
                'updated_at'        => '2025-01-26 11:30:00',
            ],
            [
                'sale_id'           => 'SAL' . str_pad('12', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000004',
                'user_id'           => 'USR000001',
                'sale_amount'       => 0,
                'payment_method'    => 'debit_card',
                'transaction_status'=> 'processing',
                'sale_status'       => 'continue',
                'sale_notes'        => 'Proses pengiriman dalam persiapan',
                'created_at'        => '2025-01-27 13:45:00',
                'updated_at'        => '2025-01-27 13:45:00',
            ],
            [
                'sale_id'           => 'SAL' . str_pad('13', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000006',
                'user_id'           => 'USR000003',
                'sale_amount'       => 0,
                'payment_method'    => 'e-wallet',
                'transaction_status'=> 'processing',
                'sale_status'       => 'continue',
                'sale_notes'        => 'Menunggu konfirmasi pengiriman',
                'created_at'        => '2025-01-28 10:20:00',
                'updated_at'        => '2025-01-28 10:20:00',
            ],
            [
                'sale_id'           => 'SAL' . str_pad('14', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000009',
                'user_id'           => 'USR000002',
                'sale_amount'       => 0,
                'payment_method'    => 'cash',
                'transaction_status'=> 'processing',
                'sale_status'       => 'continue',
                'sale_notes'        => 'Pembayaran diterima, barang sedang disiapkan',
                'created_at'        => '2025-01-29 15:10:00',
                'updated_at'        => '2025-01-29 15:10:00',
            ],
            [
                'sale_id'           => 'SAL' . str_pad('15', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000011',
                'user_id'           => 'USR000001',
                'sale_amount'       => 0,
                'payment_method'    => 'credit_card',
                'transaction_status'=> 'processing',
                'sale_status'       => 'continue',
                'sale_notes'        => 'Menunggu otorisasi kartu kredit',
                'created_at'        => '2025-01-30 09:40:00',
                'updated_at'        => '2025-01-30 09:40:00',
            ],
            [
                'sale_id'           => 'SAL' . str_pad('16', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000014',
                'user_id'           => 'USR000003',
                'sale_amount'       => 0,
                'payment_method'    => 'debit_card',
                'transaction_status'=> 'processing',
                'sale_status'       => 'continue',
                'sale_notes'        => 'Transaksi diproses, menunggu stok',
                'created_at'        => '2025-01-31 12:25:00',
                'updated_at'        => '2025-01-31 12:25:00',
            ],
            [
                'sale_id'           => 'SAL' . str_pad('17', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000017',
                'user_id'           => 'USR000002',
                'sale_amount'       => 0,
                'payment_method'    => 'e-wallet',
                'transaction_status'=> 'processing',
                'sale_status'       => 'continue',
                'sale_notes'        => 'Pembayaran via LinkAja sedang diverifikasi',
                'created_at'        => '2025-02-01 14:50:00',
                'updated_at'        => '2025-02-01 14:50:00',
            ],
            [
                'sale_id'           => 'SAL' . str_pad('18', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000019',
                'user_id'           => 'USR000001',
                'sale_amount'       => 0,
                'payment_method'    => 'cash',
                'transaction_status'=> 'processing',
                'sale_status'       => 'continue',
                'sale_notes'        => 'Pembayaran diterima, sedang memproses pesanan',
                'created_at'        => '2025-02-02 10:35:00',
                'updated_at'        => '2025-02-02 10:35:00',
            ],
            [
                'sale_id'           => 'SAL' . str_pad('19', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000023',
                'user_id'           => 'USR000003',
                'sale_amount'       => 0,
                'payment_method'    => 'credit_card',
                'transaction_status'=> 'processing',
                'sale_status'       => 'continue',
                'sale_notes'        => 'Verifikasi kartu kredit dalam proses',
                'created_at'        => '2025-02-03 13:15:00',
                'updated_at'        => '2025-02-03 13:15:00',
            ],
            [
                'sale_id'           => 'SAL' . str_pad('20', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000024',
                'user_id'           => 'USR000002',
                'sale_amount'       => 0,
                'payment_method'    => 'e-wallet',
                'transaction_status'=> 'processing',
                'sale_status'       => 'continue',
                'sale_notes'        => 'Pembayaran via ShopeePay dalam proses',
                'created_at'        => '2025-02-04 15:30:00',
                'updated_at'        => '2025-02-04 15:30:00',
            ],
            
            // 5 transaksi dengan status pending
            [
                'sale_id'           => 'SAL' . str_pad('21', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000007',
                'user_id'           => 'USR000001',
                'sale_amount'       => 0,
                'payment_method'    => 'debit_card',
                'transaction_status'=> 'pending',
                'sale_status'       => 'continue',
                'sale_notes'        => 'Menunggu pembayaran dari pelanggan',
                'created_at'        => '2025-02-05 09:20:00',
                'updated_at'        => '2025-02-05 09:20:00',
            ],
            [
                'sale_id'           => 'SAL' . str_pad('22', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000013',
                'user_id'           => 'USR000002',
                'sale_amount'       => 0,
                'payment_method'    => 'cash',
                'transaction_status'=> 'pending',
                'sale_status'       => 'continue',
                'sale_notes'        => 'Pelanggan akan membayar saat pengambilan',
                'created_at'        => '2025-02-06 11:45:00',
                'updated_at'        => '2025-02-06 11:45:00',
            ],
            [
                'sale_id'           => 'SAL' . str_pad('23', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000016',
                'user_id'           => 'USR000003',
                'sale_amount'       => 0,
                'payment_method'    => 'credit_card',
                'transaction_status'=> 'pending',
                'sale_status'       => 'continue',
                'sale_notes'        => 'Menunggu informasi kartu kredit',
                'created_at'        => '2025-02-07 14:05:00',
                'updated_at'        => '2025-02-07 14:05:00',
            ],
            [
                'sale_id'           => 'SAL' . str_pad('24', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000021',
                'user_id'           => 'USR000001',
                'sale_amount'       => 0,
                'payment_method'    => 'e-wallet',
                'transaction_status'=> 'pending',
                'sale_status'       => 'continue',
                'sale_notes'        => 'Menunggu pembayaran via e-wallet',
                'created_at'        => '2025-02-08 10:50:00',
                'updated_at'        => '2025-02-08 10:50:00',
            ],
            [
                'sale_id'           => 'SAL' . str_pad('25', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000026',
                'user_id'           => 'USR000002',
                'sale_amount'       => 0,
                'payment_method'    => 'debit_card',
                'transaction_status'=> 'pending',
                'sale_status'       => 'continue',
                'sale_notes'        => 'Menunggu konfirmasi pembayaran',
                'created_at'        => '2025-02-09 13:30:00',
                'updated_at'        => '2025-02-09 13:30:00',
            ],
            
            // 5 transaksi dengan status cancelled
            [
                'sale_id'           => 'SAL' . str_pad('26', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000025',
                'user_id'           => 'USR000003',
                'sale_amount'       => 0,
                'payment_method'    => 'credit_card',
                'transaction_status'=> 'cancelled',
                'sale_status'       => 'cancel',
                'sale_notes'        => 'Dibatalkan oleh pelanggan - stok tidak tersedia',
                'created_at'        => '2025-02-10 09:15:00',
                'updated_at'        => '2025-02-10 11:20:00',
            ],
            [
                'sale_id'           => 'SAL' . str_pad('27', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000027',
                'user_id'           => 'USR000001',
                'sale_amount'       => 0,
                'payment_method'    => 'e-wallet',
                'transaction_status'=> 'cancelled',
                'sale_status'       => 'cancel',
                'sale_notes'        => 'Pembayaran gagal - timeout',
                'created_at'        => '2025-02-11 14:40:00',
                'updated_at'        => '2025-02-11 15:30:00',
            ],
            [
                'sale_id'           => 'SAL' . str_pad('28', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000028',
                'user_id'           => 'USR000002',
                'sale_amount'       => 0,
                'payment_method'    => 'debit_card',
                'transaction_status'=> 'cancelled',
                'sale_status'       => 'cancel',
                'sale_notes'        => 'Kartu ditolak oleh bank',
                'created_at'        => '2025-02-12 10:25:00',
                'updated_at'        => '2025-02-12 11:15:00',
            ],
            [
                'sale_id'           => 'SAL' . str_pad('29', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000029',
                'user_id'           => 'USR000003',
                'sale_amount'       => 0,
                'payment_method'    => 'cash',
                'transaction_status'=> 'cancelled',
                'sale_status'       => 'cancel',
                'sale_notes'        => 'Pelanggan membatalkan pesanan',
                'created_at'        => '2025-02-13 13:10:00',
                'updated_at'        => '2025-02-13 14:05:00',
            ],
            [
                'sale_id'           => 'SAL' . str_pad('30', 6, '0', STR_PAD_LEFT),
                'customer_id'       => 'CUS000030',
                'user_id'           => 'USR000001',
                'sale_amount'       => 0,
                'payment_method'    => 'credit_card',
                'transaction_status'=> 'cancelled',
                'sale_status'       => 'cancel',
                'sale_notes'        => 'Dibatalkan - alamat pengiriman tidak valid',
                'created_at'        => '2025-02-14 15:50:00',
                'updated_at'        => '2025-02-14 16:30:00',
            ],
        ];

        $this->db->table('sales')->insertBatch($data);
    }
}