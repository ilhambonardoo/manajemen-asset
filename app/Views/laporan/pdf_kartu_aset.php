<?= $this->extend('layouts/pdf_layout') ?>

<?= $this->section('title') ?>
<?= $judul ?? 'Kartu Aset Tetap' ?>
<?= $this->endSection() ?>

<?= $this->section('header_right') ?>
<h2 class="report-title">KARTU ASET TETAP</h2>
<p>Dicetak : <?= date('d F Y') ?> </p>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    .info-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
        margin-bottom: 20px;
    }
    .info-table th {
        width: 30%;
        text-align: left;
        padding: 8px;
        border-bottom: 1px solid #ddd;
        background-color: #f9f9f9;
        vertical-align: top;
    }
    .info-table td {
        width: 70%;
        padding: 8px;
        border-bottom: 1px solid #ddd;
        vertical-align: top;
    }
    .card-box {
        margin-bottom: 20px; 
        border: 1px solid #000; 
        padding: 15px;
    }
</style>

<?php 
    $hargaPerolehan = $data['harga_perolehan'];
    $umurPenyusutan = $data['umur_penyusutan'];
    $tanggal_perolehan = $data['tanggal_perolehan'];

    $tahunSekarang = date('Y');
    $bulanSekarang = date('m');

    $tahunPerolehan = date('Y', strtotime($tanggal_perolehan));
    $bulanPerolehan = date('m', strtotime($tanggal_perolehan));

    $bulanBerjalan = ((($tahunSekarang-$tahunPerolehan) * 12) + ($bulanSekarang - $bulanPerolehan));

    if($bulanBerjalan > $umurPenyusutan){
        $bulanBerjalan = $umurPenyusutan;
    }

    if($bulanBerjalan < 0){
        $bulanBerjalan = 0;
    }

    $sisaUmur = $umurPenyusutan - $bulanBerjalan;


    if($umurPenyusutan != 0){
        $tarifPenyusutan = $hargaPerolehan / $umurPenyusutan;
        $totalPenyusutan = $tarifPenyusutan * $bulanBerjalan;

        $nilaiBuku = $hargaPerolehan - $totalPenyusutan;
    } else {
      $tarifPenyusutan = 0;
      $totalPenyusutan = 0;
      $nilaiBuku = $hargaPerolehan - $totalPenyusutan;  
    }

?>

<div class="card-box">
    <table class="info-table" style="border: none; margin: 0;">
        <tr>
            <th>Kode Aset</th>
            <td class="fw-bold"><?= $data['kode_aset'] ?? '-' ?></td>
        </tr>
        <tr>
            <th>Nama Aset</th>
            <td class="fw-bold"><?= $data['nama_aset'] ?? '-' ?></td>
        </tr>
        <tr>
            <th>Kategori / Kelompok</th>
            <td class="text-capitalize"><?= $data['kelompok_aset'] ?? '-' ?></td>
        </tr>
        <tr>
            <th>Tanggal Perolehan</th>
            <td><?= isset($data['tanggal_perolehan'])
            	? date('d F Y', strtotime($data['tanggal_perolehan']))
            	: '-' ?></td>
        </tr>
        <tr>
            <th>Harga Perolehan</th>
            <td>Rp <?= isset($data['harga_perolehan'])
            	? number_format($data['harga_perolehan'], 0, ',', '.')
            	: '0' ?></td>
        </tr>
        <tr>
            <th>Umur Penyusutan</th>
            <td><?= $data['umur_penyusutan'] ?? '0' ?> Bulan</td>
        </tr>
        <tr>
            <th>Umur Berjalan</th>
            <td><?= $bulanBerjalan; ?></td>
        </tr>
        <tr>
            <th>Sisa Umur</th>
            <td><?= $sisaUmur; ?></td>
        </tr>
        <tr>
            <th>Total Akumulasi Penyusutan</th>
            <td>(Rp <?= number_format($totalPenyusutan, 0, ',', '.'); ?>)</td>
        </tr>
        <tr>
            <th>Nilai Buku Saat Ini</th>
            <td>(Rp <?= number_format($nilaiBuku, 0, ',' , '.') ?>)</td>
        </tr>
        <tr>
            <th>Lokasi Aset</th>
            <td><?= $data['lokasi_aset'] ?? '-' ?></td>
        </tr>
        <tr>
            <th>Satuan</th>
            <td><?= $data['satuan'] ?? '-' ?></td>
        </tr>
        <tr>
            <th>Status Aset</th>
            <td>
                <?php if (isset($data['status_aktif'])): ?>
                    <span style="padding: 3px 8px; border-radius: 3px; background-color: <?= $data['status_aktif'] == 1
                    	? '#d4edda'
                    	: '#f8d7da' ?>;">
                        <?= $data['status_aktif'] == 1 ? 'AKTIF' : 'NONAKTIF (DISPOSED)' ?>
                    </span>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
        </tr>
    </table>
</div>

<div class="description-box">
    <p class="fw-bold" style="margin-bottom: 5px;">Deskripsi / Spesifikasi:</p>
    <p style="margin: 0; line-height: 1.5;"><?= !empty($data['spesifikasi'])
    	? nl2br($data['spesifikasi'])
    	: 'Tidak ada deskripsi tambahan.' ?></p>
</div>
<?= $this->endSection() ?>

