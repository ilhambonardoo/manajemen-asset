<?= $this->extend('layouts/pdf_layout') ?>

<?= $this->section('title') ?>
<?= $judul ?? 'Laporan Aset Per Lokasi' ?>
<?= $this->endSection() ?>

<?= $this->section('header_right') ?>
<h2 class="report-title">LAPORAN ASET PER LOKASI</h2>
<p>Dicetak : <?= date('d F Y') ?></p>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php $lokasiTitle = isset($data[0]['lokasi_aset']) ? $data[0]['lokasi_aset'] : 'SEMUA LOKASI'; ?>
<div class="mb-3">
    <strong>LOKASI ASET: <?= strtoupper($lokasiTitle) ?></strong>
</div>

<table class="table-data">
    <thead>
        <tr>
            <th width="4%">No</th>
            <th width="12%">Kode Aset</th>
            <th width="22%">Nama Aset</th>
            <th width="12%">Kategori</th>
            <th width="12%">Tgl Perolehan</th>
            <th width="15%">Harga Perolehan</th>
            <th width="8%">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($data)): ?>
            <tr>
                <td colspan="7" class="text-center">Tidak ada data aset ditemukan di lokasi ini.</td>
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
                <td class="text-center">
                    <?= $row['status_aktif'] == 1 ? 'Aktif' : 'Nonaktif' ?>
                </td>
            </tr>
            <?php
            endforeach;
            ?>
            
            <tr>
                <td colspan="5" class="text-right fw-bold">TOTAL ASET DI LOKASI INI</td>
                <td class="text-right fw-bold">Rp <?= number_format($totalHarga, 0, ',', '.') ?></td>
                <td></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="description-box">
    <p class="fw-bold" style="margin-bottom: 5px;">Keterangan</p>
    <p style="margin: 0;">Laporan ini mencakup aset tetap yang terdaftar di lokasi <?= $lokasiTitle ?> per tanggal <?= date(
 	'd F Y'
 ) ?>.</p>
</div>
<?= $this->endSection() ?>

