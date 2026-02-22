<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark fw-bold">
                    <i class="fas fa-plus-circle me-1"></i> Perolehan Aset
                </div>


                <div class="card-body p-4">    
                    <form action="<?= base_url('asset/store') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="kode_aset" class="form-label fw-bold">Kode Aset</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold" id="prefix_kode">PRE</span>
                                    <input type="text" class="form-control" id="nomor_aset" placeholder="001" maxlength="4" 
                                           value="<?= old('kode_aset')
                                           	? explode('-', old('kode_aset'))[1] ?? ''
                                           	: '' ?>" required>
                                    <input type="hidden" id="kode_aset" name="kode_aset" value="<?= old(
                                    	'kode_aset'
                                    ) ?>">
                                </div>
                                <small class="text-muted">Prefix otomatis sesuai kategori. Masukkan nomor urut (contoh: 001)</small>
                                <div class="text-danger small">
                                    <?= $validation->getError('kode_aset') ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="nama_aset" class="form-label fw-bold">Nama Aset</label>
                                <input type="text" class="form-control" id="nama_aset" name="nama_aset" 
                                       placeholder="Cth: Laptop ASUS ROG" value="<?= old('nama_aset') ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="kelompok_aset" class="form-label fw-bold">Kategori</label>
                                <select class="form-select" id="kelompok_aset" name="kelompok_aset" required>
                                    <option value="" selected disabled>-- Pilih Kategori --</option>
                                    <option value="office equipment" <?= old('kelompok_aset') == 'office equipment'
                                    	? 'selected'
                                    	: '' ?>>Office Equipment</option>
                                    <option value="furniture/fixture (non metal)" <?= old('kelompok_aset') ==
                                    'furniture/fixture (non metal)'
                                    	? 'selected'
                                    	: '' ?>>Furniture (Non-Metal)</option>
                                    <option value="furniture/fixture (metal)" <?= old('kelompok_aset') ==
                                    'furniture/fixture (metal)'
                                    	? 'selected'
                                    	: '' ?>>Furniture (Metal)</option>
                                    <option value="booth" <?= old('kelompok_aset') == 'booth'
                                    	? 'selected'
                                    	: '' ?>>Booth</option>
                                </select>
                            </div>
                             <div class="col-md-6">
                                <label for="umur_penyusutan" class="form-label fw-bold">Umur Ekonomis (Bulan)</label>
                                <input type="number" class="form-control" id="umur_penyusutan" name="umur_penyusutan" placeholder="Otomatis terisi..." value="<?= old(
                                	'umur_penyusutan'
                                ) ?>" readonly required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="harga_satuan" class="form-label fw-bold">Harga Satuan (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" class="form-control" id="harga_satuan_display" placeholder="0" 
                                           value="<?= old('harga_satuan') ?>" required>
                                    <input type="hidden" id="harga_satuan" name="harga_satuan" value="<?= old(
                                    	'harga_satuan'
                                    ) ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="jumlah_aset" class="form-label fw-bold">Jumlah</label>
                                <input type="number" class="form-control" id="jumlah_aset" name="jumlah_aset" placeholder="0" value="<?= old(
                                	'jumlah_aset',
                                	1
                                ) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="harga_perolehan" class="form-label fw-bold">Total Harga Perolehan (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" class="form-control bg-light" id="harga_perolehan_display" placeholder="Total" 
                                           value="<?= old('harga_perolehan') ?>" readonly required>
                                    <input type="hidden" id="harga_perolehan" name="harga_perolehan" value="<?= old(
                                    	'harga_perolehan'
                                    ) ?>">
                                </div>
                            </div>
                        </div>


                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="tanggal_perolehan" class="form-label fw-bold">Tanggal Perolehan</label>
                                <input type="date" class="form-control" name="tanggal_perolehan" value="<?= old(
                                	'tanggal_perolehan'
                                ) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="metode_penyusutan" class="form-label fw-bold">Metode Penyusutan</label>
                                <select class="form-select" name="metode_penyusutan" required>
                                    <option value="Garis Lurus" selected>Garis Lurus</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                             <div class="col-md-6">
                                <label for="lokasi_aset" class="form-label fw-bold">Lokasi Aset</label>
                                <select class="form-select" name="lokasi_aset" required>
                                    <option value="" selected disabled>-- Pilih Lokasi --</option>
                                    <option value="Director Room" <?= old('lokasi_aset') == 'Director Room'
                                    	? 'selected'
                                    	: '' ?>>Director Room</option>
                                    <option value="Finance Room" <?= old('lokasi_aset') == 'Finance Room'
                                    	? 'selected'
                                    	: '' ?>>Finance Room</option>
                                    <option value="Office 1" <?= old('lokasi_aset') == 'Office 1'
                                    	? 'selected'
                                    	: '' ?>>Office 1</option>
                                    <option value="Office 2" <?= old('lokasi_aset') == 'Office 2'
                                    	? 'selected'
                                    	: '' ?>>Office 2</option>
                                    <option value="Ruang Meeting Jakarta" <?= old('lokasi_aset') ==
                                    'Ruang Meeting Jakarta'
                                    	? 'selected'
                                    	: '' ?>>Ruang Meeting Jakarta</option>
                                    <option value="Ruang Meeting Surabaya" <?= old('lokasi_aset') ==
                                    'Ruang Meeting Surabaya'
                                    	? 'selected'
                                    	: '' ?>>Ruang Meeting Surabaya</option>
                                    <option value="Ruang Meeting Yogyakarta" <?= old('lokasi_aset') ==
                                    'Ruang Meeting Yogyakarta'
                                    	? 'selected'
                                    	: '' ?>>Ruang Meeting Yogyakarta</option>
                                    <option value="Ruang Meeting Bali" <?= old('lokasi_aset') == 'Ruang Meeting Bali'
                                    	? 'selected'
                                    	: '' ?>>Ruang Meeting Bali</option>
                                    <option value="Live Streaming Room" <?= old('lokasi_aset') == 'Live Streaming Room'
                                    	? 'selected'
                                    	: '' ?>>Live Streaming Room</option>
                                    <option value="Pantry" <?= old('lokasi_aset') == 'Pantry'
                                    	? 'selected'
                                    	: '' ?>>Pantry</option>
                                    <option value="Lobby" <?= old('lokasi_aset') == 'Lobby'
                                    	? 'selected'
                                    	: '' ?>>Lobby</option>
                                    <option value="Gudang" <?= old('lokasi_aset') == 'Gudang'
                                    	? 'selected'
                                    	: '' ?>>Gudang</option>
                                    <option value="Lainnya" <?= old('lokasi_aset') == 'Lainnya'
                                    	? 'selected'
                                    	: '' ?>>Lainnya</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="<?= base_url('asset/daftar') ?>" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-dark">Simpan Aset</button>
                        </div>
                    </form>
                    </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const kategoriSelect = document.getElementById('kelompok_aset');
        const umurInput = document.getElementById('umur_penyusutan');
        
        // Elemen Harga Satuan
        const hargaSatuanDisplay = document.getElementById('harga_satuan_display');
        const hargaSatuanHidden = document.getElementById('harga_satuan');
        
        // Elemen Jumlah
        const jumlahAsetInput = document.getElementById('jumlah_aset');
        
        // Elemen Harga Perolehan (Total)
        const totalPerolehanDisplay = document.getElementById('harga_perolehan_display');
        const totalPerolehanHidden = document.getElementById('harga_perolehan');

        // Fungsi Format Rupiah
        function formatRupiah(angka) {
            let number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            return split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        }

        // Fungsi Hitung Total
        function hitungTotal() {
            // Ambil value asli (angka murni) dari hidden input atau parse dari display
            let harga = parseFloat(document.getElementById('harga_satuan').value) || 0;
            let jumlah = parseFloat(document.getElementById('jumlah_aset').value) || 0;
            
            let total = harga * jumlah;

            // Set ke hidden input (untuk dikirim ke database)
            const hiddenHarga = document.getElementById('harga_perolehan');
            if(hiddenHarga) hiddenHarga.value = total;
            
            // Set ke display (diformat)
            const displayHarga = document.getElementById('harga_perolehan_display');
            if(displayHarga) displayHarga.value = formatRupiah(total.toString());
        }

        // Event Listener untuk Harga Satuan (Input User)
        if(hargaSatuanDisplay) {
            hargaSatuanDisplay.addEventListener('input', function(e) {
                // Hapus karakter selain angka
                let rawValue = this.value.replace(/\D/g, ''); 
                
                // Format tampilan dengan titik ribuan
                this.value = formatRupiah(rawValue);

                // Simpan nilai murni (integer) ke hidden input
                if(hargaSatuanHidden) hargaSatuanHidden.value = rawValue;

                // Hitung total
                hitungTotal();
            });
        }

        // Event Listener untuk Jumlah
        if(jumlahAsetInput) {
             jumlahAsetInput.addEventListener('input', hitungTotal);
        }

        // Logic Kode Aset Otomatis
        const prefixDisplay = document.getElementById('prefix_kode');
        const nomorAsetInput = document.getElementById('nomor_aset');
        const kodeAsetHidden = document.getElementById('kode_aset');

        function updateKodeAset() {
            let prefix = prefixDisplay.innerText;
            let nomor = nomorAsetInput.value;
            if (prefix !== 'PRE' && nomor) {
                kodeAsetHidden.value = prefix + '-' + nomor;
            } else {
                 kodeAsetHidden.value = '';
            }
        }

        nomorAsetInput.addEventListener('input', updateKodeAset);

        function updateKategoriState() {
            const kategori = kategoriSelect.value;
            let umur = '';
            let prefix = 'PRE';

            if (kategori === 'office equipment') {
                umur = 48;
                prefix = 'OEP';
            } else if (kategori === 'furniture/fixture (non metal)') {
                umur = 48;
                prefix = 'FNM';
            } else if (kategori === 'furniture/fixture (metal)') {
                umur = 96;
                prefix = 'FMT';
            } else if (kategori === 'booth') {
                umur = 96;
                prefix = 'BTH';
            }

            if(umur) umurInput.value = umur;
            prefixDisplay.innerText = prefix;
            updateKodeAset();
        }

        kategoriSelect.addEventListener('change', updateKategoriState);
        
        // Trigger saat load jika ada old value
        if(kategoriSelect.value) {
            updateKategoriState();
        }
    });
</script>
<?= $this->endSection() ?>
