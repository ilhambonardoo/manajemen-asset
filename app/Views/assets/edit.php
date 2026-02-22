<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white fw-bold">
                    <i class="fas fa-edit me-1"></i> Edit Data Aset
                </div>
                <div class="card-body p-4">
                    
                    <form action="<?= base_url('asset/update/' . $asset['id']) ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="kode_aset" class="form-label fw-bold">Kode Aset</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold" id="prefix_kode">PRE</span>
                                    <input type="text" class="form-control" id="nomor_aset" placeholder="001" maxlength="4" 
                                           value="<?= isset($asset['kode_aset'])
                                           	? explode('-', $asset['kode_aset'])[1] ?? $asset['kode_aset']
                                           	: '' ?>">
                                    <input type="hidden" id="kode_aset" name="kode_aset" value="<?= old(
                                    	'kode_aset',
                                    	$asset['kode_aset']
                                    ) ?>">
                                </div>
                                <small class="text-muted">Prefix otomatis sesuai kategori.</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Aset</label>
                                <input type="text" class="form-control" name="nama_aset" 
                                       value="<?= old('nama_aset', $asset['nama_aset']) ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kategori</label>
                                <select class="form-select" id="kelompok_aset" name="kelompok_aset" required>
                                    <option value="" disabled>-- Pilih Kategori --</option>
                                    <option value="office equipment" <?= $asset['kelompok_aset'] == 'office equipment'
                                    	? 'selected'
                                    	: '' ?>>Office Equipment</option>
                                    <option value="furniture/fixture (non metal)" <?= $asset['kelompok_aset'] ==
                                    'furniture/fixture (non metal)'
                                    	? 'selected'
                                    	: '' ?>>Furniture (Non-Metal)</option>
                                    <option value="furniture/fixture (metal)" <?= $asset['kelompok_aset'] ==
                                    'furniture/fixture (metal)'
                                    	? 'selected'
                                    	: '' ?>>Furniture (Metal)</option>
                                    <option value="booth" <?= $asset['kelompok_aset'] == 'booth'
                                    	? 'selected'
                                    	: '' ?>>Booth</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="umur_penyusutan" class="form-label fw-bold">Umur Ekonomis (Bulan)</label>
                                <input type="number" class="form-control" id="umur_penyusutan" name="umur_penyusutan" 
                                       value="<?= old(
                                       	'umur_penyusutan',
                                       	$asset['umur_penyusutan']
                                       ) ?>" readonly required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="harga_satuan" class="form-label fw-bold">Harga Satuan (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" class="form-control" id="harga_satuan_display" placeholder="0" 
                                           value="<?= old('harga_satuan', $asset['harga_satuan'] ?? 0) ?>" required>
                                    <input type="hidden" id="harga_satuan" name="harga_satuan" value="<?= old(
                                    	'harga_satuan',
                                    	$asset['harga_satuan'] ?? 0
                                    ) ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="jumlah_aset" class="form-label fw-bold">Jumlah</label>
                                <input type="number" class="form-control" id="jumlah_aset" name="jumlah_aset" placeholder="0" 
                                       value="<?= old('jumlah_aset', $asset['jumlah_aset'] ?? 1) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="harga_perolehan" class="form-label fw-bold">Total Harga Perolehan (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" class="form-control bg-light" id="harga_perolehan_display" placeholder="Total" 
                                           value="<?= old(
                                           	'harga_perolehan',
                                           	$asset['harga_perolehan']
                                           ) ?>" readonly required>
                                    <input type="hidden" id="harga_perolehan" name="harga_perolehan" value="<?= old(
                                    	'harga_perolehan',
                                    	$asset['harga_perolehan']
                                    ) ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tanggal Perolehan</label>
                                <input type="date" class="form-control" name="tanggal_perolehan" 
                                       value="<?= old('tanggal_perolehan', $asset['tanggal_perolehan']) ?>" required>
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
                                <label class="form-label fw-bold">Status</label>
                                <select name="status_aktif" class="form-select" required>
                                    <option value="1" <?= $asset['status_aktif'] == 1 ? 'selected' : '' ?>>
                                        Active
                                    </option>
                                    <option value="0" <?= $asset['status_aktif'] == 0 ? 'selected' : '' ?>>
                                        Disposed / Non-Aktif
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="<?= base_url('asset/daftar') ?>" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Update Data</button>
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
        
        const hargaSatuanDisplay = document.getElementById('harga_satuan_display');
        const hargaSatuanHidden = document.getElementById('harga_satuan');
        
        const jumlahAsetInput = document.getElementById('jumlah_aset');
        
        const totalPerolehanDisplay = document.getElementById('harga_perolehan_display');
        const totalPerolehanHidden = document.getElementById('harga_perolehan');

        function formatRupiah(angka) {
            let number_string = angka.toString().replace(/[^,\d]/g, ''),
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

        function hitungTotal() {
            let harga = parseFloat(hargaSatuanHidden.value) || 0;
            let jumlah = parseFloat(jumlahAsetInput.value) || 0;
            
            let total = harga * jumlah;

            if(totalPerolehanHidden) totalPerolehanHidden.value = total;
            
            if(totalPerolehanDisplay) totalPerolehanDisplay.value = formatRupiah(total.toString());
        }

        if(hargaSatuanDisplay) {
            hargaSatuanDisplay.addEventListener('input', function(e) {
                let rawValue = this.value.replace(/\D/g, ''); 
                
                this.value = formatRupiah(rawValue);

                if(hargaSatuanHidden) hargaSatuanHidden.value = rawValue;

                hitungTotal();
            });
            
            if(hargaSatuanHidden.value) {
                hargaSatuanDisplay.value = formatRupiah(hargaSatuanHidden.value);
            }
        }

        if(totalPerolehanHidden && totalPerolehanHidden.value) {
             totalPerolehanDisplay.value = formatRupiah(totalPerolehanHidden.value);
        }

        if(jumlahAsetInput) {
             jumlahAsetInput.addEventListener('input', hitungTotal);
        }

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

        function updateKategoriState(isInitialLoad = false) {
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
            
            if (!isInitialLoad) {
                updateKodeAset();
            }
        }

        kategoriSelect.addEventListener('change', function() {
            updateKategoriState(false);
        });
        
        if(kategoriSelect.value) {
            updateKategoriState(true);
        }
    });
</script>
<?= $this->endSection() ?>
