<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Daftar Ruangan / Lokasi</h2>
        
        <div class="d-flex gap-2">
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-filter me-1"></i> Filter Lokasi
                </button>
                <div class="dropdown-menu dropdown-menu-end p-3" style="width: 300px;">
                    <form action="<?= base_url('lokasi') ?>" method="get">
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">Jenis Lokasi / Ruangan</label>
                            <select class="form-select" name="filter_nama">
                                <option value="">-- Semua Lokasi --</option>
                                <?php 
                                // Ambil nama unik untuk filter
                                $nama_lokasi_unik = [];
                                foreach ($lokasi as $l) {
                                    if (!in_array($l['nama'], $nama_lokasi_unik)) {
                                        $nama_lokasi_unik[] = $l['nama'];
                                    }
                                }
                                sort($nama_lokasi_unik);
                                foreach ($nama_lokasi_unik as $nama): ?>
                                    <option value="<?= esc($nama) ?>" <?= (request()->getGet('filter_nama') == $nama) ? 'selected' : '' ?>>
                                        <?= esc($nama) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-sm">Terapkan Filter</button>
                            <a href="<?= base_url('lokasi') ?>" class="btn btn-light btn-sm border">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th width="15%">Kode Ruangan</th>
                            <th width="50%">Nama Ruangan</th>
                            <th width="35%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lokasi as $row): ?>
                        <tr>
                            <td><?= $row['kode'] ?></td>
                            <td><?= $row['nama'] ?></td>
                            <td class="text-center">
                                <a href="/lokasi/penempatan/<?= $row['kode'] ?>/<?= urlencode(
	$row['nama']
) ?>" class="btn btn-success btn-sm me-1 mb-1">
                                    <i class="fas fa-plus"></i> Penempatan Aset
                                </a>
                                <a href="/lokasi/detail/<?= urlencode(
                                	$row['nama']
                                ) ?>" class="btn btn-primary btn-sm me-1 mb-1">
                                    <i class="fas fa-eye"></i> Detail Ruangan
                                </a>
                                <button type="button" class="btn btn-danger btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $row['id'] ?>">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </td>
                            
                            <div class="modal fade" id="deleteModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $row['id'] ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h1 class="modal-title fs-5" id="deleteModalLabel<?= $row['id'] ?>">Konfirmasi Hapus Lokasi</h1>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Apakah Anda yakin ingin menghapus lokasi <strong><?= htmlspecialchars($row['nama']) ?></strong>?</p>
                                            <p class="text-danger mb-0"><i class="fas fa-exclamation-triangle"></i> Tindakan ini tidak dapat dibatalkan.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <form action="/lokasi/delete/<?= $row['id'] ?>" method="POST" style="display:inline;">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i> Hapus Lokasi
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
