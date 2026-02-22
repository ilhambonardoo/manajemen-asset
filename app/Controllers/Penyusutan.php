<?php

namespace App\Controllers;

use App\Models\AssetModel;
use DateTime;

class Penyusutan extends BaseController {
	protected $assetModel;

	public function __construct() {
		$this->assetModel = new AssetModel();
	}

	public function index() {
		$bulanPilih = $this->request->getGet('bulan') ?? date('n');
		$tahunPilih = $this->request->getGet('tahun') ?? date('Y');

		$targetDateStr = $tahunPilih . '-' . sprintf('%02d', $bulanPilih) . '-01';
		$targetDate = new DateTime($targetDateStr);

		$assets = $this->assetModel->where('status_aktif', 1)->findAll();
		$dataPenyusutan = [];

		foreach ($assets as $asset) {
			$tanggalBeli = new DateTime($asset['tanggal_perolehan']);
			$hariBeli = (int) $tanggalBeli->format('d');

			$hargaPerolehan = (float) $asset['harga_perolehan'];
			$umurBulan = (int) $asset['umur_penyusutan'];
			$bebanPerBulan = $umurBulan > 0 ? $hargaPerolehan / $umurBulan : 0;

			$startAccurate = clone $tanggalBeli;
			$startAccurate->modify('first day of this month');
			if ($hariBeli >= 16) {
				$startAccurate->modify('+1 month');
			}

			$startKingdee = clone $tanggalBeli;
			$startKingdee->modify('first day of this month');
			$startKingdee->modify('+1 month');

			$bulanJalanAccurate = 0;
			if ($targetDate >= $startAccurate) {
				$diff = $startAccurate->diff($targetDate);
				$bulanJalanAccurate = $diff->y * 12 + $diff->m + 1;
			}

			$bulanJalanKingdee = 0;
			if ($targetDate >= $startKingdee) {
				$diff = $startKingdee->diff($targetDate);
				$bulanJalanKingdee = $diff->y * 12 + $diff->m + 1;
			}

			$sisaUmurAccurate = max(0, $umurBulan - $bulanJalanAccurate);
			$akumulasiAcc = min($bulanJalanAccurate, $umurBulan) * $bebanPerBulan;
			$nilaiBukuAccurate = max(0, $hargaPerolehan - $akumulasiAcc);

			$sisaUmurKingdee = max(0, $umurBulan - $bulanJalanKingdee);
			$akumulasiKgd = min($bulanJalanKingdee, $umurBulan) * $bebanPerBulan;
			$nilaiBukuKingdee = max(0, $hargaPerolehan - $akumulasiKgd);

			$penyusutanAccurate = $bulanJalanAccurate > 0 && $bulanJalanAccurate <= $umurBulan ? $bebanPerBulan : 0;
			$penyusutanKingdee = $bulanJalanKingdee > 0 && $bulanJalanKingdee <= $umurBulan ? $bebanPerBulan : 0;

			$selisihBulanIni = abs($penyusutanAccurate - $penyusutanKingdee);

			$dataPenyusutan[] = [
				'kode_aset' => $asset['kode_aset'],
				'nama_aset' => $asset['nama_aset'],
				'tanggal_beli' => $asset['tanggal_perolehan'],
				'sisa_umur_acc' => $sisaUmurAccurate,
				'sisa_umur_kgd' => $sisaUmurKingdee,
				'nilai_buku_acc' => $nilaiBukuAccurate,
				'nilai_buku_kgd' => $nilaiBukuKingdee,
				'accurate' => $penyusutanAccurate,
				'kingdee' => $penyusutanKingdee,
				'selisih' => $selisihBulanIni,
			];
		}

		$data = [
			'title' => 'Laporan Penyusutan Aset',
			'bulan_pilih' => $bulanPilih,
			'tahun_pilih' => $tahunPilih,
			'data_penyusutan' => $dataPenyusutan,
		];

		return view('penyusutan/index', $data);
	}
}
