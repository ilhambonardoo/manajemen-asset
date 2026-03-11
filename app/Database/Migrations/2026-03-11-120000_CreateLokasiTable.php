<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLokasiTable extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'kode'        => [
				'type'       => 'VARCHAR',
				'constraint' => 50,
				'unique'     => true,
			],
			'nama'        => [
				'type'       => 'VARCHAR',
				'constraint' => 100,
			],
			'created_at'  => [
				'type' => 'DATETIME',
				'null' => true,
			],
			'updated_at'  => [
				'type' => 'DATETIME',
				'null' => true,
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('lokasi_asset');

		$data = [
			['kode' => 'L001', 'nama' => 'Director Room'],
			['kode' => 'L002', 'nama' => 'Finance Room'],
			['kode' => 'L003', 'nama' => 'Office 1'],
			['kode' => 'L004', 'nama' => 'Office 2'],
			['kode' => 'L005', 'nama' => 'Ruang Meeting Jakarta'],
			['kode' => 'L006', 'nama' => 'Ruang Meeting Surabaya'],
			['kode' => 'L007', 'nama' => 'Ruang Meeting Yogyakarta'],
			['kode' => 'L008', 'nama' => 'Ruang Meeting Bali'],
			['kode' => 'L009', 'nama' => 'Live Streaming Room'],
			['kode' => 'L010', 'nama' => 'Pantry'],
			['kode' => 'L011', 'nama' => 'Lobby'],
			['kode' => 'L012', 'nama' => 'Gudang'],
		];

		$this->db->table('lokasi_asset')->insertBatch($data);
	}

	public function down()
	{
		$this->forge->dropTable('lokasi_asset');
	}
}
