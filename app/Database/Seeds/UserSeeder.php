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
				'role_id' => 1,
			],
			[
				'username' => 'spv_amelia',
				'email' => 'amelia@qpon.id',
				'password' => password_hash('spv123', PASSWORD_BCRYPT),
				'nama_divisi' => 'Finance',
				'jabatan' => 'Supervisor Finance',
				'role_id' => 2,
			],
			[
				'username' => 'manager_xyz',
				'email' => 'manager@qpon.id',
				'password' => password_hash('manager123', PASSWORD_BCRYPT),
				'nama_divisi' => 'Management',
				'jabatan' => 'General Manager',
				'role_id' => 3,
			],
			[
				'username' => 'staff_finance',
				'email' => 'finance@qpon.id',
				'password' => password_hash('staff123', PASSWORD_BCRYPT),
				'nama_divisi' => 'Finance',
				'jabatan' => 'Staff',
				'role_id' => 4,
			],
			[
				'username' => 'china_team',
				'email' => 'china@qpon.id',
				'password' => password_hash('china123', PASSWORD_BCRYPT),
				'nama_divisi' => 'Headquarter',
				'jabatan' => 'Analyst',
				'role_id' => 5,
			],
		];

		$this->db->table('users')->insertBatch($data);
	}
}
