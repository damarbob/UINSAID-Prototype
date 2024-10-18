<?php

use function App\Helpers\capitalize_first_letter;

helper('text');

// URL Berita
$beritaUrl = base_url("berita/" . $berita['slug']);
?>

<?= $this->extend('layout/frontend_template') ?>

<?= $this->section('meta') ?>

<!-- Dynamic Meta Tags -->
<meta itemprop="image" content="<?= $berita['gambar_sampul']; ?>" />

<!-- TODO: Add tags to meta keywords -->
<!-- Open Graph Dynamic Meta Tags -->
<meta property="og:type" content="article" />
<meta property="og:title" content="<?= character_limiter($berita['judul'], 60); ?>" />
<meta property="og:description" content="<?= $berita['ringkasan'] ?: character_limiter(strip_tags($berita['konten']), 160); ?>" />
<meta property="og:keywords" content="<?= setting()->get('App.kataKunciSitus') ?>, <?= $berita['kategori']; ?>" />
<meta property="og:image" content="<?= $berita['gambar_sampul']; ?>" />
<meta property="og:image:alt" content="<?= $berita['judul']; ?>" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
<meta property="og:url" content="<?= $beritaUrl ?>" />

<!-- Twitter Dynamic Meta Tags -->
<meta name="twitter:title" content="<?= $berita['judul']; ?>" />
<meta name="twitter:description" content="<?= $berita['ringkasan'] ?: character_limiter(strip_tags($berita['konten']), 160); ?>" />
<meta name="twitter:image" content="<?= $berita['gambar_sampul']; ?>" />
<meta name="twitter:image:alt" content="<?= $berita['judul']; ?>" />
<meta name="twitter:url" content="<?= $beritaUrl; ?>" />

<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "NewsArticle",
        "headline": "<?= $berita['judul'] ?>",
        "image": "<?= $berita['gambar_sampul'] ?: $berita['gambar_sampul_sementara'] ?>",
        "datePublished": "<?= $berita['tanggal_terbit'] ?>",
        "author": {
            "@type": "Person",
            "name": "Admin UINSAID"
        },
        "publisher": {
            "@type": "Organization",
            "name": "<?= setting()->get('App.judulSitus') ?>",
            "logo": {
                "@type": "ImageObject",
                "url": "<?= base_url(setting()->get('App.logoSitus')) ?>"
            }
        },
        "articleBody": "<?= $berita['ringkasan'] ?: character_limiter(strip_tags($berita['konten']), 160) ?>"
    }
</script>

<?= $this->endSection() ?>


<?= $this->section('style') ?>
<link href="<?= base_url('assets/css/style-berita.css') ?>" rel="stylesheet" />

<script async defer crossorigin="anonymous"
    src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v17.0">
</script>

<script type="text/javascript">
    window.fbAsyncInit = function() {
        FB.init({
            appId: 'YOUR_APP_CODE',
            xfbml: true,
            version: 'v17.0'
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Section CTNA -->
<section class="fluid section-batik mt-navbar d-flex" id="akademik">

    <div class="lurik align-self-center mt-7"></div>

    <div class="container p-5">
        <div class="row g-5">

            <!-- Akademik column -->
            <div class="col-lg-6 ps-lg-5 pt-5" data-aos="flip-left">

                <div class="p-3 rounded-5" style="background: rgba(var(--mdb-body-bg-rgb), 0.9);">

                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">

                            <!-- TODO: Hardcoded breadcrumb -->
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url('berita') ?>">Berita</a></li>

                            <span class="badge badge-primary align-self-center ms-3" style="width: max-content; height:max-content"><?= capitalize_first_letter($berita['kategori']) ?></span>
                        </ol>
                    </nav>

                    <h1 class="pb-2 fw-bold">
                        <?= $berita['judul']; ?>
                    </h1>

                    <p>
                        Diterbitkan pada<br>
                        <span class="fw-bold">
                            <?= $berita['formatted_datetime']; ?>
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
                            <img data-aos="fade-up" class="object-fit-cover" style="border: 1rem solid var(--mdb-body-bg);" src="<?= $berita['gambar_sampul'] ?: $berita['gambar_sampul_sementara'] ?>" onerror="this.onerror=null; this.src='<?= base_url('assets/img/icon-notext.png') ?>'" />
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
                    <?= $berita['konten'] ?>
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
                        <input type="text" class="form-control text-secondary" placeholder="" aria-label="" aria-describedby="copy-link" value="<?= $beritaUrl ?>" id="beritaUrl" />
                        <div class="input-group-append">
                            <div class="tooltip"></div>
                            <button class="btn btn-primary btn-lg rounded-start-0" type="button" onclick="salinBeritaUrl()">
                                <span class="bi-link"></span>
                            </button>
                        </div>
                    </div>

                    <!-- Tombol share sosmed -->
                    <div class="col d-flex flex-nowrap">

                        <!-- <a class="btn btn-whatsapp me-2 flex-grow-1 w-100" href="https://api.whatsapp.com/send?text=<?= $berita['judul'] ?> %0a %0a<?= $beritaUrl ?>%0a %0aKunjungi situs UIN Raden Mas Said Surakarta untuk melihat informasi terkini: %0a<?= base_url() ?>" target="_blank" onclick="window.open('https\:\/\/api.whatsapp.com/send?text=<?= $berita['judul'] ?> %0a %0a<?= $beritaUrl ?>%0a %0aKunjungi situs UIN Raden Mas Said Surakarta untuk melihat informasi terkini: %0a<?= base_url() ?>', '_blank', 'width=600,height=600,scrollbars=yes,menubar=no,status=yes,resizable=yes,screenx=0,screeny=0'); return false;"><span class="bi bi-whatsapp"></span></a> -->
                        <!-- <a class="btn btn-facebook-1 me-2 flex-grow-1 w-100" href="" onclick="shareOnFacebook()" target="_blank"><span class="bi bi-facebook"></span></a> -->
                        <!-- <a class="btn btn-whatsapp me-2 flex-grow-1 w-100" href="https://api.whatsapp.com/send?text=<?= $berita['judul'] ?> %0a %0aSelengkapnya di: %0a<?= $beritaUrl ?>%0a %0a<?= urlencode(setting()->get('App.sharingCaption')) ?>" target="_blank"><span class="bi bi-whatsapp me-1"></span>WhatsApp</a> -->
                        <!-- <a class="btn btn-facebook-1 me-2 flex-grow-1 w-100" href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($beritaUrl) ?>" target="_blank"><span class="bi bi-facebook me-1"></span>Facebook</a> -->
                        <!-- <a class="btn btn-twitter-1 me-2 flex-grow-1 w-100" href="https://twitter.com/intent/tweet?text=<?= $berita['judul'] ?>&url=<?= $beritaUrl ?>" target="_blank"><span class="bi bi-twitter me-1"></span>Twitter/X</a> -->
                        <!-- <a class="btn btn-linkedin-1 me-2 flex-grow-1 w-100" href="https://www.linkedin.com/sharing/share-offsite/?url=<?= $beritaUrl ?>" target="_blank"><span class="bi bi-linkedin"></span>LinkedIn</a> -->

                        <a class="btn btn-whatsapp me-2 flex-grow-1 w-100" href="https://api.whatsapp.com/send?text=<?= $berita['judul'] ?> %0a %0aSelengkapnya di: %0a<?= $beritaUrl ?>%0a %0a<?= urlencode(setting()->get('App.sharingCaption')) ?>" target="_blank">
                            <span class="bi bi-whatsapp"></span>
                            <span class="label">WhatsApp</span>
                        </a>

                        <a class="btn btn-facebook-1 me-2 flex-grow-1 w-100" href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($beritaUrl) ?>" target="_blank">
                            <span class="bi bi-facebook"></span>
                            <span class="label">Facebook</span>
                        </a>

                        <a class="btn btn-twitter-1 me-2 flex-grow-1 w-100" href="https://twitter.com/intent/tweet?text=<?= $berita['judul'] ?>&url=<?= $beritaUrl ?>" target="_blank">
                            <span class="bi bi-twitter"></span>
                            <span class="label">Twitter/X</span>
                        </a>

                        <a class="btn btn-linkedin-1 flex-grow-1 w-100" href="https://www.linkedin.com/sharing/share-offsite/?url=<?= $beritaUrl ?>" target="_blank">
                            <span class="bi bi-linkedin"></span>
                            <span class="label">LinkedIn</span>
                        </a>
                        <!-- <?= locale_get_default() ?> -->
                    </div>

                    <!-- Artikel pilihan -->
                    <h5 class="mt-5 mb-3">Untuk Anda</h5>

                    <?php foreach ($beritaTerbaru as $key => $bt) : ?>

                        <!-- Item artikel -->
                        <div class="card mb-2">
                            <div class="row g-0">

                                <!-- Gambar kegiatan -->
                                <div class="col-3 position-relative">
                                    <div class="ratio ratio-4x3">
                                        <img src="<?= $bt['gambar_sampul'] ?: $bt['gambar_sampul_sementara'] ?>" class="card-img object-fit-cover" alt="..." onerror="this.onerror=null; this.src='<?= base_url('assets/img/icon-notext.png') ?>'" />
                                    </div>
                                </div>

                                <!-- Ringkasan kegiatan -->
                                <div class="col-9">

                                    <!-- Body kegiatan -->
                                    <div class="card-body p-2">

                                        <!-- Judul kegiatan -->
                                        <p class="card-title">
                                            <a class="text-decoration-none crop-text-2" href="<?= base_url("berita/" . $bt['slug']) ?>" target="_blank">
                                                <b class="line-clamp-2">
                                                    <?= $bt['judul'] ?>
                                                </b>
                                            </a>
                                        </p>

                                        <!-- Kategori dan tanggal terbit -->
                                        <small class="card-text crop-text-2">
                                            <?= $bt['formatted_datetime'] ?> - <b><?= $bt['kategori'] ?></b>
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
        var copyText = document.getElementById('beritaUrl');
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);
    }
</script>

<script>
    // function shareOnFacebook() {
    //     FB.ui({
    //         method: 'share',
    //         // href: '<?= base_url('berita/' . $beritaUrl) ?>',
    //         href: 'https://uinsaid.ac.id/berita/dwp-uin-surakarta-ikuti-pengajian-rutin-dwp-kementerian-agama-ri',
    //     }, function(response) {
    //         if (response && !response.error_message) {
    //             alert('Successfully shared!');
    //         } else {
    //             alert('Error while sharing.');
    //         }
    //     });
    // }
</script>
<?= $this->endSection() ?>