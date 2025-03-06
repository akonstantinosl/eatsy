<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSuppliersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'supplier_id'     => ['type' => 'VARCHAR', 'constraint' => 20],
            'supplier_name'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'supplier_phone'  => ['type' => 'VARCHAR', 'constraint' => 20],
            'supplier_address'=> ['type' => 'TEXT'],
            'supplier_status' => ['type' => 'ENUM', 'constraint' => ['active', 'inactive'], 'default' => 'active'],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('supplier_id');
        $this->forge->createTable('suppliers');
    }

    public function down()
    {
        $this->forge->dropTable('suppliers');
    }
}
