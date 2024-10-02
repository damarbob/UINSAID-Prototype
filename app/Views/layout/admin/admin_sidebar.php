<?php
// Get the current request instance
$request = service('request');

// Get the URI string
$currentRoute = $request->uri->getSegment(1) . "/" . $request->uri->getSegment(2);
?>

<!-- Topbar -->
<div class="l-navbar" id="nav-bar">
    <nav class="nav-sidebar">
        <div>

            <!-- Logo -->
            <a href="#" class="nav-logo">
                <!-- <i class="bx bx-layer nav-logo-icon"></i> -->
                <img src="<?= base_url('assets/img/icon-notext-transparent.png') ?>" width="24" class="rounded-circle">
                <span class="nav-logo-name">UINSAID</span>
            </a>

            <!-- Dasbor -->
            <div class="nav-list">
                <a href="<?= base_url('admin/dasbor') ?>" class="nav-link-admin <?= $currentRoute == "admin/dasbor" ? "active" : "" ?>" data-mdb-tooltip-init data-mdb-placement="right" title="Dasbor">
                    <i class='bx bx-grid nav_icon'></i>
                    <span class="nav_name"><?= lang('Admin.dasbor') ?></span>
                </a>
            </div>

            <!-- Halaman -->
            <?php if ((ENVIRONMENT == 'development') && auth()->user()->inGroup("superadmin")): ?>
                <!-- Halaman editor hanya untuk role superadmin -->
                <div class="nav-list">
                    <a href="<?= base_url('admin/halaman') ?>" class="nav-link-admin <?= $currentRoute == "admin/halaman" ? "active" : "" ?>" data-mdb-tooltip-init data-mdb-placement="right" title="Halaman">
                        <i class='bx bx-file nav_icon'></i>
                        <span class="nav_name">
                            <?= lang('Admin.halaman') ?>
                        </span>
                    </a>
                </div>
            <?php endif ?>

            <!-- Berita -->
            <div class="nav-list">
                <a href="<?= base_url('admin/berita') ?>" class="nav-link-admin <?= $currentRoute == "admin/berita" ? "active" : "" ?>" data-mdb-tooltip-init data-mdb-placement="right" title="Berita">
                    <i class='bx bx-news nav_icon'></i>
                    <span class="nav_name"><?= lang('Admin.berita') ?></span>
                    <?php if ($peringatanBeritaKosong || $peringatanPostingBerita) : ?>
                        <span class="position-absolute top-0 end-0 translate-middle-y badge rounded-pill bg-danger">
                            !
                            <span class="visually-hidden"><?= lang('Admin.peringatanPosting') ?></span>
                        </span>
                    <?php endif ?>
                </a>
            </div>

            <!-- Berita diajukan -->
            <?php if (env('app.siteType') == 'parent' || env('app.siteType') == 'super'): ?>
                <!-- Kelola berita diajukan khusus parent atau super -->
                <div class="nav-list">
                    <a href="<?= base_url('admin/berita-diajukan') ?>" class="nav-link-admin <?= $currentRoute == "admin/berita-diajukan" ? "active" : "" ?>" data-mdb-tooltip-init data-mdb-placement="right" title="Berita Diajukan">
                        <i class='bx bx-mail-send nav_icon'></i>
                        <span class="nav_name"><?= lang('Admin.beritaDiajukan') ?></span>
                    </a>
                </div>
            <?php endif ?>

            <!-- Agenda -->
            <div class="nav-list">
                <a href="<?= base_url('admin/agenda') ?>" class="nav-link-admin <?= $currentRoute == "admin/agenda" ? "active" : "" ?>" data-mdb-tooltip-init data-mdb-placement="right" title="Agenda">
                    <i class='bx bx-calendar-event nav_icon'></i>
                    <span class="nav_name"><?= lang('Admin.agenda') ?></span>
                </a>
            </div>

            <!-- Pengumuman -->
            <div class="nav-list">
                <a href="<?= base_url('admin/pengumuman') ?>" class="nav-link-admin <?= $currentRoute == "admin/pengumuman" ? "active" : "" ?>" data-mdb-tooltip-init data-mdb-placement="right" title="Pengumuman">
                    <i class='bx bxs-megaphone nav_icon'></i>
                    <span class="nav_name"><?= lang('Admin.pengumuman') ?></span>
                </a>
            </div>

            <!-- Galeri -->
            <div class="nav-list">
                <a href="<?= base_url('admin/galeri') ?>" class="nav-link-admin <?= $currentRoute == "admin/galeri" ? "active" : "" ?>" data-mdb-tooltip-init data-mdb-placement="right" title="Galeri">
                    <i class='bx bx-images nav_icon'></i>
                    <span class="nav_name"><?= lang('Admin.galeri') ?></span>
                </a>
            </div>

            <!-- Manajer file -->
            <div class="nav-list">
                <a href="<?= base_url('admin/file') ?>" class="nav-link-admin <?= $currentRoute == "admin/file" ? "active" : "" ?>" data-mdb-tooltip-init data-mdb-placement="right" title="Manajer File">
                    <i class='bx bx-folder-open nav_icon'></i>
                    <span class="nav_name"><?= lang('Admin.kelolaFile') ?></span>
                </a>
            </div>

            <!-- Kotak masuk -->
            <div class="nav-list d-none">
                <a href="<?= base_url('admin/kotak-masuk') ?>" class="nav-link-admin <?= $currentRoute == "admin/kotak-masuk" ? "active" : "" ?>" data-mdb-tooltip-init data-mdb-placement="right" title="Kotak Masuk">
                    <i class='bx bxs-inbox nav_icon'></i>
                    <span class="nav_name">
                        <?= lang('Admin.kotakMasuk') ?>
                        <?php if ($adaKotakMasukBelumTerbaca) : ?>
                            <span class="position-absolute top-0 end-0 translate-middle-y badge rounded-pill bg-danger">
                                <?= $jumlahKotakMasukBelumTerbaca ?>
                                <span class="visually-hidden"><?= lang('Admin.kotakMasukBaru') ?></span>
                            </span>
                        <?php endif ?>
                    </span>
                </a>
            </div>

            <!-- Pengguna -->
            <div class="nav-list">
                <a href="<?= base_url('admin/pengguna') ?>" class="nav-link-admin <?= $currentRoute == "admin/pengguna" ? "active" : "" ?>" data-mdb-tooltip-init data-mdb-placement="right" title="Pengguna">
                    <i class='bx bxs-user-account nav_icon'></i>
                    <span class="nav_name">
                        <?= lang('Admin.pengguna') ?>
                    </span>
                </a>
            </div>

            <!-- Kelola situs -->
            <?php if ((env('app.siteType') == 'parent' || env('app.siteType') == 'super') && auth()->user()->inGroup("superadmin")): ?>
                <!-- Kelola situs khusus parent atau super dan role superadmin -->
                <div class="nav-list">
                    <a href="<?= base_url('admin/situs') ?>" class="nav-link-admin <?= $currentRoute == "admin/situs" ? "active" : "" ?>" data-mdb-tooltip-init data-mdb-placement="right" title="Situs">
                        <i class='bx bxs-network-chart nav_icon'></i>
                        <span class="nav_name">
                            <?= lang('Admin.kelolaSitus') ?>
                        </span>
                    </a>
                </div>
            <?php endif ?>

            <!-- Pengaturan -->
            <div class="nav-list">
                <a href="<?= base_url('admin/pengaturan') ?>" class="nav-link-admin <?= $currentRoute == "admin/pengaturan" ? "active" : "" ?>" data-mdb-tooltip-init data-mdb-placement="right" title="Pengaturan">
                    <i class='bx bx-cog nav_icon'></i>
                    <span class="nav_name">
                        <?= lang('Admin.pengaturan') ?>
                    </span>
                </a>
            </div>

            <!-- <div class="nav-list d-lg-none">
                <a href="<?= base_url('admin/atur-profil') ?>" class="nav-link">
                    <i class='bx bx-user-circle nav_icon'></i>
                    <span class="nav_name">Atur Profil</span>
                </a>
            </div>
            <div class="nav-list d-lg-none">
                <a href="<?= base_url('akun/logout') ?>" class="nav-link">
                    <i class='bx bx-exit nav_icon'></i>
                    <span class="nav_name">Logout</span>
                </a>
            </div> -->
        </div>
    </nav>
</div>
<!-- End of Topbar -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navBar = document.getElementById('nav-bar');
        const tooltipElements = document.querySelectorAll('[data-mdb-tooltip-init]');

        function toggleTooltip() {
            if (navBar.classList.contains('show-sidebar')) {
                tooltipElements.forEach(el => {
                    const tooltip = mdb.Tooltip.getOrCreateInstance(el);
                    tooltip && tooltip.enable(); // Remove the tooltip if it already exists
                    // new mdb.Tooltip(el); // Re-enable the tooltip
                });
            } else {
                tooltipElements.forEach(el => {
                    const tooltip = mdb.Tooltip.getOrCreateInstance(el);
                    tooltip && tooltip.disable(); // Remove the tooltip when expanded
                });
            }
            // tooltipElements.forEach(el => {
            //     const tooltip = mdb.Tooltip.getInstance(el);
            //     tooltip.toggleEnabled()
            // });
        }

        // Add event listener to your navbar toggle button
        const navbarToggle = document.getElementById('header-toggle'); // Assuming this is your navbar toggle button
        navbarToggle.addEventListener('click', function() {
            // navBar.classList.toggle('collapsed');
            toggleTooltip();
        });

        // Initialize based on default state
        // toggleTooltip();
    });
</script>