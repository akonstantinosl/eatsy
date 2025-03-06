<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomerTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'customer_id'     => ['type' => 'VARCHAR', 'constraint' => 20],
            'customer_name'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'customer_phone'  => ['type' => 'VARCHAR', 'constraint' => 20],
            'customer_address'=> ['type' => 'TEXT'],
            'customer_status' => ['type' => 'ENUM', 'constraint' => ['active', 'inactive'], 'default' => 'active'],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('customer_id');
        $this->forge->createTable('customers');
    }

    public function down()
    {
        $this->forge->dropTable('customers');
    }
}
