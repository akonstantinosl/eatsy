<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id'          => ['type' => 'VARCHAR', 'constraint' => 20],
            'user_name'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'user_password'    => ['type' => 'VARCHAR', 'constraint' => 255],
            'user_role'        => ['type' => 'ENUM', 'constraint' => ['admin', 'staff'], 'default' => 'staff'],
            'user_fullname'    => ['type' => 'VARCHAR', 'constraint' => 255],
            'user_phone'       => ['type' => 'VARCHAR', 'constraint' => 20],
            'user_photo'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'user_status'      => ['type' => 'ENUM', 'constraint' => ['active', 'inactive'], 'default' => 'active'],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('user_id');
        $this->forge->createTable('users');
    }
    public function down()
    {
        $this->forge->dropTable('users');
    }
}