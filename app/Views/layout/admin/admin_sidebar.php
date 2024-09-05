<?php
// Get the current request instance
$request = service('request');

// Get the URI string
$currentRoute = $request->uri->getPath();
?>

<!-- Topbar -->
<div class="l-navbar" id="nav-bar">
    <nav class="nav-sidebar">
        <div>
            <a href="#" class="nav-logo">
                <!-- <i class="bx bx-layer nav-logo-icon"></i> -->
                <img src="<?= base_url('assets/img/icon-notext-transparent.png') ?>" width="24" class="rounded-circle">
                <span class=" nav-logo-name">UINSAID</span>
            </a>
            <div class="nav-list">
                <a href="<?= base_url('admin/dasbor') ?>" class="nav-link-admin <?= $currentRoute == "admin/dasbor" ? "active" : "" ?>">
                    <i class='bx bx-grid nav_icon'></i>
                    <span class="nav_name">Dasbor</span>
                </a>
            </div>
            <div class="nav-list d-none">
                <a href="<?= base_url('admin/halaman') ?>" class="nav-link-admin <?= $currentRoute == "admin/halaman" ? "active" : "" ?>">
                    <i class='bx bx-file nav_icon'></i>
                    <span class="nav_name">
                        Halaman
                    </span>
                </a>
            </div>
            <div class="nav-list">
                <a href="<?= base_url('admin/berita') ?>" class="nav-link-admin <?= $currentRoute == "admin/berita" ? "active" : "" ?>">
                    <i class='bx bx-news nav_icon'></i>
                    <span class="nav_name"><?= lang('Admin.berita') ?></span>
                    <?php if ($peringatanBeritaKosong || $peringatanPostingBerita) : ?>
                        <span class="position-absolute top-0 end-0 translate-middle-y badge rounded-pill bg-danger">
                            !
                            <span class="visually-hidden">peringatan rilis media</span>
                        </span>
                    <?php endif ?>
                </a>
            </div>
            <?php if (env('app.siteType') == 'parent' || env('app.siteType') == 'super'): ?>
                <!-- Kelola berita diajukan khusus parent atau super -->
                <div class="nav-list">
                    <a href="<?= base_url('admin/berita-diajukan') ?>" class="nav-link-admin <?= $currentRoute == "admin/berita-diajukan" ? "active" : "" ?>">
                        <i class='bx bx-mail-send nav_icon'></i>
                        <span class="nav_name">Berita diajukan</span>
                    </a>
                </div>
            <?php endif ?>
            <div class="nav-list">
                <a href="<?= base_url('admin/agenda') ?>" class="nav-link-admin <?= $currentRoute == "admin/agenda" ? "active" : "" ?>">
                    <i class='bx bx-calendar-event nav_icon'></i>
                    <span class="nav_name">Agenda</span>
                </a>
            </div>
            <div class="nav-list">
                <a href="<?= base_url('admin/pengumuman') ?>" class="nav-link-admin <?= $currentRoute == "admin/pengumuman" ? "active" : "" ?>">
                    <i class='bx bxs-megaphone nav_icon'></i>
                    <span class="nav_name">Pengumuman</span>
                </a>
            </div>
            <div class="nav-list">
                <a href="<?= base_url('admin/galeri') ?>" class="nav-link-admin <?= $currentRoute == "admin/galeri" ? "active" : "" ?>">
                    <i class='bx bx-images nav_icon'></i>
                    <span class="nav_name">Galeri</span>
                </a>
            </div>
            <div class="nav-list d-none">
                <a href="<?= base_url('admin/kotak-masuk') ?>" class="nav-link-admin <?= $currentRoute == "admin/kotak-masuk" ? "active" : "" ?>">
                    <i class='bx bxs-inbox nav_icon'></i>
                    <span class="nav_name">
                        Kotak Masuk
                        <?php if ($adaKotakMasukBelumTerbaca) : ?>
                            <span class="position-absolute top-0 end-0 translate-middle-y badge rounded-pill bg-danger">
                                <?= $jumlahKotakMasukBelumTerbaca ?>
                                <span class="visually-hidden">pesan belum terbaca</span>
                            </span>
                        <?php endif ?>
                    </span>
                </a>
            </div>
            <div class="nav-list">
                <a href="<?= base_url('admin/pengguna') ?>" class="nav-link-admin <?= $currentRoute == "admin/pengguna" ? "active" : "" ?>">
                    <i class='bx bxs-user-account nav_icon'></i>
                    <span class="nav_name">
                        Pengguna
                    </span>
                </a>
            </div>
            <?php if (env('app.siteType') == 'parent' || env('app.siteType') == 'super'): ?>
                <!-- Kelola situs khusus parent atau super -->
                <div class="nav-list">
                    <a href="<?= base_url('admin/situs') ?>" class="nav-link-admin <?= $currentRoute == "admin/situs" ? "active" : "" ?>">
                        <i class='bx bxs-network-chart nav_icon'></i>
                        <span class="nav_name">
                            Kelola Situs
                        </span>
                    </a>
                </div>
            <?php endif ?>
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