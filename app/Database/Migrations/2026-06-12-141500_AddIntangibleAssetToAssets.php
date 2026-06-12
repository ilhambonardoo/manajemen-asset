<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIntangibleAssetToAssets extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE assets MODIFY kelompok_aset ENUM('office equipment','furniture/fixture (non metal)','furniture/fixture (metal)','booth','intangible asset') NOT NULL");
    }

    public function down()
    {
        $this->db->query("ALTER TABLE assets MODIFY kelompok_aset ENUM('office equipment','furniture/fixture (non metal)','furniture/fixture (metal)','booth') NOT NULL");
    }
}
