<?= $this->extend('layouts/auth') ?>
<?= $this->section('content') ?>

<div class="container-fluid vh-100 p-0 overflow-hidden">
    <div class="row g-0 vh-100">
        <div class="col-md-6 d-flex flex-column p-5 bg-white position-relative">
            <div class="mb-4">
                <h2 class="fw-bold" style="color: #008080;">Registrasi Akun</h2>
                <h3 class="fw-normal" style="color: #008080;">PT XYZ</h3>
            </div>

            <div class="flex-grow-1 d-flex align-items-center justify-content-center">
                <div class="card border-0 shadow-lg p-4 w-100" style="max-width: 500px; border-radius: 15px;">
                    
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger p-2 small mb-4 rounded-3 border-0 shadow-sm">
                            <?php if (is_array(session()->getFlashdata('error'))): ?>
                                <ul class="mb-0 ps-3 text-start">
                                    <?php foreach (session()->getFlashdata('error') as $err): ?>
                                        <li><?= $err ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <i class="fas fa-exclamation-circle me-1"></i> <?= session()->getFlashdata('error') ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('register/process') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3 custom-input">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fas fa-user"></i></span>
                                <input type="text" name="username" class="form-control bg-light border-0" value="<?= old('username') ?>" placeholder="Username" required>
                            </div>
                        </div>

                        <div class="mb-3 custom-input">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control bg-light border-0" value="<?= old('email') ?>" placeholder="Email Address" required>
                            </div>
                        </div>

                        <div class="row g-2 mb-4">
                            <div class="col-md-6">
                                <div class="input-group custom-input text-nowrap">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password" class="form-control bg-light border-0" placeholder="Password" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group custom-input text-nowrap">
                                    <span class="input-group-text bg-light border-0"><i class="fas fa-check-circle"></i></span>
                                    <input type="password" name="confpassword" class="form-control bg-light border-0" placeholder="Konfirmasi" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn w-100 py-2 mb-3 fw-bold text-white shadow-sm" style="background-color: #006d6d; border-radius: 8px;">
                            Daftar Akun
                        </button>
                        <a href="<?= base_url('login') ?>" class="btn w-100 py-2 fw-bold text-white shadow-sm" style="background-color: #008080; border-radius: 8px;">
                            Sudah Ada Akun? Login
                        </a>
                    </form>
                </div>
            </div>
            
            <div class="mt-auto pt-3">
                <p class="text-muted small mb-0">© <?= date('Y') ?> PT XYZ</p>
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
    /* Styling Tambahan */
    .custom-input .input-group-text, 
    .custom-input .form-control {
        padding: 12px;
    }
    
    .custom-input .form-control:focus {
        box-shadow: none;
        background-color: #f0f0f0 !important;
    }

    /* Efek gradasi halus antara kiri dan kanan */
    .shadow-inset {
        position: relative;
    }
</style>

<?= $this->endSection() ?>

