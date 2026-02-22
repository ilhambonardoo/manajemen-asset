<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMetodePenyusutanToAssets extends Migration {
	public function up() {
		$fields = [
			'metode_penyusutan' => [
				'type' => 'VARCHAR',
				'constraint' => '50',
				'default' => 'Garis Lurus', // Default value
				'after' => 'umur_penyusutan',
			],
		];
		$this->forge->addColumn('assets', $fields);
	}

	public function down() {
		$this->forge->dropColumn('assets', 'metode_penyusutan');
	}
}
