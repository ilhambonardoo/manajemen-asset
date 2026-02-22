<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddHargaSatuanToAssets extends Migration {
	public function up() {
		$fields = [
			'harga_satuan' => [
				'type' => 'DECIMAL',
				'constraint' => '15,2',
				'null' => true,
				'after' => 'jumlah_aset',
			],
		];
		$this->forge->addColumn('assets', $fields);
	}

	public function down() {
		$this->forge->dropColumn('assets', 'harga_satuan');
	}
}
