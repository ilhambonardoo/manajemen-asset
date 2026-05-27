<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
    .cursor-pointer { cursor: pointer; }
    .row-selected { background-color: #f0f0f0 !important; }
    #tableAssets thead th { vertical-align: middle; }
    .form-check-input:checked { background-color: #6c757d; border-color: #6c757d; }
</style>
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 text-dark fw-bold">Daftar Aset Tetap</h2>
        <div class="d-flex" style="gap: 10px;">
            <?php if (session()->get('role_name') == 'Admin'): ?>
                <button type="button" id="btn-bulk-delete" class="btn btn-outline-danger fw-bold d-none" data-bs-toggle="modal" data-bs-target="#bulkDeleteModal">
                    <i class="fas fa-trash-alt me-1"></i> Hapus Terpilih
                </button>
            <?php endif; ?>
            <?php if (in_array(session()->get('role_name'), ['Admin', 'Supervisor', 'Staff Finance'])): ?>
                <a href="<?= base_url('asset/create') ?>" class="btn btn-warning fw-bold">
                    <i class="fas fa-plus me-1"></i> Tambah Aset Baru
                </a>
            <?php endif; ?>
        </div>
    </div>

    <?php if (session()->getFlashdata('pesan')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('pesan') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table id="tableAssets" class="table table-hover align-middle">
                    <thead class="table-yellow">
                        <tr>
                            <?php if (session()->get('role_name') == 'Admin'): ?>
                                <th class="text-center" width="50">
                                    <div class="form-check d-flex justify-content-center align-items-center">
                                        <input class="form-check-input cursor-pointer" type="checkbox" id="check-all" style="width: 1.25rem; height: 1.25rem; margin-top: 0;">
                                    </div>
                                </th>
                            <?php endif; ?>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Aset</th>
                            <th>Kategori</th>
                            <th>Tgl Perolehan</th>
                            <th>Harga</th>
                            <th>Umur (Bln)</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($assets as $item): ?>
                            <tr class="<?= session()->get('role_name') == 'Admin' ? 'row-selectable' : '' ?>" style="<?= session()->get('role_name') == 'Admin' ? 'cursor: pointer;' : '' ?>">
                                <?php if (session()->get('role_name') == 'Admin'): ?>
                                    <td class="text-center">
                                        <div class="form-check d-flex justify-content-center align-items-center">
                                            <input class="form-check-input asset-checkbox cursor-pointer" type="checkbox" value="<?= $item['id'] ?>" name="asset_ids[]" style="width: 1.2rem; height: 1.2rem; margin-top: 0;">
                                        </div>
                                    </td>
                                <?php endif; ?>
                                <td><?= $no++ ?></td>
                                <td class="fw-bold text-primary"><?= $item['kode_aset'] ?></td>
                                <td>
                                    <div class="fw-bold"><?= $item['nama_aset'] ?></div>
                                </td>
                                <td><?= ucwords($item['kelompok_aset']) ?></td>
                                <td><?= date('d M Y', strtotime($item['tanggal_perolehan'])) ?></td>
                                <td class="fw-bold">
                                    Rp <?= number_format($item['harga_perolehan'], 0, ',', '.') ?>
                                </td>
                                <td><?= $item['umur_penyusutan'] ?> Bulan</td>
                                <td><?= $item['lokasi_aset'] ?></td>
                                <td>
                                    <?php if ($item['status_aktif'] == 1): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Non Active</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex flex-wrap justify-content-center" style="gap: 5px; max-width: 80px; margin: 0 auto;">
                                        <?php if (
                                        	in_array(session()->get('role_name'), [
                                        		'Admin',
                                        		'Supervisor',
                                        		'Staff Finance',
                                        	])
                                        ): ?>
                                            <a href="<?= base_url(
                                            	'asset/edit/' . $item['id']
                                            ) ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= base_url(
                                            	'asset/detail/' . $item['id']
                                            ) ?>" class="btn btn-sm btn-outline-info" title="Detail & Kelola Aset">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        <?php endif; ?>

                                        <?php if (in_array($item['id'], $pending_ids)): ?>
                                            <span class="badge bg-warning text-dark py-2 w-100" title="Menunggu Approval Admin">
                                                <i class="fas fa-clock me-1"></i> Pending
                                            </span>

                                        <?php elseif (
                                        	$item['status_aktif'] == 1 &&
                                        	in_array(session()->get('role_name'), [
                                        		'Admin',
                                        		'Supervisor',
                                        		'Staff Finance',
                                        	])
                                        ): ?>
                                            <button type="button" class="btn btn-sm btn-outline-warning btn-ajukan" data-bs-toggle="modal" data-bs-target="#ajukanModal" data-id="<?= $item[
                                            	'id'
                                            ] ?>" data-nama="<?= $item[
	'nama_aset'
] ?>" title="Ajukan Penjualan/Pelepasan">
                                                <i class="fas fa-hand-holding-usd"></i>
                                            </button>
                                        <?php endif; ?>

                                        <?php if (session()->get('role_name') == 'Admin'): ?>
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $item[
                                            	'id'
                                            ] ?>" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data aset ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="#" id="btn-confirm-delete" class="btn btn-danger">Ya, Hapus!</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="bulkDeleteModal" tabindex="-1" aria-labelledby="bulkDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="bulkDeleteModalLabel">Konfirmasi Hapus Massal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('asset/delete-batch') ?>" method="post" id="form-bulk-delete">
                    <?= csrf_field() ?>
                    <div id="selected-ids-container"></div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus <span id="selected-count" class="fw-bold">0</span> data aset yang dipilih? Tindakan ini tidak dapat dibatalkan.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Hapus Semua!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ajukanModal" tabindex="-1" aria-labelledby="ajukanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title fw-bold" id="ajukanModalLabel">Ajukan Pengajuan Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('asset/ajukan') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <input type="hidden" name="asset_id" id="penjualan_asset_id">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Aset</label>
                            <input type="text" class="form-control bg-light" id="penjualan_nama_aset" readonly>
                            <small class="text-muted">Aset yang akan diajukan.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Jenis Pengajuan <span class="text-danger">*</span></label>
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input jenis-pengajuan" type="radio" name="jenis_pengajuan" id="jenis_penjualan" value="penjualan" checked>
                                    <label class="form-check-label" for="jenis_penjualan">
                                        <i class="fas fa-hand-holding-usd me-2" style="color: #28a745;"></i>Penjualan Aset
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input jenis-pengajuan" type="radio" name="jenis_pengajuan" id="jenis_penghentian" value="penghentian">
                                    <label class="form-check-label" for="jenis_penghentian">
                                        <i class="fas fa-power-off me-2" style="color: #dc3545;"></i>Penghentian Aset
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_penjualan" class="form-label fw-bold">Tanggal Pengajuan <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="tanggal_penjualan" name="tanggal_penjualan" value="<?= date(
                            	'Y-m-d'
                            ) ?>" required>
                        </div>

                        <div class="mb-3" id="harga-jual-section">
                            <label for="harga_jual" class="form-label fw-bold">Harga Jual (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="harga_jual" name="harga_jual" placeholder="Contoh: 5000000">
                        </div>

                        <div class="mb-3">
                            <label for="alasan_dijual" class="form-label fw-bold"><span id="label-alasan">Alasan Dijual</span> <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="alasan_dijual" name="alasan_dijual" rows="3" placeholder="Contoh: Barang sudah rusak / Ganti unit baru..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning fw-bold text-dark">
                            <i class="fas fa-paper-plane me-1"></i> Kirim Pengajuan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        var table = $('#tableAssets').DataTable({
            "language": {
                "search": "Cari Aset:",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ aset"
            }
        });

        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');

            console.log("ID Aset yang akan dihapus:", id);
            var deleteUrl = '<?= base_url('asset/delete') ?>/' + id;
            $(this).find('#btn-confirm-delete').attr('href', deleteUrl);
        });

        // Bulk Delete Logic
        $('#check-all').on('click', function() {
            var rows = table.rows({ 'search': 'applied' }).nodes();
            var checked = this.checked;
            $('.asset-checkbox', rows).prop('checked', checked).each(function() {
                var row = $(this).closest('tr');
                if (checked) {
                    row.addClass('row-selected');
                } else {
                    row.removeClass('row-selected');
                }
            });
            toggleBulkDeleteButton();
        });

        $('#tableAssets tbody').on('change', '.asset-checkbox', function() {
            var row = $(this).closest('tr');
            if (this.checked) {
                row.addClass('row-selected');
            } else {
                row.removeClass('row-selected');
            }

            if (!this.checked) {
                var el = $('#check-all').get(0);
                if (el && el.checked && ('indeterminate' in el)) {
                    el.indeterminate = true;
                }
            }
            toggleBulkDeleteButton();
        });

        // Click on row to toggle checkbox (excluding action buttons)
        $('#tableAssets tbody').on('click', 'tr.row-selectable td:not(:last-child)', function(e) {
            if ($(e.target).is('input')) return;
            
            var checkbox = $(this).closest('tr').find('.asset-checkbox');
            checkbox.prop('checked', !checkbox.prop('checked')).trigger('change');
        });

        function toggleBulkDeleteButton() {
            var rows = table.rows({ 'search': 'applied' }).nodes();
            var checkedCount = $('.asset-checkbox:checked', rows).length;
            if (checkedCount > 0) {
                $('#btn-bulk-delete').removeClass('d-none');
            } else {
                $('#btn-bulk-delete').addClass('d-none');
            }
        }

        $('#bulkDeleteModal').on('show.bs.modal', function() {
            var selectedIds = [];
            var rows = table.rows({ 'search': 'applied' }).nodes();
            $('.asset-checkbox:checked', rows).each(function() {
                selectedIds.push($(this).val());
            });

            $('#selected-count').text(selectedIds.length);
            
            var container = $('#selected-ids-container');
            container.empty();
            selectedIds.forEach(function(id) {
                container.append('<input type="hidden" name="ids[]" value="' + id + '">');
            });
        });

        $('#tableAssets tbody').on('click', '.btn-ajukan', function() {
            var id = $(this).attr('data-id');
            var nama = $(this).attr('data-nama');

            $('#penjualan_asset_id').val(id);
            $('#penjualan_nama_aset').val(nama);
            $('#jenis_penjualan').prop('checked', true);
            updateFormFields();
        });

        $('input[name="jenis_pengajuan"]').change(function() {
            updateFormFields();
        });

        function updateFormFields() {
            var jenisPengajuan = $('input[name="jenis_pengajuan"]:checked').val();
            var hargaJualSection = $('#harga-jual-section');
            var hargaJualInput = $('#harga_jual');
            var labelAlasan = $('#label-alasan');

            if (jenisPengajuan === 'penjualan') {
                hargaJualSection.show();
                hargaJualInput.prop('required', true);
                labelAlasan.text('Alasan Dijual');
            } else {
                hargaJualSection.hide();
                hargaJualInput.prop('required', false);
                hargaJualInput.val('');
                labelAlasan.text('Alasan Penghentian');
            }
        }
    });
</script>
<?= $this->endSection() ?>
