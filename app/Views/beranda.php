<?php helper('text'); ?>

<?= $this->extend('layout/frontend_template') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="css/style-beranda.css" type="text/css" />
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

                <!-- Body hero -->
                <div class="col-md-6 mb-3 order-2 order-md-1">
                  <div class="card-body p-md-5 p-sm-4 p-3 text-center text-md-start">

                    <!-- Judul -->
                    <h3 class="fs-2 mb-3">
                      <?= $a['judul']; ?>
                    </h3>

                    <!-- Ringkasan -->
                    <div class="">
                      <p class="fs-5 mb-3">
                        <?= word_limiter($a['meta_description'], 50); ?>
                      </p>
                    </div>

                    <a href="#" class="btn btn-outline-light" data-mdb-ripple-init="">
                      Lebih banyak
                    </a>

                  </div>

                </div>
                <!-- Akhir body kegiatan -->

              </div>
            </div>
          </div>
        <?php endforeach; ?>
        <!-- Akhir swiper kegiatan terbaru -->
      </div>

      <div class="swiper-pagination mb-4"></div>

    </div>

    <!-- </div> -->
    <script>
      var daftarHero = <?= json_encode($heroTerbaru) ?>;
    </script>
    <!-- Akhir swiper kegiatan -->



  </div>
  <!-- Akhir swiper hero -->

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
            <img data-aos="fade-up" class="" style="border-radius: 5rem; width: 100%; max-height: 512px;object-fit: contain;" src="img/foto-rektor-wisuda.png" />
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

<!-- Section Poin Akademik -->
<section class="fluid">
  <div class="lurik-silk">
  </div>
  <div class="container p-5">
    <div class="row g-4">

      <!-- Fakultas -->
      <div class="col-lg-6" data-aos="fade-right">
        <div class="card d-flex flex-sm-row border border-dark border-1">
          <div class="card-body pe-0">
            <!-- <h5 class="card-title display-5"><i class="bi bi-buildings text-primary"></i></h5> -->
            <img class="wh-64px" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGAAAABgCAYAAADimHc4AAAACXBIWXMAAAsTAAALEwEAmpwYAAAExklEQVR4nO2dz28bRRTHVwiJC0hwAi78+AcqBIeKH1I4ABforT841CmqEbeaW39wwCkIJU0doFXTxKqb2DuzsXdClR9FAWcn+EAoTuixadUDtFXLEdoiCALUDJotkYid/ZGsvbPOfD/Sk6Ik8zzzvjvvPW9mHcMAAAAAAAAAAAAAACDBZLPZB3jF2sEZueAwctFhZnetVntQ9by2PPOThUc4I+9zRm9wRsUas8mP3LYO1SZGH1U9zy1HlZnPOoz0OTa93RT4ZrvLGTnhsNJTqufd8XzDrBccRkzHJv+ECHyj3eM2Oe8w60XV6+jI/O4wMu8X4C+Lw6L8eZ9r8mvOiOfvok6EzO8Os97jjF71DLxNxPTZIWF9+oko9WXXmPzeVGFQOLa3EJzRn1AnGvjqHHnSsUmPw8ivnldwxRSTZ04Jmvu4KfCNRo9/JCbyJ8VsxfTeETb9TdaJuS/o04au8Ap53s3vjP7tFahqueQGk/QfDQx8o5n9R8W505+J6lgxsE7MjZsvGZr1745ffv/aGnGDZx7r2XDgm+xYjxg/NeD69HvNLV0naow97OZ3m1zxC8KMeUbYJ/ujB93DpO8ZsxDUPW2dOlFjo0/I/M4Z+SW4o+ltW+AbLVTn1Ml1osroc5yRvMPon4EdzUBzRxOXydeWxT2gc3LrRLVCXzaSnt+divWanKzf1T67gY6mFJOF6ZwSWydmZk48JCflMLrkN/koHU0pJiPhOicpxDVZJ761rMeUBZ6PjT3u9u8V805sHU1fTBayc5qtmMuyTtTK5WfiC/z42Lb7+Z0sq+xoSjFZyM5p9b7TK+0XwH8i2psBAajSiwACMAigdRoy4iaXSa8MZNJCR8tl0iuxBxwCpNeIoDr+Ru5A+pa2O+BA+prq+Bu5zLtvDWT239Qv+Ptv5DLp142kIP+itWqc0d893jmK1Kvb1zUeosDJm2Ze4zfiJ+o8lBTbIKIGkIdceCsEaMU8jKTBGfk5aNKTZ4c8Fz41Iu/P+4+fGvEevxE/E4VBn/FDwQIyoj73N3L/KAm95Re8w927PBd+eN9uMe2zePmzQ6ndgQIc6d7jK4K8CA7u3ek9j+5dYnp0+J7P7rkub7sbSeXKxbpYz4ICl/rPoo5viZ+u7Xe9xhtJBwIoBgJ0uACXf/i+JSkokh+dU9BlCAABUtgBdaQgpKC6pjVg8UJrinAUP1qnoEUIAAG6sAMEUpCiFLTUovcBkfzovAOWIAAESGEH1JGCkILqmtaAxda8D4jkR+sUtAgBIEAXdoBAClKVgha+a00NiOJH6x2wAAEgQBd2gEAKQgoSWtaASwvzLSnCkfzonIIuQYDNMTdO3lj34yRXD9cW8+4BXK/AH9y7U0wWTvucjB52D94GCXhk3x4xPZrftJ8P3nlbTI3kV7wP59KbDiNvGknDL/hhjpdPFAYDj4XLE9JBAvgF//8ieI0/H2K8PAVuJI2wDzZ4LXy2XIo0ftWiziPMWMcm6p+O1FkAnqQnZIq92WXVH6hRUmTF3g/V7wQIoBgIoBgIoBgIoBgIEDNh2zRdzYhBAM9naGG0/QJs8p8paGNGu+GM/KV6kVxnAXw/jhgm2i4At+kfCDRVtwMAAAAAAAAAAAAAgNGp/AsQg9AyBKdKRQAAAABJRU5ErkJggg==">
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
        <div class="card d-flex flex-sm-row border border-dark border-1">
          <div class="card-body pe-0">
            <!-- <h5 class="card-title display-5"><i class="bi bi-person-check text-primary"></i></h5> -->
            <img class="wh-64px" src="data:image/png;base64,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">
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
        <div class="card d-flex flex-sm-row border border-dark border-1">
          <div class="card-body pe-0">
            <!-- <h5 class="card-title display-5"><i class="bi bi-mortarboard text-primary"></i></h5> -->
            <img class="wh-64px" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGAAAABgCAYAAADimHc4AAAACXBIWXMAAAsTAAALEwEAmpwYAAAHPUlEQVR4nO1aa2wURRxfUJBHYiLGxJjoBzUaNfrBo7sFChVoZ44+Zq6UA1ootECvVui7ZaflcVillEdvtzxE2C0k+MU0fpJYjY/4xURiiPELicYgRIUEFRSQRAEZM9vW1Lb32tu7ubudX/JLmnK3O/P7df7zn98gSQICAgICAgICAgICAgICAgICAgICAgICkeAfHLwvGAxOjfghAWcRDAanqiGzmOjGENHM2xZ1Y4j9TpiRRARPnpyhagPrVM04R3STTkZVN79XdbOpbf+p2ckci6vQfvjko6pm7FI147dwwk8wQjOuq7rZr+rHnuA9/oxFV+jEy6pmnBouMbEJP8mK+EfVzNOdIWMB7/lkUH03SolufGJX9LDUzLOshAWDwft5zzPtEOx/50FWu1XNuOi48BNXxWVW0lr6jDmS20FCA08S3ehVdeP3ZAs/cZ8wbxLNPLZVM56T3AZVH8gjujlINONuqoWfbJ9gJY+VPonSKVK2IhgcnE5006/qxhneopOw+4TxDek3Ai19gzOlbEFn/8AjRDNVopk/cRdYj5lXWGnsOGQ+JmUqyIHjz1i9uGbeSgNBqb3yZPzNWmG178SLUkaA0ikkNFDAem+iGfd4C0gcNcP8gpVQlj9JmRgTZAvVdIo77MQE2UKVZ9zhREyQLVRTFXckNSbQs4TJiDtGYwKiGxe4T1DPDDoSd/CMCUiW0FbckU4xAZmEtdt66CK0kuYuK6MF/iqKajbTygZCa7t206aeg+w0m35GRIs7MiIm0IeZV+qnCsRhOb+onBasXE99G7fQysZOGti+hzb3HuI+7rBxR6duLmU1i/vA9Ni4CK2OaEA4Ligup4Wrq2nZpka6tmUbDezopa17j/DdJ0LHl0ipyOCdZGBbT9RVEA/Zs2DFBrq8tolWtW6nr+7cS9v3H02NCZr5g0R08ypvUYkNtvYepnU79tC1zV20rLaBgtU1dH7RcseMWVCywnomezZ7B3tX2763nJ7Hr9JWzahTdfMOb0FJhhjDGgBv5SZaHmim61p30vrgPtpx4Fj8f/26eadTM2vd0XJqBm3ardONnW/QigaVoup6q4NinZQTpuRCTPPLKmjxujq6sr6d1qjdtJl1ZPG2pq47dGlJNMbrs1ahrcOZ62MHzRlj2D6ScDwhgjczoT1Gcgpujp5JjKWshnTfSpoBbrx8ITYuaZJugBuuH0kC15SpM2DcBTw73nf0xd8PkwyjGjpOqzt20XAX9VwMGH0xO9b769toS+9h7kIRh8lOwZWNhC7EqyIKy9WAUc7zltHS9fX0tV37uQtHEuSW7pDV7cxb9v9OJ60NGEvWpm0g3WmZ05MwVHXTajWLqgLWgSqe9jLtDBjlK2UV1hJuS1HSSGyQZTos31lcvibqISvjDPjvdFi8gpbXtdDmPZNnJTzYsvcIXbW5wzq5xjqPjDVgbIBVVBWwljov4Te/3kfxhi00N0yZyWoDxrLAv364tQsZKanvm7p6rNuxRMacVQYoI1yIVlmlIAkXH7T9wFHrKjLfZ+9K0xUGKCOcV7TcKg0Nb2oJC9/U02/tOeyy3skxZqABKP6Jen3W7RMrGfG2seymip1FwrWRLjQgMS4uq6TR4o7RmGBJeVVSx+JKA5QRsriD7RONu3VrVaiaYf3Mfufk/5YQBsDoIrAbKqfudYUBMPUiCgMgfyHFCoD8xRQlCGYeXdsFKWnCNDQA/cFbFCVFlAG+ln4GAPSpawyA+OO0MyDHi8rcY0ApTjsDGGSI3st+8dG7kTTgakCu3z9TBuhz3iIpyeNnbI7h5j8X4MfHf2cuRM+m1ASv1/uADJCRBmJRRwnQ28/7/dMjiS9DdHXCigH4Gvs3KdXIAb4SGaCL3IWDiVEG6ILixUUJlV+AByUesFZDIWqRIb6UecLjnxWImtgcYpmrDPCNCAZcl3iCLd1cgNYoAH2kQHSbt7hKWKLbMsQf5gBc6fEEpsUzRxmgm+ENQHwNGItc4J+jAFQjA/SBDPBfvEUfHgM6rUBcnVdc/JC9OZU+rUAcwQB8Y77X95SUbvB4AtNyYOkLCvAFFIBOKQCfUyC+l1TRAbpsCQ6wqnh9eZG6mljwUmHhbAWg76K/F3/rKSmZJaU7cpb6HlaAz6MAXK5A1CpDdFCG6H0Z4jMywF8rEJ1newrrLmSA7g4TXxveZ9B56zMAfzn8HXSQPcN6FvB52OpzerwyxFvjWG3tTr/f9VAgOhv76sNfuV4wp6FA/GfMKwCim44PwO2QIboShwFXeI836yBDNBSHAUO8x5t1kCGuinkP8Jau5T3erIOnpGRWLGWIfSYj2tBMBItbYmhBm3mPM2uRn58/Q4Hox/B//fhSogc+gSiQIa4L3//7AtG+L+BArDISpYw/fJ2LN9gTsAkZ4oXjsqx7MkCL7T5PwAZkiE+MMWDAzjMEEgwTZYB+YWQ/J/IsAZuQvcjPaPf7AgICAgKSK/Avg963EGyKkekAAAAASUVORK5CYII=">
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
        <div class="card d-flex flex-sm-row border border-dark border-1">
          <div class="card-body pe-0">
            <!-- <h5 class="card-title display-5"><i class="bi bi-journals text-primary"></i></h5> -->
            <img class="wh-64px" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGAAAABgCAYAAADimHc4AAAACXBIWXMAAAsTAAALEwEAmpwYAAAA5klEQVR4nO3YsY0DMRADwCuVjbiCL9pugHDyTiTOAIoFkGCyzwMAAAAAwBd5/b3/81b/+ZnbgokCOgWMBBML6BQwEkwsoFPASDCxgE4BI8HEAjoFjAQTC+gUMBJMLKBTwEgwOW0BAAAAsOW2E0FOO0XcFkwU0ClgJJhYQKeAkWBiAZ0CRoKJBXQKGAkmFtApYCSYWECngJFgYgGdAkaCyWkLAAAAgC23nQhy2initmCigE4BI8HEAjoFjAQTC+gUMBJMLKBTwEgwsYBOASPBxAI6BYwEEwvoFDASTE5bAAAAAADAc5IPN1egPCdM1LoAAAAASUVORK5CYII=">
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
            <img data-aos="fade-up" class="img-section-half" style="border-bottom-left-radius: 5rem; border-bottom-right-radius: 5rem;" src="img/riset-dan-publikasi.jpeg" />
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

<!-- Kegiatan -->
<section id="section-kegiatan" class="d-flex justify-content-center align-items-center">
  <div class="section-slideshow align-self-center"></div>

  <div class="container position-relative">

    <!-- Swiper kegiatan -->
    <div class="row mb-4">
      <div class="swiper" id="swiper-kegiatan" data-aos="fade-left" data-aos-delay="400">
        <div class="swiper-wrapper">

          <!-- Swiper kegiatan terbaru -->
          <?php foreach ($kegiatanTerbaru as $i => $a) : ?>
            <div class="swiper-slide">
              <div class="container">
                <div class="row d-flex align-items-end align-items-md-center pt-5">

                  <!-- Gambar kegiatan -->
                  <div class="col-md-6 position-relative" style="height: 256px;">

                  </div>

                  <!-- Body kegiatan -->
                  <div class="col-md-6 mb-3">
                    <div class="card-body p-md-5 p-sm-4 p-3">

                      <!-- Kategori -->
                      <p class="text-primary fs-5 mt-5 mt-sm-3 mt-md-0"><b><?php echo $a['kategori']; ?></b></p>


                      <!-- Judul -->
                      <h3 class="card-title fs-2 mb-3">
                        <a class="link-dark text-decoration-none" href="<?= $a['slug']; ?>"><?= $a['judul']; ?></a>
                      </h3>

                      <!-- Tanggal -->
                      <p class="card-text mb-3">
                        <b><?= $a['tgl_terbit_terformat']; ?></b>
                      </p>

                      <!-- Ringkasan -->
                      <!-- <div class="d-none d-sm-block">
                         <p class="card-text fs-5 mb-3 line-clamp-4">
                           <?= word_limiter($a['meta_description'], 50); ?>
                         </p>
                       </div> -->

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
        <h1 class="fw-bold" data-aos="fade-up">Berita</h1>
        <p class="fs-4" data-aos="fade-up">Akademik, kampus, penelitian, dan lainnya</p>
      </div>
    </div>

    <div class="row g-4 mb-4 justify-content-center" data-aos="fade-up">
      <div class="col-lg-8">

        <!-- Slider berita -->
        <div class="swiper" id="swiper-berita">
          <!-- Additional required wrapper -->
          <div class="swiper-wrapper">
            <!-- Slides -->
            <?php foreach ($berita as $i => $b) : ?>
              <div class="swiper-slide">
                <div class="card berita-card text-white">
                  <img src="<?= $b['image'] ?>" class="card-img" alt="Agenda Image">
                  <div class="card-img-overlay d-flex flex-column justify-content-end">
                    <div class="d-flex align-items-center mb-2">
                      <span><?= $b['tgl_terbit'] ?></span>
                    </div>
                    <h5 class="card-title"><?= $b['judul'] ?></h5>
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

      <!-- Opini -->
      <div class="col-lg-4">
        <div class="card berita-card text-white">
          <img src="img/riset-dan-publikasi.jpeg" class="card-img" alt="Agenda Image">
          <div class="card-img-overlay d-flex flex-column justify-content-end">
            <div class="d-flex align-items-center mb-2">
              <span>Opini</span>
            </div>
            <h5 class="card-title">UKT Tidak Boleh Dinaikkan!</h5>
          </div>
        </div>
      </div>
    </div>


    <!-- Row tombol lebih banyak berita -->
    <div class="row">
      <div class="col text-center">
        <a class="btn btn-lg btn-outline-dark border-3 mb-4 border-start-0 border-end-0 border-top-0 rounded-0 px-0" href="#" data-aos="fade-up" data-aos-delay="400">
          <i class="bi bi-newspaper me-2"></i>Lebih banyak berita
        </a>
      </div>
    </div>

    <!-- Pengumuman dan Agenda -->
    <div class="row g-4 mb-4 mt-4 grid" data-aos="fade-up" data-aos-delay="600">
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
              <div class="card agenda-card text-white">
                <img src="img/riset-dan-publikasi.jpeg" class="card-img" alt="Agenda Image">
                <div class="card-img-overlay d-flex flex-column justify-content-end">
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
                      <img src="img/riset-dan-publikasi.jpeg" alt="News Image" class="me-3">
                      <p class="mb-0">Jadwal Pengisian Kartu Rencana Studi (KRS)dan Pengajuan Cuti Kuliah -CEK JADWALNYA-</p>
                    </div>
                  </div>
                </li>
                <!-- Item agenda -->
                <li class="list-group-item">
                  <div>
                    <p class="text-muted mb-1">Admin &bull; 54mnt</p>
                    <div class="d-flex align-items-start">
                      <img src="img/riset-dan-publikasi.jpeg" alt="News Image" class="me-3">
                      <p class="mb-0">Jadwal Pengisian Kartu Rencana Studi (KRS)dan Pengajuan Cuti Kuliah -CEK JADWALNYA-</p>
                    </div>
                  </div>
                </li>
                <!-- Item agenda -->
                <li class="list-group-item">
                  <div>
                    <p class="text-muted mb-1">Admin &bull; 54mnt</p>
                    <div class="d-flex align-items-start">
                      <img src="img/riset-dan-publikasi.jpeg" alt="News Image" class="me-3">
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
        <a class="btn btn-outline-dark mb-4" href="<?= base_url('tentang') ?>" data-aos="fade-left" data-mdb-ripple-init>
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

<?= $this->section('script') ?>
<script type="text/javascript" src="js/beranda.js"></script>
<?= $this->endSection() ?>