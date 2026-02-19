<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration {
	public function up() {
		$this->forge->addField([
			'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
			'username' => ['type' => 'VARCHAR', 'constraint' => '100', 'unique' => true],
			'email' => ['type' => 'VARCHAR', 'constraint' => '100', 'unique' => true],
			'password' => ['type' => 'VARCHAR', 'constraint' => '255'],
			'nama_divisi' => ['type' => 'VARCHAR', 'constraint' => '100'],
			'jabatan' => ['type' => 'VARCHAR', 'constraint' => '100'],
			'role_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true], // Foreign Key ke roles
			'created_at' => ['type' => 'DATETIME', 'null' => true],
			'updated_at' => ['type' => 'DATETIME', 'null' => true],
		]);
		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('role_id', 'roles', 'id', 'CASCADE', 'RESTRICT');
		$this->forge->createTable('users');
	}

	public function down() {
		// Mematikan pengecekan foreign key sementara agar tidak error saat hapus tabel
		$this->db->query('SET FOREIGN_KEY_CHECKS=0');
		$this->forge->dropTable('users', true);
		$this->db->query('SET FOREIGN_KEY_CHECKS=1');
	}
}
