<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <?php
    $uri = service('uri');
    $uri->setSilent(true);
    ?>
    <a href="/" class="brand-link">
        <span class="brand-text font-weight-light">Asset QPON</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                
                <li class="nav-item">
                    <a href="<?= base_url('dashboard') ?>" class="nav-link <?= $uri->getSegment(1) == 'dashboard' ||
$uri->getSegment(1) == ''
	? 'active'
	: '' ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p class="mt-3">Dashboard</p>
                    </a>
                </li>

                <?php if (
                	in_array(session()->get('role_name'), [
                		'Admin',
                		'Supervisor',
                		'Staff Finance',
                		'Manager',
                		'Tim China',
                	])
                ): ?>
                <li class="nav-header">MANAJEMEN ASET</li>
                <li class="nav-item">
                    <a href="<?= base_url('asset/daftar') ?>" class="nav-link <?= $uri->getSegment(1) == 'asset' &&
$uri->getSegment(2) == 'daftar'
	? 'active'
	: '' ?>">
                        <i class="nav-icon fas fa-list"></i>
                        <p class="mt-3">Daftar Aset Tetap</p>
                    </a>
                </li>
                <?php endif; ?>

                <?php if (in_array(session()->get('role_name'), ['Admin', 'Supervisor', 'Staff Finance'])): ?>
                <li class="nav-item">
                    <a href="<?= base_url('lokasi') ?>" class="nav-link <?= $uri->getSegment(1) == 'lokasi'
	? 'active'
	: '' ?>">
                        <i class="nav-icon fa-solid fa-location-dot"></i>
                        <p class="mt-3">Lokasi Aset</p>
                    </a>
                </li>
                <?php endif; ?>

                <?php if (in_array(session()->get('role_name'), ['Admin', 'Supervisor'])): ?>
                <li class="nav-item">
                    <a href="<?= base_url('asset/penyusutan') ?>" class="nav-link <?= $uri->getSegment(1) == 'asset' &&
$uri->getSegment(2) == 'penyusutan'
	? 'active'
	: '' ?>">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p class="mt-3">Penyusutan</p>
                    </a>
                </li>
                <?php endif; ?>

                <?php if (in_array(session()->get('role_name'), ['Admin', 'Manager'])): ?>
                <li class="nav-item">
                    <a href="<?= base_url('approval') ?>" class="nav-link <?= $uri->getSegment(1) == 'approval'
	? 'active'
	: '' ?>">
                        <i class="nav-icon fas fa-check-circle"></i>
                        <p class="mt-3">Approval Penjualan</p>
                    </a>
                </li>
                <?php endif; ?>

                <li class="nav-header">Laporan</li>
                <li class="nav-item">
                    <a href="<?= base_url('laporan') ?>" class="nav-link <?= $uri->getSegment(1) == 'laporan'
	? 'active'
	: '' ?>">
                        <i class="nav-icon fas fa-file-pdf"></i>
                        <p class="mt-3">Laporan Keseluruhan</p>
                    </a>
                </li>
                
                <?php if (session()->get('role_name') == 'Admin'): ?>
                <li class="nav-header">SYSTEM</li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/users') ?>" class="nav-link <?= $uri->getSegment(1) == 'admin' &&
$uri->getSegment(2) == 'users'
	? 'active'
	: '' ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p class="mt-3">Kelola Pengguna</p>
                    </a>
                </li>
                <?php endif; ?>

            </ul>
        </nav>
    </div>
    
    <div class="sidebar-footer border-top border-secondary p-3">
        <a href="<?= base_url(
        	'logout'
        ) ?>" class="btn btn-danger w-100 d-flex align-items-center justify-content-center gap-2">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>
</aside>