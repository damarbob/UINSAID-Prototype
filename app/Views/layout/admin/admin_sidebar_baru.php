<?php
// Get the current request instance
$request = service('request');

// Get the URI string
$currentRoute = $request->uri->getSegment(1) . "/" . $request->uri->getSegment(2);
?>

<!-- Sidebar -->
<aside class="app-sidebar bg-body" data-bs-theme="light">

    <!-- Logo -->
    <div class="sidebar-brand">
        <a href="#" class="brand-link">
            <!-- <i class="bx bx-layer nav-logo-icon"></i> -->
            <!-- <img src="<?= base_url('assets/img/icon-notext-transparent.png') ?>" width="24" class="rounded-circle"> -->
            <img src="<?= base_url(setting()->get('App.logoSitus') ?: 'assets/img/logo-horizontal-pb-new.png') ?>" class="brand-image">
            <!-- <span class="nav-logo-name">UINSAID</span> -->
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

                <!-- Dasbor -->
                <li class="nav-item">
                    <a href="<?= base_url('admin/dasbor') ?>" class="nav-link <?= $currentRoute == "admin/dasbor" ? "active" : "" ?>">
                        <i class='nav-icon bx bx-grid'></i>
                        <p><?= lang('Admin.dasbor') ?></p>
                    </a>
                </li>

                <!-- Konten -->
                <li class="nav-item <?= $currentRoute == "admin/posting" || $currentRoute == "admin/posting-diajukan" || $currentRoute == "admin/berita" || $currentRoute === "admin/berita-diajukan" ? "menu-open" : "" ?>">
                    <a href="#" class="nav-link <?= $currentRoute == "admin/posting" || $currentRoute == "admin/posting-diajukan" || $currentRoute == "admin/berita" || $currentRoute === "admin/berita-diajukan" ? "active" : "" ?>">
                        <i class="nav-icon bx bx-copy-alt"></i>
                        <p>
                            <?= lang('Admin.konten') ?>
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <!-- Posting -->
                        <li class="nav-item">
                            <a href="<?= base_url('admin/posting') ?>" class="nav-link <?= $currentRoute == "admin/posting" ? "active" : "" ?>">
                                <i class="nav-icon bx bx-news"></i>
                                <p><?= lang('Admin.posting') ?></p>
                                <?php if ($peringatanPostingKosong || $peringatanPostingTigaBulan) : ?>
                                    <span class="position-absolute top-0 end-0 translate-middle-y badge rounded-pill bg-danger">
                                        !
                                        <span class="visually-hidden">peringatan rilis media</span>
                                    </span>
                                <?php endif ?>
                            </a>
                        </li>

                        <!-- Posting diajukan -->
                        <?php if (env('app.siteType') == 'parent' || env('app.siteType') == 'super'): ?>
                            <li class="nav-item">
                                <a href="<?= base_url('admin/posting-diajukan') ?>" class="nav-link <?= $currentRoute == "admin/posting-diajukan" ? "active" : "" ?>">
                                    <i class="nav-icon bx bx-mail-send"></i>
                                    <p><?= lang('Admin.postingDiajukan') ?></p>
                                </a>
                            </li>
                        <?php endif ?>

                    </ul>
                </li>
                <!-- End of konten -->

                <?php if (ENVIRONMENT == 'development'): ?>
                    <!-- Acara (development, hidden) -->
                    <div class="nav-item d-none">
                        <a href="<?= base_url('admin/acara') ?>" class="nav-link <?= $currentRoute == "admin/acara" ? "active" : "" ?>" data-mdb-tooltip-init data-mdb-placement="right" title="<?= lang('Admin.acara') ?>">
                            <i class='bx bx-calendar-star nav-icon'></i>
                            <p><?= lang('Admin.acara') ?></p>
                        </a>
                    </div>
                <?php endif ?>

                <!-- Kegiatan -->
                <li class="nav-item <?= $currentRoute == "admin/agenda" || $currentRoute == "admin/pengumuman" ? "menu-open" : "" ?>">
                    <a href="#" class="nav-link <?= $currentRoute == "admin/agenda" || $currentRoute == "admin/pengumuman" ? "active" : "" ?>">
                        <i class='bx bx-calendar-star nav-icon' data-mdb-tooltip-init data-mdb-placement="right" title="<?= lang('Admin.kegiatan') ?>"></i>
                        <p>
                            <?= lang('Admin.kegiatan') ?>
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <!-- Agenda -->
                        <li class="nav-item">
                            <a href="<?= base_url('admin/agenda') ?>" class="nav-link <?= $currentRoute == "admin/agenda" ? "active" : "" ?>">
                                <i class='bx bx-calendar-event nav-icon'></i>
                                <p><?= lang('Admin.agenda') ?></p>
                            </a>
                        </li>

                        <!-- Pengumuman -->
                        <?php if (env('app.siteType') == 'parent' || env('app.siteType') == 'super'): ?>
                            <li class="nav-item">
                                <a href="<?= base_url('admin/pengumuman') ?>" class="nav-link <?= $currentRoute == "admin/pengumuman" ? "active" : "" ?>">
                                    <i class='bx bxs-megaphone nav-icon'></i>
                                    <p class="nav_name"><?= lang('Admin.pengumuman') ?></p>
                                </a>
                            </li>
                        <?php endif ?>

                    </ul>
                </li>
                <!-- End of kegiatan -->

                <!-- Unggahan -->
                <li class="nav-item <?= $currentRoute == "admin/galeri" || $currentRoute == "admin/galeri" ? "menu-open" : "" ?>">
                    <a href="#" class="nav-link <?= $currentRoute == "admin/galeri" || $currentRoute == "admin/galeri" ? "active" : "" ?>">
                        <i class='bx bx-calendar-star nav-icon' data-mdb-tooltip-init data-mdb-placement="right" title="<?= lang('Admin.kegiatan') ?>"></i>
                        <p>
                            <?= lang('Admin.unggahan') ?>
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <!-- Galeri -->
                        <li class="nav-item">
                            <a href="<?= base_url('admin/galeri') ?>" class="nav-link <?= $currentRoute == "admin/galeri" ? "active" : "" ?>">
                                <i class='bx bx-images nav-icon'></i>
                                <p><?= lang('Admin.galeri') ?></p>
                            </a>
                        </li>

                        <!-- File -->
                        <?php if (env('app.siteType') == 'parent' || env('app.siteType') == 'super'): ?>
                            <li class="nav-item">
                                <a href="<?= base_url('admin/file') ?>" class="nav-link <?= $currentRoute == "admin/file" ? "active" : "" ?>">
                                    <i class='bx bx-folder-open nav-icon'></i>
                                    <p class="nav_name"><?= lang('Admin.file') ?></p>
                                </a>
                            </li>
                        <?php endif ?>

                    </ul>
                </li>
                <!-- End of unggahan -->

                <?php if (auth()->user()->inGroup("superadmin")): ?>
                    <!-- Editor -->
                    <li class="nav-item <?= $currentRoute == "admin/halaman" || $currentRoute == "admin/menu" || $currentRoute == "admin/entitas" ? "menu-open" : "" ?>">
                        <a href="#" class="nav-link <?= $currentRoute == "admin/halaman" || $currentRoute == "admin/menu" || $currentRoute == "admin/entitas" ? "active" : "" ?>">
                            <i class='bx bx-layout nav-icon' data-mdb-tooltip-init data-mdb-placement="right" title="<?= lang('Admin.editor') ?>"></i>
                            <p>
                                <?= lang('Admin.editor') ?>
                                <i class="nav-arrow bi bi-chevron-right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <!-- Halaman -->
                            <li class="nav-item">
                                <a href="<?= base_url('admin/halaman') ?>" class="nav-link <?= $currentRoute == "admin/halaman" ? "active" : "" ?>" data-mdb-tooltip-init data-mdb-placement="right" title="Halaman">
                                    <i class='bx bx-file nav-icon'></i>
                                    <p><?= lang('Admin.halaman') ?></p>
                                </a>
                            </li>

                            <!-- Menu -->
                            <li class="nav-item">
                                <a href="<?= base_url('admin/menu') ?>" class="nav-link <?= $currentRoute == "admin/menu" ? "active" : "" ?>" data-mdb-tooltip-init data-mdb-placement="right" title="Menu">
                                    <i class='bx bx-food-menu nav-icon'></i>
                                    <p><?= lang('Admin.menu') ?></p>
                                </a>
                            </li>

                            <!-- Entitas -->
                            <!-- Entitas editor hanya untuk role superadmin -->
                            <div class="nav-item">
                                <a href="<?= base_url('admin/entitas') ?>" class="nav-link <?= $currentRoute == "admin/entitas" ? "active" : "" ?>" data-mdb-tooltip-init data-mdb-placement="right" title="Entitas">
                                    <i class='bx bx-hive nav-icon'></i>
                                    <p>
                                        <?= lang('Admin.entitas') ?>
                                    </p>
                                </a>
                            </div>

                        </ul>
                    </li>
                    <!-- End of editor -->
                <?php endif ?>

                <!-- Pengguna -->
                <?php if (auth()->user()->inGroup("superadmin")): ?>
                    <!-- Pengguna hanya untuk superadmin -->
                    <li class="nav-item">
                        <a href="<?= base_url('admin/pengguna') ?>" class="nav-link <?= $currentRoute == "admin/pengguna" ? "active" : "" ?>">
                            <i class='nav-icon bx bxs-user-account'></i>
                            <p><?= lang('Admin.pengguna') ?></p>
                        </a>
                    </li>
                <?php endif ?>

                <!-- Kelola situs -->
                <?php if ((env('app.siteType') == 'parent' || env('app.siteType') == 'super') && auth()->user()->inGroup("superadmin")): ?>
                    <!-- Kelola situs hanya untuk situs non-child dan superadmin -->
                    <li class="nav-item">
                        <a href="<?= base_url('admin/situs') ?>" class="nav-link <?= $currentRoute == "admin/situs" ? "active" : "" ?>">
                            <i class='nav-icon bx bxs-network-chart'></i>
                            <p><?= lang('Admin.kelolaSitus') ?></p>
                        </a>
                    </li>
                <?php endif ?>

                <!-- Pengaturan -->
                <li class="nav-item">
                    <a href="<?= base_url('admin/pengaturan') ?>" class="nav-link">
                        <i class='nav-icon bx bx-cog'></i>
                        <p><?= lang('Admin.pengaturan') ?></p>
                    </a>
                </li>

                <!--  -->

            </ul>
        </nav>
    </div>

    <!-- /////////////////////////// -->

</aside>
<!-- End of Sidebar -->