<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSalesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'sale_id'            => ['type' => 'VARCHAR', 'constraint' => 20],
            'customer_id'        => ['type' => 'VARCHAR', 'constraint' => 20],
            'user_id'            => ['type' => 'VARCHAR', 'constraint' => 20],
            'sale_amount'        => ['type' => 'FLOAT', 'constraint' => 20, 'default' => 0],
            'payment_method'     => ['type' => 'ENUM', 'constraint' => ['cash', 'credit_card', 'debit_card', 'e-wallet'], 'default' => 'cash'],
            'transaction_status' => ['type' => 'ENUM', 'constraint' => ['pending', 'processing', 'completed', 'cancelled'], 'default' => 'pending'],
            'sale_status'        => ['type' => 'ENUM', 'constraint' => ['continue', 'cancel'], 'default' => 'continue'],
            'sale_notes'         => ['type' => 'TEXT', 'null' => true],
            'created_at'         => ['type' => 'DATETIME', 'null' => true],
            'updated_at'         => ['type' => 'DATETIME', 'null' => true],
        ]);
        
        $this->forge->addPrimaryKey('sale_id');
        $this->forge->addForeignKey('customer_id', 'customers', 'customer_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'user_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('sales');
    }

    public function down()
    {
        $this->forge->dropTable('sales');
    }
}