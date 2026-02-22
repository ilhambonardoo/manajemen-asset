<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePenjualanAssets extends Migration {
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
			'tanggal_penjualan' => [
				'type' => 'DATE',
				'null' => true,
			],
			'harga_jual' => [
				'type' => 'DECIMAL',
				'constraint' => '15,2',
			],
			'alasan_dijual' => [
				'type' => 'TEXT',
				'null' => true,
			],
			'status_approval' => [
				'type' => 'ENUM',
				'constraint' => ['Pending', 'Approved', 'Rejected'],
				'default' => 'Pending',
			],
			'created_at' => ['type' => 'DATETIME', 'null' => true],
			'updated_at' => ['type' => 'DATETIME', 'null' => true],
		]);

		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('asset_id', 'assets', 'id', 'CASCADE', 'CASCADE');
		$this->forge->createTable('penjualan_assets');
	}

	public function down() {
		$this->forge->dropTable('penjualan_assets');
	}
}
