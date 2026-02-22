<?= $this->extend('layouts/pdf_layout') ?>

<?= $this->section('title') ?>
<?= $judul ?? 'Kartu Aset Tetap' ?>
<?= $this->endSection() ?>

<?= $this->section('header_right') ?>
<h2 class="report-title">KARTU ASET TETAP</h2>
<table class="report-info" align="right">
    <tr>
        <td>Dicetak</td>
        <td>: <?= date('d F Y') ?></td>
    </tr>
</table>
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
            <td><?= $data['kelompok_aset'] ?? '-' ?></td>
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

