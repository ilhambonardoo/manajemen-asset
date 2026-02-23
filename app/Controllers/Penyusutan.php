<?php

namespace App\Controllers;

use App\Models\AssetModel;
use DateTime;

class Penyusutan extends BaseController
{
	protected $assetModel;
	protected $perPage = 25;

	public function __construct()
	{
		$this->assetModel = new AssetModel();
	}

	public function index()
	{
		$bulanPilih = $this->request->getGet('bulan') ?? date('n');
		$tahunPilih = $this->request->getGet('tahun') ?? date('Y');
		$page = $this->request->getGet('page') ?? 1;

		$targetDateStr = $tahunPilih . '-' . sprintf('%02d', $bulanPilih) . '-01';
		$targetDate = new DateTime($targetDateStr);

		$totalAssets = $this->assetModel->where('status_aktif', 1)->countAllResults();

		$offset = ($page - 1) * $this->perPage;

		$assets = $this->assetModel
			->where('status_aktif', 1)
			->limit($this->perPage, $offset)
			->findAll();

		$allAssets = $this->assetModel->where('status_aktif', 1)->findAll();

		$dataPenyusutan = [];
		$totalAccurate = 0;
		$totalKingdee = 0;
		$totalSelisih = 0;
		$totalNilaiBukuAcc = 0;
		$totalNilaiBukuKgd = 0;

		foreach ($allAssets as $asset) {
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

			$totalAccurate += $penyusutanAccurate;
			$totalKingdee += $penyusutanKingdee;
			$totalSelisih += $selisihBulanIni;
			$totalNilaiBukuAcc += $nilaiBukuAccurate;
			$totalNilaiBukuKgd += $nilaiBukuKingdee;
		}

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

		$totalPages = ceil($totalAssets / $this->perPage);

		$data = [
			'title' => 'Laporan Penyusutan Aset',
			'bulan_pilih' => $bulanPilih,
			'tahun_pilih' => $tahunPilih,
			'data_penyusutan' => $dataPenyusutan,
			'bulan_array' => [
				1 => 'Januari',
				2 => 'Februari',
				3 => 'Maret',
				4 => 'April',
				5 => 'Mei',
				6 => 'Juni',
				7 => 'Juli',
				8 => 'Agustus',
				9 => 'September',
				10 => 'Oktober',
				11 => 'November',
				12 => 'Desember',
			],
			'current_page' => $page,
			'total_pages' => $totalPages,
			'total_assets' => $totalAssets,
			'per_page' => $this->perPage,
			'total_accurate' => $totalAccurate,
			'total_kingdee' => $totalKingdee,
			'total_selisih' => $totalSelisih,
			'total_nilai_buku_acc' => $totalNilaiBukuAcc,
			'total_nilai_buku_kgd' => $totalNilaiBukuKgd,
		];

		return view('penyusutan/index', $data);
	}
}
