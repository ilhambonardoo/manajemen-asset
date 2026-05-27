<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 5px;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .text-center { text-align: center; }
        .text-end { text-align: right; }
        .fw-bold { font-weight: bold; }
        .text-danger { color: red; }
        .text-success { color: green; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Penyusutan Aset</h2>
        <p>
            Tipe: <?= ucfirst($tipe_pilih) ?> | 
            Periode: <?= $tipe_pilih == 'bulanan' ? ($bulan_array[$bulan_pilih] ?? '') . ' ' : '' ?><?= $tahun_pilih ?>
        </p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th rowspan="2" style="width: 30px;">No</th>
                <th rowspan="2" style="width: 80px;">Kode Aset</th>
                <th rowspan="2">Nama Aset</th>
                <th colspan="2">Sisa Umur (Bln)</th>
                <th colspan="2">Nilai Buku</th>
                <th colspan="3">Penyusutan <?= $tipe_pilih == 'tahunan' ? 'Tahun ' . $tahun_pilih : 'Bulan Ini' ?></th>
            </tr>
            <tr>
                <th>Accurate</th>
                <th>Kingdee</th>
                <th>Accurate</th>
                <th>Kingdee</th>
                <th>Accurate</th>
                <th>Kingdee</th>
                <th>Selisih</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($data_penyusutan as $row): ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= $row['kode_aset'] ?></td>
                    <td><?= $row['nama_aset'] ?></td>
                    <td class="text-center"><?= $row['sisa_umur_acc'] ?></td>
                    <td class="text-center"><?= $row['sisa_umur_kgd'] ?></td>
                    <td class="text-end"><?= number_format($row['nilai_buku_acc'], 0, ',', '.') ?></td>
                    <td class="text-end"><?= number_format($row['nilai_buku_kgd'], 0, ',', '.') ?></td>
                    <td class="text-end"><?= number_format($row['accurate'], 0, ',', '.') ?></td>
                    <td class="text-end"><?= number_format($row['kingdee'], 0, ',', '.') ?></td>
                    <td class="text-end <?= $row['selisih'] > 0 ? 'text-danger' : 'text-success' ?>">
                        <?= number_format($row['selisih'], 0, ',', '.') ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="fw-bold">
                <td colspan="7" class="text-center">Total Keseluruhan</td>
                <td class="text-end"><?= number_format($total_accurate, 0, ',', '.') ?></td>
                <td class="text-end"><?= number_format($total_kingdee, 0, ',', '.') ?></td>
                <td class="text-end <?= $total_selisih > 0 ? 'text-danger' : 'text-success' ?>">
                    <?= number_format($total_selisih, 0, ',', '.') ?>
                </td>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 30px;">
        <p>Dicetak pada: <?= date('d F Y H:i:s') ?></p>
    </div>
</body>
</html>