<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Detail Ruangan - <?= $nama_lokasi ?></h3>
        <a href="/lokasi" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Kode Aset</th>
                            <th width="55%">Nama Aset</th>
                            <th width="20%" class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($aset_diruangan)): ?>
                            <tr><td colspan="4" class="text-center">Belum ada aset di ruangan ini.</td></tr>
                        <?php else: ?>
                            <?php
                            $no = 1;
                            foreach ($aset_diruangan as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['kode_aset'] ?></td>
                                <td><?= $row['nama_aset'] ?></td>
                                <td class="text-center">
                                    <span class="badge bg-success">Ditempatkan</span>
                                </td>
                            </tr>
                            <?php endforeach;
                            ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
