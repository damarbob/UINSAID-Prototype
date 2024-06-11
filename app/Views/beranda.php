<?= $this->extend('layout/frontend_template') ?>

<?php helper('text'); ?>
<?= $this->section('content') ?>
<!-- Section Hero -->
<section id="hero" class="p-0 d-flex align-items-center justify-content-center">

  <iframe id="player" class="m-0" src="https://www.youtube.com/embed/nd8aKZ8dvko?enablejsapi=1&version=3&controls=0&rel=0&autoplay=1&loop=1&mute=1&playlist=nd8aKZ8dvko&playsinline=1" title="YouTube video player" frameborder="0" referrerpolicy="strict-origin-when-cross-origin" allow="autoplay" allowfullscreen></iframe>

  <div id="overlayHero" class="collapse show">

    <!-- Overlay -->
    <div class="overlay"></div>

    <!-- Konten Hero -->
    <!-- <div class="container z-3 text-center text-light">
      <div class="row">
        <div class="col">

          <img data-aos="zoom-in-up" class="mb-2" src="../img/icon-notext-small-white.png" />
          <h1 data-aos="zoom-in-down" data-aos-delay="100" class="fw-bold">UIN Raden Mas Said</h1>
          <p data-aos="zoom-in-down" data-aos-delay="200" class="lh-lg mb-4 fst-italic">
            Dengan sejarahnya yang kaya dan potensinya yang melimpah, <br>
            UIN Raden Mas Said Surakarta siap melangkah ke masa depan yang lebih cerah <br>
          </p>

          <button id="btnSimakVideo" data-aos="zoom-in-down" data-aos-delay="500" class="btn btn-secondary btn-lg" data-mdb-collapse-init data-mdb-target="#overlayHero" aria-controls="overlayHero" aria-expanded="true" aria-label="Simak Video" mdb-ripple-init>
            <i class="bi bi-film me-3"></i>
            Simak Video
          </button>

        </div>
      </div>
    </div> -->

  </div>

</section>
<!-- End section Hero -->

<!-- Section Akademik -->
<section class="fluid section-batik" id="akademik">
  <div class="container p-5">
    <div class="row d-flex align-items-center g-5">

      <!-- Picture grid column -->
      <div class="col-lg-6">

        <!-- Picture grid -->
        <div class="row g-0">
          <div class="col">
            <img data-aos="fade-up" class="img-section" style="border-radius: 5rem;width: 100%;height: 512px;object-fit: cover;" src="img/foto-rektor-wisuda.png" />
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
          <br />
          <span class="fst-normal">(QS. Al-Mujadilah : 11)</span>
        </p>
        <button class="btn btn-lg btn-primary color-primary" data-mdb-ripple-init>Selengkapnya</button>
      </div>

    </div>
  </div>
</section>
<!-- Section Akademik -->

<!-- Section Poin Akademik -->
<section class="fluid">
  <div class="lurik">
  </div>
  <div class="container p-5">
    <div class="row g-4">

      <!-- Fakultas -->
      <div class="col-lg-6" data-aos="fade-right">
        <div class="card d-flex flex-row border border-dark border-1">
          <div class="card-body pe-0">
            <h5 class="card-title display-5"><i class="bi bi-buildings text-primary"></i></h5>
          </div>
          <div class="card-body flex-grow-1">
            <h5 class="card-title fw-bold">Fakultas</h5>
            <p class="card-text">Setiap fakultas menawarkan lingkungan akademik yang dinamis, staf pengajar berkualitas dan mahasiswa berkolaborasi dalam proses pembelajaran dan penelitian.</p>
            <a href="#" class="btn btn-primary" data-mdb-ripple-init>Selengkapnya</a>
          </div>
        </div>
      </div>

      <!-- Registrasi -->
      <div class="col-lg-6" data-aos="fade-left">
        <div class="card d-flex flex-row border border-dark border-1">
          <div class="card-body pe-0">
            <h5 class="card-title display-5"><i class="bi bi-person-check text-primary"></i></h5>
          </div>
          <div class="card-body flex-grow-1">
            <h5 class="card-title fw-bold">Registrasi</h5>
            <p class="card-text">UIN Raden Mas Said menyediakan panduan lengkap dan dukungan penuh bagi mahasiswa baru dalam proses pendaftaran, pembayaran, dan orientasi akademik.</p>
            <a href="#" class="btn btn-primary" data-mdb-ripple-init>Selengkapnya</a>
          </div>
        </div>
      </div>

      <!-- Beasiswa -->
      <div class="col-lg-6" data-aos="fade-right">
        <div class="card d-flex flex-row border border-dark border-1">
          <div class="card-body pe-0">
            <h5 class="card-title display-5"><i class="bi bi-mortarboard text-primary"></i></h5>
          </div>
          <div class="card-body flex-grow-1">
            <h5 class="card-title fw-bold">Beasiswa</h5>
            <p class="card-text">UIN Raden Mas Said Surakarta mempersembahkan beragam kesempatan beasiswa bagi mahasiswa yang berprestasi dan berkebutuhan finansial.</p>
            <a href="#" class="btn btn-primary" data-mdb-ripple-init>Selengkapnya</a>
          </div>
        </div>
      </div>

      <!-- Layanan -->
      <div class="col-lg-6" data-aos="fade-left">
        <div class="card d-flex flex-row border border-dark border-1">
          <div class="card-body pe-0">
            <h5 class="card-title display-5"><i class="bi bi-journals text-primary"></i></h5>
          </div>
          <div class="card-body flex-grow-1">
            <h5 class="card-title fw-bold">Layanan</h5>
            <p class="card-text">UIN Raden Mas Said Surakarta mengutamakan pelayanan terbaik bagi seluruh komunitas akademik, dari layanan akademik hingga dukungan kesejahteraan mahasiswa</p>
            <a href="#" class="btn btn-primary" data-mdb-ripple-init>Selengkapnya</a>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
<!-- Section Poin Akademik -->

<!-- Section Riset -->
<section class="fluid section-batik rev-90">
  <div class="container px-5 pb-5">
    <div class="row g-5 d-flex align-items-center">

      <!-- Publikasi column -->
      <div class="col-lg-6" data-aos="fade-right">
        <h1 class="pb-2 fw-bold border border-primary border-2 border-start-0 border-end-0 border-top-0">
          Riset dan publikasi
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
            <img data-aos="fade-down" class="img-section" style="border-top-left-radius: 5rem; border-top-right-radius: 5rem;" src="https://www.uinsaid.ac.id/files/upload/tekpang%201.jpg" />
          </div>
        </div>
        <div class="row">
          <div class="col">
            <img data-aos="fade-up" class="img-section" style="border-bottom-left-radius: 5rem; border-bottom-right-radius: 5rem;" src="img/riset-dan-publikasi.jpeg" />
          </div>
        </div>

      </div>

    </div>
  </div>
</section>
<!-- Section Riset -->

<!-- Section Poin Riset -->
<section class="fluid">
  <div class="lurik">
  </div>
  <div class="container p-5">
    <div class="row g-4">

      <!-- Omah jurnal -->
      <div class="col-lg-6" data-aos="fade-right">
        <div class="card d-flex flex-row border border-dark border-1">
          <div class="card-body pe-0">
            <h5 class="card-title display-5"><i class="bi bi-book text-primary"></i></h5>
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
        <div class="card d-flex flex-row border border-dark border-1">
          <div class="card-body pe-0">
            <h5 class="card-title display-5"><i class="bi bi-database-check text-primary"></i></h5>
          </div>
          <div class="card-body flex-grow-1">
            <h5 class="card-title fw-bold">Repositori Jurnal</h5>
            <p class="card-text">Repositori Jurnal berisi karya-karya akademik dan penelitian dari dosen dan mahasiswa dan dapat diakses secara terbuka dengan mudah.</p>
            <a href="#" class="btn btn-primary" data-mdb-ripple-init>Selengkapnya</a>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
<!-- Section Poin Riset -->

<!-- Section Pengabdian -->
<section class="fluid section-batik rev--90" id="Pengabdian">
  <div class="container p-5">
    <div class="row d-flex align-items-center g-5">

      <!-- Picture grid column -->
      <div class="col-lg-6">

        <!-- Picture grid -->
        <div class="row g-0">
          <div class="col">
            <img data-aos="fade-up" class="img-section" style="border-radius: 5rem;width: 100%;height: 512px;object-fit: cover;" src="https://www.uinsaid.ac.id/files/cover/fakultas-ushuluddin-dan-dakwah-1710927589.jpg" />
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
        <button class="btn btn-lg btn-primary">Selengkapnya</button>
      </div>

    </div>
  </div>
</section>
<!-- Section Pengabdian -->

<!-- Kegiatan -->
<section id="section-kegiatan" class="d-flex align-items-center">
  <div class="section-slideshow"></div>

  <div class="container position-relative">

    <!-- Swiper kegiatan -->
    <div class="row mb-4">
      <div class="swiper" id="swiper-kegiatan">
        <div class="swiper-wrapper">

          <!-- Swiper kegiatan terbaru -->
          <?php foreach ($kegiatanTerbaru as $i => $a) : ?>
            <div class="swiper-slide d-flex align-items-center">
              <div class="container">
                <div class="row">

                  <!-- Gambar kegiatan -->
                  <div class="col-md-6 position-relative" style="height: 256px;">

                  </div>

                  <!-- Body kegiatan -->
                  <div class="col-md-6">
                    <div class="card-body p-md-5">

                      <!-- Kategori -->
                      <p class="text-primary fs-5 mb-3"><b><?php echo $a['kategori']; ?></b></p>


                      <!-- Judul -->
                      <h3 class="card-title fs-2 mb-3">
                        <a class="link-dark text-decoration-none crop-text-2" href="rilis-media/<?= $a['slug']; ?>"><?= $a['judul']; ?></a>
                      </h3>

                      <!-- Tanggal -->
                      <p class="card-text crop-text-2 mb-3">
                        <b><?= $a['tgl_terbit_terformat']; ?></b>
                      </p>

                      <!-- Ringkasan -->
                      <p class="card-text fs-5 crop-text-4 mb-3">
                        <?= word_limiter($a['meta_description'], 50); ?>
                      </p>

                    </div>

                  </div>
                  <!-- Akhir body kegiatan -->

                </div>
              </div>
            </div>
          <?php endforeach; ?>
          <!-- Akhir swiper kegiatan terbaru -->
        </div>

        <div class="swiper-pagination"></div>

      </div>

    </div>
    <script>
      var daftarKegiatan = <?= json_encode($kegiatanTerbaru) ?>;
    </script>
    <!-- Akhir swiper kegiatan -->



  </div>

  <!-- <div class="container align-self-end">
		<a class="btn btn-danger rounded-4" href="/rilis-media" role="button">Lihat Semua
			Kegiatan
			<span class="ps-1 bi-arrow-right"></span></a>
	</div> -->

</section>
<!-- End Kegiatan Section -->

<!-- Section Berita -->
<section id="news" class="fluid section-batik">
  <div class="container p-5">

    <div class="row mb-5 text-center">
      <div class="col">
        <h1 class="fw-bold">Berita</h1>
        <p class="fs-4">Akademik, kampus, penelitian, dan lainnya</p>
      </div>
    </div>

    <!-- Row berita -->
    <div class="row g-4 mb-4">

      <!-- Item berita -->
      <div class="col-lg-6 col-xl-15" data-aos="fade-up">
        <div class="card" data-mdb-ripple-init>

          <!-- Gambar berita -->
          <img src="https://www.uinsaid.ac.id/files/post/cover/persiapan-akreditasi-internasional-uin-surakarta-m-1714970024.JPG" class="card-img-top" alt="...">

          <!-- Konten berita -->
          <div class="card-body">
            <p class="card-title">
              Persiapan Akreditasi Internasional, UIN Surakarta Undang Rafiazka Hilman
            </p>
          </div>
          <div class="card-footer">
            <p class="card-text fs-6"><small>07 Mei 2024</small></p>
          </div>

        </div>
      </div>

      <!-- Item berita -->
      <div class="col-lg-6 col-xl-15" data-aos="fade-up">
        <div class="card" data-mdb-ripple-init>

          <!-- Gambar berita -->
          <img src="https://www.uinsaid.ac.id/files/post/cover/jauh-datang-dari-batam-kami-ucapkan-selamat-datang-1715059577.jpg" class="card-img-top" alt="...">

          <!-- Konten berita -->
          <div class="card-body">
            <p class="card-title">
              Jauh Datang Dari Batam, Kami Ucapkan Selamat Datang. Kami Sambut Dengan Senyuman
            </p>
          </div>
          <div class="card-footer">
            <p class="card-text fs-6"><small>07 Mei 2024</small></p>
          </div>

        </div>
      </div>

      <!-- Item berita -->
      <div class="col-lg-6 col-xl-15" data-aos="fade-up">
        <div class="card" data-mdb-ripple-init>

          <!-- Gambar berita -->
          <img src="https://www.uinsaid.ac.id/files/post/cover/uin-raden-mas-said-surakarta-raih-wtp-atas-laporan-1715060511.jpg" class="card-img-top" alt="...">

          <!-- Konten berita -->
          <div class="card-body">
            <p class="card-title">
              UIN Raden Mas Said Surakarta Raih WTP atas Laporan Keuangan BLU Tahun Laporan 2023 dari Kantor Akuntan Publik
            </p>
          </div>
          <div class="card-footer">
            <p class="card-text fs-6"><small>07 Mei 2024</small></p>
          </div>

        </div>
      </div>

      <!-- Item berita -->
      <div class="col-lg-6 col-xl-15" data-aos="fade-up">
        <div class="card" data-mdb-ripple-init>

          <!-- Gambar berita -->
          <img src="https://www.uinsaid.ac.id/files/post/cover/fab-uin-rm-said-holds-iccl-1716892667.jpg" class="card-img-top" alt="...">

          <!-- Konten berita -->
          <div class="card-body">
            <p class="card-title">
              FAB UIN RM Said Holds 2nd ICCL 2024
            </p>
          </div>
          <div class="card-footer">
            <p class="card-text fs-6"><small>28 Mei 2024</small></p>
          </div>

        </div>
      </div>

      <!-- Item berita -->
      <div class="col-lg-6 col-xl-15" data-aos="fade-up">
        <div class="card" data-mdb-ripple-init>

          <!-- Gambar berita -->
          <img src="https://www.uinsaid.ac.id/files/post/cover/optimalkan-blu-uin-rm-said-perkuat-kerjasama-1717059990.jpg" class="card-img-top" alt="...">

          <!-- Konten berita -->
          <div class="card-body">
            <p class="card-title">
              Optimalkan BLU, UIN RM Said Perkuat Kerjasama
            </p>
          </div>
          <div class="card-footer">
            <p class="card-text fs-6"><small>28 Mei 2024</small></p>
          </div>

        </div>
      </div>

    </div>

    <!-- Row tombol lebih banyak berita -->
    <div class="row">
      <div class="col text-center">
        <a class="btn btn-lg btn-outline-dark border-3 mb-4 border-start-0 border-end-0 border-top-0 px-0" href="#" data-aos="fade-up" data-aos-delay="400">
          <i class="bi bi-newspaper me-2"></i>Lebih banyak berita
        </a>
      </div>
    </div>

  </div>
</section>
<!-- Section berita -->

<!-- Section About -->
<section id="about" class="d-flex z-3 section-batik rev-180">
  <div class="container p-5">
    <div class="row gx-5">
      <div class="col-lg-6"></div>
      <div class="col-lg-6 ps-xxl-5">
        <p class="fs-1 fw-bold" data-aos="fade-left">Tentang kami</p>
        <p class="fs-4 mb-4 fw-normal" data-aos="fade-left">
          UIN Raden Mas Said Surakarta berkomitmen untuk memberikan pendidikan berkualitas tinggi dan berkontribusi pada masyarakat.
        </p>
        <a class="btn btn-outline-dark mb-4" href="<?= base_url('tentang') ?>" data-aos="fade-left" data-mdb-ripple-init>
          Selengkapnya
        </a>
      </div>
    </div>
  </div>
</section>
<!-- Akhir section About -->

<!-- Section Statistik -->
<section id="statistik" class="d-flex  section-batik rev-90">
  <div class="container p-5 bg-primary" style="z-index: 100;">
    <div class="row gx-4 gy-5">
      <!-- Statistik item -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up">
        <h5 class="text-center"><i class="bi bi-people text-white"></i></h5>
        <h2 class="text-center text-white fw-bold">21536</h2>
        <p class="text-center text-white mb-0">Mahasiswa aktif</p>
      </div>
      <div class="col-lg-4 col-md-6" data-aos="fade-up">
        <h5 class="text-center"><i class="bi bi-building text-white"></i></h5>
        <h2 class="text-center text-white fw-bold">33</h2>
        <p class="text-center text-white mb-0">Program Studi</p>
      </div>
      <div class="col-lg-4 col-md-6" data-aos="fade-up">
        <h5 class="text-center"><i class="bi bi-building-up text-white"></i></h5>
        <h2 class="text-center text-white fw-bold">9</h2>
        <p class="text-center text-white mb-0">Program Pascasarjana</p>
      </div>
      <div class="col-lg-4 col-md-6" data-aos="fade-up">
        <h5 class="text-center"><i class="bi bi-person-up text-white"></i></h5>
        <h2 class="text-center text-white fw-bold">21</h2>
        <p class="text-center text-white mb-0">Guru Besar</p>
      </div>
      <div class="col-lg-4 col-md-6" data-aos="fade-up">
        <h5 class="text-center"><i class="bi bi-person-badge text-white"></i></h5>
        <h2 class="text-center text-white fw-bold">59</h2>
        <p class="text-center text-white mb-0">Lektor Kepala</p>
      </div>
      <div class="col-lg-4 col-md-6" data-aos="fade-up">
        <h5 class="text-center"><i class="bi bi-file-person text-white"></i></h5>
        <h2 class="text-center text-white fw-bold">224</h2>
        <p class="text-center text-white mb-0">Lektor</p>
      </div>
      <div class="col-lg-4 col-md-6" data-aos="fade-up">
        <h5 class="text-center"><i class="bi bi-person text-white"></i></h5>
        <h2 class="text-center text-white fw-bold">54</h2>
        <p class="text-center text-white mb-0">Asisten Ahli</p>
      </div>
      <div class="col-lg-4 col-md-6" data-aos="fade-up">
        <h5 class="text-center"><i class="bi bi-person text-white"></i></h5>
        <h2 class="text-center text-white fw-bold">371</h2>
        <p class="text-center text-white mb-0">Staff Pengajar</p>
      </div>
      <div class="col-lg-4 col-md-6" data-aos="fade-up">
        <h5 class="text-center"><i class="bi bi-person text-white"></i></h5>
        <h2 class="text-center text-white fw-bold">245</h2>
        <p class="text-center text-white mb-0">Staff Administrasi</p>
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
    <div class="row gx-4 gy-5 align-items-center align-self-center" data-aos="fade-up">
      <div class="col-xl-2 col-lg-3 col-md-4 d-flex justify-content-center">
        <img src="../img/LOGO BLU_SPEEDCIRCLE.png" style="width: 128px;height: 100%;object-fit: scale-down;" />
      </div>
      <div class="col-xl-2 col-lg-3 col-md-4 d-flex justify-content-center">
        <img src="https://pertamina.com/Media/Image/Pertamina.png" style="width: 128px;height: 100%;object-fit: scale-down;" />
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