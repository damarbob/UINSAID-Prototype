<?php helper('text'); ?>

<?= $this->extend('layout/frontend_template') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url("assets/css/style-beranda.css") ?>" type="text/css" />
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

<!-- Section Poin Utama UIN RM Said (Desktop) -->
<section class="fluid d-flex justify-content-center z-3 d-none d-lg-block position-relative" id="section-poin-utama">

  <div class="lurik align-self-start mt-8"></div>

  <div class="container p-5 ms-0">
    <div class="row g-lg-4">
      <?php foreach ($poinUtama as $i => $p) : ?>
        <?php
        $isFirst = $i == 0;
        $isNotLast = $i < sizeof($poinUtama) - 1;
        ?>
        <div class="col-lg-3">
          <div class="card rounded-9">
            <div class="card-body d-inline-flex pb-4">

              <div class="border-start border-primary border-4 h-100 d-none d-lg-block"></div>
              <div class="ps-3 h-100">
                <h5 class="card-title fw-bold"><?= $p['judul'] ?></h5>
                <p class="card-text"><?= $p['keterangan'] ?></p>
                <?php if ($isNotLast): ?>
                  <div class="border-top border-primary border-4 w-50 d-block d-lg-none"></div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- End section Poin Utama -->

<!-- Section Poin Utama UIN RM Said (Mobile) -->
<section class="fluid d-flex justify-content-center z-3 d-lg-none position-relative" id="section-poin-utama">

  <div class="lurik align-self-start mt-5"></div>

  <div class="container ms-n4">
    <div class="row">
      <?php foreach ($poinUtama as $i => $p) : ?>
        <?php
        $isFirst = $i == 0;
        $isNotLast = $i < sizeof($poinUtama) - 1;
        ?>
        <div class="col-lg-3">
          <div class="card shadow-none" style="<?= $isFirst ? 'border-top-left-radius: 1.5rem; border-top-right-radius: 1.5rem;' : (!$isNotLast ? 'border-bottom-left-radius: 1.5rem; border-bottom-right-radius: 1.5rem;' : '') ?>">
            <div class="card-body d-inline-flex <?= $isNotLast ? 'pb-0' : '' ?> pb-lg-4">

              <div class="ms-2 ps-4 h-100">
                <h5 class="card-title fw-bold"><?= $p['judul'] ?></h5>
                <p class="card-text"><?= $p['keterangan'] ?></p>
                <?php if ($isNotLast): ?>
                  <div class="border-top border-primary border-4 w-50"></div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- End section Poin Utama -->

<!-- Section Sambutan Rektor -->
<section class="fluid" id="section-sambutan-rektor">
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

<!-- Section Poin Akademik -->
<section class="fluid" id="section-poin-akademik">
  <div class="lurik-silk">
  </div>
  <div class="container p-5 pe-5">
    <div class="row g-4">

      <!-- Poin-poin -->
      <?php foreach ($poinAkademik as $p => $key) : ?>
        <div class="col-lg-6" data-aos="fade-right">
          <div class="card d-flex flex-sm-row border border-primary-subtle border-1 rounded-5 overflow-hidden gradient-1">
            <div class="poin-akademik-gambar ratio ratio-1x1 border-start border-primary border-2 border-lg-5 rounded-5 overflow-hidden" style="background: url('<?= $key['gambar'] ?>'); background-repeat: no-repeat; background-size: cover;">
              <!-- <img src="" class="object-fit-cover"> -->
            </div>
            <div class="card-body flex-grow-1">
              <h5 class="card-title fw-bold"><?= $key['judul'] ?></h5>
              <p class="card-text fs-6"><?= $key['keterangan'] ?></p>
              <a href="" class="text-body fw-bold">Selengkapnya <span class="ms-2">›</span></a>
            </div>
          </div>
        </div>
      <?php endforeach ?>

    </div>
  </div>
</section>
<!-- Section Poin Akademik -->

<!-- Section UIN RM Said -->
<section class="fluid" id="section-uin-said">
  <div class="container p-5">
    <div class="row g-4">

      <!-- Tulisan -->
      <div class="col-xl-4">
        <h2 class="fw-bold" data-aos="fade-right"><?= $poinUinRmSaid['judul'] ?></h2>
        <div class="lurik-3 mt-2 mb-4"></div>
        <p data-aos="fade-right"><?= $poinUinRmSaid['keterangan'] ?></p>
        <a href="" class="fw-bold" data-aos="fade-right">Selengkapnya</a>
      </div>

      <!-- Poin-poin -->
      <div class="col-xl-8">
        <div class="row g-4">
          <?php foreach ($poinUinRmSaid['poin'] as $p => $key) : ?>
            <div class="col-md-4">
              <div class="card rounded-2 d-flex flex-sm-col <?= $p == 0 ? 'bg-primary text-light' : ($p == 1 ? 'bg-secondary text-light' : 'bg-body-secondary text-body-emphasis') ?>" data-aos="fade-left" data-aos-delay="<?= $p == 0 ? '100' : ($p == 1 ? '200' : '300') ?>">
                <div class="card-body flex-grow-1 pb-0">
                  <h5 class="card-title fw-bold"><?= $key['judul'] ?></h5>
                  <p class="card-text" style="font-size: 12px"><?= $key['keterangan'] ?></p>
                </div>
                <div class="d-flex flex-grow-1 justify-content-end pe-4 pb-4">
                  <img src="<?= $key['gambar'] ?>" style="width: 54px;" class="bg-light p-2 rounded-2 align-self-end">
                </div>
              </div>
            </div>
          <?php endforeach ?>
        </div>
      </div>

    </div>
  </div>
</section>
<!-- End section UIN RM Said -->

<!-- Section Statistik -->
<section class="fluid" id="section-statistik">
  <div class="container p-5">
    <div class="row g-4 p-2 p-sm-5">

      <!-- Tulisan -->
      <div class="col-lg-2 d-flex align-items-center" data-aos="fade-up">
        <div>
          <h2 class="fw-bold" style="color: #955900;">Data Statistik</h2>
          <p class="text-light">UIN Raden Mas Said Surakarta</p>
        </div>
      </div>

      <!-- Poin-poin -->
      <div class="col-lg-10">
        <div class="row g-2 mb-4">
          <?php foreach ($statistik['utama'] as $s => $key) : ?>
            <div class="col-md-4">
              <div class="d-inline-flex align-items-center rounded-3 p-3 w-100 shadow" style="background-color: #FFC42E;  border-color: #573400 !important;" data-aos="fade-up" data-aos-delay="<?= $s == 0 ? '100' : ($s == 1 ? '200' : '300') ?>">

                <div class="d-flex wh-64px rounded-2 p-2 me-3" style="background-color: #D57301; border-color: #573400 !important;">
                  <img src="<?= $key['gambar'] ?>" class="w-100 me-2 align-self-center">
                </div>
                <div class="d-flex text-start flex-column justify-content-center" style="color: #955900;">
                  <h2 class="fw-bold"><?= $key['nilai'] ?></h2>
                  <h6 class=""><?= $key['namaStatistik'] ?></h6>
                </div>

              </div>
            </div>
          <?php endforeach ?>
        </div>

        <div class="row g-2 mb-4">
          <div class="col">
            <?php foreach ($statistik['lainnya'] as $s => $key) : ?>
              <div class="d-inline-flex p-3 me-2 mb-2 text-light rounded-3 shadow fs-6" style="width: auto; background-color: #D27E00; border-color: #462A00 !important;" data-aos="fade-left" data-aos-delay="<?= $s == 0 ? '100' : ($s == 1 ? '200' : ($s == 2 ? '300' : ($s == 3 ? '400' : ($s == 4 ? '500' : '600')))) ?>">
                <p class="h5 fw-bold me-2 m-0"><?= $key['nilai'] ?></p>
                <p class="m-0"><?= $key['namaStatistik'] ?></p>
              </div>
            <?php endforeach ?>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
<!-- End of Section Statistik -->

<!-- Prestasi -->
<section id="section-prestasi" class="fluid d-flex justify-content-center align-items-center">
  <!-- <div class="section-slideshow align-self-center"></div> -->

  <div class="container p-5 position-relative">

    <!-- Swiper prestasi -->
    <div class="row mb-4">
      <div class="col">
        <h2>Prestasi Mahasiswa</h2>
        <div class="lurik-4 mb-4"></div>
        <div class="d-flex justify-content-evenly align-items-center">
          <div class="prestasi-swiper-button-prev d-none d-md-block"><img src="assets/img/icons8-back-to-96.png" style="width: 48px; height: 48px" /></div>

          <div class="swiper" id="swiper-prestasi" data-aos="fade-up" data-aos-delay="300" style="width: 80%;">
            <div class="swiper-wrapper ">

              <!-- Swiper prestasi terbaru -->
              <?php foreach ($prestasiTerbaru as $i => $a) : ?>
                <div class="swiper-slide">
                  <div class="swiper-slide-transform">
                    <div class="card prestasi-card text-light">
                      <img src="<?= $a['gambar'] ?>" class="card-img" alt="Agenda Image">
                      <div class="card-img-overlay d-flex flex-column justify-content-end text-light">
                        <div class="d-flex align-items-center mb-2">
                        </div>
                        <a href="">
                          <h5 class="card-title fw-bold"><a class="text-decoration-none text-light" href="<?= $a['slug']; ?>"><?= $a['judul']; ?></a></h5>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
              <!-- Akhir swiper prestasi terbaru -->
            </div>

            <div class="swiper-pagination"></div>

          </div>
          <div class="prestasi-swiper-button-next d-none d-md-block"><img src="assets/img/icons8-next-page-96.png" style="width: 48px; height: 48px" /></div>
        </div>
      </div>
    </div>
    <script>
      var daftarPrestasi = <?= json_encode($prestasiTerbaru) ?>;
    </script>
    <!-- Akhir swiper prestasi -->



  </div>

  <!-- <div class="container align-self-end">
		<a class="btn btn-danger rounded-4" href="/rilis-media" role="button">Lihat Semua
			prestasi
			<span class="ps-1 bi-arrow-right"></span></a>
	</div> -->

</section>
<!-- End prestasi Section -->

<!-- Lurik -->
<section class="fluid lurik position-static"></section>

<!-- Section Berita -->
<section id="news" class="fluid section-batik">
  <div class="container p-5">

    <div class="row mb-5 text-start">
      <div class="col-sm-6">
        <h1 class="fw-bold" data-aos="fade-up">Berita</h1>
        <div class="lurik-4"></div>
        <!-- <p class="fs-4" data-aos="fade-up">Akademik, kampus, penelitian, dan lainnya</p> -->
      </div>
      <div class="col-sm-6 d-flex align-items-center justify-content-end">
        <a href="" class="text-body fw-bold">Selengkapnya <span class="ms-2">›</span></a>
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

    <div class="row g-4 mb-4 justify-content-center" data-aos="fade-up">
      <div class="d-flex justify-content-evenly align-items-center">

        <div class="berita-swiper-button-prev d-none d-md-block"><img src="assets/img/icons8-back-to-96.png" style="width: 48px; height: 48px" /></div> <!-- todo: style -->


        <!-- Slider berita -->
        <div class="swiper py-3 px-2" id="swiper-berita">
          <!-- Additional required wrapper -->
          <div class="swiper-wrapper">
            <!-- Slides -->
            <?php foreach ($beritaSwiper as $i => $b) : ?>
              <div class="swiper-slide">
                <div class="swiper-slide-transform">
                  <div class="card berita-card text-body border-3 rounded-4">
                    <div class="d-flex align-items-center" data-mdb-ripple-init data-mdb-ripple-color="light" style="width: 96px;">
                      <img src="<?= $b['gambar_sampul'] ?>" class="card-img" alt="Gambar Berita">
                    </div>
                    <div class="d-flex flex-column justify-content-center ps-3">
                      <a href="">
                        <h6 class="card-title text-body"><?= $b['judul'] ?></h6>
                      </a>
                      <div class="d-flex align-items-center mb-2">
                        <span style="font-size:small"><?= $b['created_at_terformat'] ?></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
            <div class="swiper-slide">
              <div class="swiper-slide-transform">
                <div class="card berita-card text-body border-3 rounded-4">
                  <div class="d-flex flex-column justify-content-center ps-3 align-items-center">
                    <a href="">
                      <h5 class="card-title text-body">Follow Instagram UIN RM Said</h5>
                    </a>
                  </div>
                  <img src="assets/img/mahasiswa/mahasiswa-1.png" class="card-img" alt="Gambar">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="berita-swiper-button-next d-none d-md-block"><img src="assets/img/icons8-next-page-96.png" style="width: 48px; height: 48px" /></div> <!-- todo: style -->

      </div>
    </div>

    <!-- Row tombol lebih banyak berita -->
    <!-- <div class="row mt-2 mb-2">
      <div class="col text-center">
        <a class="btn btn-lg btn-outline-body border-3 mb-4 border-start-0 border-end-0 border-top-0 rounded-0 px-0" href="#" data-aos="fade-up">
          <i class="bi bi-newspaper me-2"></i>Lebih banyak berita
        </a>
      </div>
    </div> -->

  </div>

</section>
<!-- Section berita -->

<!-- Section Pojok Pimpinan -->
<section class="fluid" id="section-pojok-pimpinan">
  <div class="container p-5">
    <div class="row g-4 px-2">

      <!-- Pojok Pimpinan -->
      <div class="col-lg-6" id="pojok-pimpinan">

        <div class="row g-4">
          <div class="col" data-aos="fade-up">
            <h2 class="fw-bold">Pojok Pimpinan</h2>
            <div class="lurik-4"></div>
          </div>
        </div>

        <div class="row g-4">
          <div class="col" data-aos="fade-up">

            <?php foreach ($pojokPimpinan as $p => $key) : ?>
              <div class="card mb-4">
                <div class="card-body">
                  <h5 class="fw-bold"><?= $key['judul'] ?></h5>
                  <p>
                    <?= $key['ringkasan'] ?>
                  </p>
                  <a href="" class="text-body fw-bold">Selengkapnya <span class="ms-2">›</span></a>
                </div>
              </div>
            <?php endforeach ?>

          </div>
        </div>

      </div>

      <!-- Opini -->
      <div class="col-lg-6" id="pojok-pimpinan">

        <div class="row">
          <div class="col" data-aos="fade-up">
            <h2 class="fw-bold">Opini</h2>
            <div class="lurik-4"></div>
          </div>
        </div>

        <div class="row g-4">
          <div class="col" data-aos="fade-up">

            <?php foreach ($opini as $p => $key) : ?>
              <div class="card mb-4">
                <div class="card-body">
                  <h5 class="fw-bold"><?= $key['judul'] ?></h5>
                  <p>
                    <?= $key['ringkasan'] ?>
                  </p>
                  <a href="" class="text-body fw-bold">Selengkapnya <span class="ms-2">›</span></a>
                </div>
              </div>
            <?php endforeach ?>

          </div>
        </div>
      </div>

    </div>
  </div>
</section>
<!-- End of Section Pojok Pimpinan -->

<!-- Section Agenda -->
<section id="agenda" class="fluid section-batik">
  <div class="container p-5">

    <div class="row border-bottom border-1 border-primary-subtle mb-4">
      <div class="col-sm-6 text-start">
        <h1 class="fw-bold text-primary" data-aos="fade-up">Agenda</h1>
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
          <div class="card" data-mdb-ripple-init>

            <!-- Konten agenda -->
            <div class="card-body">
              <p class="card-text"><?= $key['formatted_datetime'] ?></p>
              <a href="#">
                <p class="card-title text-body">
                  <?= $key['agenda'] ?>
                </p>
              </a>
            </div>

          </div>
        </div>
      <?php endforeach ?>

    </div>

  </div>
</section>
<!-- End of section agenda -->

<!-- Section Pengumuman -->
<section class="fluid" id="section-pengumuman">
  <div class="container p-5">
    <div class="row rounded-3 px-2 px-lg-4" style="background: var(--mdb-secondary-bg)">
      <div class="col">


        <div class="row pt-4 mb-3">
          <div class="col text-start">
            <h1 class="fw-bold text-primary" data-aos="fade-up">Pengumuman</h1>
          </div>
          <div class="col d-flex align-items-center justify-content-end">
            <a href="" class="text-body fw-bold" data-aos="fade-up">Selengkapnya <span class="ms-2">›</span></a>
          </div>
        </div>

        <div class="row pb-4">

          <?php foreach ($pengumuman as $p => $key) : ?>
            <div class="col-lg-4" data-aos="fade-up">
              <div class="card">
                <div class="d-flex p-3">

                  <div class="px-3">
                    <p class="mb-0 text-primary">
                      <span class="h3 fw-bold">
                        <?= $key['waktu_terformat_tanggal'] ?>
                      </span>
                      <br>
                      <?= $key['waktu_terformat_bulan'] ?>
                    </p>
                  </div>
                  <div class="flex-grow-1 d-flex align-items-center">
                    <a href="#">
                      <p class="card-title text-body fw-bold fs-6 mb-0">
                        <?= $key['pengumuman'] ?>
                      </p>
                    </a>
                  </div>

                </div>
              </div>
            </div>
          <?php endforeach ?>
        </div>


      </div>
    </div>
  </div>
</section>
<!-- End of Section Pengumuman -->

<!-- Section Kerjasama -->
<section id="kerjasama" class="d-flex section-batik rev-180 align-items-center">
  <div class="container p-5">

    <div class="row mb-5 text-center" data-aos="fade-up">
      <div class="col">
        <h1 class="fw-bold">Kerjasama</h1>
        <p class="fs-4">Pendidikan, penelitian, bisnis, dan lainnya</p>
      </div>
    </div>

    <!-- Logo -->
    <div class="row gx-4 gy-5 align-items-center align-self-center justify-content-center" data-aos="fade-up">
      <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 d-flex justify-content-center">
        <img src="assets/img/LOGO BLU_SPEEDCIRCLE.png" style="width: 128px;height: 100%;object-fit: scale-down;" /> <!-- todo: style -->
      </div>
      <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 d-flex justify-content-center">
        <img src="https://th.bing.com/th/id/OIP.fineWnFIFMDVRCzgORCDFQHaHa?pid=ImgDetMain" style="width: 128px;height: 100%;object-fit: scale-down;" /> <!-- todo: style -->
      </div>
      <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 d-flex justify-content-center">
        <img src="https://iconlogovector.com/uploads/images/2023/05/lg-7a359c6dfcb72ca61d94df92ac78afdf98.jpg" style="width: 128px;height: 100%;object-fit: scale-down;" /> <!-- todo: style -->
      </div>
      <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 d-flex justify-content-center">
        <img src="https://logosmarcas.net/wp-content/uploads/2020/09/SpaceX-Simbolo.jpg" style="width: 128px;height: 100%;object-fit: scale-down;" /> <!-- todo: style -->
      </div>
      <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6 d-flex justify-content-center">
        <img src="https://th.bing.com/th/id/OIP.arezqGrVeKUAmuKTaXGGEgHaEK?pid=ImgDetMain" style="width: 128px;height: 100%;object-fit: scale-down;" /> <!-- todo: style -->
      </div>
    </div>

  </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script type="text/javascript" src="<?= base_url("assets/js/beranda.js") ?>"></script>
<?= $this->endSection() ?>