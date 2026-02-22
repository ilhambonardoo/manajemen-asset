<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 text-dark fw-bold mb-0">Detail & Kelola Aset</h2>
            <p class="text-muted mb-0">Kode Aset: <span class="badge bg-secondary"><?= $asset['kode_aset'] ?></span></p>
        </div>
        <a href="<?= base_url('asset/daftar') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>

    <?php if (session()->getFlashdata('pesan')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('pesan') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-primary fw-bold"><?= $asset['nama_aset'] ?></h4>
                    <p class="mb-1"><i class="fas fa-tags text-muted me-2"></i> Kelompok: <?= ucfirst(
                    	$asset['kelompok_aset']
                    ) ?></p>
                    <p class="mb-1"><i class="fas fa-map-marker-alt text-muted me-2"></i> Lokasi Saat Ini: <strong><?= $asset[
                    	'lokasi_aset'
                    ] ?></strong></p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-1">Harga Perolehan:</p>
                    <h4 class="text-success fw-bold">Rp <?= number_format(
                    	$asset['harga_perolehan'],
                    	0,
                    	',',
                    	'.'
                    ) ?></h4>
                    <p class="mb-0 text-muted">Tgl Perolehan: <?= date(
                    	'd M Y',
                    	strtotime($asset['tanggal_perolehan'])
                    ) ?></p>
                </div>
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs" id="assetTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold" id="lokasi-tab" data-bs-toggle="tab" data-bs-target="#lokasi" type="button" role="tab">
                <i class="fas fa-map-marked-alt me-1"></i> Riwayat Lokasi
            </button>
        </li>

    </ul>

    <div class="tab-content bg-white p-4 border border-top-0 rounded-bottom shadow-sm" id="assetTabsContent">
        
        <div class="tab-pane fade show active" id="lokasi" role="tabpanel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold">Riwayat Perpindahan Lokasi</h5>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#pindahLokasiModal">
                    <i class="fas fa-exchange-alt me-1"></i> Pindahkan Lokasi
                </button>
            </div>
            
            <div class="table-responsive">
                <table class="table table-bordered table-hover mt-2">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Pindah</th>
                            <th>Dari Lokasi</th>
                            <th>Ke Lokasi</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($riwayat_lokasi)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada riwayat perpindahan lokasi untuk aset ini.</td>
                            </tr>
                        <?php else: ?>
                            <?php
                            $no = 1;
                            foreach ($riwayat_lokasi as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= date('d M Y', strtotime($row['tanggal_pindah'])) ?></td>
                                <td><span class="text-danger"><?= $row['lokasi_lama'] ?></span></td>
                                <td><span class="text-success fw-bold"><?= $row['lokasi_baru'] ?></span></td>
                                <td><?= $row['keterangan'] ?: '-' ?></td>
                            </tr>
                            <?php endforeach;
                            ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-pane fade" id="penyusutan" role="tabpanel">
            <h5 class="fw-bold mb-3">Rekonsiliasi Penyusutan (Accurate vs Kingdee)</h5>
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-1"></i> Fitur kalkulasi penyusutan otomatis per bulan sedang dalam tahap pengembangan.
            </div>
        </div>

        <div class="tab-pane fade" id="perbaikan" role="tabpanel">
            <h5 class="fw-bold mb-3">Riwayat Perbaikan (Maintenance)</h5>
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-1"></i> Fitur riwayat perbaikan sedang dalam tahap pengembangan.
            </div>
        </div>

        <div class="tab-pane fade" id="revaluasi" role="tabpanel">
            <h5 class="fw-bold mb-3">Riwayat Revaluasi Aset</h5>
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-1"></i> Fitur revaluasi nilai aset sedang dalam tahap pengembangan.
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="pindahLokasiModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-exchange-alt me-2"></i> Form Pindah Lokasi Aset</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('asset/simpan-lokasi') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <input type="hidden" name="asset_id" value="<?= $asset['id'] ?>">
                    
                    <div class="mb-3">
                        <label class="form-label text-muted">Lokasi Saat Ini</label>
                        <input type="text" class="form-control bg-light" value="<?= $asset['lokasi_aset'] ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Pindah Ke Lokasi Baru <span class="text-danger">*</span></label>
                        <select class="form-select" name="lokasi_baru" required>
                            <option value="" selected disabled>-- Pilih Lokasi --</option>
                            <option value="Director Room" >Director Room</option>
                            <option value="Finance Room" >Finance Room</option>
                            <option value="Office 1" >Office 1</option>
                            <option value="Office 2" >Office 2</option>
                            <option value="Ruang Meeting Jakarta" >Ruang Meeting Jakarta</option>
                            <option value="Ruang Meeting Surabaya" >Ruang Meeting Surabaya</option>
                            <option value="Ruang Meeting Yogyakarta" >Ruang Meeting Yogyakarta</option>
                            <option value="Ruang Meeting Bali" >Ruang Meeting Bali</option>
                            <option value="Live Streaming Room" >Live Streaming Room</option>
                            <option value="Pantry" >Pantry</option>
                            <option value="Lobby" >Lobby</option>
                            <option value="Gudang" >Gudang</option>
                            <option value="Lainnya" >Lainnya</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tanggal Pindah <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tanggal_pindah" value="<?= date(
                        	'Y-m-d'
                        ) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Keterangan / Alasan Pindah</label>
                        <textarea class="form-control" name="keterangan" rows="2" placeholder="Contoh: Dipinjam sementara, Mutasi divisi..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan Perpindahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
