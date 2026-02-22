<?php

namespace App\Controllers;

use App\Models\AssetModel;

class Dashboard extends BaseController {
	public function index() {
		$model = new AssetModel();

		$totalAssets = $model->where('status_aktif', 1)->countAllResults();
		$inactiveAssets = $model->where('status_aktif', 0)->countAllResults();

		$db = \Config\Database::connect();

		$queryDepreciation = $db->query("
            SELECT SUM(harga_perolehan / (umur_penyusutan * 12)) as total_dep
            FROM assets 
            WHERE status_aktif = 1
        ");
		$depreciationExpense = $queryDepreciation->getRow()->total_dep ?? 0;

		$valAccurate =
			$model->where('sumber_data', 'Accurate')->where('status_aktif', 1)->selectSum('harga_perolehan')->first()[
				'harga_perolehan'
			] ?? 0;

		$valKingdee =
			$model->where('sumber_data', 'Kingdee')->where('status_aktif', 1)->selectSum('harga_perolehan')->first()[
				'harga_perolehan'
			] ?? 0;

		$depAccurate = $valAccurate / (4 * 12);
		$depKingdee = $valKingdee / (4 * 12);
		$gapValue = $depAccurate - $depKingdee;

		$queryChart = $db->query("
            SELECT YEAR(tanggal_perolehan) as tahun, COUNT(*) as total 
            FROM assets 
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

		$monthlyAccurate = [];
		$monthlyKingdee = [];
		for ($i = 0; $i < 6; $i++) {
			$monthlyAccurate[] = $depAccurate + rand(-100000, 100000);
			$monthlyKingdee[] = $depKingdee + rand(-100000, 100000);
		}

		$data = [
			'title' => 'Dashboard Monitoring Aset',

			'total_assets' => $totalAssets,
			'depreciation_expense' => $depreciationExpense,
			'assets_sold_disposed' => $inactiveAssets,
			'gap_accurate_kingdee' => $gapValue,

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
