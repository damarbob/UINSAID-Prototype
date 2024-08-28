<?php helper('text'); ?>

<?= $this->extend('layout/frontend_template') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url("assets/css/style-beranda-fakultas.css") ?>" type="text/css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Section Hero -->
<section id="hero" class="fluid bg-body p-0 mt-navbar position-relative h-auto">

  <!-- <iframe id="player" class="m-0" src="https://www.youtube.com/embed/nd8aKZ8dvko?enablejsapi=1&version=3&controls=0&rel=0&autoplay=1&loop=1&mute=1&playlist=nd8aKZ8dvko&playsinline=1" title="YouTube video player" frameborder="0" referrerpolicy="strict-origin-when-cross-origin" allow="autoplay" allowfullscreen></iframe> -->

  <!-- <div class="ratio" style="--bs-aspect-ratio: 36.36%;">
    <div class="section-slideshow object-fit-cover"></div>
  </div> -->

  <!-- Swiper hero -->
  <div class="container p-0">

    <!-- Swiper hero -->
    <!-- <div class="row mb-4"> -->
    <div class="swiper d-flex align-items-center" id="swiper-hero">
      <div class="swiper-wrapper">

        <!-- Swiper hero terbaru -->
        <?php foreach ($heroTerbaru as $i => $a) : ?>
          <div class="swiper-slide">

            <!-- Gambar hero -->
            <!-- <div class="col-md-6 position-relative order-1 order-md-2" style="height: 20vh; min-height: 128px; max-height:256px;">
                </div> -->
            <!-- <div class="ratio" style="--bs-aspect-ratio: 36.36%;"> -->

            <!-- Slideshow -->
            <img class="d-none d-lg-block"
              style="
            background: url('<?= $a['featured_image'] ?>');
            background-size: cover;
            width: 100vw;
            max-width: 1920px;
            /* Mengikuti aspek ratio hero versi desktop di figma */
            height: calc(100vw * 0.3636);
            max-height: 700px;
            ">

            <!-- Slideshow mobile -->
            <img class="d-block d-lg-none"
              style="
            background: url('<?= $a['featured_image_mobile'] ?>');
            background-size: cover;
            width: 100vw;
            max-width: 1920px;
            /* Mengikuti aspek ratio hero versi mobile di figma */
            height: calc(100vw * 0.5581395348837209);
            max-height: 700px;
            ">
            <!-- </div> -->

          </div>
        <?php endforeach; ?>
        <!-- Akhir swiper hero terbaru -->
      </div>
      <div class="swiper-button-prev ms-4 d-none d-lg-block"></div>
      <div class="swiper-button-next me-4 d-none d-lg-block"></div>

      <!-- <div class="swiper-pagination mb-4"></div> -->

    </div>

    <!-- </div> -->
    <script>
      var daftarHero = <?= json_encode($heroTerbaru) ?>;
    </script>
    <!-- Akhir swiper hero -->



  </div>
  <!-- Akhir swiper hero -->

</section>
<!-- End section Hero -->

<div class="lurik align-self-start"></div>

<!-- Section Sambutan Rektor -->
<section class="fluid mt-6" id="section-sambutan-rektor">
  <div class="container p-5">
    <div class="row g-5">

      <!-- Foto -->
      <div class="col-lg-6 pe-5">
        <div class="row">
          <img src="assets/img/rektor-lurik-noborder.png" />
          <div class="foto-kecil ratio ratio-16x9 overflow-hidden">
            <img src="assets/img/uinsaid3.png" class="object-fit-cover " />
          </div>
        </div>
      </div>

      <!-- Sambutan -->
      <div class="col-lg-6">

        <h2 class="fw-bold"><?= $sambutanRektor['judul'] ?></h2>
        <div class="lurik-3 mt-3 mb-5"></div>
        <p><?= $sambutanRektor['sambutan'] ?></p>
        <a href="" class="text-body fw-bold">Selengkapnya <span class="ms-2">›</span></a>

      </div>

    </div>
  </div>
</section>
<!-- End section Sambutan Rektor -->

<!-- Section Prodi -->
<section class="fluid" id="section-prodi">
  <!-- <div class="lurik-silk">
  </div> -->
  <div class="container p-5 pe-5">
    <div class="row g-4 p-5">

      <div class="col-12">
        <h2 class="text-light fw-bold">Prestasi Mahasiswa</h2>
        <h4 class="fw-bold"><?= $fakultas ?></h4>
      </div>

      <!-- Poin-poin -->
      <?php foreach ($prodi as $key) : ?>
        <div class="col-md-6 col-lg-4" data-aos="fade-right">
          <div class="card d-flex flex-sm-row border border-primary-subtle border-1 rounded-5 overflow-hidden gradient-1">
            <div class="prodi-gambar ratio ratio-1x1 border-start border-primary border-2 border-lg-5 rounded-5 overflow-hidden" style="background: url('<?= $key['gambar'] ?>'); background-repeat: no-repeat; background-size: cover;">
              <!-- <img src="" class="object-fit-cover"> -->
            </div>
            <div class="card-body flex-grow-1 align-content-center">
              <h5 class="card-title fw-bold"><?= $key['judul'] ?></h5>
              <!-- <a href="" class="text-body fw-bold">Selengkapnya <span class="ms-2">›</span></a> -->
            </div>
          </div>
        </div>
      <?php endforeach ?>

    </div>
  </div>
</section>
<!-- Section Prodi -->

<!-- Section Berita -->
<section id="news" class="fluid section-batik">
  <div class="container p-5">

    <div class="row mb-5 text-start" data-aos="fade-up">
      <div class="col-sm-6">
        <h1 class="fw-bold">Berita</h1>
        <div class="lurik-4"></div>
        <!-- <p class="fs-4" data-aos="fade-up">Akademik, kampus, penelitian, dan lainnya</p> -->
      </div>
      <div class="col-sm-6 d-flex align-items-center justify-content-end">
        <a href="<?= base_url("berita") ?>" class="text-body fw-bold">Selengkapnya <span class="ms-2">›</span></a>
      </div>
    </div>

    <!-- Row berita -->
    <div class="row g-4 mb-4 justify-content-center">

      <!-- Item berita -->
      <?php foreach ($beritaCard as $b => $key) : ?>
        <div class="col-lg-4 col-xl-15 col-md-6" id="item-berita" data-aos="fade-up">
          <div class="card">

            <!-- Gambar berita -->
            <div class="bg-image hover-overlay d-flex align-items-center" data-mdb-ripple-init data-mdb-ripple-color="light" style="max-height: 256px;">
              <img src="<?= $key['gambar_sampul'] ?>" class="card-img-top img-fluid object-fit-cover" alt="...">
            </div>
            <!-- Konten berita -->
            <!-- <div class="card-header">
            </div> -->
            <div class="card-body">
              <p class="card-text"><?= $key['created_at_terformat'] ?></p>
              <a href="#">
                <p class="card-title text-body">
                  <?= $key['judul'] ?>
                </p>
              </a>
            </div>

          </div>
        </div>
      <?php endforeach ?>

    </div>
  </div>
</section>
<!-- Section berita -->

<!-- Section Artikel dan Opini -->
<section class="fluid" id="section-artikel-opini">
  <div class="container p-5">
    <div class="row g-4 px-2">

      <!-- Artikel dan Opini -->
      <div class="col-lg-12" id="artikel-opini">

        <div class="row g-4">
          <div class="col" data-aos="fade-up">
            <h2 class="fw-bold">Artikel dan Opini</h2>
            <div class="lurik-4"></div>
          </div>
        </div>

        <div class="row g-4">

          <?php foreach ($artikelOpini as $key) : ?>
            <div class="col-lg-6" data-aos="fade-up">
              <div class="card mb-2">
                <div class="card-body">
                  <h5 class="fw-bold"><?= $key['judul'] ?></h5>
                  <p>
                    <?= $key['ringkasan'] ?>
                  </p>
                  <a href="" class="text-body fw-bold">Selengkapnya <span class="ms-2">›</span></a>
                </div>
              </div>
            </div>
          <?php endforeach ?>

        </div>

      </div>

    </div>
  </div>
</section>
<!-- End of Section Artikel dan Opini -->

<!-- Section Agenda -->
<section id="agenda" class="fluid section-batik">
  <div class="container p-5">

    <div class="row border-bottom border-1 border-primary-subtle mb-4">
      <div class="col-sm-6 text-start">
        <h1 class="fw-bold text-primary" data-aos="fade-up">Agenda dan Pengumuman</h1>
      </div>
      <div class="col-sm-6 d-flex align-items-center justify-content-end">
        <a href="" class="text-body fw-bold" data-aos="fade-up">Selengkapnya <span class="ms-2">›</span></a>
      </div>
    </div>

    <!-- Row agenda -->
    <div class="row g-4 mb-4 justify-content-center">

      <!-- Item agenda -->
      <?php foreach ($agenda as $b => $key) : ?>
        <div class="col-lg-4 col-xl-3 col-md-6" id="item-agenda" data-aos="fade-up">
          <div class="card" data-mdb-ripple-init
            data-mdb-ripple-init
            data-mdb-modal-init
            data-mdb-target="#berandaModal"
            data-uri="<?= $key['uri'] ?>"
            data-title="<?= $key['agenda'] ?>"
            data-deskripsi="<?= $key['deskripsi'] ?>"
            data-waktu="<?= $key['waktu'] ?>">

            <!-- Konten agenda -->
            <div class="card-body">
              <p class="card-text"><?= $key['formatted_datetime'] ?></p>
              <!-- <a href="#"> -->
              <p class="card-title text-body">
                <?= $key['agenda'] ?>
              </p>
              <!-- </a> -->
            </div>

          </div>
        </div>
      <?php endforeach ?>

    </div>

  </div>
</section>
<!-- End of section agenda -->

<!-- Section Menu -->
<section id="menu-fakultas" class="fluid section-menu-fakultas">
  <div class="container p-5">

    <!-- Row menu-fakultas -->
    <div class="row g-4 mb-4 justify-content-center">

      <!-- Item menu-fakultas -->
      <div class="col d-flex justify-content-center flex-wrap" id="item-menu-fakultas" data-aos="fade-up">
        <?php foreach ($menu as $key) : ?>
          <div class="p-3 me-3 mb-2 text-primary rounded-3 shadow fs-6 bg-secondary" style="width: auto; border-color: #462A00 !important;" data-aos="fade-up">
            <p class="h6 fw-bold me-2 m-0 d-flex align-items-center">
              <span><i class="<?= $key['icon'] ?> text-light fs-4 me-2"></i></span>
              <?= $key['menu'] ?>
            </p>
          </div>
        <?php endforeach ?>
      </div>

    </div>

  </div>
</section>
<!-- End of section menu-fakultas -->

<!-- Modal beranda -->
<div class="modal fade" id="berandaModal" tabindex="-1" aria-labelledby="berandaModalLabel" aria-hidden="true" data-mdb-backdrop="true" data-mdb-keyboard="true" aria-modal="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-secondary border-bottom-0">
        <h5 class="modal-title text-secondary-emphasis" id="modalTitle">Modal title</h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="bg-primary w-100" style="height: 4px;"></div>
      <div class="modal-body">
        <img id="modalImageContent" class="w-100" /><!-- Image content will be here -->
        <p id="modalWaktuContent"><!-- Waktu content will be here --></p>
        <p id="modalDescriptionContent"><!-- Description content will be here --></p>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script type="text/javascript" src="<?= base_url("assets/js/formatter.js") ?>"></script>
<script type="text/javascript" src="<?= base_url("assets/js/beranda.js") ?>"></script>
<?= $this->endSection() ?>