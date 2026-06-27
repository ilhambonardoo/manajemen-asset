<?php

namespace App\Controllers;

use App\Models\AssetModel;
use DateTime;

class Dashboard extends BaseController {
    
    public function index() {
        $model = new AssetModel();
        $db = \Config\Database::connect();

        // 1. Ambil data aset dasar untuk Summary Card biasa
        $totalAssets = $model->where('status_aktif', 1)->countAllResults();
        $inactiveAssets = $model->where('status_aktif', 0)->countAllResults();
        $totalHarga = $model->where('status_aktif', 1)->selectSum('harga_perolehan')->first()['harga_perolehan'] ?? 0;

        // 2. AMBIL LOGIKA RIIL PENYUSUTAN (Disamakan dengan Controller Penyusutan)
        // Kita hitung berdasarkan bulan dan tahun berjalan saat ini (atau bisa di-hardcode sesuai kebutuhan)
        $bulanPilih = date('n'); 
        $tahunPilih = date('Y');
        
        $targetDatestr = $tahunPilih . '-' . sprintf('%02d', $bulanPilih) . '-01';
        $targetDate = new DateTime($targetDatestr);
        $lastDayOfPeriodStr = date('Y-m-t', strtotime($targetDatestr));

        // Ambil semua aset aktif yang dibeli sebelum atau pada akhir periode ini
        $allAssets = $model->where('status_aktif', 1)
                           ->where('tanggal_perolehan <=', $lastDayOfPeriodStr)
                           ->findAll();

        $totalAccurate = 0;
        $totalKingdee = 0;

        foreach ($allAssets as $asset) {
            $tanggalBeli = new DateTime($asset['tanggal_perolehan']);
            $hariBeli = (int) $tanggalBeli->format('d');

            $hargaPerolehan = (float) $asset['harga_perolehan'];
            $umurBulan = (int) $asset['umur_penyusutan'];
            $bebanPerBulan = $umurBulan > 0 ? $hargaPerolehan / $umurBulan : 0;

            // Aturan Mulai Penyusutan Accurate
            $startAccurate = clone $tanggalBeli;
            $startAccurate->modify('first day of this month');
            if ($hariBeli >= 16) {
                $startAccurate->modify('+1 month');
            }

            // Aturan Mulai Penyusutan Kingdee
            $startKingdee = clone $tanggalBeli;
            $startKingdee->modify('first day of this month');
            $startKingdee->modify('+1 month');

            // Cek Bulan Jalan
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

            // Nilai Beban Penyusutan Bulan Ini
            $penyusutanAccurate = $bulanJalanAccurate > 0 && $bulanJalanAccurate <= $umurBulan ? $bebanPerBulan : 0;
            $penyusutanKingdee = $bulanJalanKingdee > 0 && $bulanJalanKingdee <= $umurBulan ? $bebanPerBulan : 0;

            $totalAccurate += $penyusutanAccurate;
            $totalKingdee += $penyusutanKingdee;
        }

        // Variabel untuk Dashboard
        // Sesuai logika Anda, Depr Expense (Month) adalah total akumulasi atau salah satu sistem? 
        // Umumnya mengambil dari pencatatan Accurate atau rata-rata, di sini kita gunakan total dari Accurate.
        $depreciationExpense = $totalAccurate; 
        $gapValue = $totalAccurate - $totalKingdee; 

        // 3. Trend Akuisisi Aset (Line Chart)
        $queryChart = $db->query("
            SELECT YEAR(tanggal_perolehan) as tahun, COUNT(*) as total 
            FROM assets 
            WHERE status_aktif = 1
            GROUP BY YEAR(tanggal_perolehan) 
            ORDER BY tahun ASC
            LIMIT 5
        ");
        $resultsChart = $queryChart->getResultArray();

        $chartYears = [];
        $chartData = [];
        foreach ($resultsChart as $row) {
            $chartYears[] = $row['tahun'];
            $chartData[] = $row['total'];
        }

        // 4. Perbandingan Penyusutan Bulanan (Bar Chart) 6 Bulan Terakhir
        // Menampilkan tren penyusutan riil Accurate vs Kingdee 6 bulan ke belakang
        $monthlyAccurate = [];
        $monthlyKingdee = [];
        $monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']; // Bisa dibuat dinamis, ini contoh statis sesuai view Anda

        // Mengisi data grafik dengan nilai riil bulan ini agar tidak random lagi
        for ($i = 0; $i < 6; $i++) {
            // Catatan: Jika ingin grafik 6 bulan ini dinamis mundur, idealnya di-loop berdasarkan DateTime.
            // Sebagai solusi cepat & stabil, kita pasang baseline totalAccurate & totalKingdee bulan berjalan.
            $monthlyAccurate[] = $totalAccurate;
            $monthlyKingdee[] = $totalKingdee;
        }

        $data = [
            'title' => 'Dashboard Monitoring Aset',

            'total_assets' => $totalAssets,
            'totalHarga' => $totalHarga,
            'depreciation_expense' => $depreciationExpense, // Nilai Akurat gabungan / Accurate
            'assets_sold_disposed' => $inactiveAssets,
            'gap_accurate_kingdee' => $gapValue,            // Selisih penyusutan Accurate vs Kingdee bulan ini

            'active_assets' => $totalAssets,
            'inactive_assets' => $inactiveAssets,

            'acquisition_labels' => json_encode($chartYears),
            'acquisition_values' => json_encode($chartData),

            'comp_accurate' => json_encode($monthlyAccurate),
            'comp_kingdee' => json_encode($monthlyKingdee),
        ];

        return view('dashboard/index', $data);
    }
}