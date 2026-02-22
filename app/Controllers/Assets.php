<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AssetModel;
use App\Models\PenjualanAssetModel;
use App\Models\RiwayatLokasiModel;

class Assets extends BaseController {
	protected $penjualanModel;
	protected $assetModel;
	protected $lokasiModel;

	public function __construct() {
		$this->penjualanModel = new PenjualanAssetModel();
		$this->assetModel = new AssetModel();
		$this->lokasiModel = new RiwayatLokasiModel();
	}

	public function index() {
		$assets = $this->assetModel->orderBy('kode_aset', 'ASC')->findAll();
		$pendingJualan = $this->penjualanModel->where('status_approval', 'Pending')->findAll();
		$pendingAssetIds = array_column($pendingJualan, 'asset_id');

		$data = [
			'title' => 'Daftar Aset Tetap',
			'assets' => $assets,
			'pending_ids' => $pendingAssetIds,
		];

		return view('assets/daftar', $data);
	}

	public function create() {
		session();
		$data = [
			'title' => 'Tambah Aset Baru',
			'validation' => \Config\Services::validation(),
		];

		if (session()->getFlashdata('validation')) {
			$data['validation'] = session()->getFlashdata('validation');
		}

		return view('assets/create', $data);
	}

	public function store() {
		if (
			!$this->validate([
				'kode_aset' => [
					'rules' => 'required|is_unique[assets.kode_aset]',
					'errors' => [
						'required' => 'Kode aset wajib diisi.',
						'is_unique' => 'Kode aset sudah digunakan, silakan gunakan kode lain.',
					],
				],
				'nama_aset' => 'required',
				'kelompok_aset' => 'required',
				'jumlah_aset' => 'required|numeric',
				'harga_satuan' => 'required|numeric',
				'tanggal_perolehan' => 'required',
				'harga_perolehan' => 'required|numeric',
				'umur_penyusutan' => 'required|numeric',
				'lokasi_aset' => 'required',
			])
		) {
			return redirect()->back()->withInput()->with('validation', $this->validator);
		}

		if (
			!$this->assetModel->save([
				'kode_aset' => $this->request->getPost('kode_aset'),
				'nama_aset' => $this->request->getPost('nama_aset'),
				'kelompok_aset' => $this->request->getPost('kelompok_aset'),
				'jumlah_aset' => $this->request->getPost('jumlah_aset'),
				'harga_satuan' => $this->request->getPost('harga_satuan'),
				'harga_perolehan' => $this->request->getPost('harga_perolehan'),
				'umur_penyusutan' => $this->request->getPost('umur_penyusutan'),
				'metode_penyusutan' => $this->request->getPost('metode_penyusutan'),
				'tanggal_perolehan' => $this->request->getPost('tanggal_perolehan'),
				'lokasi_aset' => $this->request->getPost('lokasi_aset'),
				'status_aktif' => 1,
			])
		) {
			return redirect()
				->back()
				->withInput()
				->with('errors', $this->assetModel->errors());
		}

		session()->setFlashdata('pesan', 'Data aset berhasil ditambahkan!');

		return redirect('asset/daftar');
	}

	public function edit($id) {
		$data = [
			'title' => 'Edit Data Aset',
			'validation' => \Config\Services::validation(),
			'asset' => $this->assetModel->find($id),
		];

		if (empty($data['asset'])) {
			return redirect()->to('/assets');
		}

		return view('assets/edit', $data);
	}

	public function update($id) {
		$this->assetModel->skipValidation(true);

		$this->assetModel->update($id, [
			'kode_aset' => $this->request->getPost('kode_aset'),
			'nama_aset' => $this->request->getPost('nama_aset'),
			'kelompok_aset' => $this->request->getPost('kelompok_aset'),
			'harga_perolehan' => $this->request->getPost('harga_perolehan'),
			'umur_penyusutan' => $this->request->getPost('umur_penyusutan'),
			'tanggal_perolehan' => $this->request->getPost('tanggal_perolehan'),
			'sumber_data' => $this->request->getPost('sumber_data'),
			'status_aktif' => $this->request->getPost('status_aktif'),
		]);

		session()->setFlashdata('pesan', 'Data aset berhasil diperbarui!');
		return redirect()->to('asset/daftar');
	}

	public function delete($id) {
		$asset = $this->assetModel->find($id);
		if ($asset) {
			$this->assetModel->delete($id);
			session()->setFlashdata('pesan', 'Data aset berhasil dihapus!');
		}

		return redirect()->to('asset/daftar');
	}

	public function ajukan() {
		$data = [
			'asset_id' => $this->request->getPost('asset_id'),
			'tanggal_penjualan' => $this->request->getPost('tanggal_penjualan'),
			'harga_jual' => $this->request->getPost('harga_jual'),
			'alasan_dijual' => $this->request->getPost('alasan_dijual'),
			'status_approval' => 'Pending',
		];

		$this->penjualanModel->save($data);

		session()->setFlashdata('pesan', 'Pengajuan penjualan aset berhasil dikirim! Menunggu persetujuan Admin.');
		return redirect()->to(base_url('asset/daftar'));
	}

	public function detail($id) {
		$asset = $this->assetModel->find($id);
		if (!$asset) {
			session()->setFlashdata('error', 'Data aset tidak ditemukan!');
			return redirect()->to(base_url('asset'));
		}

		$data = [
			'title' => 'Detail & Kelola Aset',
			'asset' => $asset,
			'riwayat_lokasi' => $this->lokasiModel->getRiwayatByAsset($id),
		];

		return view('assets/detail', $data);
	}

	public function simpanLokasi() {
		$asset_id = $this->request->getPost('asset_id');
		$lokasi_baru = $this->request->getPost('lokasi_baru');

		$asset = $this->assetModel->find($asset_id);

		$this->lokasiModel->save([
			'asset_id' => $asset_id,
			'lokasi_lama' => $asset['lokasi_aset'],
			'lokasi_baru' => $lokasi_baru,
			'tanggal_pindah' => $this->request->getPost('tanggal_pindah'),
			'keterangan' => $this->request->getPost('keterangan'),
		]);

		$this->assetModel->update($asset_id, [
			'lokasi_aset' => $lokasi_baru,
		]);

		session()->setFlashdata('pesan', 'Lokasi aset berhasil dipindahkan!');
		return redirect()->to(base_url('asset/detail/' . $asset_id));
	}
}
