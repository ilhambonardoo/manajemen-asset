<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>

<div class="container-fluid vh-100 p-0 overflow-hidden">
    <div class="row g-0 vh-100">
        <div class="col-md-6 d-flex flex-column p-5 bg-white position-relative">
            <div class="mb-5">
                <h2 class="fw-bold" style="color: #008080;">Sistem Pengelolaan Asset</h2>
                <h3 class="fw-normal" style="color: #008080;">PT XYZ</h3>
            </div>

            <div class="flex-grow-1 d-flex flex-column align-items-center justify-content-center text-center">
                <div class="mb-4">
                    <span class="badge rounded-pill px-3 py-2 text-dark mb-3" style="background-color: #e0f2f2; border: 1px solid #008080;">
                        <i class="fas fa-circle text-success me-1 small"></i> System Online v1.0
                    </span>
                    <h1 class="fw-bold text-dark mb-2" style="font-size: 2.5rem;">Selamat Datang,</h1>
                    <h4 class="text-muted fw-light mb-4">di Portal Fixed Asset Management</h4>
                    <p class="text-secondary mb-5 px-md-5">
                        Sistem informasi komprehensif untuk pengelolaan aset tetap perusahaan dengan pendekatan akuntansi modern.
                    </p>
                </div>

                <div class="d-grid gap-3 w-100" style="max-width: 400px;">
                    <a href="<?= base_url('login') ?>" class="btn py-3 fw-bold text-white shadow-sm" style="background-color: #006d6d; border-radius: 8px;">
                        <i class="fas fa-sign-in-alt me-2"></i> Masuk ke Aplikasi
                    </a>
                </div>
            </div>
            
            <div class="mt-auto pt-3 d-flex justify-content-between text-muted small">
                <p class="mb-0">© <?= date('Y') ?> PT XYZ</p>
                <span><i class="fas fa-shield-alt me-1"></i> Secure Access</span>
            </div>
        </div>

        <div class="col-md-6 d-none d-md-block">
            <div class="h-100 w-100 shadow-inset" style="
                background: linear-gradient(to right, rgba(255,255,255,1) 0%, rgba(255,255,255,0) 15%), 
                            url('<?= base_url('assets/gambar1.jpeg') ?>');
                background-size: cover;
                background-position: center;
            ">
            </div>
        </div>
    </div>
</div>

<style>
    /* Efek gradasi halus antara kiri dan kanan */
    .shadow-inset {
        position: relative;
    }
</style>

<?= $this->endSection() ?>
