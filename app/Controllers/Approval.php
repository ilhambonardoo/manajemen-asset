<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AssetModel;
use App\Models\PenjualanAssetModel;

class Approval extends BaseController {
	protected $penjualanModel;
	protected $assetModel;

	public function __construct() {
		$this->penjualanModel = new PenjualanAssetModel();
		$this->assetModel = new AssetModel();
	}

	public function index() {
		$data = [
			'title' => 'Approval Penjualan Aset',
			'pending_approvals' => $this->penjualanModel->getPendingApprovals(),
		];

		return view('approval/index', $data);
	}

	public function approve($id) {
		$pengajuan = $this->penjualanModel->find($id);
		if (!$pengajuan) {
			session()->setFlashdata('error', 'Data pengajuan tidak ditemukan!');
			return redirect()->to(base_url('approval'));
		}

		$this->penjualanModel->update($id, ['status_approval' => 'Approved']);

		$this->assetModel->update($pengajuan['asset_id'], ['status_aktif' => 0]);

		session()->setFlashdata(
			'pesan',
			'Pengajuan penjualan berhasil disetujui (Approved)! Aset telah di-set menjadi Disposed.'
		);
		return redirect()->to(base_url('approval'));
	}

	public function reject($id) {
		$this->penjualanModel->update($id, ['status_approval' => 'Rejected']);

		session()->setFlashdata('error', 'Pengajuan penjualan telah ditolak (Rejected)!');
		return redirect()->to(base_url('approval'));
	}
}
