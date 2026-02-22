<?= $this->extend('layouts/auth') ?>
<?= $this->section('content') ?>

<div class="welcome-container flex-column flex-md-row">
    <div class="welcome-left col-12 col-md-5 text-center p-4 p-md-5 d-none d-md-flex align-items-center justify-content-center"> 
        <div class="z-index-1" style="position: relative; z-index: 2;">
            <i class="fas fa-id-card brand-icon mb-4 fs-1"></i>
            <h3 class="fw-bold mb-3">Buat Akun Baru</h3>
            <p class="text-white-50 mb-4">Bergabunglah dengan sistem manajemen aset kami untuk akses penuh.</p>
            <ul class="text-start text-white-50 small mx-auto" style="list-style: none; padding-left: 0; display: inline-block;">
                <li class="mb-2"><i class="fas fa-check me-2 text-warning"></i> Akses Dashboard</li>
                <li class="mb-2"><i class="fas fa-check me-2 text-warning"></i> Laporan Realtime</li>
                <li class="mb-2"><i class="fas fa-check me-2 text-warning"></i> Notifikasi Sistem</li>
            </ul>
        </div>
    </div>

    <div class="welcome-right col-12 col-md-7 p-4 p-md-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-dark fs-2">Registrasi</h2>
            <p class="text-muted small">Isi data diri Anda untuk mendaftar sistem aset</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger p-2 small mb-4 rounded-3 border-0 shadow-sm">
                <?php if (is_array(session()->getFlashdata('error'))): ?>
                    <ul class="mb-0 pl-3 text-start">
                        <?php foreach (session()->getFlashdata('error') as $err): ?>
                            <li><i class="fas fa-exclamation-triangle me-1"></i> <?= $err ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <i class="fas fa-exclamation-circle me-1"></i> <?= session()->getFlashdata('error') ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('register/process') ?>" method="post">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label text-muted small fw-bold">USERNAME</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                        <input type="text" name="username" class="form-control bg-light border-start-0" value="<?= old(
                        	'username'
                        ) ?>" placeholder="Pilih username unik" required style="height: 45px;">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted small fw-bold">EMAIL ADDRESS</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                    <input type="email" name="email" class="form-control bg-light border-start-0" value="<?= old(
                    	'email'
                    ) ?>" placeholder="user@example.com" required style="height: 45px;">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label text-muted small fw-bold">PASSWORD</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                        <input type="password" name="password" class="form-control bg-light border-start-0" placeholder="Minimal 6 karakter" required style="height: 45px;">
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <label class="form-label text-muted small fw-bold">KONFIRMASI PASSWORD</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-check-circle text-muted"></i></span>
                        <input type="password" name="confpassword" class="form-control bg-light border-start-0" placeholder="Ulangi password" required style="height: 45px;">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-dark w-100 py-2 mb-3 fw-bold rounded-3 shadow-sm" style="height: 45px; background-color: #1e1e2d; border-color: #1e1e2d;">
                <i class="fas fa-user-plus me-2"></i> DAFTAR AKUN
            </button>
        </form>

        <div class="text-center mt-3">
            <span class="text-muted small">Sudah memiliki akun?</span>
            <a href="<?= base_url(
            	'/login'
            ) ?>" class="text-decoration-none fw-bold ms-1" style="color: #1e1e2d;">Masuk disini</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

