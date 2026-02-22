<?= $this->extend('layouts/auth') ?>
<?= $this->section('content') ?>

<div class="welcome-container flex-column flex-md-row">
    <div class="welcome-left col-12 col-md-5 text-center p-4 p-md-5 d-none d-md-flex align-items-center justify-content-center">
        <div class="z-index-1" style="position: relative; z-index: 2;">
            <i class="fas fa-user-circle brand-icon mb-4 fs-1"></i>
            <h3 class="fw-bold mb-3">Selamat Datang Kembali</h3>
            <p class="text-white-50 mb-4 small">Silakan masuk ke akun Anda untuk mengakses sistem manajemen aset.</p>
        </div>
    </div>

    <div class="welcome-right col-12 col-md-7 p-4 p-md-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-dark fs-2">Login</h2>
            <p class="text-muted small">Masuk ke Dashboard Asset</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger p-2 small text-center mb-4 rounded-3 border-0 shadow-sm">
                <i class="fas fa-exclamation-circle me-1"></i> <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('/login/process') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-4">
                <label class="form-label text-muted small fw-bold">USERNAME</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                    <input type="text" name="username" class="form-control bg-light border-start-0" placeholder="Masukkan username" required style="height: 45px;">
                </div>
            </div>
            <div class="mb-4">
                <div class="d-flex justify-content-between">
                    <label class="form-label text-muted small fw-bold">PASSWORD</label>
                </div>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                    <input type="password" name="password" class="form-control bg-light border-start-0" placeholder="********" required style="height: 45px;">
                </div>
            </div>
            
            <button type="submit" class="btn btn-dark w-100 py-2 mb-3 fw-bold rounded-3 shadow-sm" style="height: 45px; background-color: #1e1e2d; border-color: #1e1e2d;">
                MASUK SEKARANG <i class="fas fa-arrow-right ms-2"></i>
            </button>
        </form>

        <div class="text-center mt-3">
            <span class="text-muted small">Belum punya akun?</span>
            <a href="<?= base_url(
            	'register'
            ) ?>" class="text-decoration-none fw-bold ms-1" style="color: #1e1e2d;">Buat Akun Baru</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
