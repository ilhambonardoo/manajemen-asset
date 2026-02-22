<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ResetAssets extends Seeder {
	public function run() {
		$this->db->disableForeignKeyChecks();
		$this->db->table('assets')->truncate();
		$this->db->enableForeignKeyChecks();
	}
}
