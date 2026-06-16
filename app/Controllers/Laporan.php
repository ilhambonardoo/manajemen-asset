<?php

namespace App\Controllers;

use App\Models\AssetModel;
use App\Models\PenjualanAssetModel;
use DateTime;

class Laporan extends BaseController
{
	protected $assetModel;
	protected $penjualanAssetModel;

	public function __construct()
	{
		$this->assetModel = new AssetModel();
		$this->penjualanAssetModel = new PenjualanAssetModel();
	}

	public function index()
	{
		$jenis = $this->request->getGet('jenis');

		$data = [
			'title' => 'Pusat Laporan Aset',
			'assets' => $this->assetModel->where('status_aktif', 1)->findAll(),
			'lokasi' => $this->assetModel->select('lokasi_aset')->distinct()->findAll(),
			'current_jenis' => $jenis,
		];

		return view('laporan/index', $data);
	}

	public function preview()
	{
		$data = $this->getReportData($this->request);
		if (!$data) {
			return '';
		}

		try {
			return view($data['view'], $data['data']);
		} catch (\Exception $e) {
			return '<div style="padding:20px; text-align:center; color:red;">View file not found: ' .
				$data['view'] .
				'</div>';
		}
	}

	public function generate()
	{
		$action = $this->request->getPost('action');
		$reportData = $this->getReportData($this->request);

		if (!$reportData) {
			return redirect()->back()->with('error', 'Jenis laporan tidak valid!');
		}

		if ($action == 'excel') {
			echo 'Fitur export Excel sedang dalam pengembangan.';
			exit();
		}

		$dompdf = new \Dompdf\Dompdf();
		$html = view($reportData['view'], $reportData['data']);
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		$dompdf->stream($reportData['filename'] . '.pdf', ['Attachment' => true]);
		exit;
	}

	private function hitungPenyusutanBulanan($assets, $targetDate){
		$jurnalData = [];
		$totalJurnal = 0;

		foreach ($assets as $asset) {
			$tanggalBeli = new \DateTime($asset['tanggal_perolehan']);
					$hariBeli = (int) $tanggalBeli->format('d');

					$hargaPerolehan = (float) $asset['harga_perolehan'];
					$umurBulan = (int) $asset['umur_penyusutan'];
					$bebanPerBulan = $umurBulan > 0 ? $hargaPerolehan / $umurBulan : 0;

					$startAccurate = clone $tanggalBeli;
					$startAccurate->modify('first day of this month');
					if ($hariBeli >= 16) {
						$startAccurate->modify('+1 month');
					}

					$bulanJalan = 0;
					if ($targetDate >= $startAccurate) {
						$diff = $startAccurate->diff($targetDate);
						$bulanJalan = $diff->y * 12 + $diff->m + 1;
					}

					if ($bulanJalan > 0 && $bulanJalan <= $umurBulan) {
						$penyusutanBulanIni = $bebanPerBulan;

						$kategori = !empty($asset['kelompok_aset']) ? ucwords($asset['kelompok_aset']) : 'Aset Tetap';

						if (!isset($jurnalData[$kategori])) {
							$jurnalData[$kategori] = 0;
						}
						$jurnalData[$kategori] += $penyusutanBulanIni;
						$totalJurnal += $penyusutanBulanIni;
					}
				}

		return [
			'jurnal_data' => $jurnalData,
			'total_jurnal' => $totalJurnal, 
		];
	}

	private function getReportData($request)
    {
        $jenisLaporan = $request->getPost('jenis_laporan');
        $dataLaporan = [];
        $viewLaporan = '';
        $namaFile = '';
        $tanggalAkhirBulan = date('d F Y');

        $bulanPilih = $request->getPost('bulan');
        $tahunPilih = $request->getPost('tahun');

        switch ($jenisLaporan) {
            case 'keseluruhan':
                $query = $this->assetModel->where('status_aktif', 1);

                if(!empty($bulanPilih) && !empty($tahunPilih)){
                    $query->where('MONTH(tanggal_perolehan)', $bulanPilih)
                          ->where('YEAR(tanggal_perolehan)', $tahunPilih);
                    $targetDateStr = $tahunPilih . '-' . sprintf('%02d', $bulanPilih) . '-01';
                    $tanggalAkhirBulan = date('t F Y', strtotime($targetDateStr));
                } else {
                    $tanggalAkhirBulan = date('t F Y'); 
                }

                $dataLaporan = [
                    'data' => $query->findAll(), // Menggunakan $query dinamis, bukan instansiasi ulang statis
                    'tanggal_akhir' => $tanggalAkhirBulan
                ];
                $viewLaporan = 'laporan/pdf_keseluruhan';
                $namaFile = 'Laporan_Aset_Periode_' . date('Ymd');
            break;

            case 'kartu_aset':
                $assetId = $request->getPost('asset_id');
                $dataLaporan = [
                    'asset' => $this->assetModel->find($assetId)
                ];
                $viewLaporan = 'laporan/pdf_kartu_aset';
                $namaFile = 'Kartu_Aset_' . ($dataLaporan['asset']['kode_aset'] ?? 'Unknown');
            break;

            case 'lokasi':
                $lokasiPilih = $request->getPost('lokasi');
                $dataLaporan = [
                    'data' => $this->assetModel->where('lokasi_aset', $lokasiPilih)->findAll()
                ];
                $viewLaporan = 'laporan/pdf_lokasi';
                $namaFile = 'Laporan_Aset_Lokasi_' . str_replace(' ', '_', $lokasiPilih);
            break;

            case 'nonaktif':
                $subJenis = $request->getPost('sub_jenis') ?? 'penjualan';
                
                $query = $this->penjualanAssetModel
                    ->table('penjualan_assets')
                    ->select('penjualan_assets.*, assets.kode_aset, assets.nama_aset, assets.harga_perolehan, assets.kelompok_aset, assets.tanggal_perolehan, assets.lokasi_aset, assets.umur_penyusutan')
                    ->join('assets', 'assets.id = penjualan_assets.asset_id')
                    ->where('status_approval', 'Approved');

                if ($subJenis == 'penjualan') {
                    $query->where('jenis_pengajuan', 'penjualan');
                    $namaFile = 'Laporan_Penjualan_Aset_' . date('Ymd');
                } else {
                    $query->where('jenis_pengajuan', 'penghentian');
                    $namaFile = 'Laporan_Penghentian_Aset_' . date('Ymd');
                }

                $dataLaporan = [
                    'data' => $query->get()->getResultArray(),
                    'sub_jenis' => $subJenis
                ];
                $viewLaporan = 'laporan/pdf_nonaktif';
            break;

            case 'jurnal':
                // Jika bulan kosong (Semua Periode), gunakan bulan berjalan saat ini sebagai jangkar perhitungan
                $bln = !empty($bulanPilih) ? (int)$bulanPilih : (int)date('n');
                $thn = !empty($tahunPilih) ? (int)$tahunPilih : (int)date('Y');

                $targetDateStr = $thn . '-' . sprintf('%02d', $bln) . '-01';
                $targetDate = new \DateTime($targetDateStr);
                $lastDayOfPeriodStr = date('Y-m-t', strtotime($targetDateStr));

                $assets = $this->assetModel->where('status_aktif', 1)
                    ->where('tanggal_perolehan <=', $lastDayOfPeriodStr)
                    ->findAll();

                $bulanArray = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                    7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                ];

                $dataPenyusutan = [];

                foreach ($assets as $asset) {
                    $tanggalBeli = new \DateTime($asset['tanggal_perolehan']);
                    $hariBeli = (int) $tanggalBeli->format('d');
                    $hargaPerolehan = (float) $asset['harga_perolehan'];
                    $umurBulan = (int) $asset['umur_penyusutan'];
                    $bebanPerBulan = $umurBulan > 0 ? $hargaPerolehan / $umurBulan : 0;
                    $tarif = $umurBulan > 0 ? (100 / ($umurBulan / 12)) : 0;

                    $startAccurate = clone $tanggalBeli;
                    $startAccurate->modify('first day of this month');
                    if ($hariBeli >= 16) {
                        $startAccurate->modify('+1 month');
                    }

                    $startKingdee = clone $tanggalBeli;
                    $startKingdee->modify('first day of this month');
                    $startKingdee->modify('+1 month');

                    $bulanJalanAcc = 0;
                    if ($targetDate >= $startAccurate) {
                        $diff = $startAccurate->diff($targetDate);
                        $bulanJalanAcc = $diff->y * 12 + $diff->m + 1;
                    }
                    $bulanJalanAcc = min($bulanJalanAcc, $umurBulan);

                    $bulanJalanKgd = 0;
                    if ($targetDate >= $startKingdee) {
                        $diff = $startKingdee->diff($targetDate);
                        $bulanJalanKgd = $diff->y * 12 + $diff->m + 1;
                    }
                    $bulanJalanKgd = min($bulanJalanKgd, $umurBulan);

                    $accDep = $bulanJalanAcc * $bebanPerBulan;
                    $kgdDep = $bulanJalanKgd * $bebanPerBulan;

                    $dataPenyusutan[] = [
                        'nama' => $asset['nama_aset'],
                        'nilai_buku' => $hargaPerolehan,
                        'umur' => $umurBulan,
                        'tarif' => number_format($tarif, 1, ',', '.') . '%',
                        'metode' => 'GARIS LURUS',
                        'beban_bln' => $bebanPerBulan,
                        'dep_acc' => $accDep,
                        'dep_kgd' => $kgdDep,
                        'sisa_umur_acc' => max(0, $umurBulan - $bulanJalanAcc),
                        'sisa_umur_kgd' => max(0, $umurBulan - $bulanJalanKgd),
                        'nilai_sisa_acc' => max(0, $hargaPerolehan - $accDep),
                        'nilai_sisa_kgd' => max(0, $hargaPerolehan - $kgdDep),
                    ];
                }

                $dataLaporan = [
                    'title' => 'Laporan Daftar Penyusutan Aset Tetap',
                    'data_penyusutan' => $dataPenyusutan,
                    'tipe_pilih' => empty($bulanPilih) ? 'tahunan' : 'bulanan', // Deteksi dinamis untuk template view
                    'bulan_pilih' => $bln,
                    'tahun_pilih' => $thn,
                    'bulan_array' => $bulanArray,
                ];

                $viewLaporan = 'laporan/pdf_jurnal';
                $namaFile = 'Laporan_Penyusutan_' . $thn . '_' . sprintf('%02d', $bln);
            break;
            
            case 'laporan_aset':
                $queryPerolehan = $this->assetModel->where('status_aktif', 1);
            
            // Create fresh model instances to avoid query builder state pollution
            $penjualanModel = new PenjualanAssetModel();
            $penghentianModel = new PenjualanAssetModel();
            
            $queryPenjualan = $penjualanModel
                ->table('penjualan_assets')
                ->select('penjualan_assets.*, assets.kode_aset, assets.nama_aset, assets.harga_perolehan')
                ->join('assets', 'assets.id = penjualan_assets.asset_id')
                ->where('jenis_pengajuan', 'penjualan')
                ->where('status_approval', 'Approved');

            $queryPenghentian = $penghentianModel
                ->table('penjualan_assets')
                ->select('penjualan_assets.*, assets.kode_aset, assets.nama_aset, assets.harga_perolehan')
                ->join('assets', 'assets.id = penjualan_assets.asset_id')
                ->where('jenis_pengajuan', 'penghentian')
                ->where('status_approval', 'Approved');
                
                // Pastikan Tahun ada isinya, jika dikosongkan user gunakan tahun berjalan
                $tahunJangkar = !empty($tahunPilih) ? $tahunPilih : date('Y');

                if(!empty($bulanPilih)){
                    // Filter Bulanan Spesifik
                    $queryPerolehan->where('MONTH(tanggal_perolehan)', $bulanPilih)->where('YEAR(tanggal_perolehan)', $tahunJangkar);
                    $queryPenjualan->where('MONTH(penjualan_assets.tanggal_penjualan)', $bulanPilih)->where('YEAR(penjualan_assets.tanggal_penjualan)', $tahunJangkar);
                    $queryPenghentian->where('MONTH(penjualan_assets.created_at)', $bulanPilih)->where('YEAR(penjualan_assets.created_at)', $tahunJangkar);

                    $targetDatestr = $tahunJangkar . '-' . sprintf('%02d', $bulanPilih) . '-01';
                    $targetDate = new \DateTime($targetDatestr);
                    $tanggalAkhirBulan = date('t F Y', strtotime($targetDatestr));
                } else {
                    // Semua Periode (Bulan Kosong) -> Filter berdasarkan Tahun saja
                    $queryPerolehan->where('YEAR(tanggal_perolehan)', $tahunJangkar);
                    $queryPenjualan->where('YEAR(penjualan_assets.tanggal_penjualan)', $tahunJangkar);
                    $queryPenghentian->where('YEAR(penjualan_assets.created_at)', $tahunJangkar);
                    
                    // Gunakan tanggal akhir tahun sebagai batas penentu parameter hitungPenyusutanBulanan
                    $targetDate = new \DateTime($tahunJangkar . '-12-31');
                    $tanggalAkhirBulan = '31 Desember ' . $tahunJangkar;
                }

                $dataPerolehan = $queryPerolehan->findAll();

                // Ambil aset yang diperoleh sebelum atau sama dengan tanggal jangkar targetDate
                $assetsForPenyusutan = $this->assetModel->where('status_aktif', 1)
                    ->where('tanggal_perolehan <=', $targetDate->format('Y-m-d'))
                    ->findAll();
                
                // PANGGILAN FUNGSI: Pastikan $targetDate dikirim berupa Objek DateTime yang valid
                $hasilPenyusutan = $this->hitungPenyusutanBulanan($assetsForPenyusutan, $targetDate);
                
                $penjualan = $queryPenjualan->get()->getResultArray();
                $dataPenghentian = $queryPenghentian->get()->getResultArray();

                $dataLaporan = [
                    'perolehan'     => $dataPerolehan,
                    'penyusutan'    => $hasilPenyusutan,
                    'penjualan'     => $penjualan,
                    'penghentian'   => $dataPenghentian,
                    'tanggal'       => date('d F Y'),
                    'tanggal_akhir' => $tanggalAkhirBulan,
                ];
                
                $viewLaporan = 'laporan/pdf_laporan_aset';
                $namaFile = 'Laporan_Aset_' . $tahunJangkar . '_' . (!empty($bulanPilih) ? sprintf('%02d', $bulanPilih) : 'SemuaBulan');           
            break;

        default:
            return null;
        }

        return [
            'view' => $viewLaporan,
            'filename' => $namaFile,
            'data' => array_merge($dataLaporan, [
                'judul' => 'Laporan Aset',
            ])];
    }
}
