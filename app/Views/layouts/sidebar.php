<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background: linear-gradient(135deg, #1a4d7a 0%, #0d2a47 100%); overflow-y: auto;">
    <?php
    $uri = service('uri');
    $uri->setSilent(true);
    $segment1 = $uri->getSegment(1);
    $segment2 = $uri->getSegment(2);
    $role = session()->get('role_name');
    ?>

    <a href="/" class="brand-link text-center" style="background: rgba(0,0,0,0.2); border-bottom: 1px solid rgba(255,255,255,0.1);">
        <i class="fas fa-building text-warning me-2"></i>
        <span class="brand-text font-weight-bold" >Asset QPON</span>
    </a>

    <div class="sidebar px-2">
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column gap-1" data-widget="treeview" role="menu">
                
                <li class="nav-item">
                    <a href="<?= base_url('dashboard') ?>" class="nav-link <?= ($segment1 == 'dashboard' || $segment1 == '') ? 'active' : '' ?>" style="border-radius: 8px; transition: all 0.3s ease;">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <?php if (in_array($role, ['Admin', 'Supervisor', 'Staff Finance', 'Manager', 'Tim China'])): ?>
                    <li class="nav-header" style="color: rgba(255,255,255,0.5); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; padding: 15px 10px 5px 15px;">
                        Manajemen Aset
                    </li>

                    <li class="nav-item">
                        <a href="<?= base_url('asset/daftar') ?>" class="nav-link <?= ($segment1 == 'asset' && $segment2 == 'daftar') ? 'active' : '' ?>" style="border-radius: 8px; transition: all 0.3s ease;">
                            <i class="nav-icon fas fa-list"></i>
                            <p>Daftar Aset Tetap</p>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (in_array($role, ['Admin', 'Supervisor', 'Staff Finance'])): ?>
                    <li class="nav-item">
                        <a href="<?= base_url('lokasi') ?>" class="nav-link <?= ($segment1 == 'lokasi') ? 'active' : '' ?>" style="border-radius: 8px; transition: all 0.3s ease;">
                            <i class="nav-icon fas fa-map-marked-alt"></i>
                            <p>Lokasi Aset</p>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (in_array($role, ['Admin', 'Supervisor'])): ?>
                    <li class="nav-item">
                        <a href="<?= base_url('asset/penyusutan') ?>" class="nav-link <?= ($segment1 == 'asset' && $segment2 == 'penyusutan') ? 'active' : '' ?>" style="border-radius: 8px; transition: all 0.3s ease;">
                            <i class="nav-icon fas fa-chart-line"></i>
                            <p>Penyusutan Aset</p>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (in_array($role, ['Admin', 'Manager'])): ?>
                    <li class="nav-item <?= ($segment1 == 'approval') ? 'menu-open' : '' ?>">
                        <a href="javascript:void(0)" class="nav-link <?= ($segment1 == 'approval') ? 'active' : '' ?>" style="border-radius: 8px; transition: all 0.3s ease;" onclick="toggleDropdown('approvalMenu', 'arrowApproval')">
                            <i class="nav-icon fas fa-check-circle"></i>
                            <p>
                                Pusat Approval
                                <i class="right fas fa-angle-left transition-arrow ms-2" id="arrowApproval"></i>
                            </p>
                        </a>
                        <ul id="approvalMenu" class="nav nav-treeview dropdown-container">
                            <li class="nav-item">
                                <a href="<?= base_url('approval?jenis=penjualan') ?>" class="nav-link <?= ($segment1 == 'approval' && ($_GET['jenis'] ?? '') == 'penjualan') ? 'active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Penjualan Aset</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('approval?jenis=penghentian') ?>" class="nav-link <?= (($_GET['jenis'] ?? '') == 'penghentian') ? 'active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Penghentian Aset</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <li class="nav-header" style="color: rgba(255,255,255,0.5); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; padding: 15px 10px 5px 15px;">
                    Laporan
                </li>

                <li class="nav-item <?= ($segment1 == 'laporan') ? 'menu-open' : '' ?>">
                    <a href="javascript:void(0)" class="nav-link <?= ($segment1 == 'laporan') ? 'active' : '' ?>" style="border-radius: 8px; transition: all 0.3s ease;" onclick="toggleDropdown('laporanMenu', 'arrowLaporan')">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Jenis Laporan
                            <i class="right fas fa-angle-left transition-arrow ms-3" id="arrowLaporan"></i>
                        </p>
                    </a>
                    <ul id="laporanMenu" class="nav nav-treeview dropdown-container">
                        <li class="nav-item">
                            <a href="<?= base_url('laporan?jenis=keseluruhan') ?>" class="nav-link <?= ($segment1 == 'laporan' && (($_GET['jenis'] ?? '') == 'keseluruhan' || !isset($_GET['jenis']))) ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Keseluruhan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('laporan?jenis=jurnal') ?>" class="nav-link <?= ($_GET['jenis'] ?? '') == 'jurnal'? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jurnal Penyusutan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('laporan?jenis=kartu_aset') ?>" class="nav-link <?= (($_GET['jenis'] ?? '') == 'kartu_aset') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kartu Aset</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('laporan?jenis=lokasi') ?>" class="nav-link <?= (($_GET['jenis'] ?? '') == 'lokasi') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Lokasi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('laporan?jenis=laporan_aset') ?>" class="nav-link <?= (($_GET['jenis'] ?? '') == 'laporan_aset') ? 'active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Aset (Gabungan)</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <?php if ($role == 'Admin'): ?>
                    <li class="nav-header" style="color: rgba(255,255,255,0.5); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; padding: 15px 10px 5px 15px;">
                        Sistem
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('admin/users') ?>" class="nav-link <?= ($segment1 == 'admin' && $segment2 == 'users') ? 'active' : '' ?>" style="border-radius: 8px; transition: all 0.3s ease;">
                            <i class="nav-icon fas fa-user-cog"></i>
                            <p>Kelola Pengguna</p>
                        </a>
                    </li>
                <?php endif; ?>

            </ul>
        </nav>
    </div>

    <div class="sidebar-footer border-top border-secondary mt-auto" style="padding: 15px;">
        <a href="<?= base_url('logout') ?>" class="btn btn-danger btn-sm w-100 d-flex align-items-center justify-content-center gap-2" style="border-radius: 8px; font-weight: 500; padding: 8px;">
            <i class="fas fa-sign-out-alt"></i>
            <span>Keluar Aplikasi</span>
        </a>
    </div>

    <style>
        .dropdown-container {
            background: rgba(0,0,0,0.15);
            border-radius: 8px;
            margin: 5px 0;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        .transition-arrow {
            transition: transform 0.3s ease;
            margin-left: auto;
        }
        .rotated {
            transform: rotate(-90deg);
        }
        .nav-sidebar .nav-link p {
            margin-bottom: 0 !important;
        }
        .nav-treeview .nav-link {
            padding-left: 2.5rem !important;
        }
    </style>

    <script>
        function toggleDropdown(menuId, arrowId) {
            const menu = document.getElementById(menuId);
            const arrow = document.getElementById(arrowId);
            
            if (menu.style.maxHeight && menu.style.maxHeight !== '0px') {
                menu.style.maxHeight = '0px';
                arrow.classList.remove('rotated');
            } else {
                menu.style.maxHeight = menu.scrollHeight + 'px';
                arrow.classList.add('rotated');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const activeLinks = document.querySelectorAll('.nav-treeview .nav-link.active');
            activeLinks.forEach(link => {
                const menu = link.closest('.nav-treeview');
                const parentLink = menu.previousElementSibling;
                const arrow = parentLink.querySelector('.transition-arrow');
                
                menu.style.maxHeight = menu.scrollHeight + 'px';
                if (arrow) arrow.classList.add('rotated');
            });
        });
    </script>
</aside>