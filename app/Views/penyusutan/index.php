<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 text-dark fw-bold mb-0"><i class="fas fa-calculator text-primary me-2"></i> Laporan Penyusutan Aset</h2>
            <p class="text-muted mb-0">Lakukan penyusutan aset berdasarkan periode bulan dan tahun.</p>
        </div>
    </div>

    <hr class="mb-4">

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body bg-light rounded">
            <form action="" method="get" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Periode Bulan</label>
                    <select name="bulan" class="form-select">
                        <?php
                        $bulan_pilih = isset($bulan_pilih) ? $bulan_pilih : date('n');
                        foreach ($bulan_array as $key => $val): ?>
                            <option value="<?= $key ?>" <?= $key == $bulan_pilih ? 'selected' : '' ?>><?= $val ?></option>
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

    <hr class="my-4">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary">
                Data Aset Yang Disusutkan - Periode <?= $bulan_array[$bulan_pilih] ?? '' ?> <?= isset($tahun_pilih) ? $tahun_pilih : date('Y') ?>
            </h6>
            <small class="text-muted">
                Menampilkan <?= count($data_penyusutan) > 0 ? (($current_page - 1) * $per_page) + 1 : 0 ?> - <?= ($current_page - 1) * $per_page + count($data_penyusutan) ?> dari <?= $total_assets ?> data
            </small>
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
                            <th class="bg-secondary text-white border-end border-white">Accurate</th>
                            <th class="bg-secondary text-white border-end border-white">Kingdee</th>
                            <th class="bg-secondary text-white border-end border-white">Accurate</th>
                            <th class="bg-secondary text-white border-end border-white">Kingdee</th>
                            <th class="bg-secondary text-white border-end border-white">Accurate</th>
                            <th class="bg-secondary text-white border-end border-white">Kingdee</th>
                            <th class="bg-secondary text-white border-end border-white">Selisih</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($data_penyusutan)): ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">Tidak ada data aset untuk disusutkan.</td>
                            </tr>
                        <?php else: ?>
                            <?php
                            $no = (($current_page - 1) * $per_page) + 1;
                            $pageTotal_accurate = 0;
                            $pageTotal_kingdee = 0;
                            $pageTotal_selisih = 0;

                            foreach ($data_penyusutan as $row):

                                $pageTotal_accurate += $row['accurate'];
                                $pageTotal_kingdee += $row['kingdee'];
                                $pageTotal_selisih += $row['selisih'];
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

                            <tr class="table-dark fw-bold text-end">
                                <td colspan="7" class="text-uppercase align-middle text-center border-end border-white">Total Halaman Ini</td>
                                <td class="align-middle text-center border-end border-white">Rp <?= number_format(
                                                                                                    $pageTotal_accurate,
                                                                                                    0,
                                                                                                    ',',
                                                                                                    '.'
                                                                                                ) ?></td>
                                <td class="align-middle text-center border-end border-white">Rp <?= number_format(
                                                                                                    $pageTotal_kingdee,
                                                                                                    0,
                                                                                                    ',',
                                                                                                    '.'
                                                                                                ) ?></td>
                                <td class="<?= $pageTotal_selisih > 0
                                                ? 'text-danger'
                                                : 'text-success' ?> align-middle text-center">
                                    <?php if ($pageTotal_selisih > 0): ?>
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                    <?php endif; ?>
                                    Rp <?= number_format($pageTotal_selisih, 0, ',', '.') ?>
                                </td>
                            </tr>

                            <tr class="table-warning fw-bold text-end">
                                <td colspan="7" class="text-uppercase align-middle text-center border-end border-dark">Total Keseluruhan (Semua Periode)</td>
                                <td class="align-middle text-center border-end border-dark">Rp <?= number_format(
                                                                                                    $total_accurate,
                                                                                                    0,
                                                                                                    ',',
                                                                                                    '.'
                                                                                                ) ?></td>
                                <td class="align-middle text-center border-end border-dark">Rp <?= number_format(
                                                                                                    $total_kingdee,
                                                                                                    0,
                                                                                                    ',',
                                                                                                    '.'
                                                                                                ) ?></td>
                                <td class="<?= $total_selisih > 0
                                                ? 'text-danger'
                                                : 'text-success' ?> align-middle text-center border-end border-dark">
                                    <?php if ($total_selisih > 0): ?>
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                    <?php endif; ?>
                                    Rp <?= number_format($total_selisih, 0, ',', '.') ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <hr class="my-4">

            <?php if ($total_pages > 1): ?>
                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?= $current_page <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link"
                                href="?bulan=<?= $bulan_pilih ?>&tahun=<?= $tahun_pilih ?>&page=<?= max(1, $current_page - 1) ?>"
                                aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span> Sebelumnya
                            </a>
                        </li>

                        <?php
                        $start_page = max(1, $current_page - 2);
                        $end_page = min($total_pages, $current_page + 2);

                        if ($start_page > 1): ?>
                            <li class="page-item">
                                <a class="page-link"
                                    href="?bulan=<?= $bulan_pilih ?>&tahun=<?= $tahun_pilih ?>&page=1">1</a>
                            </li>
                            <?php if ($start_page > 2): ?>
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php for ($page = $start_page; $page <= $end_page; $page++): ?>
                            <li class="page-item <?= $page == $current_page ? 'active' : '' ?>">
                                <a class="page-link"
                                    href="?bulan=<?= $bulan_pilih ?>&tahun=<?= $tahun_pilih ?>&page=<?= $page ?>">
                                    <?= $page ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($end_page < $total_pages): ?>
                            <?php if ($end_page < $total_pages - 1): ?>
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            <?php endif; ?>
                            <li class="page-item">
                                <a class="page-link"
                                    href="?bulan=<?= $bulan_pilih ?>&tahun=<?= $tahun_pilih ?>&page=<?= $total_pages ?>">
                                    <?= $total_pages ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <li class="page-item <?= $current_page >= $total_pages ? 'disabled' : '' ?>">
                            <a class="page-link"
                                href="?bulan=<?= $bulan_pilih ?>&tahun=<?= $tahun_pilih ?>&page=<?= min($total_pages, $current_page + 1) ?>"
                                aria-label="Next">
                                Berikutnya <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>

    </hr>
    <?= $this->endSection() ?>