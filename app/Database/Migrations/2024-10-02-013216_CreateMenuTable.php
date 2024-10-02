<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMenuTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
                'null'    => false,
            ],
            'parent_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'    => false,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null'    => false,
            ],
            'uri' => [
                'type' => 'TEXT',
                'null'    => false,
            ],
            'link_eksternal' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null'    => false,
            ],
            'urutan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'    => false,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);

        $this->forge->addKey('id', true); // Primary key

        // Create the table
        $this->forge->createTable('manu');
    }

    public function down()
    {
        // Drop the table if it exists
        $this->forge->dropTable('menu');
    }
}
