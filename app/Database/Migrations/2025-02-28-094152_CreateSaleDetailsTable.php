<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSaleDetailsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'sale_detail_id' => ['type' => 'VARCHAR', 'constraint' => 20],
            'sale_id'        => ['type' => 'VARCHAR', 'constraint' => 20],
            'product_id'     => ['type' => 'VARCHAR', 'constraint' => 20],
            'quantity_sold'  => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'price_per_unit' => ['type' => 'FLOAT', 'constraint' => 20, 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        
        $this->forge->addPrimaryKey('sale_detail_id');
        $this->forge->addForeignKey('sale_id', 'sales', 'sale_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'products', 'product_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('sale_details');
    }

    public function down()
    {
        $this->forge->dropTable('sale_details');
    }
}