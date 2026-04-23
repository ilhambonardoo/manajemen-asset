<?php

namespace App\Controllers;

use App\Models\AssetModel;
use DateTime;

class Penyusutan extends BaseController
{
	protected $assetModel;

	public function __construct()
	{
		$this->assetModel = new AssetModel();
	}

	public function index()
	{
		$tipeLaporan = $this->request->getGet('tipe') ?? 'bulanan';
		$bulanPilih = $this->request->getGet('bulan') ?? date('n');
		$tahunPilih = $this->request->getGet('tahun') ?? date('Y');

		if ($tipeLaporan === 'tahunan') {
			$targetDatestr = $tahunPilih . '-12-31';
		} else {
			$targetDatestr = $tahunPilih . '-' . sprintf('%02d', $bulanPilih) . '-01';
		}
		$targetDate = new DateTime($targetDatestr);

		$lastDayOfPeriodStr = $tipeLaporan === 'tahunan' ? $tahunPilih . '-12-31' : date('Y-m-t', strtotime($targetDatestr));

		$builderTotal = $this->assetModel->where('status_aktif', 1);
		$builderTotal->where('tanggal_perolehan <=', $lastDayOfPeriodStr);

		$totalAssets = $builderTotal->countAllResults(false);
		$allAssets = $builderTotal->findAll();

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

			if ($tipeLaporan === 'tahunan') {
				// Penyusutan tahun ini = beban per bulan * sisa umur (tapi maks 12 bulan atau sisa umur yang ada)
				// Sesuai request: "nilai penysutan bulanan dikalikan sisa umur"
				// Tapi ini biasanya untuk sisa penyusutan. 
				// Mari kita asumsikan untuk laporan tahunan adalah sisa penyusutan yang akan datang atau penyusutan di tahun tersebut.
				// Re-read: "nilai penysutan bulanan dikalikan sisa umur"
				$penyusutanAccurate = $bebanPerBulan * $sisaUmurAccurate;
				$penyusutanKingdee = $bebanPerBulan * $sisaUmurKingdee;
			} else {
				$penyusutanAccurate = $bulanJalanAccurate > 0 && $bulanJalanAccurate <= $umurBulan ? $bebanPerBulan : 0;
				$penyusutanKingdee = $bulanJalanKingdee > 0 && $bulanJalanKingdee <= $umurBulan ? $bebanPerBulan : 0;
			}

			$selisihBulanIni = abs($penyusutanAccurate - $penyusutanKingdee);

			$dataPenyusutan[] = [
				'kode_aset' => $asset['kode_aset'],
				'nama_aset' => $asset['nama_aset'],
				'tanggal_beli' => $asset['tanggal_perolehan'],
				'sisa_umur_acc' => $sisaUmurAccurate,
				'sisa_umur_kgd' => $sisaUmurKingdee,
				'nilai_buku_acc' => $nilaiBukuAccurate,
				'nilai_buku_kgd' => $nilaiBukuKingdee,
				'penyusutan_per_bulan' => $bebanPerBulan,
				'accurate' => $penyusutanAccurate,
				'kingdee' => $penyusutanKingdee,
				'selisih' => $selisihBulanIni,
			];

			$totalAccurate += $penyusutanAccurate;
			$totalKingdee += $penyusutanKingdee;
			$totalSelisih += $selisihBulanIni;
			$totalNilaiBukuAcc += $nilaiBukuAccurate;
			$totalNilaiBukuKgd += $nilaiBukuKingdee;
		}

		$data = [
			'title' => 'Laporan Penyusutan Aset',
			'tipe_pilih' => $tipeLaporan,
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
			'total_assets' => $totalAssets,
			'total_accurate' => $totalAccurate,
			'total_kingdee' => $totalKingdee,
			'total_selisih' => $totalSelisih,
			'total_nilai_buku_acc' => $totalNilaiBukuAcc,
			'total_nilai_buku_kgd' => $totalNilaiBukuKgd,
		];

		return view('penyusutan/index', $data);
	}
}
