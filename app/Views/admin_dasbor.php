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
        <div class="row gy-2">

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
            <div class="col-lg-6 col-xl-4">
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

        </div>
        <!-- Akhir pilihan cepat -->

    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
<?= $this->endSection() ?>