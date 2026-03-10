<?= $this->extend('layouts/pdf_layout') ?>

<?= $this->section('title') ?>
<?= $judul ?? 'Laporan Aset' ?>
<?= $this->endSection() ?>

<?= $this->section('header_right') ?>
<h2 class="report-title">LAPORAN ASET TETAP</h2>
<p>Periode : <?= isset($tanggal_akhir) ? $tanggal_akhir : (isset($tanggal) ? $tanggal : date('d F Y')) ?></p>
<p>Dicetak : <?= date('d F Y') ?></p>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
	.section-title {
		font-size: 13px;
		font-weight: bold;
		margin-top: 20px;
		margin-bottom: 10px;
		padding-bottom: 5px;
		border-bottom: 2px solid #000;
		text-transform: uppercase;
	}

	.table-data th, .table-data td {
		padding: 5px 4px;
	}

	.section-title:last-of-type {
		page-break-after: avoid;
	}

	.table-data {
		page-break-inside: avoid;
	}

	.description-box {
		page-break-after: avoid;
		page-break-inside: avoid;
	}

	.section-termination {
		page-break-inside: avoid;
		margin-top: 10px;
		margin-bottom: 0;
	}

	.section-termination .description-box {
		margin-bottom: 0 !important;
		margin-top: 5px;
	}
</style>

<div class="section-title">I. PEROLEHAN ASET DI PERIODE INI</div>
<table class="table-data">
	<thead>
		<tr>
			<th width="4%">No</th>
			<th width="12%">Kode Aset</th>
			<th width="20%">Nama Aset</th>
			<th width="12%">Kategori</th>
			<th width="12%">Tgl Perolehan</th>
			<th width="15%">Harga Perolehan</th>
			<th width="15%">Lokasi</th>
		</tr>
	</thead>
	<tbody>
		<?php if (empty($perolehan)): ?>
			<tr>
				<td colspan="7" class="text-center">Tidak ada perolehan aset di periode ini.</td>
			</tr>
		<?php else: ?>
			<?php
			$no = 1;
			$totalPerolehan = 0;
			foreach ($perolehan as $row):
				$totalPerolehan += (float) $row['harga_perolehan'];
			?>
			<tr>
				<td class="text-center"><?= $no++ ?></td>
				<td class="text-center"><?= $row['kode_aset'] ?></td>
				<td><?= $row['nama_aset'] ?></td>
				<td class="text-center"><?= $row['kelompok_aset'] ?? '-' ?></td>
				<td class="text-center"><?= date('d/m/Y', strtotime($row['tanggal_perolehan'])) ?></td>
				<td class="text-right">Rp <?= number_format($row['harga_perolehan'], 0, ',', '.') ?></td>
				<td><?= $row['lokasi_aset'] ?></td>
			</tr>
			<?php endforeach; ?>
			<tr>
				<td colspan="5" class="text-right fw-bold">SUBTOTAL PEROLEHAN</td>
				<td class="text-right fw-bold">Rp <?= number_format($totalPerolehan, 0, ',', '.') ?></td>
				<td></td>
			</tr>
		<?php endif; ?>
	</tbody>
</table>

<div class="section-title">II. BEBAN PENYUSUTAN PERIODE INI</div>
<table class="table-data">
	<thead>
		<tr>
			<th width="50%">Kategori Aset</th>
			<th width="50%">Beban Penyusutan</th>
		</tr>
	</thead>
	<tbody>
		<?php if (empty($penyusutan['jurnal_data'])): ?>
			<tr>
				<td colspan="2" class="text-center">Tidak ada aset yang disusutkan pada periode ini.</td>
			</tr>
		<?php else: ?>
			<?php foreach ($penyusutan['jurnal_data'] as $kategori => $nominal): ?>
			<tr>
				<td><?= $kategori ?></td>
				<td class="text-right">Rp <?= number_format($nominal, 0, ',', '.') ?></td>
			</tr>
			<?php endforeach; ?>
			<tr>
				<td class="text-right fw-bold">TOTAL PENYUSUTAN</td>
				<td class="text-right fw-bold">Rp <?= number_format($penyusutan['total_jurnal'], 0, ',', '.') ?></td>
			</tr>
		<?php endif; ?>
	</tbody>
</table>

<div class="section-title">III. PENJUALAN ASET</div>
<table class="table-data">
	<thead>
		<tr>
			<th width="4%">No</th>
			<th width="12%">Kode Aset</th>
			<th width="20%">Nama Aset</th>
			<th width="12%">Tgl Penjualan</th>
			<th width="15%">Harga Perolehan</th>
			<th width="15%">Harga Jual</th>
			<th width="12%">Alasan</th>
		</tr>
	</thead>
	<tbody>
		<?php if (empty($penjualan)): ?>
			<tr>
				<td colspan="7" class="text-center">Tidak ada penjualan aset di periode ini.</td>
			</tr>
		<?php else: ?>
			<?php
			$no = 1;
			$totalHargaPerolehanJual = 0;
			$totalHargaJual = 0;
			foreach ($penjualan as $row):
				$totalHargaPerolehanJual += (float) $row['harga_perolehan'];
				$totalHargaJual += (float) $row['harga_jual'];
			?>
			<tr>
				<td class="text-center"><?= $no++ ?></td>
				<td class="text-center"><?= $row['kode_aset'] ?></td>
				<td><?= $row['nama_aset'] ?></td>
				<td class="text-center"><?= date('d/m/Y', strtotime($row['tanggal_penjualan'])) ?></td>
				<td class="text-right">Rp <?= number_format($row['harga_perolehan'], 0, ',', '.') ?></td>
				<td class="text-right">Rp <?= number_format($row['harga_jual'], 0, ',', '.') ?></td>
				<td><?= $row['alasan_dijual'] ?? '-' ?></td>
			</tr>
			<?php endforeach; ?>
			<tr>
				<td colspan="4" class="text-right fw-bold">SUBTOTAL PENJUALAN</td>
				<td class="text-right fw-bold">Rp <?= number_format($totalHargaPerolehanJual, 0, ',', '.') ?></td>
				<td class="text-right fw-bold">Rp <?= number_format($totalHargaJual, 0, ',', '.') ?></td>
				<td></td>
			</tr>
		<?php endif; ?>
	</tbody>
</table>

<div class="section-termination">
	<div class="section-title">IV. PENGHENTIAN ASET</div>
	<table class="table-data" style="margin-bottom: 10px;">
		<thead>
			<tr>
				<th width="4%">No</th>
				<th width="12%">Kode Aset</th>
				<th width="18%">Nama Aset</th>
				<th width="12%">Tgl Penghentian</th>
				<th width="15%">Harga Perolehan</th>
				<th width="18%">Alasan Penghentian</th>
				<th width="13%">Status</th>
			</tr>
		</thead>
		<tbody>
			<?php if (empty($penghentian)): ?>
				<tr>
					<td colspan="7" class="text-center">Tidak ada penghentian aset di periode ini.</td>
				</tr>
			<?php else: ?>
				<?php
				$no = 1;
				$totalHargaPerolehanHenti = 0;
				foreach ($penghentian as $row):
					$totalHargaPerolehanHenti += (float) $row['harga_perolehan'];
				?>
				<tr>
					<td class="text-center"><?= $no++ ?></td>
					<td class="text-center"><?= $row['kode_aset'] ?></td>
					<td><?= $row['nama_aset'] ?></td>
					<td class="text-center"><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
					<td class="text-right">Rp <?= number_format($row['harga_perolehan'], 0, ',', '.') ?></td>
					<td><?= $row['alasan_penghentian'] ?? '-' ?></td>
					<td class="text-center"><?= $row['status_approval'] ?></td>
				</tr>
				<?php endforeach; ?>
				<tr>
					<td colspan="4" class="text-right fw-bold">SUBTOTAL PENGHENTIAN</td>
					<td class="text-right fw-bold">Rp <?= number_format($totalHargaPerolehanHenti, 0, ',', '.') ?></td>
					<td colspan="2"></td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>

	<div class="description-box" style="margin-bottom: 0; margin-top: 5px;">
		<p class="fw-bold" style="margin-bottom: 5px; margin-top: 0;">Keterangan</p>
		<p style="margin: 0;">Laporan ini mencakup perolehan, penyusutan, penjualan, dan penghentian aset tetap selama periode <?= isset($tanggal_akhir) ? $tanggal_akhir : date('F Y') ?>.</p>
	</div>
</div>

<?= $this->endSection() ?>
