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
            <a href="#" class="nav_logo">
                <!-- <i class="bx bx-layer nav_logo-icon"></i> -->
                <img src="<?= base_url('assets/img/icon-notext-transparent.png') ?>" width="24" class="rounded-circle">
                <span class=" nav_logo-name">UINSAID</span>
            </a>
            <div class="nav_list">
                <a href="<?= base_url('admin/dasbor') ?>" class="nav_link <?= $currentRoute == "admin/dasbor" ? "active" : "" ?>">
                    <i class='bx bx-grid nav_icon'></i>
                    <span class="nav_name">Dasbor</span>
                </a>
            </div>
            <div class="nav_list">
                <a href="<?= base_url('admin/berita') ?>" class="nav_link <?= $currentRoute == "admin/berita" ? "active" : "" ?>">
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
            <div class="nav_list">
                <a href="<?= base_url('admin/kotak-masuk') ?>" class="nav_link <?= $currentRoute == "admin/kotak-masuk" ? "active" : "" ?>">
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
            <div class="nav_list d-lg-none">
                <a href="<?= base_url('admin/atur-profil') ?>" class="nav_link">
                    <i class='bx bx-user-circle nav_icon'></i>
                    <span class="nav_name">Atur Profil</span>
                </a>
            </div>
            <div class="nav_list d-lg-none">
                <a href="<?= base_url('akun/logout') ?>" class="nav_link">
                    <i class='bx bx-exit nav_icon'></i>
                    <span class="nav_name">Logout</span>
                </a>
            </div>
        </div>
    </nav>
</div>
<!-- End of Topbar -->