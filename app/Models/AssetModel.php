<?php

namespace App\Models;

use CodeIgniter\Model;

class AssetModel extends Model {
	protected $table = 'assets';
	protected $primaryKey = 'id';
	protected $useAutoIncrement = true;
	protected $returnType = 'array';
	protected $useSoftDeletes = false;
	protected $protectFields = true;
	protected $allowedFields = [
		'kode_aset',
		'nama_aset',
		'kelompok_aset',
		'jumlah_aset',
		'harga_satuan',
		'harga_perolehan',
		'umur_penyusutan',
		'metode_penyusutan',
		'tanggal_perolehan',
		'lokasi_aset',
		'sumber_data',
		'status_aktif',
	];

	protected bool $allowEmptyInserts = false;
	protected bool $updateOnlyChanged = true;

	protected array $casts = [];
	protected array $castHandlers = [];

	protected $useTimestamps = true;
	protected $dateFormat = 'datetime';
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';

	protected $validationRules = [
		'kode_aset' => 'required|is_unique[assets.kode_aset]',
		'nama_aset' => 'required|min_length[3]',
		'harga_perolehan' => 'required|numeric',
		'metode_penyusutan' => 'required',
		'tanggal_perolehan' => 'required|valid_date',
	];
	protected $validationMessages = [
		'kode_aset' => [
			'is_unique' => 'Kode Aset ini sudah terdaftar, mohon gunakan kode lain.',
		],
	];
	protected $skipValidation = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks = true;
	protected $beforeInsert = [];
	protected $afterInsert = [];
	protected $beforeUpdate = [];
	protected $afterUpdate = [];
	protected $beforeFind = [];
	protected $afterFind = [];
	protected $beforeDelete = [];
	protected $afterDelete = [];

	public function getTotalAssetValue() {
		$query = $this->selectSum('harga_perolehan')->where('status_aktif', 1)->first();
		return $query['harga_perolehan'] ?? 0;
	}

	public function getCountBySource($source) {
		return $this->where('sumber_data', $source)->countAllResults();
	}

	public function getAcquisitionPerYear() {
		return $this->select('YEAR(tanggal_perolehan) as tahun, COUNT(*) as total, SUM(harga_perolehan) as nilai')
			->groupBy('YEAR(tanggal_perolehan)')
			->orderBy('tahun', 'ASC')
			->findAll();
	}
}
