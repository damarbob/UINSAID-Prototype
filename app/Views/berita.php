<?php helper('text'); ?>

<?= $this->extend('layout/frontend_template') ?>

<?= $this->section('style') ?>

<?= $this->endSection() ?>

<?= $this->section('content') ?>

<section class="fluid mt-navbar d-flex">

    <div class="lurik align-self-center mt-10"></div>
    <div class="container pt-5">

        <div class="row mb-4">
            <div class="col">

                <!-- Swiper -->
                <div class="swiper" id="swiper-berita">
                    <div class="swiper-wrapper">

                        <!-- Swiper artikel terbaru -->
                        <?php foreach ($beritaTerbaru as $i => $a) : ?>
                            <div class="swiper-slide">
                                <div class="card bg-transparent">
                                    <div class="row">

                                        <!-- Gambar artikel -->
                                        <div class="col-md-6">
                                            <img src="<?= $a['gambar_sampul'] ?>" class="object-fit-cover w-100 border border-white" style="height: 384px; border-width: 16px !important;" alt="..." />
                                        </div>

                                        <!-- Body artikel -->
                                        <div class="col-md-6">
                                            <div class="card-body p-md-5">

                                                <!-- Kategori -->
                                                <p class="text-danger mb-3"><b><?php echo $a['kategori']; ?></b></p>

                                                <!-- Judul -->
                                                <h3 class="card-title mb-3">
                                                    <a class="link-dark text-decoration-none crop-text-2" href="rilis-media/<?= $a['slug']; ?>"><?= $a['judul']; ?></a>
                                                </h3>

                                                <!-- Ringkasan -->
                                                <p class="card-text crop-text-2 mb-3">
                                                    <?= word_limiter($a['ringkasan'], 10); ?>
                                                </p>

                                                <!-- Tanggal -->
                                                <p class="card-text crop-text-2 mb-3">
                                                    <?= $a['created_at_terformat']; ?>
                                                </p>
                                            </div>

                                        </div>
                                        <!-- Akhir body artikel -->

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <!-- Akhir swiper artikel terbaru -->
                    </div>

                    <div class="swiper-pagination"></div>

                </div>
                <!-- Akhir Swiper -->

            </div>
        </div>

    </div>

</section>

<div class="container mt-5">

    <div class="row mb-4">
        <div class="col">
            <h1 class="fw-bold">Ada apa di UIN Raden Mas Said?</h1>
            <div class="lurik-3"></div>
        </div>
    </div>

    <!-- Konten utama -->
    <div class="row g-3">

        <!-- Konten utama kiri -->
        <!-- Daftar artikel terbaru -->
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