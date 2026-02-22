<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid mt-4">
    <h3 class="mb-4">Tambah Detail Ruangan <?= $kode_lokasi ?> - <?= $nama_lokasi ?></h3>

    <form action="/lokasi/simpan_penempatan" method="post">
        <input type="hidden" name="nama_lokasi" value="<?= $nama_lokasi ?>">
        
        <div class="row mb-3">
            <div class="col-md-3">
                <label>Tanggal Penempatan</label>
                <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="col-md-9 text-end align-self-end">
                <button type="submit" class="btn btn-primary px-4">Simpan Penempatan</button>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white py-3">
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari aset berdasarkan kode, nama, lokasi...">
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="assetTable">
                        <thead class="table-light">
                            <tr>
                                <th width="20%">Kode Aset</th>
                                <th width="50%">Nama Aset</th>
                                <th width="15%">Lokasi Saat Ini</th>
                                <th width="15%" class="text-center">
                                    <input type="checkbox" id="checkAll"> Check All
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($aset_tersedia)): ?>
                                <tr><td colspan="4" class="text-center">Tidak ada aset yang tersedia.</td></tr>
                            <?php else: ?>
                                <?php foreach ($aset_tersedia as $aset): ?>
                                <tr>
                                    <td><?= $aset['kode_aset'] ?></td>
                                    <td><?= $aset['nama_aset'] ?></td>
                                    <td><?= $aset['lokasi_aset'] ?? 'Belum ada' ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" name="aset_id[]" value="<?= $aset[
                                        	'id'
                                        ] ?>" class="checkItem">
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.getElementById('checkAll').addEventListener('change', function() {
        var checkboxes = document.querySelectorAll('.checkItem');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    });

    document.getElementById('searchInput').addEventListener('keyup', function() {
        var input, filter, table, tr, td_kode, td_nama, i, txtValueKode, txtValueNama, txtValueLokasi;
        input = document.getElementById('searchInput');
        filter = input.value.toUpperCase();
        table = document.getElementById('assetTable');
        tr = table.getElementsByTagName('tr');

        for (i = 0; i < tr.length; i++) {
            td_kode = tr[i].getElementsByTagName("td")[0];
            td_nama = tr[i].getElementsByTagName("td")[1];
            td_lokasi = tr[i].getElementsByTagName("td")[2]
            
            if (td_kode || td_nama) {
                txtValueKode = td_kode ? (td_kode.textContent || td_kode.innerText) : "";
                txtValueNama = td_nama ? (td_nama.textContent || td_nama.innerText) : "";
                txtValueLokasi =td_lokasi?(td_lokasi.textContent || td_lokasi.innerText) :'';
                
                if (txtValueKode.toUpperCase().indexOf(filter) > -1 || txtValueNama.toUpperCase().indexOf(filter) > -1 || txtValueLokasi.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    });
</script>
<?= $this->endSection() ?>
