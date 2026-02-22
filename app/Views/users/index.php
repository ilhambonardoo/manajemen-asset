<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 text-dark fw-bold">Kelola Pengguna</h2>
        <a href="<?= base_url('admin/users/create') ?>" class="btn btn-warning fw-bold">
            <i class="fas fa-plus me-1"></i> Tambah Pengguna Baru
        </a>
    </div>

    <?php if (session()->getFlashdata('pesan')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('pesan') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table id="tableUsers" class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Divisi</th>
                            <th>Jabatan</th>
                            <th>Role</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($users as $user): ?>
                        <tr>
                            <td class="fw-bold"><?= $no++ ?></td>
                            <td class="text-primary fw-bold"><?= $user['username'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= $user['nama_divisi'] ?></td>
                            <td><?= $user['jabatan'] ?></td>
                            <td>
                                <?php if ($user['role_name'] == 'Admin'): ?>
                                    <span class="badge bg-danger"><?= $user['role_name'] ?></span>
                                <?php elseif ($user['role_name'] == 'Supervisor'): ?>
                                    <span class="badge bg-primary"><?= $user['role_name'] ?></span>
                                <?php else: ?>
                                    <span class="badge bg-secondary"><?= $user['role_name'] ?? 'User' ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url(
                                	'/admin/users/edit/' . $user['id']
                                ) ?>" class="btn btn-sm btn-outline-primary me-1 mb-1" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-delete btn-sm btn-outline-danger mb-1" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $user[
                                	'id'
                                ] ?>" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
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
                    Apakah Anda yakin ingin menghapus pengguna ini? Tindakan ini tidak dapat dibatalkan.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="#" id="btn-confirm-delete" class="btn btn-danger">Ya, Hapus!</a>
                </div>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function () {
        $('#tableUsers').DataTable({
            "language": {
                "search": "Cari Pengguna:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ pengguna"
            }
        });

        $('#tableUsers tbody').on('click', '.btn-delete', function () {
            var id = $(this).attr('data-id');
            var urlHapus = '<?= base_url('admin/users/delete/') ?>' + id;
            $('#btn-confirm-delete').attr('href', urlHapus);
        });
    });
</script>
<?= $this->endSection() ?>
