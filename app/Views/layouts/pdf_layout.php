<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?></title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #000;
            margin: 0;
            padding: 20px;
        }

        .header-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .header-table td {
            vertical-align: top;
        }
        .company-name {
            font-size: 16px; 
            font-weight: bold;
            margin: 0 0 5px 0;
            text-transform: uppercase;
        }
        .company-address {
            font-size: 11px;
            line-height: 1.4;
            margin: 0;
        }
        
        .report-title {
            font-size: 18px;
            font-weight: bold;
            margin: 0 0 10px 0;
            text-align: right;
            text-transform: uppercase;
        }
        .report-info {
            width: 100%;
            font-size: 12px;
        }
        .report-info td {
            padding: 2px 0;
            text-align: right;
        }
        .report-info td:first-child {
            text-align: left;
            width: 40%;
        }

        .table-data, .table-jurnal, .info-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px; 
            margin-bottom: 20px;
        }
        .table-data th, .table-data td, .table-jurnal th, .table-jurnal td {
            border: 1px solid #000;
            padding: 4px 6px;
        }
        .table-data th, .table-jurnal th {
            font-weight: bold;
            text-align: center;
            background-color: #f9f9f9;
            text-transform: uppercase;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .fw-bold { font-weight: bold; }
        .mb-3 { margin-bottom: 15px; }
        
        .description-box {
            margin-bottom: 30px;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            margin-top: 20px;
        }
        .signature-table td {
            width: 33.33%;
            padding: 10px;
            vertical-align: top;
        }
        .signature-space {
            height: 60px;
        }

        <?= $this->renderSection('styles') ?>
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td width="60%">
                <h2 class="company-name">PT. XYZ</h2>
                <p class="company-address">
                    RDTX PLACE JL. PROF. DR. SATRIO, KEL. KARET KUNINGAN,<br/>
                    KEC. SETIABUDI, JAKARTA SELATAN, DKI JAKARTA 12930.
                </p>
            </td>
            <td width="40%" class="text-right">
                <?= $this->renderSection('header_right') ?>
            </td>
        </tr>
    </table>

    <?= $this->renderSection('content') ?>

    <table class="signature-table">
        <tr>
            <td>
                Prepared By
                <div class="signature-space"></div>
                <div style="border-bottom: 1px solid #000; width: 80%; margin: 0 auto;"></div>
                <div style="text-align: left; padding-left: 10%; margin-top: 5px;">Date:</div>
            </td>
            <td>
                Reviewed By
                <div class="signature-space"></div>
                <div style="border-bottom: 1px solid #000; width: 80%; margin: 0 auto;"></div>
                <div style="text-align: left; padding-left: 10%; margin-top: 5px;">Date:</div>
            </td>
            <td>
                Approved By
                <div class="signature-space"></div>
                <div style="border-bottom: 1px solid #000; width: 80%; margin: 0 auto;"></div>
                <div style="text-align: left; padding-left: 10%; margin-top: 5px;">Date:</div>
            </td>
        </tr>
    </table>

</body>
</html>
