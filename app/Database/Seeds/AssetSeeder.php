<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class AssetSeeder extends Seeder {
	public function run() {
		$data = [];

		// Daftar nama aset biar terlihat real
		$items = [
			'Laptop Dell Latitude 5420',
			'MacBook Pro M1',
			'Meja Kerja Staff (Kayu)',
			'Kursi Ergonomis High Back',
			'AC Daikin 2PK Inverter',
			'Projector Epson EB-X500',
			'Lemari Arsip Besi 4 Laci',
			'Server Rack 42U',
			'Honda Vario 160 (Kendaraan Ops)',
			'Sofa Tamu L-Shape',
			'Printer HP LaserJet Pro',
			'Booth Pameran Portable',
			'Meja Meeting Oval 12 Seat',
			'Dispenser Galon Bawah Sharp',
		];

		// Lokasi aset
		$locations = [
			'Head Office - Lt 1',
			'Head Office - Lt 2',
			'Gudang Cikarang',
			'Cabang Bandung',
			'Cabang Surabaya',
		];

		// Sesuai ENUM di Migration
		$categories = ['office equipment', 'furniture/fixture (non metal)', 'furniture/fixture (metal)', 'booth'];

		// Sesuai ENUM di Migration
		$sources = ['Accurate', 'Kingdee'];

		for ($i = 1; $i <= 50; $i++) {
			// Random index untuk pengambilan data acak
			$itemRand = $items[array_rand($items)];
			$catRand = $categories[array_rand($categories)];
			$locRand = $locations[array_rand($locations)];
			$srcRand = $sources[array_rand($sources)];

			// Random Tanggal antara 2020 - 2024
			$year = rand(2020, 2024);
			$month = rand(1, 12);
			$day = rand(1, 28);
			$date = "$year-$month-$day";

			// Random Harga (Jutaan - Puluhan Juta)
			$price = rand(2, 25) * 1000000;

			// Tentukan umur penyusutan (misal: elektronik 4 thn, furniture 8 thn)
			$usefulLife = $catRand == 'office equipment' ? 4 : 8;

			$data[] = [
				'kode_aset' => 'AST-' . str_pad($i, 4, '0', STR_PAD_LEFT), // Hasil: AST-0001
				'nama_aset' => $itemRand,
				'kelompok_aset' => $catRand,
				'jumlah_aset' => 1,
				'harga_perolehan' => $price,
				'umur_penyusutan' => $usefulLife,
				'tanggal_perolehan' => $date,
				'lokasi_aset' => $locRand,
				'sumber_data' => $srcRand, // Penting untuk Gap Analysis
				'status_aktif' => 1, // Default Aktif
				'created_at' => Time::now(),
				'updated_at' => Time::now(),
			];
		}

		// Insert Batch (Sekali jalan langsung 50 data masuk)
		$this->db->table('assets')->insertBatch($data);
	}
}
