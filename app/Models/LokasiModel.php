<?php

namespace App\Models;

use CodeIgniter\Model;

class LokasiModel extends Model {
	protected $table = 'lokasi_asset';
	protected $primaryKey = 'id';
	protected $useAutoIncrement = true;
	protected $returnType = 'array';
	protected $useSoftDeletes = false;
	protected $protectFields = true;
	protected $allowedFields = [
		'kode',
		'nama',
	];

	protected $useTimestamps = true;
	protected $dateFormat = 'datetime';
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';

	public function generateKode() {
		$lastLokasi = $this->orderBy('id', 'DESC')->first();
		$lastNumber = 0;

		if ($lastLokasi) {
			preg_match('/\d+/', $lastLokasi['kode'], $matches);
			$lastNumber = intval($matches[0] ?? 0);
		}

		return 'L' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
	}
}
