<?= $this->extend('layouts/pdf_layout') ?>

<?= $this->section('title') ?>
<?= $judul ?? 'Laporan Aset Nonaktif' ?>
<?= $this->endSection() ?>

<?= $this->section('header_right') ?>
<h2 class="report-title">LAPORAN ASET NONAKTIF (<?= isset($sub_jenis) && $sub_jenis == 'penghentian' ? 'PENGHENTIAN' : 'PENJUALAN' ?>)</h2>
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
            <th width="20%">Nama Aset</th>
            <th width="12%">Kategori</th>
            <th width="12%">Tgl Perolehan</th>
            <th width="15%">Harga Perolehan</th>
            <?php if (isset($sub_jenis) && $sub_jenis == 'penjualan'): ?>
                <th width="15%">Harga Jual</th>
            <?php else: ?>
                <th width="15%">Alasan Penghentian</th>
            <?php endif; ?>
            <th width="10%">Umur (Bln)</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($data)): ?>
            <tr>
                <td colspan="<?= (isset($sub_jenis) && $sub_jenis == 'penjualan') ? 8 : 8 ?>" class="text-center">Tidak ada data aset nonaktif.</td>
            </tr>
        <?php else: ?>
            <?php
            $no = 1;
            $totalHarga = 0;
            $totalJual = 0;
            foreach ($data as $row):
            	$totalHarga += (float) $row['harga_perolehan'];
                if (isset($sub_jenis) && $sub_jenis == 'penjualan') {
                    $totalJual += (float) ($row['harga_jual'] ?? 0);
                }
            ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td class="text-center"><?= $row['kode_aset'] ?></td>
                <td><?= $row['nama_aset'] ?></td>
                <td class="text-center"><?= $row['kelompok_aset'] ?></td>
                <td class="text-center"><?= date('d/m/Y', strtotime($row['tanggal_perolehan'])) ?></td>
                <td class="text-right">Rp <?= number_format($row['harga_perolehan'], 0, ',', '.') ?></td>
                <?php if (isset($sub_jenis) && $sub_jenis == 'penjualan'): ?>
                    <td class="text-right">Rp <?= number_format($row['harga_jual'], 0, ',', '.') ?></td>
                <?php else: ?>
                    <td><?= $row['alasan_penghentian'] ?></td>
                <?php endif; ?>
                <td class="text-center"><?= $row['umur_penyusutan'] ?></td>
            </tr>
            <?php
            endforeach;
            ?>
            
            <tr>
                <td colspan="5" class="text-right fw-bold">TOTAL HARGA ASET</td>
                <td class="text-right fw-bold">Rp <?= number_format($totalHarga, 0, ',', '.') ?></td>
                <?php if (isset($sub_jenis) && $sub_jenis == 'penjualan'): ?>
                    <td class="text-right fw-bold">Rp <?= number_format($totalJual, 0, ',', '.') ?></td>
                <?php else: ?>
                    <td></td>
                <?php endif; ?>
                <td></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="description-box">
    <p class="fw-bold" style="margin-bottom: 5px;">Keterangan</p>
    <p style="margin: 0;">Laporan ini mencakup seluruh aset yang sudah disetujui untuk <?= isset($sub_jenis) && $sub_jenis == 'penghentian' ? 'dihentikan penggunaannya' : 'dijual' ?>.</p>
</div>
<?= $this->endSection() ?>

