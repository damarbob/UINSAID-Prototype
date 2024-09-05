<?= $this->extend('layout/admin/admin_template') ?>

<?= $this->section('content') ?>
<?php

use function App\Helpers\format_tanggal_dari_timestamp;

setlocale(LC_TIME, 'id_ID'); // Set locale to Indonesian

// Get current date and format it in Indonesian
$date = format_tanggal_dari_timestamp(time());

?>

<div class="row mb-5">
    <div class="col">

        <h1 class="fs-1 fw-normal"><?= lang('Admin.selamatDatang') ?>, <?= $user->username ?></h1>
        <p class="mb-4"><?= $date ?></p>

        <!-- Pilihan cepat -->
        <div class="row gy-2 gx-2">

            <!-- Rilis Media -->
            <div class="col-lg-6 col-xl-4">
                <a href="<?= base_url('admin/berita') ?>">
                    <div class="card border <?= ($peringatanBeritaKosong) ? 'border-success' : (($peringatanPostingBerita) ? 'border-danger' : 'border-primary') ?>">
                        <div class="card-body">
                            <h5 class="card-title display-5 fw-bold"><?= lang('Admin.berita') ?></h5>
                            <h6 class="card-subtitle"><?= lang('Admin.kelolaBerita') ?></h6>
                        </div>
                        <div class="card-footer d-flex justify-content-between fs-2 fw-bold lh-1">
                            <i class='fs-1 bx bx-news nav_icon'></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Kotak Masuk -->
            <div class="col-lg-6 col-xl-4 d-none">
                <a href="<?= base_url('admin/kotak-masuk') ?>">
                    <div class="card border <?= ($adaKotakMasukBelumTerbaca) ? 'border-success' : 'border-primary' ?>">
                        <div class="card-body">
                            <h5 class="card-title display-5 fw-bold"><?= lang('Admin.kotakMasuk') ?></h5>
                            <h6 class="card-subtitle"><?= lang('Admin.kelolaMasukanDanPelaporan') ?></h6>
                        </div>
                        <div class="card-footer d-flex justify-content-between fs-2 fw-bold lh-1">
                            <i class='fs-1 bx bxs-inbox nav_icon me-2'></i>
                            <?php if ($adaKotakMasukBelumTerbaca) : ?>
                                <span class=" badge rounded-pill bg-success">
                                    <?= ($adaKotakMasukBelumTerbaca) ? $jumlahKotakMasukBelumTerbaca : '' ?>
                                </span>
                            <?php endif ?>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Agenda -->
            <div class="col-lg-6 col-xl-4">
                <a href="<?= base_url('admin/agenda') ?>">
                    <div class="card border border-success">
                        <div class="card-body">
                            <h5 class="card-title display-5 fw-bold"><?= lang('Admin.agenda') ?></h5>
                            <h6 class="card-subtitle">Kelola Agenda</h6>
                        </div>
                        <div class="card-footer d-flex justify-content-between fs-2 fw-bold lh-1">
                            <i class='fs-1 bx bx-calendar-event nav_icon'></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Pengumuman -->
            <div class="col-lg-6 col-xl-4">
                <a href="<?= base_url('admin/pengumuman') ?>">
                    <div class="card border border-success">
                        <div class="card-body">
                            <h5 class="card-title display-5 fw-bold"><?= lang('Admin.pengumuman') ?></h5>
                            <h6 class="card-subtitle">Kelola Pengumuman</h6>
                        </div>
                        <div class="card-footer d-flex justify-content-between fs-2 fw-bold lh-1">
                            <i class='fs-1 bx bxs-megaphone nav_icon'></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Galeri -->
            <div class="col-lg-6 col-xl-4">
                <a href="<?= base_url('admin/galeri') ?>">
                    <div class="card border border-success">
                        <div class="card-body">
                            <h5 class="card-title display-5 fw-bold"><?= lang('Admin.galeri') ?></h5>
                            <h6 class="card-subtitle">Kelola Galeri</h6>
                        </div>
                        <div class="card-footer d-flex justify-content-between fs-2 fw-bold lh-1">
                            <i class='fs-1 bx bx-images nav_icon'></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Pengguna -->
            <div class="col-lg-6 col-xl-4">
                <a href="<?= base_url('admin/pengguna') ?>">
                    <div class="card border border-success">
                        <div class="card-body">
                            <h5 class="card-title display-5 fw-bold"><?= lang('Admin.pengguna') ?></h5>
                            <h6 class="card-subtitle">Kelola Pengguna</h6>
                        </div>
                        <div class="card-footer d-flex justify-content-between fs-2 fw-bold lh-1">
                            <i class='fs-1 bx bxs-user-account nav_icon'></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Situs -->
            <div class="col-lg-6 col-xl-4">
                <a href="<?= base_url('admin/situs') ?>">
                    <div class="card border border-success">
                        <div class="card-body">
                            <h5 class="card-title display-5 fw-bold"><?= lang('Admin.situs') ?></h5>
                            <h6 class="card-subtitle">Kelola Situs</h6>
                        </div>
                        <div class="card-footer d-flex justify-content-between fs-2 fw-bold lh-1">
                            <i class='fs-1 bx bxs-network-chart nav_icon'></i>
                        </div>
                    </div>
                </a>
            </div>

        </div>
        <!-- Akhir pilihan cepat -->

    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
<?= $this->endSection() ?>