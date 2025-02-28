<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePurchasesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'purchase_id'        => ['type' => 'VARCHAR', 'constraint' => 20],
            'supplier_id'        => ['type' => 'VARCHAR', 'constraint' => 20],
            'user_id'            => ['type' => 'VARCHAR', 'constraint' => 20],
            'purchase_amount'    => ['type' => 'FLOAT', 'constraint' => 20, 'default' => 0],
            'order_status'       => ['type' => 'ENUM', 'constraint' => ['pending', 'ordered', 'completed', 'cancelled'], 'default' => 'pending'],
            'purchase_status'    => ['type' => 'ENUM', 'constraint' => ['continue', 'cancel'], 'default' => 'continue'],
            'purchase_notes'     => ['type' => 'TEXT', 'null' => true],
            'created_at'         => ['type' => 'DATETIME', 'null' => true],
            'updated_at'         => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('purchase_id');
        $this->forge->addForeignKey('supplier_id', 'suppliers', 'supplier_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'user_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('purchases');
    }

    public function down()
    {
        $this->forge->dropTable('purchases');
    }
}
