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

      <div class="swiper-pagination mb-4"></div>

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
<section class="fluid" id="section-poin-utama">
  <div class="container p-5">
    <div class="row g-4">
      <?php foreach ($poinUtama as $p => $key) : ?>
        <div class="col-lg-3">
          <div class="card d-flex">
            <div class="card-body flex-grow-1">
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
        <div class="row" style="position: relative;">
          <img src="assets/img/foto-rektor-wisuda.png" />
          <img src="assets/img/uinsaid2.jpg" style="position: absolute; width: 50%; bottom: 0px; right: 0px" />
        </div>
      </div>

      <!-- sambutan -->
      <div class="col-lg-6">
        <h2><?= $sambutanRektor['judul'] ?></h2>
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
              <!-- <h5 class="card-title display-5"><i class="bi bi-buildings text-primary"></i></h5> -->
              <img src="<?= $key['gambar'] ?>" style="width: 128px;">
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
        <div class="row">
          <h2><?= $poinUinRmSaid['judul'] ?></h2>
          <p><?= $poinUinRmSaid['keterangan'] ?></p>
        </div>
      </div>

      <!-- Poin-poin -->
      <div class="col-lg-8">
        <div class="row g-4">
          <?php foreach ($poinUinRmSaid['poin'] as $p => $key) : ?>
            <div class="col-md-4">
              <div class="card d-flex flex-sm-col border border-dark border-1">
                <div class="card-body flex-grow-1">
                  <h5 class="card-title fw-bold"><?= $key['judul'] ?></h5>
                  <p class="card-text"><?= $key['keterangan'] ?></p>
                </div>
                <!-- <div class="card-body"> -->
                <img src="<?= $key['gambar'] ?>" style="width: 64px;">
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
    <div class="row g-4 px-2">

      <!-- Tulisan -->
      <div class="col-lg-2 d-flex align-items-center">
        <div class="row">
          <h2>Data Statistik</h2>
          <p>UIN Raden Mas Said Surakarta</p>
        </div>
      </div>

      <!-- Poin-poin -->
      <div class="col-lg-10">
        <div class="row g-2 mb-4">
          <?php foreach ($statistik['utama'] as $s => $key) : ?>
            <!-- <div class="col-md-4"> -->
            <div class="p-3 me-4 border border-dark border-1" style="width:fit-content;">
              <div class="d-inline-flex align-items-center">
                <img src="<?= $key['gambar'] ?>" class="wh-64px me-2">
                <div class="d-flex text-start flex-column justify-content-center">
                  <h2 class="fw-bold"><?= $key['nilai'] ?></h2>
                  <h6 class=""><?= $key['namaStatistik'] ?></h6>
                </div>
              </div>
            </div>
            <!-- </div> -->
          <?php endforeach ?>
        </div>

        <div class="row g-2 mb-4">
          <?php foreach ($statistik['lainnya'] as $s => $key) : ?>
            <!-- <div class="col-md-4"> -->
            <div class="p-3 me-4 border border-dark border-1" style="width: auto;">
              <p class=""><span class="h5 fw-bold"><?= $key['nilai'] ?>
                </span><?= $key['namaStatistik'] ?></p>
            </div>
            <!-- </div> -->
          <?php endforeach ?>
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
        <div class="prestasi-swiper-button-prev"><img src="assets/img/icons8-back-to-96.png" style="width: 48px; height: 48px" /></div>

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
        <div class="prestasi-swiper-button-next"><img src="assets/img/icons8-next-page-96.png" style="width: 48px; height: 48px" /></div>
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

<!-- Section Berita -->
<section id="news" class="fluid section-batik">
  <div class="container p-5">

    <div class="row mb-5 text-center">
      <div class="col">
        <h1 class="fw-bold" data-aos="fade-up">Berita</h1>
        <p class="fs-4" data-aos="fade-up">Akademik, kampus, penelitian, dan lainnya</p>
      </div>
    </div>

    <div class="row g-4 mb-4 justify-content-center" data-aos="fade-up">
      <div class="col-lg-8">
        <div class="row">
          <div class="col">

            <!-- Slider berita -->
            <div class="swiper" id="swiper-berita">
              <!-- Additional required wrapper -->
              <div class="swiper-wrapper">
                <!-- Slides -->
                <?php foreach ($berita as $i => $b) : ?>
                  <div class="swiper-slide">
                    <div class="swiper-slide-transform">
                      <div class="card berita-card text-light">
                        <img src="<?= $b['image'] ?>" class="card-img" alt="Agenda Image">
                        <div class="card-img-overlay d-flex flex-column justify-content-end text-light">
                          <div class="d-flex align-items-center mb-2">
                            <span><?= $b['tgl_terbit'] ?></span>
                          </div>
                          <a href="">
                            <h5 class="card-title text-light"><?= $b['judul'] ?></h5>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
              <!-- If we need pagination -->
              <div class="swiper-pagination"></div>

              <!-- If we need navigation buttons -->
              <!-- <div class="swiper-button-prev"></div>
              <div class="swiper-button-next"></div> -->
            </div>
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

      <!-- Opini -->
      <div class="col-lg-4">
        <div class="row">
          <div class="col">
            <div class="card berita-card text-light">
              <img src="assets/img/riset-dan-publikasi.jpeg" class="card-img" alt="Agenda Image">
              <div class="card-img-overlay d-flex flex-column justify-content-end text-light">
                <div class="d-flex align-items-center mb-2">
                  <span>Opini</span>
                </div>
                <a href="#">
                  <h5 class="card-title text-light">Kenaikan UKT masih harus dipertimbangkan</h5>
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Row tombol lebih banyak opini -->
        <div class="row mt-2 mb-2">
          <div class="col text-center">
            <a class="btn btn-lg btn-outline-body border-3 mb-4 border-start-0 border-end-0 border-top-0 rounded-0 px-0" href="#" data-aos="fade-up">
              <i class="bi bi-newspaper me-2"></i>Lebih banyak opini
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Row berita -->
    <div class="row g-4 mb-4 justify-content-center">

      <!-- Item berita -->
      <div class="col-lg-4 col-xl-15 col-md-6" id="item-berita" data-aos="fade-up">
        <div class="card" data-mdb-ripple-init>

          <!-- Gambar berita -->
          <img src="https://www.uinsaid.ac.id/files/post/cover/persiapan-akreditasi-internasional-uin-surakarta-m-1714970024.JPG" class="card-img-top" alt="...">

          <!-- Konten berita -->
          <div class="card-body">
            <a href="#">
              <p class="card-title">
                Persiapan Akreditasi Internasional, UIN Surakarta Undang Rafiazka Hilman
              </p>
            </a>
          </div>
          <div class="card-footer">
            <p class="card-text fs-6"><small>07 Mei 2024</small></p>
          </div>

        </div>
      </div>

      <!-- Item berita -->
      <div class="col-lg-4 col-xl-15 col-md-6" id="item-berita" data-aos="fade-up">
        <div class="card" data-mdb-ripple-init>

          <!-- Gambar berita -->
          <img src="https://www.uinsaid.ac.id/files/post/cover/jauh-datang-dari-batam-kami-ucapkan-selamat-datang-1715059577.jpg" class="card-img-top" alt="...">

          <!-- Konten berita -->
          <div class="card-body">
            <a href="#">
              <p class="card-title">
                Jauh Datang Dari Batam, Kami Ucapkan Selamat Datang. Kami Sambut Dengan Senyuman
              </p>
            </a>
          </div>
          <div class="card-footer">
            <p class="card-text fs-6"><small>07 Mei 2024</small></p>
          </div>

        </div>
      </div>

      <!-- Item berita -->
      <div class="col-lg-4 col-xl-15 col-md-6" id="item-berita" data-aos="fade-up">
        <div class="card" data-mdb-ripple-init>

          <!-- Gambar berita -->
          <img src="https://www.uinsaid.ac.id/files/post/cover/uin-raden-mas-said-surakarta-raih-wtp-atas-laporan-1715060511.jpg" class="card-img-top" alt="...">

          <!-- Konten berita -->
          <div class="card-body">
            <a href="#">
              <p class="card-title">
                UIN Raden Mas Said Surakarta Raih WTP atas Laporan Keuangan BLU Tahun Laporan 2023 dari Kantor Akuntan Publik
              </p>
            </a>
          </div>
          <div class="card-footer">
            <p class="card-text fs-6"><small>07 Mei 2024</small></p>
          </div>

        </div>
      </div>

      <!-- Item berita -->
      <div class="col-lg-4 col-xl-15 col-md-6" id="item-berita" data-aos="fade-up">
        <div class="card" data-mdb-ripple-init>

          <!-- Gambar berita -->
          <img src="https://www.uinsaid.ac.id/files/post/cover/fab-uin-rm-said-holds-iccl-1716892667.jpg" class="card-img-top" alt="...">

          <!-- Konten berita -->
          <div class="card-body">
            <a href="#">
              <p class="card-title">
                FAB UIN RM Said Holds 2nd ICCL 2024
              </p>
            </a>
          </div>
          <div class="card-footer">
            <p class="card-text fs-6"><small>28 Mei 2024</small></p>
          </div>

        </div>
      </div>

      <!-- Item berita -->
      <div class="col-lg-4 col-xl-15 col-md-6" id="item-berita" data-aos="fade-up">
        <div class="card" data-mdb-ripple-init>

          <!-- Gambar berita -->
          <img src="https://www.uinsaid.ac.id/files/post/cover/optimalkan-blu-uin-rm-said-perkuat-kerjasama-1717059990.jpg" class="card-img-top" alt="...">

          <!-- Konten berita -->
          <div class="card-body">
            <a href="#">
              <p class="card-title">
                Optimalkan BLU, UIN RM Said Perkuat Kerjasama
              </p>
            </a>
          </div>
          <div class="card-footer">
            <p class="card-text fs-6"><small>28 Mei 2024</small></p>
          </div>

        </div>
      </div>

    </div>

    <!-- Pengumuman dan Agenda -->
    <div class="row g-4 mb-4 mt-4 grid" data-aos="fade-up" data-aos-delay="300">
      <div class="col-lg-4 d-flex">
        <div class="card pengumuman-widget flex-fill">
          <div class="card-header d-flex justify-content-center">
            <span class="fw-bold">Pengumuman</span>
          </div>

          <!-- Daftar Pengumuman -->
          <ul class="list-group list-group-flush">
            <!-- Item pengumuman -->
            <li class="list-group-item">
              <div class="d-flex justify-content-between">
                <p class="text-muted"><span class="badge bg-danger">Terkini</span> Admin &bull; 54mnt</p>
              </div>
              <p class="mt-2 line-clamp-4">Wisuda akan dilaksanakan besok Rabu, 12 Juni 2024. Jalan akan ditutup sebagian</p>
            </li>
            <!-- Item pengumuman -->
            <li class="list-group-item">
              <div class="d-flex justify-content-between">
                <span class="text-muted">Admin &bull; 7jam</span>
              </div>
              <p class="mt-2 line-clamp-4">Pengisian KRS akan dimulai pada 17 Agustus 2024 pukul 00.00 WIB</p>
            </li>
            <!-- Item pengumuman -->
            <li class="list-group-item">
              <div class="d-flex justify-content-between">
                <span class="text-muted">Admin &bull; 6jam</span>
              </div>
              <p class="mt-2 line-clamp-4">Menteri Agama akan hadir dan mengisi kuliah umum pada Jumat, 14 Juni 2024</p>
            </li>
          </ul>
        </div>
      </div>

      <!-- Agenda -->
      <div class="col-lg-8 d-flex">
        <div class="card pengumuman-widget flex-fill">
          <div class="card-header d-flex justify-content-center">
            <span class="fw-bold">Agenda</span>
          </div>

          <!-- Konten Agenda -->
          <div class="row">

            <!-- Highlight agenda -->
            <div class="col-lg-6">
              <div class="card agenda-card text-light">
                <img src="assets/img/riset-dan-publikasi.jpeg" class="card-img rounded-0" alt="Agenda Image">
                <div class="card-img-overlay d-flex flex-column justify-content-end rounded-0 text-light">
                  <div class="d-flex align-items-center mb-2">
                    <span>14 Juni 2024</span>
                  </div>
                  <h5 class="card-title">Piala Rektor UIN RM Said Surakarta Tahun 2024</h5>
                </div>
              </div>
            </div>
            <!-- Agenda lainnya -->
            <div class="col-lg-6">
              <!-- Daftar agenda lainnya -->
              <ul class="list-group list-group-flush">
                <!-- Item agenda -->
                <li class="list-group-item">
                  <div>
                    <p class="text-muted mb-1">Admin &bull; 54mnt</p>
                    <div class="d-flex align-items-start">
                      <img src="assets/img/riset-dan-publikasi.jpeg" alt="News Image" class="me-3">
                      <p class="mb-0">Jadwal Pengisian Kartu Rencana Studi (KRS)dan Pengajuan Cuti Kuliah -CEK JADWALNYA-</p>
                    </div>
                  </div>
                </li>
                <!-- Item agenda -->
                <li class="list-group-item">
                  <div>
                    <p class="text-muted mb-1">Admin &bull; 54mnt</p>
                    <div class="d-flex align-items-start">
                      <img src="assets/img/riset-dan-publikasi.jpeg" alt="News Image" class="me-3">
                      <p class="mb-0">Jadwal Pengisian Kartu Rencana Studi (KRS)dan Pengajuan Cuti Kuliah -CEK JADWALNYA-</p>
                    </div>
                  </div>
                </li>
                <!-- Item agenda -->
                <li class="list-group-item">
                  <div>
                    <p class="text-muted mb-1">Admin &bull; 54mnt</p>
                    <div class="d-flex align-items-start">
                      <img src="assets/img/riset-dan-publikasi.jpeg" alt="News Image" class="me-3">
                      <p class="mb-0">Jadwal Pengisian Kartu Rencana Studi (KRS)dan Pengajuan Cuti Kuliah -CEK JADWALNYA-</p>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Section berita -->

<!-- Section Akademik -->
<section class="fluid section-batik gradient-1" id="akademik">
  <div class="container p-5">
    <div class="row d-flex align-items-center g-5">

      <!-- Picture grid column -->
      <div class="col-lg-6">

        <!-- Picture grid -->
        <div class="row g-0">
          <div class="col">
            <img data-aos="fade-up" class="" style="border-radius: 5rem; width: 100%; max-height: 512px;object-fit: contain;" src="assets/img/foto-rektor-wisuda.png" />
          </div>
          <!-- <div class="col">
            <img data-aos="fade-down-right" class="img-section" style="border-top-left-radius: 5rem;" src="https://www.uinsaid.ac.id/files/cover/fakultas-ushuluddin-dan-dakwah-1710927589.jpg" />
          </div>
          <div class="col">
            <img data-aos="fade-down-left" class="img-section" style="border-top-right-radius: 5rem;" src="https://www.uinsaid.ac.id/files/cover/fakultas-ekonomi-dan-bisnis-islam-1710927692.jpg" />
          </div> -->
        </div>
        <!-- <div class="row g-0">
          <div class="col">
            <img data-aos="fade-up-right" class="img-section" style="border-bottom-left-radius: 5rem;" src="https://www.uinsaid.ac.id/files/cover/fakultas-ilmu-tarbiyah-1710927668.png" />
          </div>
          <div class="col">
            <img data-aos="fade-up-left" class="img-section" style="border-bottom-right-radius: 5rem;" src="https://www.uinsaid.ac.id/files/cover/fakultas-adab-dan-bahasa-1710927720.png" />
          </div>
        </div> -->

      </div>

      <!-- Akademik column -->
      <div class="col-lg-6" data-aos="fade-left">
        <h1 class="pb-2 fw-bold border border-primary border-2 border-start-0 border-end-0 border-top-0">
          Akademik
        </h1>
        <p class="lh-lg fst-italic">
          "Niscaya Allah akan meninggikan orang-orang yang beriman di
          antaramu dan orang-orang yang diberi ilmu pengetahuan beberapa
          derajat. Dan Allah Maha Mengetahui apa yang kamu kerjakan."
          <br>
          <span class="fst-normal fw-bold">(QS. Al-Mujadilah : 11)</span>
        </p>
        <button class="btn btn-lg btn-primary color-primary" data-mdb-ripple-init>Selengkapnya</button>
      </div>

    </div>
  </div>
</section>
<!-- Section Akademik -->

<!-- Section Riset -->
<section class="section-batik rev-90">
  <div class="container p-5">
    <div class="row g-5 d-flex align-items-center">

      <!-- Publikasi column -->
      <div class="col-lg-6" data-aos="fade-right">
        <h1 class="pb-2 fw-bold border border-primary border-2 border-start-0 border-end-0 border-top-0">
          Riset dan Publikasi
        </h1>
        <p class="lh-lg">
          Sebagai bagian dari komitmennya sebagai Universitas Islam Unggul dan Inovatif, UIN Raden Mas Said Surakarta menekankan pentingnya penelitian transdisiplin dan publikasi ilmiah sebagai upaya untuk menghasilkan inovasi dalam ilmu pengetahuan dan teknologi.
        </p>
        <button class="btn btn-lg btn-primary" data-mdb-ripple-init>Selengkapnya</button>
      </div>

      <!-- Picture grid column -->
      <div class="col-lg-6">

        <!-- Picture grid -->
        <div class="row">
          <div class="col">
            <img data-aos="fade-down" class="img-section-half" style="border-top-left-radius: 5rem; border-top-right-radius: 5rem;" src="https://www.uinsaid.ac.id/files/upload/tekpang%201.jpg" />
          </div>
        </div>
        <div class="row">
          <div class="col">
            <img data-aos="fade-up" class="img-section-half" style="border-bottom-left-radius: 5rem; border-bottom-right-radius: 5rem;" src="assets/img/riset-dan-publikasi.jpeg" />
          </div>
        </div>

      </div>

    </div>
  </div>
</section>
<!-- Section Riset -->

<!-- Section Poin Riset -->
<section class="fluid d-flex justify-content-center">
  <div class="lurik">
  </div>
  <div class="container p-5">
    <div class="row g-4">

      <!-- Omah jurnal -->
      <div class="col-lg-6" data-aos="fade-right">
        <div class="card d-flex flex-sm-row border border-dark border-1">
          <div class="card-body pe-0">
            <!-- <h5 class="card-title display-5"><i class="bi bi-book text-primary"></i></h5> -->
            <img class="wh-64px" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGAAAABgCAYAAADimHc4AAAACXBIWXMAAAsTAAALEwEAmpwYAAAEgklEQVR4nO1c0Y8TRRxuSEwIGAH/gPPVhLB7ySXeq8/GRGMw8Yk3MRol8Y8wKoR30TdTgoe9nIBi9FZ6BzRdbHsc7fX2wiHmMNzu7LQzmDNBH3TIt6SIreXKXXcH6/clv6TZnZ35fr9v9zezM7PN5QiCIAiCIAiCIAiCIAiCIIhNENT8CS2FaYvor7YIf1dx9JuSQikpftIyWtSxKKtYzCoZFZQUn2kpPtBx9L5qiUPtOH5JCeG2Wq1nbAUabYNDwqUlDoEbOIJrwjkWs/ABvsAnJUVbxeFGW4R3lYj+hO+IgS3+uaDinwCJ7ZqKRUvFUUXJ6LSOow/bcfiGlPJ5Y8yO7XJEHagLdaJutJG0FYvWMLgvV8uf5Gxgaan49HK1/OswnND9hWmrOJrWcfTmnTu3nh2UG8riGlyLOtLkGFT8jeu+n/1THFT8t4Kqn5pjuleMP3Qcfa7U+nP9OOFcUgZlM+KFGAQ1/7ANAapZCqAfWLShZfhiNx8cu38uWz6JABW/mm3wa/5E0rAVAYRRcRh2c1IiXLfBpROHoXfGDdc1/ax5/NiDhm04raUw3un8P8wWj04cmseP9o0XbHgCTL5ggstzFEB2PQGX501jcjJ9AZpH3vu7UT4B5uFYNI+8m74Ay4UpCiD/pQ+o+klsUhfg4Qb5BIieeFAAaWkURAGE1VEQBZAU4H/9HhAwBQkKwCfA5yhIMwWxD2jwRUywE+YoyOVUhOYwlO8BDU7GCb6I8U3Y5XS05lQE54IeC1yQEZyM05wN5ZKk5nS04HoAF+UFF2Q0V8S4LUVzSVJwTZgbswQX5TV3RXBroua2lDz3BXFzruDGLI874+zsSPOYgvh9gGYKyjMF2dqV7DEFMQVppqA8UxBTkM8PNDx+IcNOOOAnSoKfKHEY6mf7idLCxR+S/HuhcNIUZ6YSm5uZMpfOTpvS+TOm/N0586N33tSKs2bxUtEsXSmZlYWKudG4atZWmmb95xumFd629h6AtsEBXMAJ3MARXMEZ3OEDfIFP8K3jJ3xGuwvznp1OuHmlZC5Mn+oJxFZsbmbKlL89lziNANxs1k24dtOoONq2AKgDdaFO1I020BbaHAZ3xACxyFyA0jdfDcUB75HCfGFqxe/N9WsLRq7fHlgAlMU1uBZ1pM2z9PVMtgLU5rzUnfK677TCySTliV/W+gqAcyjTSQ9ZWicVpf9/QUNMPd5WhJg+ZW6trvQcxzHbvBCb1AXIIvV4m9jFs1/2HJs/U7DOC6ko/b8ss2Sv7dplXt65cyA7uHu3db4jJ8Dbe/cOLADK2uY7cgKcGBsbWIBPx8as8x05Aa46jjm8Z8+mwUeZRcexznfkBGhgALB//yNFwDmUsc1zZAVouG5ydyPFIM+jY4a9s29fcuxJvPO3LMCTgrrrHtuy447zkW3+/3mYXG5H3XGOPm7w647zMa61zX9kUHfdV+uOszpA4FevjY+/YpvvSKI6MfFUfXz89Ybj5BuuG9RddwOG3zi2dODAQZSxzZMgCIIgCIIgCIIgCIIgCILIdeEe7QqYtYSfAYcAAAAASUVORK5CYII=">
          </div>
          <div class="card-body flex-grow-1">
            <h5 class="card-title fw-bold">Omah Jurnal</h5>
            <p class="card-text">Akses mudah dan sistem yang terorganisir dengan baik, Omah Jurnal memfasilitasi penelitian dan pertukaran pengetahuan di seluruh fakultas dan departemen.</p>
            <a href="#" class="btn btn-primary" data-mdb-ripple-init>Selengkapnya</a>
          </div>
        </div>
      </div>

      <!-- Repositori jurnal -->
      <div class="col-lg-6" data-aos="fade-left">
        <div class="card d-flex flex-sm-row border border-dark border-1">
          <div class="card-body pe-0">
            <!-- <h5 class="card-title display-5"><i class="bi bi-database-check text-primary"></i></h5> -->
            <img class="wh-64px" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGAAAABgCAYAAADimHc4AAAACXBIWXMAAAsTAAALEwEAmpwYAAADjElEQVR4nO2dTU8TURSGJzHiWqp/QvAXUPZG4sLM9C/UhZmJq/mSpBLX0ENK/OpdsGZTEpd+JGqMJnUn/gEUFqYbS2FVc80MAdvSKUU790znvm9yNuRCO+9zPm5zSGoYEARBEARB0D+odH/5puUE65Yd7Jh22LGcUPaGTyJnUe/4JHb8ap0CEvNsSXPLtq+YTvjEtIPfg6bnG4D4G9V61yexUalszSg333LCt6OM1wIAncYbpRAsO3g6jvkaAZBeVdSU9fzz2o6OAPxqveuuvZhLHUA8cMc0XysAFEEQa6kDMJ3wGwCIhDZU/6oAQHAAACKhCurt1AFcxHztWhAJCQAEABergNoz6X25Ld3OrHQ7Bek1l+KfcRupTQV4zSXpykt9EUPIgJlaAHCjzB8A4B7OshupEYDC2Qo4uMZupNYtyEULUjyEm0vHlYAhrL4C/JzFBJsNAPgAINgzGhVA/KaiBRG/sZgBNB2BIUwAgGtomsLnAIEW5Geg12MGEL/ZGMLEb/j034Jq2IixAvCwEeMF4GIjxg2ggI0YJwAPGzHeCvCxEWMGQPkKI20BgAAAPwOZjgogfrPRgojfcMwAylZgCBMA4BqapnANFWhBfgZ6PWYA8ZuNIUz8hk//LaiGjRgrAA8bMV4ALjZi3AAK2IhxAvCwEeOtAB8bMWYAlK8w0hYACADwM5DpqADiNxstiPgNxwygbAWGMAEArqFpCtdQgRbkZ6DXYwYQv9kYwsRveCZuQfeWV+Sn95vyaH9bytZLrcIa8EI5gMj8g+8NdiOkrgCizOc2QeoMQMe2I7ME4Nw3uWhMJlr8ZgNAi99wVECL33S0oJbOM8AO231DeG9b2xlw+KPRZ77pBL+Uf4XJ5w+b2gL4+G6zvwLsUMFXmNgh9b6ovfJYtncb2gFo7zbiD6EDFbCaOoC7TjBvOmG394XLDx/F2TC0HeUMwNHedvysZ80PuyU7uGGokOWEG+PuBSYFwLrg/yOpj2DdUKVSpTJj2eFrAAhPzH9VLpcvKwNwAsG0g9pgO9KpAsz42YN15eb3ynywPGfZ4Vp0Axj2HWN5A2BGz3j8rKvKev7/6Bxjf8qiUZILxh1ZNPZHneV+jqnVCFO3ZNG4fnquaFyVi8ZzAEgfQJz1iecXhlfDpN+XNhqV9UkaVg2Jh6HRGifrx6mGxEPQaI2b9UmKfjf6G4kHIAiCIMiYTv0BWOCwhSmMNFMAAAAASUVORK5CYII=">
          </div>
          <div class="card-body flex-grow-1">
            <h5 class="card-title fw-bold">Repositori Jurnal</h5>
            <p class="card-text">Repositori Jurnal UIN Raden Mas Said berisi karya-karya akademik dan penelitian dari dosen dan mahasiswa dan dapat diakses secara terbuka dengan mudah.</p>
            <a href="#" class="btn btn-primary" data-mdb-ripple-init>Selengkapnya</a>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
<!-- Section Poin Riset -->

<!-- Section Pengabdian -->
<section class="section-batik rev--90" id="Pengabdian">
  <div class="container p-5">
    <div class="row d-flex align-items-center g-5">

      <!-- Picture grid column -->
      <div class="col-lg-6">

        <!-- Picture grid -->
        <div class="row g-0">
          <div class="col">
            <img data-aos="fade-up" class="img-section" style="border-radius: 5rem;" src="https://www.uinsaid.ac.id/files/cover/fakultas-ushuluddin-dan-dakwah-1710927589.jpg" />
          </div>
        </div>

      </div>

      <!-- Pengabdian column -->
      <div class="col-lg-6" data-aos="fade-left">
        <h1 class="pb-2 fw-bold border border-primary border-2 border-start-0 border-end-0 border-top-0">
          Pengabdian
        </h1>
        <p class="lh-lg">
          Dengan semangat Tri Dharma Perguruan Tinggi, LP2M UIN Raden Mas Said Surakarta berdedikasi untuk memajukan penelitian dan pengabdian kepada masyarakat yang berorientasi pada solusi
        </p>
        <button class="btn btn-lg btn-primary" data-mdb-ripple-init>Selengkapnya</button>
      </div>

    </div>
  </div>
</section>
<!-- Section Pengabdian -->

<!-- Section About -->
<section id="about" class="d-flex z-3 section-batik rev-180">
  <div class="container p-5">
    <div class="row gx-5">
      <div class="col-lg-6"></div>
      <div class="col-lg-6 ps-xxl-5">
        <p class="fs-1 fw-bold" data-aos="fade-left">Tentang Kami</p>
        <p class="fs-4 mb-4 fw-normal" data-aos="fade-left">
          UIN Raden Mas Said Surakarta berkomitmen untuk memberikan pendidikan berkualitas tinggi dan berkontribusi pada masyarakat.
        </p>
        <a class="btn btn-outline-body mb-4" href="<?= base_url('tentang') ?>" data-aos="fade-left" data-mdb-ripple-init>
          Selengkapnya
        </a>
      </div>
    </div>
  </div>
</section>
<!-- Akhir section About -->

<!-- Section Statistik -->
<section id="statistik" class="d-flex section-batik rev-90 p-0">
  <div class="container p-5 gradient-1 rounded-0" style="z-index: 100;">
    <div class="row gx-4 gy-5 justify-content-center">
      <!-- Statistik item -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up">
        <h5 class="text-center"><i class="bi bi-people"></i></h5>
        <h2 class="text-center fw-bold">21.536</h2>
        <p class="text-center mb-0">Mahasiswa aktif</p>
      </div>
      <div class="col-lg-4 col-md-6" data-aos="fade-up">
        <h5 class="text-center"><i class="bi bi-building"></i></h5>
        <h2 class="text-center fw-bold">33</h2>
        <p class="text-center mb-0">Program Studi</p>
      </div>
      <div class="col-lg-4 col-md-6" data-aos="fade-up">
        <h5 class="text-center"><i class="bi bi-building-up"></i></h5>
        <h2 class="text-center fw-bold">9</h2>
        <p class="text-center mb-0">Program Pascasarjana</p>
      </div>
      <div class="col-lg-4 col-md-6" data-aos="fade-up">
        <h5 class="text-center"><i class="bi bi-person-up"></i></h5>
        <h2 class="text-center fw-bold">21</h2>
        <p class="text-center mb-0">Guru Besar</p>
      </div>
      <div class="col-lg-4 col-md-6" data-aos="fade-up">
        <h5 class="text-center"><i class="bi bi-person-badge"></i></h5>
        <h2 class="text-center fw-bold">59</h2>
        <p class="text-center mb-0">Lektor Kepala</p>
      </div>
      <div class="col-lg-4 col-md-6" data-aos="fade-up">
        <h5 class="text-center"><i class="bi bi-file-person"></i></h5>
        <h2 class="text-center fw-bold">224</h2>
        <p class="text-center mb-0">Lektor</p>
      </div>
      <div class="col-lg-4 col-md-6" data-aos="fade-up">
        <h5 class="text-center"><i class="bi bi-person"></i></h5>
        <h2 class="text-center fw-bold">54</h2>
        <p class="text-center mb-0">Asisten Ahli</p>
      </div>
      <div class="col-lg-4 col-md-6" data-aos="fade-up">
        <h5 class="text-center"><i class="bi bi-person"></i></h5>
        <h2 class="text-center fw-bold">371</h2>
        <p class="text-center mb-0">Staff Pengajar</p>
      </div>
      <div class="col-lg-4 col-md-6" data-aos="fade-up">
        <h5 class="text-center"><i class="bi bi-person"></i></h5>
        <h2 class="text-center fw-bold">245</h2>
        <p class="text-center mb-0">Staff Administrasi</p>
      </div>
    </div>
  </div>
</section>
<!-- Akhir Section Statistik -->

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
        <img src="assets/img/LOGO BLU_SPEEDCIRCLE.png" style="width: 128px;height: 100%;object-fit: scale-down;" />
      </div>
      <div class="col-xl-2 col-lg-3 col-md-4 d-flex justify-content-center">
        <img src="https://th.bing.com/th/id/OIP.fineWnFIFMDVRCzgORCDFQHaHa?pid=ImgDetMain" style="width: 128px;height: 100%;object-fit: scale-down;" />
      </div>
      <div class="col-xl-2 col-lg-3 col-md-4 d-flex justify-content-center">
        <img src="https://iconlogovector.com/uploads/images/2023/05/lg-7a359c6dfcb72ca61d94df92ac78afdf98.jpg" style="width: 128px;height: 100%;object-fit: scale-down;" />
      </div>
      <div class="col-xl-2 col-lg-3 col-md-4 d-flex justify-content-center">
        <img src="https://logosmarcas.net/wp-content/uploads/2020/09/SpaceX-Simbolo.jpg" style="width: 128px;height: 100%;object-fit: scale-down;" />
      </div>
      <div class="col-xl-2 col-lg-3 col-md-4 d-flex justify-content-center">
        <img src="https://th.bing.com/th/id/OIP.arezqGrVeKUAmuKTaXGGEgHaEK?pid=ImgDetMain" style="width: 128px;height: 100%;object-fit: scale-down;" />
      </div>
    </div>

  </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script type="text/javascript" src="<?= base_url("assets/js/beranda.js") ?>"></script>
<?= $this->endSection() ?>