<?php helper('text'); ?>

<?= $this->extend('layout/frontend_template') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url("assets/css/style-beranda.css") ?>" type="text/css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Section Hero -->
<section id="hero" class="bg-primary p-0 d-flex align-items-center justify-content-center">

  <!-- <iframe id="player" class="m-0" src="https://www.youtube.com/embed/nd8aKZ8dvko?enablejsapi=1&version=3&controls=0&rel=0&autoplay=1&loop=1&mute=1&playlist=nd8aKZ8dvko&playsinline=1" title="YouTube video player" frameborder="0" referrerpolicy="strict-origin-when-cross-origin" allow="autoplay" allowfullscreen></iframe> -->

  <div class="section-slideshow"></div>

  <!-- Swiper hero -->
  <div class="container position-relative">

    <!-- Swiper hero -->
    <!-- <div class="row mb-4"> -->
    <div class="swiper" id="swiper-hero">
      <div class="swiper-wrapper">

        <!-- Swiper hero terbaru -->
        <?php foreach ($heroTerbaru as $i => $a) : ?>
          <div class="swiper-slide">
            <div class="container text-light">
              <div class="row d-flex align-items-center align-items-md-center pt-5 mb-sm-4">

                <!-- Gambar hero -->
                <div class="col-md-6 position-relative order-1 order-md-2" style="height: 20vh; min-height: 128px; max-height:256px;">
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
        <!-- Akhir swiper hero terbaru -->
      </div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>

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

<!-- Section Poin Utama UIN RM Said -->
<section class="fluid d-flex justify-content-center" id="section-poin-utama">

  <div class="lurik align-self-start mt-4"></div>

  <div class="container p-5">
    <div class="row g-4">
      <?php foreach ($poinUtama as $p => $key) : ?>
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-bold"><?= $key['judul'] ?></h5>
              <p class="card-text"><?= $key['keterangan'] ?></p>
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
    <div class="row g-4">

      <!-- foto -->
      <div class="col-lg-6">
        <div class="row">
          <img src="assets/img/foto-rektor-wisuda.png" />
          <img class="foto-kecil" src="assets/img/uinsaid2.jpg" />
        </div>
      </div>

      <!-- sambutan -->
      <div class="col-lg-6">

        <h2 class="fw-bold"><?= $sambutanRektor['judul'] ?></h2>
        <div class="lurik-3 mt-2 mb-4"></div>
        <p><?= $sambutanRektor['sambutan'] ?></p>
        <a href="#">Selengkapnya</a>

      </div>

    </div>
  </div>
</section>
<!-- End section Sambutan Rektor -->

<!-- Section Poin Akademik -->
<section class="fluid" id="section-poin-akademik">
  <div class="lurik-silk">
  </div>
  <div class="container p-5">
    <div class="row g-4">

      <!-- Poin-poin -->
      <?php foreach ($poinAkademik as $p => $key) : ?>
        <div class="col-lg-6" data-aos="fade-right">
          <div class="card d-flex flex-sm-row border border-dark border-1">
            <div class="card-body pe-0">
              <img src="<?= $key['gambar'] ?>" style="width: 128px;"> <!-- todo: style -->
            </div>
            <div class="card-body flex-grow-1">
              <h5 class="card-title fw-bold"><?= $key['judul'] ?></h5>
              <p class="card-text"><?= $key['keterangan'] ?></p>
              <a href="#" class="btn btn-primary" data-mdb-ripple-init>Selengkapnya</a>
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
      <div class="col-lg-4">
        <h2 class="fw-bold"><?= $poinUinRmSaid['judul'] ?></h2>
        <div class="lurik-3 mt-2 mb-4"></div>
        <p><?= $poinUinRmSaid['keterangan'] ?></p>
        <a href="" class="fw-bold">Selengkapnya</a>
      </div>

      <!-- Poin-poin -->
      <div class="col-lg-8">
        <div class="row g-4">
          <?php foreach ($poinUinRmSaid['poin'] as $p => $key) : ?>
            <div class="col-md-4">
              <div class="card rounded-2 d-flex flex-sm-col <?= $p == 0 ? 'bg-primary text-light' : ($p == 1 ? 'bg-secondary text-light' : 'bg-body-secondary text-body-emphasis') ?>" style="height: 328px">
                <div class="card-body flex-grow-1">
                  <h5 class="card-title fw-bold"><?= $key['judul'] ?></h5>
                  <p class="card-text" style="font-size: 12px"><?= $key['keterangan'] ?></p>
                  <div class="w-100 text-end d-flex justify-content-end">
                    <img src="<?= $key['gambar'] ?>" style="width: 54px;" class="bg-light p-2 rounded-2 align-self-end">
                  </div>
                </div>
                <!-- <div class="card-body"> -->
                <!-- </div> -->
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
    <div class="row g-4 p-5">

      <!-- Tulisan -->
      <div class="col-lg-2 d-flex align-items-center">
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
              <div class="d-inline-flex align-items-center rounded-3 p-3 w-100 shadow" style="background-color: #FFC42E;  border-color: #573400 !important;">

                <div class="d-flex wh-64px rounded-2 p-2 me-3" style="background-color: #D57301; border-color: #573400 !important;">
                  <img src="<?= $key['gambar'] ?>" class="w-100 me-2 align-self-center">
                </div>
                <div class="d-flex text-start flex-column justify-content-center">
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
              <div class="d-inline-flex p-3 me-2 text-light rounded-3 shadow" style="width: auto; background-color: #D27E00; border-color: #462A00 !important;">
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
      <h2>Prestasi Mahasiswa</h2>
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
                        <h5 class="card-title"><a class="text-decoration-none text-light" href="<?= $a['slug']; ?>"><?= $a['judul']; ?></a></h5>
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
      <div class="col">
        <h1 class="fw-bold" data-aos="fade-up">Berita</h1>
        <div class="lurik-4"></div>
        <!-- <p class="fs-4" data-aos="fade-up">Akademik, kampus, penelitian, dan lainnya</p> -->
      </div>
    </div>

    <!-- Row berita -->
    <div class="row g-4 mb-4 justify-content-center">

      <!-- Item berita -->
      <?php foreach ($berita as $b => $key) : ?>
        <div class="col-lg-4 col-xl-15 col-md-6" id="item-berita" data-aos="fade-up">
          <div class="card" data-mdb-ripple-init>

            <!-- Gambar berita -->
            <img src="<?= $key['image'] ?>" class="card-img-top" alt="...">

            <!-- Konten berita -->
            <!-- <div class="card-header">
            </div> -->
            <div class="card-body">
              <p class="card-text"><?= $key['tgl_terbit'] ?></p>
              <a href="#">
                <p class="card-title">
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
        <div class="swiper" id="swiper-berita">
          <!-- Additional required wrapper -->
          <div class="swiper-wrapper">
            <!-- Slides -->
            <?php foreach ($berita as $i => $b) : ?>
              <div class="swiper-slide">
                <div class="swiper-slide-transform">
                  <div class="card berita-card text-dark border-3 rounded-4">
                    <img src="<?= $b['image'] ?>" class="card-img" alt="Agenda Image">
                    <div class="card-img-overlay d-flex flex-column justify-content-center">
                      <a href="">
                        <h6 class="card-title text-dark"><?= $b['judul'] ?></h6>
                      </a>
                      <div class="d-flex align-items-center mb-2">
                        <span><small><?= $b['tgl_terbit'] ?></small></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="berita-swiper-button-next d-none d-md-block"><img src="assets/img/icons8-next-page-96.png" style="width: 48px; height: 48px" /></div> <!-- todo: style -->

      </div>
    </div>

    <!-- Row tombol lebih banyak berita -->
    <div class="row mt-2 mb-2">
      <div class="col text-center">
        <a class="btn btn-lg btn-outline-body border-3 mb-4 border-start-0 border-end-0 border-top-0 rounded-0 px-0" href="#" data-aos="fade-up">
          <i class="bi bi-newspaper me-2"></i>Lebih banyak berita
        </a>
      </div>
    </div>

  </div>

</section>
<!-- Section berita -->

<!-- Section Pojok Pimpinan -->
<section class="fluid" id="section-pojok-pimpinan">
  <div class="container p-5">
    <div class="row g-4 px-2 text-dark">

      <!-- Pojok Pimpinan -->
      <div class="col-lg-6" id="pojok-pimpinan">

        <div class="row">
          <div class="col">
            <h2 class="fw-bold">Pojok Pimpinan</h2>
            <div class="lurik-4"></div>
          </div>
        </div>

        <div class="row g-4">

          <?php foreach ($pojokPimpinan as $p => $key) : ?>
            <div class="card">
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

      <!-- Opini -->
      <div class="col-lg-6" id="pojok-pimpinan">

        <div class="row">
          <div class="col">
            <h2 class="fw-bold">Opini</h2>
            <div class="lurik-4"></div>
          </div>
        </div>

        <div class="row g-4">

          <?php foreach ($opini as $p => $key) : ?>
            <div class="card">
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
</section>
<!-- End of Section Pojok Pimpinan -->

<!-- Section Agenda -->
<section id="agenda" class="fluid section-batik">
  <div class="container p-5">

    <div class="row border-bottom border-1 border-primary-subtle mb-4">
      <div class="col text-start">
        <h1 class="fw-bold text-primary" data-aos="fade-up">Agenda</h1>
      </div>
      <div class="col d-flex align-items-center justify-content-end">
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
              <p class="card-text"><?= $key['tgl_terbit'] ?></p>
              <a href="#">
                <p class="card-title text-dark">
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
<!-- End of section agenda -->

<!-- Section Pengumuman -->
<section class="fluid" id="section-pengumuman">
  <div class="container p-5">
    <div class="row rounded-3" style="background: var(--mdb-secondary-bg)">
      <div class="col">


        <div class="row pt-4 px-4 mb-3">
          <div class="col text-start">
            <h1 class="fw-bold text-primary" data-aos="fade-up">Pengumuman</h1>
          </div>
          <div class="col d-flex align-items-center justify-content-end">
            <a href="" class="text-body fw-bold" data-aos="fade-up">Selengkapnya <span class="ms-2">›</span></a>
          </div>
        </div>

        <div class="row px-4 pb-4">

          <?php foreach ($pengumuman as $p => $key) : ?>
            <div class="col-lg-4">
              <div class="card">
                <div class="d-flex p-3">

                  <div class="px-3">
                    <p class="mb-0 text-primary">
                      <span class="h3 fw-bold">
                        <?= $key['tanggal'] ?>
                      </span>
                      <?= $key['bulan'] ?>
                    </p>
                  </div>
                  <div class="flex-grow-1">
                    <a href="#">
                      <p class="card-title text-dark fw-bold">
                        <?= $key['judul'] ?>
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
      <div class="col-xl-2 col-lg-3 col-md-4 d-flex justify-content-center">
        <img src="assets/img/LOGO BLU_SPEEDCIRCLE.png" style="width: 128px;height: 100%;object-fit: scale-down;" /> <!-- todo: style -->
      </div>
      <div class="col-xl-2 col-lg-3 col-md-4 d-flex justify-content-center">
        <img src="https://th.bing.com/th/id/OIP.fineWnFIFMDVRCzgORCDFQHaHa?pid=ImgDetMain" style="width: 128px;height: 100%;object-fit: scale-down;" /> <!-- todo: style -->
      </div>
      <div class="col-xl-2 col-lg-3 col-md-4 d-flex justify-content-center">
        <img src="https://iconlogovector.com/uploads/images/2023/05/lg-7a359c6dfcb72ca61d94df92ac78afdf98.jpg" style="width: 128px;height: 100%;object-fit: scale-down;" /> <!-- todo: style -->
      </div>
      <div class="col-xl-2 col-lg-3 col-md-4 d-flex justify-content-center">
        <img src="https://logosmarcas.net/wp-content/uploads/2020/09/SpaceX-Simbolo.jpg" style="width: 128px;height: 100%;object-fit: scale-down;" /> <!-- todo: style -->
      </div>
      <div class="col-xl-2 col-lg-3 col-md-4 d-flex justify-content-center">
        <img src="https://th.bing.com/th/id/OIP.arezqGrVeKUAmuKTaXGGEgHaEK?pid=ImgDetMain" style="width: 128px;height: 100%;object-fit: scale-down;" /> <!-- todo: style -->
      </div>
    </div>

  </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script type="text/javascript" src="<?= base_url("assets/js/beranda.js") ?>"></script>
<?= $this->endSection() ?>