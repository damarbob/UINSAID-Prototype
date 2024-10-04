<?php
helper('text');

// URL PPID
$ppidUrl = base_url("ppid/" . $ppid['slug']);
?>

<?= $this->extend('layout/frontend_template') ?>

<?= $this->section('meta') ?>

<!-- Dynamic Meta Tags -->
<meta itemprop="image" content="<?= $ppid['gambar_sampul']; ?>" />

<!-- TODO: Add tags to meta keywords -->
<!-- Open Graph Dynamic Meta Tags -->
<meta property="og:title" content="<?= $ppid['judul']; ?>" />
<meta property="og:keywords" content="uinsaid, rmsaid, uinsurakarta, <?= $ppid['kategori']; ?>" />
<meta property="og:image" content="<?= $ppid['gambar_sampul']; ?>" />
<meta property="og:image:alt" content="<?= $ppid['judul']; ?>" />
<meta property="og:image:width" content="400" />
<meta property="og:image:height" content="400" />
<meta property="og:url" content="<?= $ppidUrl ?>" />
<meta property="og:description" content="<?= character_limiter(strip_tags($ppid['konten']), 160); ?>" />

<!-- Twitter Dynamic Meta Tags -->
<meta name="twitter:title" content="<?= $ppid['judul']; ?>" />
<meta name="twitter:description" content="<?= character_limiter(strip_tags($ppid['konten']), 160); ?>" />
<meta name="twitter:image" content="<?= $ppid['gambar_sampul']; ?>" />
<meta name="twitter:image:alt" content="<?= $ppid['judul']; ?>" />

<?= $this->endSection() ?>


<?= $this->section('style') ?>
<link href="<?= base_url('assets/css/style-berita.css') ?>" rel="stylesheet" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Section CTNA -->
<section class="fluid section-batik mt-navbar d-flex" id="akademik">

    <div class="lurik align-self-center mt-7"></div>

    <div class="container p-5">
        <div class="row g-5">

            <!-- Akademik column -->
            <div class="col-lg-6 ps-5 pt-5" data-aos="fade-left">

                <div class="p-3 rounded-5" style="background: rgba(var(--bs-body-bg-rgb), 0.9);">

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">

                            <!-- TODO: Hardcoded breadcrumb -->
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url('ppid') ?>">PPID</a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url('ppid/' . urlencode($ppid['kategori'])) ?>"><?= $ppid['kategori'] ?></a></li>
                            <li class="breadcrumb-item active fw-bold" aria-current="page">
                                <?= $ppid['judul']; ?>
                            </li>
                        </ol>
                    </nav>

                    <h1 class="pb-2 fw-bold">
                        <?= $ppid['judul']; ?>
                    </h1>

                    <p>
                        Diterbitkan pada<br>
                        <span class="fw-bold">
                            <?= $ppid['formatted_datetime']; ?>
                        </span>
                    </p>

                    <a href="#" class="btn btn-primary d-none">
                        Baca
                    </a>

                </div>

            </div>

            <!-- Picture grid column -->
            <div class="col-lg-6">

                <!-- Picture grid -->
                <div class="row g-0">
                    <div class="col">
                        <div class="ratio ratio-4x3">
                            <img data-aos="fade-up" class="object-fit-cover" style="border: 1rem solid var(--mdb-body-bg);" src="<?= base_url('assets/img/uinsaid.jpg') ?>" />
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>
<!-- Section CTNA -->

<!-- Detail ppid -->
<section id="berita-konten">
    <div class="container px-5 mt-sm-5 pt-md-5 mb-5">
        <div class="row">

            <!-- Konten artikel -->
            <div class="col-lg-8">

                <!-- <img src="<?php echo base_url() . 'uploads/' ?>" alt="" class="img-fluid object-fit-cover rounded-2 my-3" style="width: 100%; max-height: 450px" /> -->
                <p>
                    <?= $ppid['konten'] ?>
                </p>
            </div>
            <!-- Akhir konten artikel -->

            <!-- Sidebar sticky -->
            <div class="col-lg-4">
                <div class="sticky-top pt-3" style="top: var(--navbar-height)">

                    <!-- Judul sidebar -->
                    <h5>Bagikan</h5>

                    <!-- Input link siap copy -->
                    <div class="input-group mb-3">
                        <input type="text" class="form-control text-secondary" placeholder="" aria-label="" aria-describedby="copy-link" value="<?= $ppidUrl ?>" id="ppidUrl" />
                        <div class="input-group-append">
                            <div class="tooltip"></div>
                            <button class="btn btn-primary btn-lg rounded-start-0" type="button" onclick="salinPPIDUrl()">
                                <span class="bi-link"></span>
                            </button>
                        </div>
                    </div>

                    <!-- Tombol share sosmed -->
                    <!-- <div class="col">
                        <a class="btn btn-facebook-1 m-2 m-xl-0 mb-lg-2 me-2" href="https://www.facebook.com/sharer/sharer.php?u=<?= $ppidUrl ?>" target="_blank"><small><span class="bi bi-facebook me-2"></span>Facebook</small></a>
                        <a class="btn btn-twitter-1 m-2 m-xl-0 mb-lg-2 me-2" href="https://twitter.com/intent/tweet?url=<?= $ppidUrl ?>" target="_blank"><small><span class="bi bi-twitter me-2"></span>Twitter</small></a>

                        <a class="btn btn-linkedin-1 m-2 m-xl-0 mb-lg-2 me-2" href="https://www.linkedin.com/sharing/share-offsite/?url=<?= $ppidUrl ?>" target="_blank"><small><span class="bi bi-linkedin me-2"></span>LinkedIn</small></a>
                    </div> -->
                    <div class="col">

                        <a class="btn btn-whatsapp m-2 m-xl-0 mb-lg-2 me-2" href="https://api.whatsapp.com/send?text=<?= $ppid['judul'] ?> %0a %0a<?= $ppidUrl ?>%0a %0aKunjungi situs UIN Raden Mas Said Surakarta untuk melihat informasi terkini: %0a<?= base_url() ?>" target="_blank" onclick="window.open('https\:\/\/api.whatsapp.com/send?text=<?= $ppid['judul'] ?> %0a %0a<?= $ppidUrl ?>%0a %0aKunjungi situs UIN Raden Mas Said Surakarta untuk melihat informasi terkini: %0a<?= base_url() ?>', '_blank', 'width=600,height=600,scrollbars=yes,menubar=no,status=yes,resizable=yes,screenx=0,screeny=0'); return false;"><small><span class="bi bi-whatsapp me-2"></span>Whatsapp</small></a>

                        <a class="btn btn-facebook-1 m-2 m-xl-0 mb-lg-2 me-2" href="https://www.facebook.com/sharer/sharer.php?u=<?= $ppidUrl ?>" target="_blank"><small><span class="bi bi-facebook me-2"></span>Facebook</small></a>

                        <a class="btn btn-twitter-1 m-2 m-xl-0 mb-lg-2 me-2" href="https://twitter.com/intent/tweet?url=<?= $ppidUrl ?>" target="_blank"><small><span class="bi bi-twitter me-2"></span>Twitter</small></a>

                        <a class="btn btn-linkedin-1 m-2 m-xl-0 mb-lg-2 me-2" href="https://www.linkedin.com/sharing/share-offsite/?url=<?= $ppidUrl ?>" target="_blank"><small><span class="bi bi-linkedin me-2"></span>LinkedIn</small></a>

                    </div>

                    <!-- Artikel pilihan -->
                    <h5 class="mt-5 mb-3">Untuk Anda</h5>

                    <?php foreach ($beritaTerbaru as $key => $bt) : ?>

                        <!-- Item artikel -->
                        <div class="card mb-2">
                            <div class="row g-0">

                                <!-- Gambar berita -->
                                <div class="col-3 position-relative">
                                    <div class="ratio ratio-4x3">
                                        <img src="<?= $bt['gambar_sampul'] ?: $bt['gambar_sampul_sementara'] ?>" class="card-img object-fit-cover" alt="..." />
                                    </div>
                                </div>

                                <!-- Ringkasan berita -->
                                <div class="col-9">

                                    <!-- Body berita -->
                                    <div class="card-body p-2">

                                        <!-- Judul berita -->
                                        <p class="card-title">
                                            <a class="text-decoration-none crop-text-2" href="<?= base_url("berita/" . $bt['slug']) ?>" target="_blank">
                                                <b>
                                                    <?= $bt['judul'] ?>
                                                </b>
                                            </a>
                                        </p>

                                        <!-- Kategori dan tanggal terbit -->
                                        <small class="card-text crop-text-2">
                                            <?= $bt['formatted_datetime'] ?> - <b><?= $bt['kategori'] ?></b>
                                        </small>
                                    </div>
                                    <!-- Akhir body berita -->

                                </div>

                                <!-- Akhir ringkasan berita -->

                            </div>
                        </div>
                        <!-- Akhir item artikel -->


                    <?php endforeach; ?>

                </div>
            </div>
            <!-- Akhir sidebar sticky -->

        </div>
    </div>
</section>
<!-- Detail ppid -->

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    function salinPPIDUrl() {
        var copyText = document.getElementById('ppidUrl');
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);
    }
</script>
<?= $this->endSection() ?>