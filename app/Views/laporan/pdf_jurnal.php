<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 8pt;
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
            padding: 4px;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .text-center { text-align: center; }
        .text-end { text-align: right; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="margin-bottom: 5px;">LAPORAN DAFTAR PENYUSUTAN ASET TETAP</h2>
        <p style="margin: 0;">
            Periode: <?= $bulan_array[$bulan_pilih] ?? '' ?> <?= $tahun_pilih ?>
        </p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th rowspan="2" width="3%">NO</th>
                <th rowspan="2">NAMA ASET</th>
                <th rowspan="2">NILAI BUKU</th>
                <th rowspan="2">UMUR MANFAAT</th>
                <th colspan="2">PENYUSUTAN</th>
                <th rowspan="2">PENYUSUTAN (PER BULAN)</th>
                <th rowspan="2">PENYUSUTAN (ACCURATE)</th>
                <th rowspan="2">PENYUSUTAN (KINGDEE)</th>
                <th rowspan="2">SISA UMUR (ACCURATE)</th>
                <th rowspan="2">SISA UMUR (KINGDEE)</th>
                <th rowspan="2">NILAI SISA (ACCURATE)</th>
                <th rowspan="2">NILAI SISA (KINGDEE)</th>
            </tr>
            <tr>
                <th>TARIF</th>
                <th>METODE</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            foreach ($data_penyusutan as $row): ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= $row['nama'] ?></td>
                    <td class="text-end"><?= number_format($row['nilai_buku'], 0, ',', '.') ?></td>
                    <td class="text-center"><?= $row['umur'] ?></td>
                    <td class="text-center"><?= $row['tarif'] ?></td>
                    <td class="text-center"><?= $row['metode'] ?></td>
                    <td class="text-end"><?= number_format($row['beban_bln'], 0, ',', '.') ?></td>
                    <td class="text-end"><?= number_format($row['dep_acc'], 0, ',', '.') ?></td>
                    <td class="text-end"><?= number_format($row['dep_kgd'], 0, ',', '.') ?></td>
                    <td class="text-center"><?= $row['sisa_umur_acc'] ?></td>
                    <td class="text-center"><?= $row['sisa_umur_kgd'] ?></td>
                    <td class="text-end"><?= number_format($row['nilai_sisa_acc'], 0, ',', '.') ?></td>
                    <td class="text-end"><?= number_format($row['nilai_sisa_kgd'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div style="margin-top: 30px;">
        <p>Dicetak pada: <?= date('d F Y H:i:s') ?></p>
    </div>
</body>
</html>