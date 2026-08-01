<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSiteTranslations extends Migration
{
    public function up()
    {
        if ($this->db->tableExists('site_translations')) {
            return;
        }

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'text_key' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
            ],
            'source_text' => [
                'type' => 'TEXT',
            ],
            'language' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
            ],
            'translation' => [
                'type' => 'TEXT',
            ],
            'context' => [
                'type' => 'VARCHAR',
                'constraint' => 120,
                'null' => true,
            ],
            'status' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'sort_order' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['text_key', 'language']);
        $this->forge->createTable('site_translations', true);
    }

    public function down()
    {
        $this->forge->dropTable('site_translations', true);
    }
}
