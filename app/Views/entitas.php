<?php helper('text'); ?>

<?= $this->extend('layout/frontend_template') ?>

<?= $this->section('style') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container mt-navbar pt-5">

    <div class="row mb-4">
        <div class="col">
            <h1 class="fw-bold"><?= $judul ?></h1>
            <div class="lurik-3"></div>
        </div>
    </div>

    <!-- Konten utama -->
    <div class="row g-3" data-masonry='{"percentPosition": true }'>

        <?php if (sizeof($entitas) == 0): ?>
            <div class="col">
                <p class="text-center">
                    Tidak ditemukan
                </p>
            </div>
        <?php endif ?>

        <!-- Konten utama kiri -->
        <!-- Daftar artikel terbaru -->
        <?php foreach ($entitas as $e) : ?>
            <div class="col-lg-6 col-xl-3">
                <!-- Item berita -->
                <div class="card shadow" mdb-ripple-init>
                    <div class="ratio ratio-4x3">
                        <img src="<?= ($e['gambar_sampul'] != null) ? $e['gambar_sampul'] : base_url('assets/img/icon-notext-transparent.png') ?>" class="card-img-top object-fit-cover" alt="..." />
                    </div>
                    <div class="card-body text-start">
                        <a href="<?= base_url() ?>entitas/<?= $e['slug'] ?>">
                            <h5 class="card-title lh-sm">
                                <?= $e['nama'] ?>
                            </h5>
                        </a>
                        <p class="card-text">
                            <small class="text-body-secondary"><?php //$e['created_at_terformat'] 
                                                                ?></small>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
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
            <?= $pagerEntitas->links('entitas', 'pager') ?>
        </div>
        <!-- Akhir paginasi -->
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
<script>
    // Initialize Swiper JS for Berita
    var swiperBerita = new Swiper("#swiper-berita", {
        slidesPerView: 1,
        grabCursor: true,
        spaceBetween: 30,
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".berita-swiper-button-next",
            prevEl: ".berita-swiper-button-prev",
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: true,
        },
        cssMode: false,
    });
</script>
<?= $this->endSection() ?>