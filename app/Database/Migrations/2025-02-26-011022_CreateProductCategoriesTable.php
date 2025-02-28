<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductCategoriesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'product_category_id'  => ['type' => 'VARCHAR', 'constraint' => 20],
            'product_category_name'=> ['type' => 'VARCHAR', 'constraint' => 50], 
            'created_at'           => ['type' => 'DATETIME', 'null' => true],
            'updated_at'           => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('product_category_id');
        $this->forge->createTable('product_categories');
    }

    public function down()
    {
        $this->forge->dropTable('product_categories');
    }
}
