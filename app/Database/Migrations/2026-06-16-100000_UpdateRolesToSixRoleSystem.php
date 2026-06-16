<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateRolesToSixRoleSystem extends Migration {
	public function up() {
		// Disable foreign key checks temporarily
		$this->db->query('SET FOREIGN_KEY_CHECKS=0');

		// Delete existing roles with WHERE clause
		$this->db->table('roles')->where('id >', 0)->delete();

		// Re-enable foreign key checks
		$this->db->query('SET FOREIGN_KEY_CHECKS=1');

		// Insert the 6 new roles
		$data = [
			[
				'id' => 1,
				'role_name' => 'Admin',
				'description' => 'Full access, user management, approve all data'
			],
			[
				'id' => 2,
				'role_name' => 'Manager',
				'description' => 'Read reports, approve asset sales and termination'
			],
			[
				'id' => 3,
				'role_name' => 'Supervisor',
				'description' => 'Read-only: view asset list, depreciation values, and reports'
			],
			[
				'id' => 4,
				'role_name' => 'Staff Finance',
				'description' => 'CRUD assets: input acquisition, view, edit, delete assets'
			],
			[
				'id' => 5,
				'role_name' => 'Staff Accounting',
				'description' => 'Manage asset list, depreciation and variances, propose asset sales/termination'
			],
			[
				'id' => 6,
				'role_name' => 'Staff GA',
				'description' => 'Read-only: view asset list and asset location reports'
			],
		];

		$this->db->table('roles')->insertBatch($data);
	}

	public function down() {
		// Disable foreign key checks temporarily
		$this->db->query('SET FOREIGN_KEY_CHECKS=0');

		// Delete roles with WHERE clause
		$this->db->table('roles')->where('id >', 0)->delete();

		// Re-enable foreign key checks
		$this->db->query('SET FOREIGN_KEY_CHECKS=1');

		// Restore old roles
		$oldData = [
			[
				'role_name' => 'Admin',
				'description' => 'Mengelola seluruh data, user, dan approval'
			],
			[
				'role_name' => 'Supervisor',
				'description' => 'Input/edit aset, kelola penyusutan dan perbaikan'
			],
			[
				'role_name' => 'Manager',
				'description' => 'Approval penjualan/penghentian dan view laporan'
			],
			[
				'role_name' => 'Staff Finance',
				'description' => 'Input perolehan dan update data, tanpa akses hapus'
			],
			[
				'role_name' => 'Tim China',
				'description' => 'View data, laporan, dan penyusutan saja'
			],
		];

		$this->db->table('roles')->insertBatch($oldData);
	}
}
