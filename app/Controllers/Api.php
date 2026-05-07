<?php

namespace App\Controllers;

use App\Models\LokasiModel;

class Api extends BaseController
{
	protected $lokasiModel;

	public function __construct()
	{
		$this->lokasiModel = new LokasiModel();
	}

	public function lokasi()
	{
		$lokasi = $this->lokasiModel->findAll();
		return $this->response->setJSON($lokasi);
	}

	public function generate_kode($prefix)
	{
		$assetModel = new \App\Models\AssetModel();
		$lastAsset = $assetModel->where('kode_aset LIKE', $prefix . '-%')
			->orderBy('kode_aset', 'DESC')
			->first();

		if (!$lastAsset) {
			$nextNumber = 1;
		} else {
			$lastKode = $lastAsset['kode_aset'];
			$parts = explode('-', $lastKode);
			$lastNumber = (int)end($parts);
			$nextNumber = $lastNumber + 1;
		}

		return $this->response->setJSON([
			'next_number' => str_pad($nextNumber, 3, '0', STR_PAD_LEFT)
		]);
	}
}
