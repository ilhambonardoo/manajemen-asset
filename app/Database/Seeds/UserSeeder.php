<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder {
	public function run() {
		$data = [
			[
				'username' => 'admin_top',
				'email' => 'admin@qpon.id',
				'password' => password_hash('admin123', PASSWORD_BCRYPT),
				'nama_divisi' => 'IT & Asset Management',
				'jabatan' => 'System Administrator',
				'role_id' => 1, // Admin
			],
			[
				'username' => 'manager_xyz',
				'email' => 'manager@qpon.id',
				'password' => password_hash('manager123', PASSWORD_BCRYPT),
				'nama_divisi' => 'Management',
				'jabatan' => 'General Manager',
				'role_id' => 2, // Manager
			],
			[
				'username' => 'spv_amelia',
				'email' => 'amelia@qpon.id',
				'password' => password_hash('spv123', PASSWORD_BCRYPT),
				'nama_divisi' => 'Finance',
				'jabatan' => 'Supervisor Finance',
				'role_id' => 3, // Supervisor
			],
			[
				'username' => 'staff_finance',
				'email' => 'finance@qpon.id',
				'password' => password_hash('staff123', PASSWORD_BCRYPT),
				'nama_divisi' => 'Finance',
				'jabatan' => 'Staff Finance',
				'role_id' => 4, // Staff Finance
			],
			[
				'username' => 'staff_accounting',
				'email' => 'accounting@qpon.id',
				'password' => password_hash('accounting123', PASSWORD_BCRYPT),
				'nama_divisi' => 'Finance',
				'jabatan' => 'Staff Accounting',
				'role_id' => 5, // Staff Accounting
			],
			[
				'username' => 'staff_ga',
				'email' => 'ga@qpon.id',
				'password' => password_hash('ga123', PASSWORD_BCRYPT),
				'nama_divisi' => 'General Administration',
				'jabatan' => 'Staff GA',
				'role_id' => 6, // Staff GA
			],
		];

		$this->db->table('users')->insertBatch($data);
	}
}
