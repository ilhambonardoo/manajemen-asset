<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>

<div class="welcome-container flex-column flex-md-row">
    <div class="welcome-left col-12 col-md-5 p-4 p-md-5">
        <div class="z-index-1" style="position: relative; z-index: 2;">
            <i class="fas fa-chart-line brand-icon"></i>
            <h2 class="fw-bold mb-3 fs-3 fs-md-2">Asset Management</h2>
            <p class="mb-4 text-white-50 small">Sistem informasi komprehensif untuk pengelolaan aset tetap perusahaan dengan pendekatan akuntansi modern.</p>
            
            <ul class="feature-list small d-none d-md-block">
                <li>
                    <i class="fas fa-check-circle"></i>
                    <span>Tracking Lokasi & Mutasi Aset</span>
                </li>
                <li>
                    <i class="fas fa-calculator"></i>
                    <span>Kalkulasi Penyusutan Otomatis</span>
                </li>
                <li>
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span>Pelaporan Nilai Buku Real-time</span>
                </li>
                <li>
                    <i class="fas fa-qrcode"></i>
                    <span>Manajemen Label & Audit</span>
                </li>
            </ul>
        </div>
    </div>

    <div class="welcome-right col-12 col-md-7 p-4 p-md-5">
        <div class="mb-3">
            <span class="stat-badge">
                <i class="fas fa-circle"></i> System Online v1.0
            </span>
        </div>
        
        <h1 class="fw-bold text-dark mb-2 fs-2 fs-md-1">Selamat Datang,</h1>
        <h4 class="text-muted fw-light mb-4 fs-5 fs-md-4">di Portal Fixed Asset Management</h4>
        
        <p class="text-secondary mb-5 small d-none d-md-block">
            Silakan masuk untuk mengakses dashboard pengelolaan aset, melihat laporan penyusutan, atau melakukan opname aset.
        </p>

        <div class="d-grid gap-3">
            <a href="<?= base_url('login') ?>" class="btn-action shadow-sm py-3">
                <i class="fas fa-sign-in-alt me-2"></i> Masuk ke Aplikasi
            </a>
        </div>

        <div class="mt-auto pt-4 border-top">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-muted small text-center text-md-start">
                <span class="mb-2 mb-md-0">&copy; <?= date('Y') ?> PT XYZ Corp.</span>
                <span>
                    <i class="fas fa-shield-alt me-1"></i> Secure Access
                </span>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
