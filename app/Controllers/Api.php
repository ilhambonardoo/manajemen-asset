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
}
