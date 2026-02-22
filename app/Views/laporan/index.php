<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 text-dark fw-bold mb-0"><i class="fas fa-file-invoice text-primary me-2"></i> Pusat Laporan Aset</h2>
            <p class="text-muted mb-0">Pilih dan cetak laporan aset tetap sesuai kebutuhan perusahaan.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-filter me-1"></i> Parameter Laporan</h6>
                </div>
                <div class="card-body p-4">
                    <form action="<?= base_url('laporan/generate') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="row g-4">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Jenis Laporan <span class="text-danger">*</span></label>
                                <select class="form-select border-primary" id="jenis_laporan" name="jenis_laporan" required>
                                    <option value="">-- Pilih Laporan --</option>
                                    <option value="keseluruhan" <?= isset($current_jenis) &&
                                    $current_jenis == 'keseluruhan'
                                    	? 'selected'
                                    	: '' ?>>Laporan Aset Tetap Keseluruhan</option>
                                    <option value="kartu_aset" <?= isset($current_jenis) &&
                                    $current_jenis == 'kartu_aset'
                                    	? 'selected'
                                    	: '' ?>>Kartu Aset Tetap (Per Aset)</option>
                                    <option value="jurnal" <?= isset($current_jenis) && $current_jenis == 'jurnal'
                                    	? 'selected'
                                    	: '' ?>>Jurnal Penyesuaian Penyusutan</option>
                                    <option value="lokasi" <?= isset($current_jenis) && $current_jenis == 'lokasi'
                                    	? 'selected'
                                    	: '' ?>>Laporan Aset Per Lokasi</option>
                                    <option value="nonaktif" <?= isset($current_jenis) && $current_jenis == 'nonaktif'
                                    	? 'selected'
                                    	: '' ?>>Laporan Aset Nonaktif (Disposed)</option>
                                </select>
                            </div>

                            <div class="col-md-4 filter-group" id="filter_periode" style="display: none;">
                                <label class="form-label fw-bold">Periode (Bulan & Tahun)</label>
                                <div class="input-group">
                                    <select name="bulan" class="form-select">
                                        <?php
                                        $bulan_array = [
                                        	1 => 'Januari',
                                        	2 => 'Februari',
                                        	3 => 'Maret',
                                        	4 => 'April',
                                        	5 => 'Mei',
                                        	6 => 'Juni',
                                        	7 => 'Juli',
                                        	8 => 'Agustus',
                                        	9 => 'September',
                                        	10 => 'Oktober',
                                        	11 => 'November',
                                        	12 => 'Desember',
                                        ];
                                        foreach ($bulan_array as $key => $val): ?>
                                            <option value="<?= $key ?>" <?= date('n') == $key
	? 'selected'
	: '' ?>><?= $val ?></option>
                                        <?php endforeach;
                                        ?>
                                    </select>
                                    <input type="number" name="tahun" class="form-control" value="<?= date('Y') ?>">
                                </div>
                            </div>

                            <div class="col-md-4 filter-group" id="filter_aset" style="display: none;">
                                <label class="form-label fw-bold">Pilih Aset</label>
                                <select class="form-select" name="asset_id">
                                    <option value="">-- Pilih Kode Aset --</option>
                                    <?php if (!empty($assets) && is_array($assets)): ?>
                                        <?php foreach ($assets as $asset): ?>
                                            <option value="<?= esc($asset['id']) ?>">
                                                <?= esc($asset['kode_aset']) ?> - <?= esc($asset['nama_aset']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="col-md-4 filter-group" id="filter_lokasi" style="display: none;">
                                <label class="form-label fw-bold">Pilih Lokasi</label>
                                <select class="form-select" name="lokasi">
                                    <option value="">-- Pilih Lokasi --</option>
                                    <?php if (!empty($lokasi) && is_array($lokasi)): ?>
                                        <?php foreach ($lokasi as $loc): ?>
                                            <?php if (!empty($loc['lokasi_aset'])): ?>
                                                <option value="<?= esc($loc['lokasi_aset']) ?>">
                                                    <?= esc($loc['lokasi_aset']) ?>
                                                </option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-light border" onclick="window.location.reload()"><i class="fas fa-sync-alt me-1"></i> Reset</button>
                            <button type="submit" name="action" value="pdf" class="btn btn-danger">
                                <i class="fas fa-file-pdf me-1"></i> Cetak PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Preview Container -->
            <div id="preview-result" class="card shadow-sm border-0 mb-4" style="display:none;">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-table me-1"></i> Preview Laporan</h6>
                </div>
                <div class="card-body p-4" id="preview-content">
                    <!-- Dynamic Content -->
                </div>
            </div>

        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        $('#jenis_laporan').change(function() {
            var jenis = $(this).val();
            
            $('.filter-group').hide();
            
            if(jenis === 'keseluruhan' || jenis === 'jurnal') {
                $('#filter_periode').fadeIn();
            } 
            else if(jenis === 'kartu_aset') {
                $('#filter_aset').fadeIn();
            }
            else if(jenis === 'lokasi') {
                $('#filter_lokasi').fadeIn();
            }
            else if(jenis === 'nonaktif') {
                // No filters needed
            }
            loadPreview();
        });

        // Trigger changes for filters
        $('select[name="bulan"], input[name="tahun"], select[name="asset_id"], select[name="lokasi"]').change(function() {
            loadPreview();
        });
        
        // Also trigger on keyup for year to be responsive
        $('input[name="tahun"]').keyup(function() {
            loadPreview();
        });

        function loadPreview() {
            var jenis = $('#jenis_laporan').val();
            if (!jenis) {
                $('#preview-result').hide();
                return;
            }

            // Simple validation before request
            if(jenis === 'kartu_aset' && !$('select[name="asset_id"]').val()) {
                $('#preview-result').hide();
                return;
            }
            if(jenis === 'lokasi' && !$('select[name="lokasi"]').val()) {
                $('#preview-result').hide();
                return;
            }

            // Show loading or similar visual cue could be added here
            $('#preview-content').html('<div class="text-center p-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2 text-muted">Memuat preview...</p></div>');
            $('#preview-result').show();
            
            $.ajax({
                url: '<?= base_url('laporan/preview') ?>',
                type: 'POST',
                data: $('form').serialize(),
                success: function(response) {
                    if(response.trim() !== '') {
                        $('#preview-result').show();
                        var iframe = document.createElement('iframe');
                        iframe.style.width = '100%';
                        iframe.style.height = '600px';
                        iframe.style.border = 'none';
                        $('#preview-content').html(iframe);
                        
                        var doc = iframe.contentWindow.document;
                        doc.open();
                        doc.write(response);
                        doc.close();
                    } else {
                        $('#preview-result').hide();
                    }
                },
                error: function(xhr, status, error) {
                    $('#preview-content').html('<div class="alert alert-danger">Gagal memuat preview: ' + error + '</div>');
                    console.error(error);
                }
            });
        }

        // Init preview if value is present
        if ($('#jenis_laporan').val()) {
            $('#jenis_laporan').trigger('change');
        }
    });
</script>
<?= $this->endSection() ?>
