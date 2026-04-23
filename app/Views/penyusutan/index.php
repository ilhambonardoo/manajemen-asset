
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
                <div class="col-md-3">
                    <label class="form-label fw-bold">Tipe Laporan</label>
                    <select name="tipe" class="form-select" id="tipeLaporan">
                        <option value="bulanan" <?= ($tipe_pilih ?? 'bulanan') == 'bulanan' ? 'selected' : '' ?>>Bulanan</option>
                        <option value="tahunan" <?= ($tipe_pilih ?? 'bulanan') == 'tahunan' ? 'selected' : '' ?>>Tahunan</option>
                    </select>
                </div>
                <div class="col-md-3" id="containerBulan">
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
                        <i class="fas fa-filter me-1"></i> Tampilkan Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <hr class="my-4">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary">
                Data Aset Yang Disusutkan - 
                <?php if (($tipe_pilih ?? 'bulanan') == 'tahunan'): ?>
                    Tahunan <?= isset($tahun_pilih) ? $tahun_pilih : date('Y') ?>
                <?php else: ?>
                    Periode <?= $bulan_array[$bulan_pilih] ?? '' ?> <?= isset($tahun_pilih) ? $tahun_pilih : date('Y') ?>
                <?php endif; ?>
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
                            <?php if (($tipe_pilih ?? 'bulanan') == 'tahunan'): ?>
                                <th rowspan="2" class="align-middle">Penyusutan / Bln</th>
                            <?php endif; ?>
                            <th colspan="3">Penyusutan <?= ($tipe_pilih ?? 'bulanan') == 'tahunan' ? 'Sampai Selesai' : 'Bulan Ini' ?></th>
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
                                <td colspan="10" class="text-center text-muted py-4">Tidak ada data aset untuk disusutkan pada periode ini.</td>
                            </tr>
                        <?php else: ?>
                            <?php
                            $no = 1;

                            foreach ($data_penyusutan as $row):
                            ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>

                                    <td>
                                        <span class="badge bg-secondary mb-1"><?= $row['kode_aset'] ?></span><br>
                                        <small class="text-muted" style="font-size: 0.75rem;">Beli: <?= date('d M Y', strtotime($row['tanggal_beli'])) ?></small>
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

                                    <?php if (($tipe_pilih ?? 'bulanan') == 'tahunan'): ?>
                                        <td class="text-end fw-bold text-dark">Rp <?= number_format($row['penyusutan_per_bulan'], 0, ',', '.') ?></td>
                                    <?php endif; ?>

                                    <td class="text-success fw-bold align-middle text-end">Rp <?= number_format($row['accurate'], 0, ',', '.') ?></td>
                                    <td class="text-info text-dark fw-bold align-middle text-end">Rp <?= number_format($row['kingdee'], 0, ',', '.') ?></td>

                                    <td class="align-middle <?= $row['selisih'] > 0 ? 'text-danger' : 'text-success' ?> fw-bold text-end">
                                        <?php if ($row['selisih'] > 0): ?>
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                        <?php endif; ?>
                                        Rp <?= number_format($row['selisih'], 0, ',', '.') ?>
                                    </td>
                                </tr>
                            <?php
                            endforeach;
                            ?>
                        <?php endif; ?>
                    </tbody>
                    <?php if (!empty($data_penyusutan)): ?>
                    <tfoot>
                        <tr class="table-dark fw-bold text-end">
                            <td colspan="<?= ($tipe_pilih ?? 'bulanan') == 'tahunan' ? '8' : '7' ?>" class="text-uppercase align-middle text-center border-end border-light">Total Keseluruhan</td>
                            <td class="align-middle text-center border-end border-light">Rp <?= number_format($total_accurate, 0, ',', '.') ?></td>
                            <td class="align-middle text-center border-end border-light">Rp <?= number_format($total_kingdee, 0, ',', '.') ?></td>
                            <td class="<?= $total_selisih > 0 ? 'text-danger' : 'text-success' ?> align-middle text-center border-end border-dark">
                                <?php if ($total_selisih > 0): ?>
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                <?php endif; ?>
                                Rp <?= number_format($total_selisih, 0, ',', '.') ?>
                            </td>
                        </tr>
                    </tfoot>
                    <?php endif; ?>
                </table>
            </div>

        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "language": {
                "search": "Cari Aset:",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ aset",
                "infoEmpty": "Tidak ada data tersedia",
                "zeroRecords": "Tidak ada data yang cocok dengan pencarian"
            }
        });

        // Hide bulan container if "tahunan" is selected
        function toggleBulan() {
            if ($('#tipeLaporan').val() === 'tahunan') {
                $('#containerBulan').hide();
            } else {
                $('#containerBulan').show();
            }
        }

        $('#tipeLaporan').on('change', function() {
            toggleBulan();
        });

        // Initial check
        toggleBulan();
    });
</script>
<?= $this->endSection() ?>