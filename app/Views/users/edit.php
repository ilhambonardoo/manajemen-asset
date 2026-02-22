<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 text-dark fw-bold">Edit Data Pengguna</h2>
        <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form action="<?= base_url('admin/users/update/' . $user['id']) ?>" method="post">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h5 class="text-primary border-bottom pb-2 mb-3">Informasi Akun</h5>
                        
                        <div class="mb-3">
                            <label for="username" class="form-label fw-bold">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= $user[
                            	'username'
                            ] ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Alamat Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $user[
                            	'email'
                            ] ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Password Baru</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                            <small class="text-muted">Isi hanya jika Anda ingin mereset password pengguna ini.</small>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <h5 class="text-primary border-bottom pb-2 mb-3">Informasi Karyawan</h5>
                        
                        <div class="mb-3">
                            <label for="nama_divisi" class="form-label fw-bold">Nama Divisi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama_divisi" name="nama_divisi" value="<?= $user[
                            	'nama_divisi'
                            ] ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="jabatan" class="form-label fw-bold">Jabatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?= $user[
                            	'jabatan'
                            ] ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="role_id" class="form-label fw-bold">Hak Akses (Role) <span class="text-danger">*</span></label>
                            <select class="form-select" id="role_id" name="role_id" required>
                                <option value="" disabled>-- Pilih Role --</option>
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?= $role['id'] ?>" <?= $user['role_id'] == $role['id']
	? 'selected'
	: '' ?>>
                                        <?= $role['role_name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-primary px-4 fw-bold">
                        <i class="fas fa-save me-1"></i> Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
<?= $this->endSection() ?>
