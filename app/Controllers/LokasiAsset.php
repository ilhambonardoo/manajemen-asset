<?php

namespace App\Controllers;

use App\Models\AssetModel;
use App\Models\RiwayatLokasiModel;
use App\Models\LokasiModel;

class LokasiAsset extends BaseController {
	protected $assetModel;
	protected $riwayatModel;
	protected $lokasiModel;

	public function __construct() {
		$this->assetModel = new AssetModel();
		$this->riwayatModel = new RiwayatLokasiModel();
		$this->lokasiModel = new LokasiModel();
	}
	
	public function index() {
		$filter_nama = $this->request->getGet('filter_nama');
		
		if (!empty($filter_nama)) {
			$data['lokasi'] = $this->lokasiModel->where('nama', $filter_nama)->findAll();
		} else {
			$data['lokasi'] = $this->lokasiModel->findAll();
		}
		
		return view('lokasi/index', $data);
	}
	
	public function tambahLokasi() {
		$nama = $this->request->getPost('nama_lokasi');
		
		if (empty($nama)) {
			return $this->response->setJSON([
				'success' => false,
				'message' => 'Nama lokasi tidak boleh kosong'
			])->setStatusCode(400);
		}

		$existingLokasi = $this->lokasiModel->where('nama', $nama)->first();
		if ($existingLokasi) {
			return $this->response->setJSON([
				'success' => false,
				'message' => 'Lokasi sudah terdaftar'
			])->setStatusCode(400);
		}

		$kode = $this->lokasiModel->generateKode();

		if ($this->lokasiModel->save([
			'kode' => $kode,
			'nama' => $nama,
		])) {
			return $this->response->setJSON([
				'success' => true,
				'message' => 'Lokasi berhasil ditambahkan',
				'kode' => $kode,
				'nama' => $nama,
			]);
		}

		return $this->response->setJSON([
			'success' => false,
			'message' => 'Gagal menambahkan lokasi'
		])->setStatusCode(500);
	}

	public function penempatan($kode_lokasi, $nama_lokasi) {
		$data['aset_tersedia'] = $this->assetModel
			->where('lokasi_aset', null)
			->orWhere('lokasi_aset', '')
			->orWhere('lokasi_aset !=', $nama_lokasi)
			->findAll();

		$data['kode_lokasi'] = $kode_lokasi;
		$data['nama_lokasi'] = urldecode($nama_lokasi);

		return view('lokasi/penempatan', $data);
	}

	public function simpan_penempatan() {
		$lokasi_tujuan = $this->request->getPost('nama_lokasi');
		$tanggal_penempatan = $this->request->getPost('tanggal');
		$aset_terpilih = $this->request->getPost('aset_id');

		if (!empty($aset_terpilih)) {
			foreach ($aset_terpilih as $id_aset) {
				$currentAsset = $this->assetModel->find($id_aset);
				$lokasi_lama = $currentAsset['lokasi_aset'] ?? '-';

				$this->assetModel->update($id_aset, [
					'lokasi_aset' => $lokasi_tujuan,
				]);

				$this->riwayatModel->insert([
					'asset_id' => $id_aset,
					'lokasi_lama' => $lokasi_lama,
					'lokasi_baru' => $lokasi_tujuan,
					'tanggal_pindah' => $tanggal_penempatan,
					'keterangan' => 'Penempatan Aset via Menu Lokasi',
				]);
			}
			return redirect()
				->to('/lokasi/detail/' . urlencode($lokasi_tujuan))
				->with('success', 'Aset berhasil ditempatkan!');
		}

		return redirect()->back()->with('error', 'Pilih minimal satu aset untuk ditempatkan.');
	}

	public function detail($nama_lokasi) {
		$nama_lokasi = urldecode($nama_lokasi);

		$data['aset_diruangan'] = $this->assetModel->where('lokasi_aset', $nama_lokasi)->findAll();
		$data['nama_lokasi'] = $nama_lokasi;

		return view('lokasi/detail', $data);
	}

	public function delete($id) {
		$lokasi = $this->lokasiModel->find($id);
		if (!$lokasi) {
			return redirect()->to('/lokasi')->with('error', 'Lokasi tidak ditemukan.');
		}

		$asetCount = $this->assetModel->where('lokasi_aset', $lokasi['nama'])->countAllResults();
		if ($asetCount > 0) {
			return redirect()->back()->with('error', 'Tidak dapat menghapus lokasi yang masih memiliki aset. Pindahkan semua aset terlebih dahulu.');
		}

		if ($this->lokasiModel->delete($id)) {
			return redirect()->to('/lokasi')->with('success', 'Lokasi berhasil dihapus.');
		}

		return redirect()->back()->with('error', 'Gagal menghapus lokasi.');
	}
}
