<?php

namespace App\Controllers;

use App\Models\AssetModel;
use App\Models\RiwayatLokasiModel;

class LokasiAsset extends BaseController {
	protected $assetModel;
	protected $riwayatModel;

	public function __construct() {
		$this->assetModel = new AssetModel();
		$this->riwayatModel = new RiwayatLokasiModel();
	}
	public function index() {
		$data['lokasi'] = [
			['kode' => 'L001', 'nama' => 'Director Room'],
			['kode' => 'L002', 'nama' => 'Finance Room'],
			['kode' => 'L003', 'nama' => 'Office 1'],
			['kode' => 'L004', 'nama' => 'Office 2'],
			['kode' => 'L005', 'nama' => 'Ruang Meeting Jakarta'],
			['kode' => 'L006', 'nama' => 'Ruang Meeting Surabaya'],
			['kode' => 'L007', 'nama' => 'Ruang Meeting Yogyakarta'],
			['kode' => 'L008', 'nama' => 'Ruang Meeting Bali'],
			['kode' => 'L009', 'nama' => 'Live Streaming Room'],
			['kode' => 'L010', 'nama' => 'Pantry'],
			['kode' => 'L011', 'nama' => 'Lobby'],
			['kode' => 'L012', 'nama' => 'Gudang'],
			['kode' => 'L013', 'nama' => 'Lainnya'],
		];

		return view('lokasi/index', $data);
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
}
