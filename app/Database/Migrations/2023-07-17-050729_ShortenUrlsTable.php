<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ShortenUrlsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
            ],
            'url' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'short_url' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'code' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'clicks' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'status' => [
                'type' => 'BOOLEAN',
                'default' => '1',
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('shorten_urls');
    }

    public function down()
    {
        //
    }
}
