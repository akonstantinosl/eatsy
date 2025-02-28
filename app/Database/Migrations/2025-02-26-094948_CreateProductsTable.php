<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'product_id'         => ['type' => 'VARCHAR', 'constraint' => 20],
            'product_name'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'purchase_price'     => ['type' => 'FLOAT', 'constraint' => 20],  
            'selling_price'      => ['type' => 'FLOAT', 'constraint' => 20],  
            'product_stock'      => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'product_category_id'=> ['type' => 'VARCHAR', 'constraint' => 20],
            'product_status'     => ['type' => 'ENUM', 'constraint' => ['active', 'inactive'], 'default' => 'active'],
            'supplier_id'        => ['type' => 'VARCHAR', 'constraint' => 20],
            'created_at'         => ['type' => 'DATETIME', 'null' => true],
            'updated_at'         => ['type' => 'DATETIME', 'null' => true],
        ]);
        
        $this->forge->addPrimaryKey('product_id');
        $this->forge->addForeignKey('product_category_id', 'product_categories', 'product_category_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('supplier_id', 'suppliers', 'supplier_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
