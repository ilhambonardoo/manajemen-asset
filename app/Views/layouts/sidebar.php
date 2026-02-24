<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background: linear-gradient(135deg, #1a4d7a 0%, #0d2a47 100%);">
    <?php
    $uri = service('uri');
    $uri->setSilent(true);
    ?>
    <a href="/" class="brand-link text-center" style="background: rgba(0,0,0,0.2); border-bottom: 2px solid rgba(255,255,255,0.1);">
        <i class="fas fa-building text-warning me-2"></i>
        <span class="brand-text font-weight-bold" style="font-size: 1.1rem; letter-spacing: 0.5px;">Asset QPON</span>
    </a>

    <div class="sidebar">
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                <li class="nav-item mb-1">
                    <a href="<?= base_url('dashboard') ?>" class="nav-link <?= $uri->getSegment(1) == 'dashboard' || $uri->getSegment(1) == '' ? 'active' : '' ?>" style="border-radius: 8px; margin: 0 10px; transition: all 0.3s ease;">
                        <i class="nav-icon fas fa-home"></i>
                        <p class="ms-2">Dashboard</p>
                    </a>
                </li>

                <?php if (in_array(session()->get('role_name'), ['Admin', 'Supervisor', 'Staff Finance', 'Manager', 'Tim China'])): ?>
                    <li class="nav-header" style="margin-top: 20px; color: rgba(255,255,255,0.6); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; padding: 10px 15px;">
                        <i class="fas fa-cogs me-2"></i>Manajemen Aset
                    </li>

                    <li class="nav-item mb-1">
                        <a href="<?= base_url('asset/daftar') ?>" class="nav-link <?= $uri->getSegment(1) == 'asset' && $uri->getSegment(2) == 'daftar' ? 'active' : '' ?>" style="border-radius: 8px; margin: 0 10px; transition: all 0.3s ease;">
                            <i class="nav-icon fas fa-list"></i>
                            <p class="ms-2">Daftar Aset Tetap</p>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (in_array(session()->get('role_name'), ['Admin', 'Supervisor', 'Staff Finance'])): ?>
                    <li class="nav-item mb-1">
                        <a href="<?= base_url('lokasi') ?>" class="nav-link <?= $uri->getSegment(1) == 'lokasi' ? 'active' : '' ?>" style="border-radius: 8px; margin: 0 10px; transition: all 0.3s ease;">
                            <i class="nav-icon fa-solid fa-map-location-dot"></i>
                            <p class="ms-2">Lokasi Aset</p>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (in_array(session()->get('role_name'), ['Admin', 'Supervisor'])): ?>
                    <li class="nav-item mb-1">
                        <a href="<?= base_url('asset/penyusutan') ?>" class="nav-link <?= $uri->getSegment(1) == 'asset' && $uri->getSegment(2) == 'penyusutan' ? 'active' : '' ?>" style="border-radius: 8px; margin: 0 10px; transition: all 0.3s ease;">
                            <i class="nav-icon fas fa-chart-line"></i>
                            <p class="ms-2">Penyusutan Aset</p>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (in_array(session()->get('role_name'), ['Admin', 'Manager'])): ?>
                    <li class="nav-item mb-1">
                        <a href="javascript:void(0)" class="nav-link <?= $uri->getSegment(1) == 'approval' ? 'active' : '' ?>" style="border-radius: 8px; margin: 0 10px; transition: all 0.3s ease; cursor: pointer;" onclick="toggleApprovalMenu(event)">
                            <i class="nav-icon fas fa-check-circle"></i>
                            <p class="ms-2">
                                Pusat Approval
                                <i class="right fas fa-angle-up arrow-icon-approval" style="margin-left: auto; transition: transform 0.3s ease;"></i>
                            </p>
                        </a>
                        <ul id="approvalMenu" class="nav nav-treeview" style="background: rgba(0,0,0,0.2); border-radius: 8px; margin: 5px 10px; max-height: 0; overflow: hidden; transition: max-height 0.3s ease;">
                            <li class="nav-item">
                                <a href="<?= base_url('approval?jenis=penjualan') ?>" class="nav-link ms-3 <?= $uri->getSegment(1) == 'approval' && (!isset($_GET['jenis']) || $_GET['jenis'] == 'penjualan') ? 'active' : '' ?>" style="border-radius: 6px; margin: 5px 0;">
                                    <i class="far fa-circle nav-icon text-success"></i>
                                    <p>Penjualan Aset</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?= base_url('approval?jenis=penghentian') ?>" class="nav-link ms-3 <?= $uri->getSegment(1) == 'approval' && isset($_GET['jenis']) && $_GET['jenis'] == 'penghentian' ? 'active' : '' ?>" style="border-radius: 6px; margin: 5px 0;">
                                    <i class="far fa-circle nav-icon text-danger"></i>
                                    <p>Penghentian Aset</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <li class="nav-header" style="margin-top: 20px; color: rgba(255,255,255,0.6); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; padding: 10px 15px;">
                    <i class="fas fa-file me-2"></i>Jenis Laporan
                </li>

                <li class="nav-item mb-1">
                    <a href="javascript:void(0)" class="nav-link <?= $uri->getSegment(1) == 'laporan' ? 'active' : '' ?>" style="border-radius: 8px; margin: 0 10px; transition: all 0.3s ease; cursor: pointer;" onclick="toggleLaporanMenu(event)">
                        <i class="nav-icon fas fa-file-pdf"></i>
                        <p class="ms-2">
                            Laporan
                            <i class="right fas fa-angle-up arrow-icon" style="margin-left: auto; transition: transform 0.3s ease;"></i>
                        </p>
                    </a>
                    <ul id="laporanMenu" class="nav nav-treeview px-4" style="background: rgba(0,0,0,0.2); border-radius: 5px; margin: 5px 0; max-height: 0; overflow: hidden; transition: max-height 0.3s ease;">
                        <li class="nav-item">
                            <a href="<?= base_url('laporan?jenis=keseluruhan') ?>" class="nav-link  <?= $uri->getSegment(1) == 'laporan' && (!isset($_GET['jenis']) || $_GET['jenis'] == 'keseluruhan') ? 'active' : '' ?>" style="border-radius: 6px; margin: 5px 0;">
                                <i class="far fa-file nav-icon"></i>
                                <p>Laporan Keseluruhan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('laporan?jenis=jurnal') ?>" class="nav-link <?= $uri->getSegment(1) == 'laporan' && isset($_GET['jenis']) && $_GET['jenis'] == 'jurnal' ? 'active' : '' ?>" style="border-radius: 6px; margin: 5px 0;">
                                <i class="fas fa-chart-bar nav-icon"></i>
                                <p>Jurnal Penyusutan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('laporan?jenis=kartu_aset') ?>" class="nav-link <?= $uri->getSegment(1) == 'laporan' && isset($_GET['jenis']) && $_GET['jenis'] == 'kartu_aset' ? 'active' : '' ?>" style="border-radius: 6px; margin: 5px 0;">
                                <i class="fas fa-shopping-cart nav-icon"></i>
                                <p>Kartu Aset</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('laporan?jenis=lokasi') ?>" class="nav-link mb-5 <?= $uri->getSegment(1) == 'laporan' && isset($_GET['jenis']) && $_GET['jenis'] == 'lokasi' ? 'active' : '' ?>" style="border-radius: 6px; margin: 5px 0;">
                                <i class="fas fa-map nav-icon"></i>
                                <p>Laporan Lokasi</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <?php if (session()->get('role_name') == 'Admin'): ?>
                    <li class="nav-header" style="margin-top: 20px; color: rgba(255,255,255,0.6); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; padding: 10px 15px;">
                        <i class="fas fa-tools me-2"></i>Sistem
                    </li>

                    <li class="nav-item mb-1">
                        <a href="<?= base_url('admin/users') ?>" class="nav-link <?= $uri->getSegment(1) == 'admin' && $uri->getSegment(2) == 'users' ? 'active' : '' ?>" style="border-radius: 8px; margin: 0 10px; transition: all 0.3s ease;">
                            <i class="nav-icon fas fa-user-cog"></i>
                            <p class="ms-2">Kelola Pengguna</p>
                        </a>
                    </li>
                <?php endif; ?>

            </ul>
        </nav>
    </div>

    <div class="sidebar-footer border-top" style="border-color: rgba(255,255,255,0.1) !important; padding: 15px 10px; background: rgba(0,0,0,0.3);">
        <a href="<?= base_url('logout') ?>" class="btn btn-danger btn-sm w-100 d-flex align-items-center justify-content-center gap-2" style="border-radius: 8px; font-weight: 500; transition: all 0.3s ease;">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>

    <link rel="stylesheet" href="<?= base_url('css/sidebar.css') ?>">
    <script>
        function toggleLaporanMenu(e) {
            e.preventDefault();
            const menu = document.getElementById('laporanMenu');
            const arrow = document.querySelector('.arrow-icon');

            if (menu.style.maxHeight && menu.style.maxHeight !== '0px') {
                menu.style.maxHeight = '0px';
                arrow.classList.remove('rotated');
            } else {
                menu.style.maxHeight = menu.scrollHeight + 'px';
                arrow.classList.add('rotated');
            }
        }

        function toggleApprovalMenu(e) {
            e.preventDefault();
            const menu = document.getElementById('approvalMenu');
            const arrow = document.querySelector('.arrow-icon-approval');

            if (menu.style.maxHeight && menu.style.maxHeight !== '0px') {
                menu.style.maxHeight = '0px';
                arrow.classList.remove('rotated');
            } else {
                menu.style.maxHeight = menu.scrollHeight + 'px';
                arrow.classList.add('rotated');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            if (currentPath.includes('/laporan')) {
                const menu = document.getElementById('laporanMenu');
                const arrow = document.querySelector('.arrow-icon');
                menu.style.maxHeight = menu.scrollHeight + 'px';
                arrow.classList.add('rotated');
            }
            if (currentPath.includes('/approval')) {
                const menu = document.getElementById('approvalMenu');
                const arrow = document.querySelector('.arrow-icon-approval');
                menu.style.maxHeight = menu.scrollHeight + 'px';
                arrow.classList.add('rotated');
            }
        });
    </script>
</aside>