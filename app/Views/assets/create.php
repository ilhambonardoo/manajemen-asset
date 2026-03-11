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
                                <div class="input-group">
                                    <select class="form-select" id="lokasi_aset" required></select>
                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalTambahLokasi" title="Tambah Lokasi Baru">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="lokasi_aset_final" name="lokasi_aset">

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

<div class="modal fade" id="modalTambahLokasi" tabindex="-1" aria-labelledby="modalTambahLokasiLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalTambahLokasiLabel">Tambah Lokasi Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="namaLokasiModal" class="form-label fw-bold">Nama Lokasi</label>
                    <input type="text" class="form-control" id="namaLokasiModal" placeholder="Contoh: Gudang Cabang Bandung" maxlength="100">
                    <div class="text-danger small mt-2" id="errorMsgModal" style="display: none;"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-info text-white" id="btnTambahLokasi">Tambah Lokasi</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const lokasiSelect = document.getElementById('lokasi_aset');
        const lokasiCustomContainer = document.getElementById('lokasi_custom_container');
        const lokasiCustomInput = document.getElementById('lokasi_custom');

        fetch('<?= base_url('lokasi') ?>')
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                loadLokasiOptions();
            })
            .catch(error => console.error('Error loading lokasi:', error));

        function loadLokasiOptions() {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', '<?= base_url('api/lokasi') ?>', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        const lokasiList = JSON.parse(xhr.responseText);
                        lokasiSelect.innerHTML = '<option value="" selected disabled>-- Pilih Lokasi --</option>';
                        lokasiList.forEach(lokasi => {
                            const option = document.createElement('option');
                            option.value = lokasi.nama;
                            option.textContent = lokasi.nama;
                            if (lokasi.nama === '<?= old('lokasi_aset') ?>') {
                                option.selected = true;
                            }
                            lokasiSelect.appendChild(option);
                        });
                    } catch (e) {
                        console.error('Error parsing lokasi:', e);
                    }
                }
            };
            xhr.send();
        }

        const btnTambahLokasi = document.getElementById('btnTambahLokasi');
        const namaLokasiModal = document.getElementById('namaLokasiModal');
        const errorMsgModal = document.getElementById('errorMsgModal');
        const modalTambahLokasi = document.getElementById('modalTambahLokasi');
        const modalInstance = new bootstrap.Modal(modalTambahLokasi);

        if (btnTambahLokasi) {
            btnTambahLokasi.addEventListener('click', function() {
                const namaLokasi = namaLokasiModal.value.trim();

                if (!namaLokasi) {
                    errorMsgModal.textContent = 'Nama lokasi tidak boleh kosong';
                    errorMsgModal.style.display = 'block';
                    return;
                }

                const formData = new FormData();
                formData.append('nama_lokasi', namaLokasi);

                fetch('<?= base_url('lokasi/tambah') ?>', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadLokasiOptions();
                        
                        setTimeout(() => {
                            lokasiSelect.value = data.nama;
                        }, 100);

                        namaLokasiModal.value = '';
                        errorMsgModal.style.display = 'none';
                        
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
                        alertDiv.style.zIndex = '9999';
                        alertDiv.innerHTML = `
                            <i class="fas fa-check-circle me-2"></i>${data.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        `;
                        document.body.appendChild(alertDiv);
                        
                        modalInstance.hide();

                        setTimeout(() => alertDiv.remove(), 3000);
                    } else {
                        errorMsgModal.textContent = data.message || 'Terjadi kesalahan';
                        errorMsgModal.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    errorMsgModal.textContent = 'Gagal menambahkan lokasi';
                    errorMsgModal.style.display = 'block';
                });
            });

            modalTambahLokasi.addEventListener('show.bs.modal', function() {
                namaLokasiModal.value = '';
                errorMsgModal.style.display = 'none';
            });
        }

        const kategoriSelect = document.getElementById('kelompok_aset');
        const umurInput = document.getElementById('umur_penyusutan');
        
        const hargaSatuanDisplay = document.getElementById('harga_satuan_display');
        const hargaSatuanHidden = document.getElementById('harga_satuan');
        
        const jumlahAsetInput = document.getElementById('jumlah_aset');
        
        const totalPerolehanDisplay = document.getElementById('harga_perolehan_display');
        const totalPerolehanHidden = document.getElementById('harga_perolehan');

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

        function hitungTotal() {
            let harga = parseFloat(document.getElementById('harga_satuan').value) || 0;
            let jumlah = parseFloat(document.getElementById('jumlah_aset').value) || 0;
            
            let total = harga * jumlah;

            const hiddenHarga = document.getElementById('harga_perolehan');
            if(hiddenHarga) hiddenHarga.value = total;
            
            const displayHarga = document.getElementById('harga_perolehan_display');
            if(displayHarga) displayHarga.value = formatRupiah(total.toString());
        }

        if(hargaSatuanDisplay) {
            hargaSatuanDisplay.addEventListener('input', function(e) {
                let rawValue = this.value.replace(/\D/g, ''); 
                
                this.value = formatRupiah(rawValue);

                if(hargaSatuanHidden) hargaSatuanHidden.value = rawValue;

                hitungTotal();
            });
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
        
        if(kategoriSelect.value) {
            updateKategoriState();
        }

        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const lokasiFinalInput = document.getElementById('lokasi_aset_final');
            lokasiFinalInput.value = lokasiSelect.value;
        });
    })
</script>
<?= $this->endSection() ?>