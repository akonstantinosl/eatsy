<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePurchaseDetailsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'purchase_detail_id' => ['type' => 'VARCHAR', 'constraint' => 20],
            'purchase_id'        => ['type' => 'VARCHAR', 'constraint' => 20],
            'product_id'         => ['type' => 'VARCHAR', 'constraint' => 20],
            'box_bought'         => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'unit_per_box'       => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'price_per_box'      => ['type' => 'FLOAT', 'constraint' => 20, 'null' => true],
            'created_at'         => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('purchase_detail_id');
        $this->forge->addForeignKey('purchase_id', 'purchases', 'purchase_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'products', 'product_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('purchase_details');
    }

    public function down()
    {
        $this->forge->dropTable('purchase_details');
    }
}