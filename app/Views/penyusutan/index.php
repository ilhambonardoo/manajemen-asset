<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 text-dark fw-bold mb-0"><i class="fas fa-calculator text-primary me-2"></i> Laporan Penyusutan Aset</h2>
            <p class="text-muted mb-0">Lakukan penyusutan aset berdasarkan periode bulan dan tahun.</p>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body bg-light rounded">
            <form action="" method="get" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Periode Bulan</label>
                    <select name="bulan" class="form-select">
                        <?php
                        $bulan_array = [
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
                        ];
                        $bulan_pilih = isset($bulan_pilih) ? $bulan_pilih : date('n');
                        foreach ($bulan_array as $key => $val): ?>
                            <option value="<?= $key ?>" <?= $key == $bulan_pilih
	? 'selected'
	: '' ?>><?= $val ?></option>
                        <?php endforeach;
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Tahun</label>
                    <input type="number" name="tahun" class="form-control" 
                           value="<?= isset($tahun_pilih) ? $tahun_pilih : date('Y') ?>" 
                           min="2000" max="2099">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i> Tampilkan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 fw-bold text-primary">
                Data Aset Yang Disusutkan - Periode <?= $bulan_array[$bulan_pilih] ?> <?= isset($_GET['tahun'])
 	? $_GET['tahun']
 	: date('Y') ?>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="dataTable">
                    <thead class="table-dark text-center">
                        <tr>
                            <th rowspan="2" class="align-middle">No</th>
                            <th rowspan="2" class="align-middle">Kode Aset</th>
                            <th rowspan="2" class="align-middle text-start">Nama Aset</th>
                            <th colspan="2" class="align-middle">Sisa Umur (Bln)</th>
                            <th colspan="2" class="align-middle">Nilai Buku</th>
                            <th colspan="3">Penyusutan Bulan Ini</th>
                        </tr>
                        <tr>
                            <th class="bg-secondary text-white">Accurate</th>
                            <th class="bg-secondary text-white">Kingdee</th>
                            <th class="bg-secondary text-white">Accurate</th>
                            <th class="bg-secondary text-white">Kingdee</th>
                            <th class="bg-secondary text-white">Accurate</th>
                            <th class="bg-secondary text-white">Kingdee</th>
                            <th class="bg-secondary text-white">Selisih</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data_penyusutan)): ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">Tidak ada data aset untuk disusutkan.</td>
                            </tr>
                        <?php else: ?>
                            <?php
                            $no = 1;
                            $totalAccurate = 0;
                            $totalKingdee = 0;
                            $totalSelisih = 0;
                            $totalNilaiBukuAcc = 0;
                            $totalNilaiBukuKgd = 0;

                            foreach ($data_penyusutan as $row):

                            	$totalAccurate += $row['accurate'];
                            	$totalKingdee += $row['kingdee'];
                            	$totalSelisih += $row['selisih'];
                            	$totalNilaiBukuAcc += $row['nilai_buku_acc'];
                            	$totalNilaiBukuKgd += $row['nilai_buku_kgd'];
                            	?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                
                                <td>
                                    <span class="badge bg-secondary mb-1"><?= $row['kode_aset'] ?></span><br>
                                    <small class="text-muted" style="font-size: 0.75rem;">Beli: <?= date(
                                    	'd M Y',
                                    	strtotime($row['tanggal_beli'])
                                    ) ?></small>
                                </td>
                                
                                <td class="fw-bold text-dark"><?= $row['nama_aset'] ?></td>
                                
                                <td class="fw-bold text-primary text-center"><?= $row['sisa_umur_acc'] ?></td>
                                <td class="fw-bold text-info text-dark text-center"><?= $row['sisa_umur_kgd'] ?></td>
                                
                                <td class="text-end text-success fw-bold">
                                    Rp <?= number_format($row['nilai_buku_acc'], 0, ',', '.') ?>
                                </td>
                                <td class="text-end text-info text-dark fw-bold">
                                    Rp <?= number_format($row['nilai_buku_kgd'], 0, ',', '.') ?>
                                </td>
                                
                                <td class="text-success fw-bold align-middle text-end">Rp <?= number_format(
                                	$row['accurate'],
                                	0,
                                	',',
                                	'.'
                                ) ?></td>
                                <td class="text-info text-dark fw-bold align-middle text-end">Rp <?= number_format(
                                	$row['kingdee'],
                                	0,
                                	',',
                                	'.'
                                ) ?></td>
                                
                                <td class="align-middle <?= $row['selisih'] > 0
                                	? 'text-danger'
                                	: 'text-success' ?> fw-bold text-end">
                                    <?php if ($row['selisih'] > 0): ?>
                                        <i class="fas fa-exclamation-triangle me-1"></i> 
                                    <?php endif; ?>
                                    Rp <?= number_format($row['selisih'], 0, ',', '.') ?>
                                </td>
                            </tr>
                            <?php
                            endforeach;
                            ?>
                            
                            <!-- Total Row -->
                            <tr class="table-dark fw-bold text-end">
                                <td colspan="7" class="text-uppercase align-middle text-center">Total Penyusutan</td>
                                <td class="align-middle text-center">Rp <?= number_format(
                                	$totalAccurate,
                                	0,
                                	',',
                                	'.'
                                ) ?></td>
                                <td class="align-middle text-center">Rp <?= number_format(
                                	$totalKingdee,
                                	0,
                                	',',
                                	'.'
                                ) ?></td>
                                <td class="<?= $totalSelisih > 0
                                	? 'text-danger'
                                	: 'text-success' ?> align-middle text-center">
                                    <?php if ($totalSelisih > 0): ?>
                                        <i class="fas fa-exclamation-triangle me-1"></i> 
                                    <?php endif; ?>
                                    Rp <?= number_format($totalSelisih, 0, ',', '.') ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>
