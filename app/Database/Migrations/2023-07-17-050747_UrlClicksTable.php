<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UrlClicksTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'shorten_url_id' => [
                'type' => 'INT',
            ],
            'device' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'platform' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'browser' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('url_clicks');
    }

    public function down()
    {
        //
    }
}
