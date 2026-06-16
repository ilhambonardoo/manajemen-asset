<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder {
	public function run() {
		$data = [
			[
				'role_name' => 'Admin',
				'description' => 'Full access, user management, approve all data'
			],
			[
				'role_name' => 'Manager',
				'description' => 'Read reports, approve asset sales and termination'
			],
			[
				'role_name' => 'Supervisor',
				'description' => 'Read-only: view asset list, depreciation values, and reports'
			],
			[
				'role_name' => 'Staff Finance',
				'description' => 'CRUD assets: input acquisition, view, edit, delete assets'
			],
			[
				'role_name' => 'Staff Accounting',
				'description' => 'Manage asset list, depreciation and variances, propose asset sales/termination'
			],
			[
				'role_name' => 'Staff GA',
				'description' => 'Read-only: view asset list and asset location reports'
			],
		];
		$this->db->table('roles')->insertBatch($data);
	}
}
