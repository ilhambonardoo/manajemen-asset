<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRiwayatLokasi extends Migration {
	public function up() {
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
				'auto_increment' => true,
			],
			'asset_id' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => true,
			],
			'lokasi_lama' => [
				'type' => 'VARCHAR',
				'constraint' => '100',
			],
			'lokasi_baru' => [
				'type' => 'VARCHAR',
				'constraint' => '100',
			],
			'tanggal_pindah' => [
				'type' => 'DATE',
			],
			'keterangan' => [
				'type' => 'TEXT',
				'null' => true,
			],
			'created_at' => ['type' => 'DATETIME', 'null' => true],
			'updated_at' => ['type' => 'DATETIME', 'null' => true],
		]);

		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('asset_id', 'assets', 'id', 'CASCADE', 'CASCADE');
		$this->forge->createTable('riwayat_lokasi');
	}

	public function down() {
		$this->forge->dropTable('riwayat_lokasi');
	}
}
