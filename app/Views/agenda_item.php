<?php
helper('text');

// URL Berita
$agendaUrl = base_url("agenda/" . $agenda['id']);
?>

<?= $this->extend('layout/frontend_template') ?>

<?= $this->section('meta') ?>

<!-- Dynamic Meta Tags -->
<meta itemprop="image" content="<?= $agenda['uri']; ?>" />

<!-- TODO: Add tags to meta keywords -->
<!-- Open Graph Dynamic Meta Tags -->
<meta property="og:title" content="<?= $agenda['agenda']; ?>" />
<meta property="og:keywords" content="uinsaid, rmsaid, uinsurakarta" />
<meta property="og:image" content="<?= $agenda['uri']; ?>" />
<meta property="og:image:alt" content="<?= $agenda['agenda']; ?>" />
<meta property="og:image:width" content="400" />
<meta property="og:image:height" content="400" />
<meta property="og:url" content="<?= $agendaUrl ?>" />
<meta property="og:description" content="<?= character_limiter(strip_tags($agenda['deskripsi']), 160); ?>" />

<!-- Twitter Dynamic Meta Tags -->
<meta name="twitter:title" content="<?= $agenda['agenda']; ?>" />
<meta name="twitter:description" content="<?= character_limiter(strip_tags($agenda['deskripsi']), 160); ?>" />
<meta name="twitter:image" content="<?= $agenda['uri']; ?>" />
<meta name="twitter:image:alt" content="<?= $agenda['agenda']; ?>" />

<?= $this->endSection() ?>


<?= $this->section('style') ?>
<link href="../assets/css/style-berita.css" rel="stylesheet" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Section CTNA -->
<section class="fluid section-batik mt-navbar d-flex" id="akademik">

    <div class="lurik align-self-center mt-7"></div>

    <div class="container p-5">
        <div class="row g-5">

            <!-- Akademik column -->
            <div class="col-lg-6 ps-lg-5 pt-5" data-aos="fade-left">

                <div class="p-3 rounded-5" style="background: rgba(var(--bs-body-bg-rgb), 0.9);">

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">

                            <!-- TODO: Hardcoded breadcrumb -->
                            <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="/agenda">Agenda</a></li>
                            <li class="breadcrumb-item active fw-bold" aria-current="page">
                                <?= $agenda['agenda']; ?>
                            </li>
                        </ol>
                    </nav>

                    <h1 class="pb-2 fw-bold">
                        <?= $agenda['agenda']; ?>
                    </h1>

                    <p>
                        Diterbitkan pada<br>
                        <span class="fw-bold">
                            <?= $agenda['created_at_terformat']; ?>
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
                            <img data-aos="fade-up" class="object-fit-cover" style="background: white; border: 1rem solid var(--mdb-body-bg);" src="<?= ($agenda['id_galeri'] != null) ? $agenda['uri'] : base_url('assets/img/icon-notext-transparent.png') ?>" />
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>
<!-- Section CTNA -->

<!-- Detail berita -->
<section id="berita-konten">
    <div class="container px-5 mt-sm-5 pt-md-5 mb-5">
        <div class="row">

            <!-- Konten artikel -->
            <div class="col-lg-8">

                <!-- <img src="<?php echo base_url() . 'uploads/' ?>" alt="" class="img-fluid object-fit-cover rounded-2 my-3" style="width: 100%; max-height: 450px" /> -->
                <p>
                    <?= $agenda['deskripsi'] ?>
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
                        <input type="text" class="form-control text-secondary" placeholder="" aria-label="" aria-describedby="copy-link" value="<?= $agendaUrl ?>" id="agendaUrl" />
                        <div class="input-group-append">
                            <div class="tooltip"></div>
                            <button class="btn btn-primary btn-lg rounded-start-0" type="button" onclick="salinBeritaUrl()">
                                <span class="bi-link"></span>
                            </button>
                        </div>
                    </div>

                    <!-- Tombol share sosmed -->
                    <div class="col">

                        <a class="btn btn-whatsapp m-2 m-xl-0 mb-lg-2 me-2" href="https://api.whatsapp.com/send?text=<?= $agenda['agenda'] ?> %0a %0a<?= $agendaUrl ?>%0a %0aKunjungi situs UIN Raden Mas Said Surakarta untuk melihat informasi terkini: %0a<?= base_url() ?>" target="_blank" onclick="window.open('https\:\/\/api.whatsapp.com/send?text=<?= $agenda['agenda'] ?> %0a %0a<?= $agendaUrl ?>%0a %0aKunjungi situs UIN Raden Mas Said Surakarta untuk melihat informasi terkini: %0a<?= base_url() ?>', '_blank', 'width=600,height=600,scrollbars=yes,menubar=no,status=yes,resizable=yes,screenx=0,screeny=0'); return false;"><small><span class="bi bi-whatsapp me-2"></span>Whatsapp</small></a>

                        <a class="btn btn-facebook-1 m-2 m-xl-0 mb-lg-2 me-2" href="https://www.facebook.com/sharer/sharer.php?u=<?= $agendaUrl ?>" target="_blank"><small><span class="bi bi-facebook me-2"></span>Facebook</small></a>

                        <a class="btn btn-twitter-1 m-2 m-xl-0 mb-lg-2 me-2" href="https://twitter.com/intent/tweet?url=<?= $agendaUrl ?>" target="_blank"><small><span class="bi bi-twitter me-2"></span>Twitter</small></a>

                        <a class="btn btn-linkedin-1 m-2 m-xl-0 mb-lg-2 me-2" href="https://www.linkedin.com/sharing/share-offsite/?url=<?= $agendaUrl ?>" target="_blank"><small><span class="bi bi-linkedin me-2"></span>LinkedIn</small></a>

                    </div>

                    <!-- Artikel pilihan -->
                    <h5 class="mt-5 mb-3">Untuk Anda</h5>

                    <?php foreach ($agendaTerbaru as $x) : ?>

                        <!-- Item artikel -->
                        <div class="card mb-2">
                            <div class="row g-0">

                                <!-- Gambar kegiatan -->
                                <div class="col-3 position-relative">
                                    <div class="ratio ratio-4x3">
                                        <img src="<?= ($x['id_galeri'] != null) ? $x['uri'] : base_url('assets/img/logo-square.png') ?>" class="card-img object-fit-cover" alt="..." />
                                    </div>
                                </div>

                                <!-- Ringkasan kegiatan -->
                                <div class="col-9">

                                    <!-- Body kegiatan -->
                                    <div class="card-body p-2">

                                        <!-- Judul kegiatan -->
                                        <p class="card-title">
                                            <a class="text-decoration-none crop-text-2" href="<?= base_url("agenda/" . $x['id']) ?>" target="_blank">
                                                <b>
                                                    <?= $x['agenda'] ?>
                                                </b>
                                            </a>
                                        </p>

                                        <!-- Kategori dan tanggal terbit -->
                                        <small class="card-text crop-text-2">
                                            <?= $x['created_at_terformat'] ?>
                                        </small>
                                    </div>
                                    <!-- Akhir body kegiatan -->

                                </div>

                                <!-- Akhir ringkasan kegiatan -->

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
<!-- Detail berita -->

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    function salinBeritaUrl() {
        var copyText = document.getElementById('agendaUrl');
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);
    }
</script>
<?= $this->endSection() ?>