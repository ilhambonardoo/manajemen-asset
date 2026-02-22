<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MakeSumberDataNullableOrDrop extends Migration {
	public function up() {
		// Make sumber_data nullable just in case we need to revert or for safety
		$fields = [
			'sumber_data' => [
				'type' => 'ENUM',
				'constraint' => ['Accurate', 'Kingdee', 'Manual Input'],
				'null' => true,
			],
		];
		$this->forge->modifyColumn('assets', $fields);
	}

	public function down() {
		$fields = [
			'sumber_data' => [
				'type' => 'ENUM',
				'constraint' => ['Accurate', 'Kingdee', 'Manual Input'],
				'null' => false,
			],
		];
		$this->forge->modifyColumn('assets', $fields);
	}
}
