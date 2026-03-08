<?= $this->extend('layouts/pdf_layout') ?>

<?= $this->section('title') ?>
<?= $judul ?? 'Journal Voucher' ?>
<?= $this->endSection() ?>

<?= $this->section('header_right') ?>
<h2 class="report-title">Journal Voucher</h2>
<p width="35%" style="text-align:right;">Voucher No : JV-<?= date('Ymd') ?>-01 </p>
<p style="text-align:right;">Date : <?= date('d M Y', strtotime($data['tanggal_akhir'] ?? date('Y-m-d'))) ?> </p>
<?= $this->endSection() ?>

<?php
function terbilang($angka)
{
    $angka = (int) $angka;
    $bilangan = [
        '',
        'satu',
        'dua',
        'tiga',
        'empat',
        'lima',
        'enam',
        'tujuh',
        'delapan',
        'sembilan',
        'sepuluh',
        'sebelas'
    ];

    if ($angka == 0) {
        return 'nol';
    }

    if ($angka < 0) {
        return "minus " . terbilang(-1 * $angka);
    }

    if ($angka < 12) {
        return $bilangan[$angka];
    } elseif ($angka < 20) {
        return terbilang($angka - 10) . " belas";
    } elseif ($angka < 100) {
        return terbilang(intdiv($angka, 10)) . " puluh" . ($angka % 10 ? " " . terbilang($angka % 10) : "");
    } elseif ($angka < 1000) {
        return terbilang(intdiv($angka, 100)) . " ratus" . ($angka % 100 ? " " . terbilang($angka % 100) : "");
    } elseif ($angka < 1000000) {
        return terbilang(intdiv($angka, 1000)) . " ribu" . ($angka % 1000 ? " " . terbilang($angka % 1000) : "");
    } elseif ($angka < 1000000000) {
        return terbilang(intdiv($angka, 1000000)) . " juta" . ($angka % 1000000 ? " " . terbilang($angka % 1000000) : "");
    } elseif ($angka < 1000000000000) {
        return terbilang(intdiv($angka, 1000000000)) . " miliar" . ($angka % 1000000000 ? " " . terbilang($angka % 1000000000) : "");
    } else {
        return terbilang(intdiv($angka, 1000000000000)) . " triliun" . ($angka % 1000000000000 ? " " . terbilang($angka % 1000000000000) : "");
    }
}
?>

<?= $this->section('content') ?>
<style>
    .table-jurnal {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
        margin-bottom: 20px;
    }

    .table-jurnal th,
    .table-jurnal td {
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
                <td colspan="2" class="fw-bold">Terbilang: <i><?= ucfirst(terbilang($data['total_jurnal'] ?? 0)) ?> rupiah</i></td>
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