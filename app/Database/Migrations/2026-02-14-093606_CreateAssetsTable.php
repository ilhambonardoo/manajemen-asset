<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAssetsTable extends Migration {
	public function up() {
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
				'auto_increment' => true,
			],
			'kode_aset' => [
				'type' => 'VARCHAR',
				'constraint' => '100',
				'unique' => true,
			],
			'nama_aset' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
			],
			'kelompok_aset' => [
				'type' => 'ENUM',
				'constraint' => [
					'office equipment',
					'furniture/fixture (non metal)',
					'furniture/fixture (metal)',
					'booth',
				],
			],
			'jumlah_aset' => [
				'type' => 'INT',
				'constraint' => 11,
				'default' => 1,
			],
			'harga_perolehan' => [
				'type' => 'DECIMAL',
				'constraint' => '15,2',
			],
			'umur_penyusutan' => [
				'type' => 'INT',
				'constraint' => 5,
			],
			'tanggal_perolehan' => [
				'type' => 'DATE',
			],
			'lokasi_aset' => [
				'type' => 'VARCHAR',
				'constraint' => '100',
			],
			'sumber_data' => [
				'type' => 'ENUM',
				'constraint' => ['Accurate', 'Kingdee', 'Manual Input'],
			],
			'status_aktif' => [
				'type' => 'BOOLEAN',
				'default' => true,
			],
			'created_at' => ['type' => 'DATETIME', 'null' => true],
			'updated_at' => ['type' => 'DATETIME', 'null' => true],
		]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('assets');
	}

	public function down() {
		$this->forge->dropTable('assets');
	}
}
