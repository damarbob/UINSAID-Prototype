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
        <?php if (sizeof($berita) > 0): ?>
            <?php foreach ($berita as $key => $r) : ?>
                <div class="col-lg-6 col-xl-3">
                    <!-- Item berita -->
                    <div class="card shadow" mdb-ripple-init>
                        <div class="ratio ratio-4x3">
                            <img src="<?= $r['gambar_sampul'] ?>" class="card-img-top object-fit-cover" alt="..." />
                        </div>
                        <div class="card-body text-start">
                            <a href="<?= base_url() ?>berita/<?= $r['slug'] ?>">
                                <h5 class="card-title lh-sm">
                                    <?= $r['judul'] ?>
                                </h5>
                            </a>
                            <p class="card-text">
                                <small class="text-body-secondary"><?= $r['created_at_terformat'] ?></small>
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
            <?= $pagerBerita->links('berita', 'pager') ?>
        </div>
        <!-- Akhir paginasi -->
    </div>
</div>
<div class="container mt-4">
    <div class="row">
        <div class="col text-center">
            <?php foreach ($kategori as $key => $k) : ?>
                <a href="<?= base_url('kategori/' . $k['nama']) ?>" class="btn btn-primary btn-lg me-2 mb-2" data-mdb-ripple-init><?= $k['nama'] ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
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