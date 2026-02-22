<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid mt-4">
    <h2 class="mb-4">Daftar Ruangan / Lokasi</h2>

    <div class="card">
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
                                ) ?>" class="btn btn-primary btn-sm mb-1">
                                    <i class="fas fa-eye"></i> Detail Ruangan
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
