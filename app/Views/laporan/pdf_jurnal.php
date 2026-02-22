<?= $this->extend('layouts/pdf_layout') ?>

<?= $this->section('title') ?>
<?= $judul ?? 'Journal Voucher' ?>
<?= $this->endSection() ?>

<?= $this->section('header_right') ?>
<h2 class="report-title">For Journal Voucher</h2>
<table class="report-info" align="right">
    <tr>
        <td width="35%" style="text-align:left;">Voucher No.</td>
        <td>: JV-<?= date('Ymd') ?>-01</td>
    </tr>
    <tr>
        <td style="text-align:left;">Date</td>
        <td>: <?= date('d M Y', strtotime($data['tanggal_akhir'] ?? date('Y-m-d'))) ?></td>
    </tr>
</table>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    .table-jurnal {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
        margin-bottom: 20px;
    }
    .table-jurnal th, .table-jurnal td {
        border: 1px solid #000;
        padding: 6px 8px;
    }
    .table-jurnal th {
        font-weight: bold;
        text-align: center;
        background-color: #f9f9f9;
    }
</style>

<table class="table-jurnal">
    <thead>
        <tr>
            <th width="15%">Account No.</th>
            <th width="30%">Account Name</th>
            <th width="15%">Debit</th>
            <th width="15%">Credit</th>
            <th width="25%">Memo</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($data['jurnal'])): ?>
            <tr>
                <td colspan="5" class="text-center">Tidak ada aset yang disusutkan pada periode ini.</td>
            </tr>
        <?php else: ?>
            <?php
            $kode_beban = 6000;
            $kode_akumulasi = 1500;
            foreach ($data['jurnal'] as $kategori => $nominal):

            	$kode_beban++;
            	$kode_akumulasi++;
            	?>
                <tr>
                    <td class="text-center"><?= $kode_beban ?>.01</td>
                    <td>Beban Penyusutan - <?= $kategori ?></td>
                    <td class="text-right"><?= number_format($nominal, 0, ',', '.') ?></td>
                    <td class="text-right">0</td>
                    <td>Penyusutan <?= $kategori ?> periode <?= date(
 	'M Y',
 	strtotime($data['tanggal_akhir'] ?? date('Y-m-d'))
 ) ?></td>
                </tr>
                <tr>
                    <td class="text-center"><?= $kode_akumulasi ?>.01</td>
                    <td>Akumulasi Penyusutan - <?= $kategori ?></td>
                    <td class="text-right">0</td>
                    <td class="text-right"><?= number_format($nominal, 0, ',', '.') ?></td>
                    <td>Penyusutan <?= $kategori ?> periode <?= date(
 	'M Y',
 	strtotime($data['tanggal_akhir'] ?? date('Y-m-d'))
 ) ?></td>
                </tr>
            <?php
            endforeach;
            ?>
            
            <tr>
                <td colspan="2" class="fw-bold">Say: <i>(Total Depreciation Expense)</i></td>
                <td class="text-right fw-bold"><?= number_format($data['total_jurnal'] ?? 0, 0, ',', '.') ?></td>
                <td class="text-right fw-bold"><?= number_format($data['total_jurnal'] ?? 0, 0, ',', '.') ?></td>
                <td></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="description-box">
    <p class="fw-bold" style="margin-bottom: 5px;">Description</p>
    <p style="margin: 0;">Pencatatan Jurnal Penyesuaian Beban Penyusutan Aset Tetap Perusahaan untuk periode <?= date(
    	'F Y',
    	strtotime($data['tanggal_akhir'] ?? date('Y-m-d'))
    ) ?>.</p>
</div>
<?= $this->endSection() ?>
