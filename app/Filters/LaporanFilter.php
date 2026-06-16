<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class LaporanFilter implements FilterInterface {
	/**
	 * Filter untuk membatasi akses laporan berdasarkan role dan jenis laporan
	 * Staff hanya bisa akses: keseluruhan, lokasi
	 *
	 * @param RequestInterface $request
	 * @param array|null       $arguments
	 *
	 * @return RequestInterface|ResponseInterface|string|void
	 */
	public function before(RequestInterface $request, $arguments = null) {
		$role = session()->get('role_name');
		$jenis = $request->getGet('jenis');
		$jenisLaporan = $request->getPost('jenis_laporan');

		// Jika role Staff, batasi hanya ke jenis keseluruhan dan lokasi
		if ($role === 'Staff GA') {
			$allowedJenis = ['keseluruhan', 'lokasi'];
			
			// Check GET parameter (untuk halaman index)
			if ($jenis && !in_array($jenis, $allowedJenis)) {
				return redirect()->to('laporan')->with('error', 'Akses ke jenis laporan ini ditolak!');
			}
			
			// Check POST parameter (untuk preview/generate)
			if ($jenisLaporan && !in_array($jenisLaporan, $allowedJenis)) {
				return redirect()->to('laporan')->with('error', 'Akses ke jenis laporan ini ditolak!');
			}
		}
	}

	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
		//
	}
}
