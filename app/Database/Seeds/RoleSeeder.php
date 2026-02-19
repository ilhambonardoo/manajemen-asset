<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder {
	public function run() {
		$data = [
			['role_name' => 'Admin', 'description' => 'Mengelola seluruh data, user, dan approval '],
			[
				'role_name' => 'Supervisor',
				'description' => 'Input/edit aset, kelola penyusutan dan perbaikan ',
			],
			[
				'role_name' => 'Manager',
				'description' => 'Approval penjualan/penghentian dan view laporan',
			],
			[
				'role_name' => 'Staff Finance',
				'description' => 'Input perolehan dan update data, tanpa akses hapus ',
			],
			['role_name' => 'Tim China', 'description' => 'View data, laporan, dan penyusutan saja'],
		];
		$this->db->table('roles')->insertBatch($data);
	}
}
