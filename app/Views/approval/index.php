<?= $this->extend('layouts/main') ?> <?= $this->section('content') ?>
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 text-dark fw-bold">Approval Penjualan Aset</h2>
    </div>

    <?php if (session()->getFlashdata('pesan')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('pesan') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tableApproval">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Kode Aset</th>
                            <th>Nama Aset</th>
                            <th>Tgl Pengajuan</th>
                            <th>Harga Jual (Rp)</th>
                            <th>Alasan Dijual</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pending_approvals)): ?>
                            <?php
                            $no = 1;
                            foreach ($pending_approvals as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><span class="badge bg-secondary"><?= $row['kode_aset'] ?></span></td>
                                <td class="fw-bold"><?= $row['nama_aset'] ?></td>
                                <td><?= date('d M Y', strtotime($row['tanggal_penjualan'])) ?></td>
                                <td>Rp <?= number_format($row['harga_jual'], 0, ',', '.') ?></td>
                                <td><?= $row['alasan_dijual'] ?></td>
                                <td class="text-center">
                                    <form action="<?= base_url(
                                    	'approval/approve/' . $row['id']
                                    ) ?>" method="post" class="d-inline">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-success me-1 mb-1" title="Setujui" onclick="return confirm('Yakin ingin menyetujui penjualan aset ini? Aset akan otomatis di-set sebagai Disposed.')">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                    </form>

                                    <form action="<?= base_url(
                                    	'approval/reject/' . $row['id']
                                    ) ?>" method="post" class="d-inline">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-danger mb-1" title="Tolak" onclick="return confirm('Yakin ingin menolak pengajuan ini?')">
                                            <i class="fas fa-times"></i> Reject
                                        </button>
                                    </form>
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

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        if ($.fn.DataTable) {
            $('#tableApproval').DataTable();
        } else {
            console.error('DataTables is not loaded!');
        }
    });
</script>
<?= $this->endSection() ?>
