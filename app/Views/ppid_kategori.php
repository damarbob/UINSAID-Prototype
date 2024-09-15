<?php helper('text'); ?>

<?= $this->extend('layout/frontend_template') ?>

<?= $this->section('style') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-navbar">

    <div class="row mb-4">
        <div class="col">
            <h1 class="fw-bold mt-5"><?= ucfirst($namaKategori) ?></h1>
            <div class="lurik-3"></div>
        </div>
    </div>

    <!-- Konten utama -->
    <div class="row g-3">

        <!-- Konten utama kiri -->
        <!-- Daftar artikel terbaru -->
        <?php if (sizeof($ppid) > 0): ?>
            <?php foreach ($ppid as $i => $x) : ?>
                <div class="col-lg-6 col-xl-3">
                    <!-- Item ppid -->
                    <div class="card shadow" mdb-ripple-init>

                        <img src="<?= base_url('assets/img/icon-notext.png') ?>" class="card-img-top object-fit-cover" alt="..." />

                        <div class="card-body text-start">
                            <a href="<?= base_url('ppid/detail/' . $x['slug']) ?>">
                                <h5 class="card-title lh-sm">
                                    <?= $x['judul'] ?>
                                </h5>
                            </a>
                            <p class="card-text">
                                <small class="text-body-secondary"><?= $x['formatted_datetime'] ?></small>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        <?php else: ?>
            <div class="col mt-5">
                <p class="text-center">
                    Tidak ada konten. Silakan pilih kategori lain.
                </p>
            </div>
        <?php endif; ?>
        <!-- Akhir artikel terbaru -->

        <!-- Akhir konten utama kiri -->

        <!-- Sidebar kanan -->
        <!-- <div class="col-lg-3"> -->

        <!-- Pencarian -->
        <!-- <div class="row">
                    <form action="" method="post">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control bg-light text-secondary" placeholder="Cari Artikel" aria-label="" aria-describedby="" id="" name="keyword" />
                            <div class="input-group-append">
                                <div class="tooltip"></div>
                                <button class="btn btn-danger rounded-start-0" type="submit">
                                    <span class="bi bi-search"></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div> -->

        <!-- Artikel pilihan -->
        <?php
        // $this->include('layout/frontend/frontend_artikel_pilihan') 
        ?>

        <!-- </div> -->
        <!-- Akhir sidebar kanan -->

    </div>
    <!-- Akhir konten utama -->

    <div class="row mt-5">
        <!-- Paginasi -->
        <div class="d-flex">
            <?= $pagerPPID->links('ppid', 'pager') ?>
        </div>
        <!-- Akhir paginasi -->
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    // Initialize Swiper JS for PPID
    var swiperPPID = new Swiper("#swiper-ppid", {
        slidesPerView: 1,
        grabCursor: true,
        spaceBetween: 30,
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".ppid-swiper-button-next",
            prevEl: ".ppid-swiper-button-prev",
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: true,
        },
        cssMode: false,
    });
</script>
<?= $this->endSection() ?>