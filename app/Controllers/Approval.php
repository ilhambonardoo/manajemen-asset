<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AssetModel;
use App\Models\PenjualanAssetModel;

class Approval extends BaseController
{
	protected $penjualanModel;
	protected $assetModel;

	public function __construct()
	{
		$this->penjualanModel = new PenjualanAssetModel();
		$this->assetModel = new AssetModel();
	}

	public function index()
	{
		$jenis = $this->request->getGet('jenis') ?? 'penjualan';

		$data = [
			'title' => 'Approval Aset',
			'jenis_approval' => $jenis,
			'pending_approvals' => $this->penjualanModel->getPendingApprovals($jenis),
		];

		return view('approval/index', $data);
	}

	public function approve($id)
	{
		$pengajuan = $this->penjualanModel->find($id);
		if (!$pengajuan) {
			session()->setFlashdata('error', 'Data pengajuan tidak ditemukan!');
			return redirect()->to(base_url('approval'));
		}

		$jenis = $this->request->getPost('jenis') ?? 'penjualan';
		$this->penjualanModel->update($id, ['status_approval' => 'Approved']);

		$this->assetModel->update($pengajuan['asset_id'], ['status_aktif' => 0]);

		$jenis_text = $jenis === 'penjualan' ? 'penjualan' : 'penghentian';
		session()->setFlashdata(
			'pesan',
			'Pengajuan ' . $jenis_text . ' berhasil disetujui (Approved)! Aset telah di-set menjadi Disposed.'
		);
		return redirect()->to(base_url('approval?jenis=' . $jenis));
	}

	public function reject($id)
	{
		$jenis = $this->request->getPost('jenis') ?? 'penjualan';
		$this->penjualanModel->update($id, ['status_approval' => 'Rejected']);

		$jenis_text = $jenis === 'penjualan' ? 'penjualan' : 'penghentian';
		session()->setFlashdata('error', 'Pengajuan ' . $jenis_text . ' telah ditolak (Rejected)!');
		return redirect()->to(base_url('approval?jenis=' . $jenis));
	}
}
