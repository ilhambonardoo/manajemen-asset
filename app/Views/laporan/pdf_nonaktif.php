<?= $this->extend('layouts/pdf_layout') ?>

<?= $this->section('title') ?>
<?= $judul ?? 'Laporan Aset Nonaktif' ?>
<?= $this->endSection() ?>

<?= $this->section('header_right') ?>
<h2 class="report-title">LAPORAN ASET NONAKTIF (DISPOSED)</h2>
<table class="report-info" align="right">
    <tr>
        <td>Dicetak</td>
        <td>: <?= date('d F Y') ?></td>
    </tr>
</table>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<table class="table-data">
    <thead>
        <tr>
            <th width="4%">No</th>
            <th width="12%">Kode Aset</th>
            <th width="22%">Nama Aset</th>
            <th width="12%">Kategori</th>
            <th width="12%">Tgl Perolehan</th>
            <th width="15%">Harga Perolehan</th>
            <th width="15%">Lokasi Terakhir</th>
            <th width="8%">Umur (Bln)</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($data)): ?>
            <tr>
                <td colspan="8" class="text-center">Tidak ada data aset nonaktif.</td>
            </tr>
        <?php else: ?>
            <?php
            $no = 1;
            $totalHarga = 0;
            foreach ($data as $row):
            	$totalHarga += (float) $row['harga_perolehan']; ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td class="text-center"><?= $row['kode_aset'] ?></td>
                <td><?= $row['nama_aset'] ?></td>
                <td class="text-center"><?= $row['kelompok_aset'] ?></td>
                <td class="text-center"><?= date('d/m/Y', strtotime($row['tanggal_perolehan'])) ?></td>
                <td class="text-right">Rp <?= number_format($row['harga_perolehan'], 0, ',', '.') ?></td>
                <td><?= $row['lokasi_aset'] ?></td>
                <td class="text-center"><?= $row['umur_penyusutan'] ?></td>
            </tr>
            <?php
            endforeach;
            ?>
            
            <tr>
                <td colspan="5" class="text-right fw-bold">TOTAL HARGA ASET NONAKTIF</td>
                <td class="text-right fw-bold">Rp <?= number_format($totalHarga, 0, ',', '.') ?></td>
                <td colspan="2"></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="description-box">
    <p class="fw-bold" style="margin-bottom: 5px;">Keterangan</p>
    <p style="margin: 0;">Laporan ini mencakup seluruh aset yang statusnya sudah tidak aktif / disposed.</p>
</div>
<?= $this->endSection() ?>

