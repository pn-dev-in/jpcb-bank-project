<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAboutPageContent extends Migration
{
    public function up()
    {
        if ($this->db->tableExists('about_page_content')) {
            return;
        }

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'hero_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'hero_subtitle' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'intro_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'intro_description' => [
                'type' => 'TEXT',
            ],
            'mission_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'mission_description' => [
                'type' => 'TEXT',
            ],
            'vision_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'vision_description' => [
                'type' => 'TEXT',
            ],
            'hero_image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'seo_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'seo_description' => [
                'type' => 'TEXT',
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
        $this->forge->createTable('about_page_content', true);
    }

    public function down()
    {
        $this->forge->dropTable('about_page_content', true);
    }
}
