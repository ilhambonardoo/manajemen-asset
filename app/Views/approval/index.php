<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
$jenis_approval = isset($jenis_approval) ? $jenis_approval : (isset($_GET['jenis']) ? $_GET['jenis'] : 'penjualan');
$judul_halaman = $jenis_approval == 'penghentian' ? 'Approval Penghentian Aset' : 'Approval Penjualan Aset';
?>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 text-dark fw-bold"><?= $judul_halaman ?></h2>
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

                            <?php if ($jenis_approval == 'penjualan'): ?>
                                <th>Harga Jual (Rp)</th>
                                <th>Alasan Dijual</th>
                            <?php else: ?>
                                <th>Kondisi Terakhir</th>
                                <th>Alasan Penghentian</th>
                            <?php endif; ?>

                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pending_approvals)): ?>
                            <?php $no = 1;
                            foreach ($pending_approvals as $row): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><span class="badge bg-secondary"><?= $row['kode_aset'] ?></span></td>
                                    <td class="fw-bold"><?= $row['nama_aset'] ?></td>

                                    <td><?= date('d M Y', strtotime($row['tanggal_pengajuan'] ?? $row['tanggal_penjualan'] ?? date('Y-m-d'))) ?></td>

                                    <?php if ($jenis_approval == 'penjualan'): ?>
                                        <td>Rp <?= number_format($row['harga_jual'] ?? 0, 0, ',', '.') ?></td>
                                        <td><?= $row['alasan_dijual'] ?? '-' ?></td>
                                    <?php else: ?>
                                        <td><span class="badge bg-warning"><?= $row['kondisi'] ?? 'Rusak' ?></span></td>
                                        <td><?= $row['alasan_penghentian'] ?? '-' ?></td>
                                    <?php endif; ?>

                                    <td class="text-center">
                                        <form action="<?= base_url('approval/approve/' . $row['id']) ?>" method="post" class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="jenis" value="<?= $jenis_approval ?>">
                                            <button type="submit" class="btn btn-sm btn-success me-1 mb-1" title="Setujui" onclick="return confirm('Yakin ingin menyetujui pengajuan ini?')">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                        </form>

                                        <form action="<?= base_url('approval/reject/' . $row['id']) ?>" method="post" class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="jenis" value="<?= $jenis_approval ?>">
                                            <button type="submit" class="btn btn-sm btn-danger mb-1" title="Tolak" onclick="return confirm('Yakin ingin menolak pengajuan ini?')">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
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
            $('#tableApproval').DataTable({
                "language": {
                    "search": "Cari Pengajuan:",
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ pengajuan",
                    "emptyTable": "Tidak ada pengajuan yang menunggu approval"
                }
            });
        } else {
            console.error('DataTables is not loaded!');
        }
    });
</script>
<?= $this->endSection() ?>