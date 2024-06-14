<!DOCTYPE html>
<html lang="id" dir="">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>UIN Raden Mas Said Surakarta</title>
  <meta name="googlebot" content="index,follow">
  <meta name="language" content="id" />
  <link rel="canonical" href="https://webdemo.uinsaid.id" />
  <meta name="google-site-verification" content="wVOBtikI0s7xKLkglkAAc2ZereV7l0NrQZH8LPCoKSk">

  <meta name="author" content="UIN Raden Mas Said Surakarta" />
  <meta name="copyright" content="UIN Raden Mas Said Surakarta" />
  <meta name="application-name" content="UIN Raden Mas Said Surakarta" />
  <meta itemprop="https://webdemo.uinsaid.id" content="https://www.uinsaid.ac.id/files/icon-1704942188.png" />
  <meta property="og:title" content="UIN Raden Mas Said Surakarta" />
  <meta property="og:site_name" content="webdemo.uinsaid.id">
  <meta property="og:keywords" content="uinsaid, rmsaid, uinsurakarta">
  <meta property="og:type" content="article" />
  <meta property="og:image" content="https://www.uinsaid.ac.id/files/icon-1704942188.png" />
  <meta property="og:image:alt" content="UIN Raden Mas Said Surakarta" />
  <meta property="og:image:width" content="400" />
  <meta property="og:image:height" content="400" />
  <meta property="og:url" content="https://webdemo.uinsaid.id" />
  <meta property="og:description" content="Demo web UIN Raden Mas Said Surakarta" />
  <meta property="og:locale" content="id_ID" />

  <!-- Favicon -->
  <link rel="shortcut icon" href="https://www.uinsaid.ac.id/files/icon-1704942188.png">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <!-- Libre baskerville font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
  <!-- Google Fonts Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
  <!-- Google Fonts Montseratt -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <!-- MDB -->
  <link id="mdbCSS" rel="stylesheet" href="css/mdb-dsm-custom-new.css" />
  <link rel="stylesheet" href="css/style.css" />
  <!-- Bootstrap icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Boxicons -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <!-- Material icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <style>
    .material-symbols-outlined {
      font-variation-settings:
        'FILL' 0,
        'wght' 400,
        'GRAD' 0,
        'opsz' 24
    }
  </style>
  <!-- AOS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <!-- Swiper JS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <!-- Script -->
  <?= $this->renderSection('style'); ?>
</head>

<body>
  <!-- Navbar -->
  <nav id="frontend-navbar" class="navbar navbar-dark fixed-top">
    <!-- Container wrapper -->
    <div class="container">


      <!-- Navbar brand -->
      <a class="navbar-brand" href="#">
        <!-- <img src="img/logo-horizontal.png" class="me-2" height="64px" alt="MDB Logo" loading="lazy" /> -->
      </a>

      <!-- Icons -->
      <ul class="navbar-nav d-flex flex-row me-1">

        <!-- Cari -->
        <li class="nav-item">
          <button id="menuSearch" class="nav-link d-flex align-items-center px-4 rounded-pill" data-mdb-collapse-init data-mdb-target="#search" aria-controls="search" aria-expanded="false" aria-label="Toggle search" data-mdb-ripple-init>
            <i class="bi bi-search me-lg-4 fs-2"></i>
            <span class="d-none d-lg-block">
              Cari
            </span>
          </button>
        </li>

        <!-- Bahasa -->
        <div class="btn-group shadow-0 mb-2">
          <button id="menuLanguage" class="nav-link px-4 rounded-pill" type="button" id="dropdownMenuButton" data-mdb-dropdown-init data-mdb-ripple-init aria-expanded="false">
            <i class="bi bi-globe fs-2"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
            <li><a id="translateToID" class="dropdown-item no-translate" href="#" onclick="">
                <img src="<?= base_url("/img/country-flags/indonesia.png") ?>" width="16px" class="me-2">
                IDN (Bahasa Indonesia)
              </a></li>
            <li><a id="translateToAR" class="dropdown-item no-translate" href="#" onclick="">
                <img src="<?= base_url("/img/country-flags/saudi-arabia.png") ?>" width="16px" class="me-2">
                AR (Arab)
              </a></li>
            <li><a id="translateToEN" class="dropdown-item no-translate" href="#" onclick="">
                <img src="<?= base_url("/img/country-flags/united-states-of-america.png") ?>" width="16px" class="me-2">
                EN (Inggris)
              </a></li>
          </ul>
        </div>

        <!-- Menu -->
        <li class="nav-item">
          <button id="menuButton" class="nav-link px-4 rounded-pill" data-mdb-collapse-init data-mdb-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Toggle menu" data-mdb-ripple-init>
            <i id="menuIcon" class="bi bi-list fs-2"></i>
          </button>
        </li>

      </ul>

    </div>

    <!-- Menu -->
    <div class="collapse w-100 gradient-1" id="menu">

      <div class="container overflow-auto px-5">

        <div class="row mb-4">

          <!-- Menu utama -->
          <div class="col-md-6">

            <ul class="fs-2">
              <li>
                <a id="menuAkademik" href="#" class="" data-mdb-collapse-init data-mdb-toggle="collapse" data-mdb-target="#dropdownAkademik" aria-expanded="true" aria-controls="dropdownAkademik">Akademik</a>

                <div class="d-block d-md-none">
                  <ul id="dropdownAkademik" class="collapse ps-4 fs-4" aria-labelledby="menuAkademik">
                    <li><a href="#" class="">Fakultas Usluhuddin dan Dakwah</a></li>
                    <li><a href="#" class="">Fakultas Syariah</a></li>
                    <li><a href="#" class="">Fakultas Ilmu Tarbiyah</a></li>
                    <li><a href="#" class="">Fakultas Ekonomi dan Bisnis Islam</a></li>
                    <li><a href="#" class="">Fakultas Adab dan Bahasa</a></li>
                    <li><a href="#" class="">Pascasarjana</a></li>
                    <li><a href="#" class="">Lembaga</a></li>
                    <li><a href="#" class="">Unit Pelaksana Teknis</a></li>
                  </ul>
                </div>

              </li>
              <li>
                <a id="menuRisetDanPublikasi" href="#" class="" data-mdb-collapse-init data-mdb-toggle="collapse" data-mdb-target="#dropdownRisetDanPublikasi" aria-expanded="true" aria-controls="dropdownRisetDanPublikasi">Riset dan Publikasi</a>

                <div class="d-block d-md-none">
                  <ul id="dropdownRisetDanPublikasi" class="collapse ps-4 fs-4" aria-labelledby="menuRisetDanPublikasi">
                    <li><a href="#" class="">Omah Jurnal</a></li>
                    <li><a href="#" class="">Repositori Jurnal</a></li>
                  </ul>
                </div>

              </li>
              <li>
                <a href="#" class="">Pengabdian</a>
              </li>
              <li>
                <a id="menuTentangKami" href="#" class="" data-mdb-collapse-init data-mdb-toggle="collapse" data-mdb-target="#dropdownTentangKami" aria-expanded="true" aria-controls="dropdownTentangKami">Tentang Kami</a>

                <div class="d-block d-md-none">
                  <ul id="dropdownTentangKami" class="collapse ps-4 fs-4" aria-labelledby="menuTentangKami">
                    <li><a href="#" class="">Tentang UIN RM Said</a></li>
                    <li><a href="#" class="">Sambutan Rektor</a></li>
                    <li><a href="#" class="">Sejarah</a></li>
                    <li><a href="#" class="">Profil Universitas</a></li>
                    <li><a href="#" class="">Arti Lambang</a></li>
                    <li><a href="#" class="">Visi Misi</a></li>
                    <li><a href="#" class="">Fasilitas</a></li>
                    <li><a href="#" class="">Peta Kampus</a></li>
                  </ul>
                </div>

              </li>
              <li>
                <a href="#" class="">Berita</a>
              </li>
              <li>
                <a href="https://registrasimaba.uinsaid.ac.id/" class="" target="_blank">Pendaftaran Mahasiswa Baru</a>
              </li>
              <li>
                <a href="#" class="">Alumni</a>
              </li>
            </ul>

          </div>

          <!-- Sub menu samping -->
          <div class="col-md-6 ps-md-4 d-none d-md-block border-start border-2">

            <ul id="dropdownAkademik" class="collapse ps-4 fs-4" aria-labelledby="menuAkademik">
              <li><a href="#" class="">Fakultas Usluhuddin dan Dakwah</a></li>
              <li><a href="#" class="">Fakultas Syariah</a></li>
              <li><a href="#" class="">Fakultas Ilmu Tarbiyah</a></li>
              <li><a href="#" class="">Fakultas Ekonomi dan Bisnis Islam</a></li>
              <li><a href="#" class="">Fakultas Adab dan Bahasa</a></li>
              <li><a href="#" class="">Pascasarjana</a></li>
              <li><a href="#" class="">Lembaga</a></li>
              <li><a href="#" class="">Unit Pelaksana Teknis</a></li>
            </ul>

            <ul id="dropdownRisetDanPublikasi" class="collapse ps-4 fs-2" aria-labelledby="menuRisetDanPublikasi">
              <li><a href="#" class="">Omah Jurnal</a></li>
              <li><a href="#" class="">Repositori Jurnal</a></li>
            </ul>

            <ul id="dropdownTentangKami" class="collapse ps-4 fs-4" aria-labelledby="menuTentangKami">
              <li><a href="#" class="">Tentang UIN RM Said</a></li>
              <li><a href="#" class="">Sambutan Rektor</a></li>
              <li><a href="#" class="">Sejarah</a></li>
              <li><a href="#" class="">Profil Universitas</a></li>
              <li><a href="#" class="">Arti Lambang</a></li>
              <li><a href="#" class="">Visi Misi</a></li>
              <li><a href="#" class="">Fasilitas</a></li>
              <li><a href="#" class="">Peta Kampus</a></li>
            </ul>

          </div>
        </div>

        <div class="row mb-4 g-2 pb-4">

          <!-- SIAKAD -->
          <div class="col-dm-6 col-lg-4">
            <a href="https://siakad.uinsaid.ac.id/" target="_blank" class="card" data-mdb-ripple-init>
              <div class="card-body row">
                <div class="col-auto">
                  <img class="wh-64px" src="data:image/png;base64,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">
                </div>
                <div class="col d-flex align-items-center">
                  SIAKAD
                </div>
              </div>
            </a>
          </div>

          <!-- Helpdesk -->
          <div class="col-md-6 col-lg-4">
            <a href="https://wa.me/6282133754228" target="_blank" class="card" data-mdb-ripple-init>
              <div class="card-body row">
                <div class="col-auto">
                  <img class="wh-64px" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGAAAABgCAYAAADimHc4AAAACXBIWXMAAAsTAAALEwEAmpwYAAAC2ElEQVR4nO2bsW7TQByHbyovYJMBBP4XJloepy9Q2WzMjJSRAZQq8fEOPAPBx8ZOusHIwsZdxiCjA9SqQm2Txvbv7vz7pP+UKI6+r3dJe7VShBBCCCGEEEIIIYRsyP7MPZXanhbaLkW7lWjXBjqrv+/RTve1O4w+8OPT9k5ROy3a/gpAbrvV1HZd1Hb+5H27p2KVL9p+hIvUu01R20WUEUS7d2h50l2EmYpuz49x29FXTG3Xj+buQMWC/8CFS9MdrwJt36pYkNqdJRegtl9ULBTaufQCOKtiAS1LehoVC2hRwgB4WcIVgBcm3ILSGhULaFHCAHhZwhWAFybcgtIaFQtoUcIAeFnCFYAXJtyC0pq8MhtNVplVVpllXjbTyXEz/Nny2APkl2edVc1cHS2HO9ZEi5KwAvybZjFYBLQoCTKAabPSDHO2jBYlgQbw29GkXPR/towWJeEGaPPS9H+2jBYlAQfIKtP/2TJalAQcIK+a/s+W0aIk6ACm/78poUUJA+BlCVcAXphwC0pnivlPfgYIMMDDNz8YQIAB7p18ZQBBBahtO3n+mQEEFOD+q2+dyefvAXo7+Q9ef2/vPvvEAALYdvxPftfyuQL09V81/bcd/4Hb5Z4fdIBC25c3vV7ekwjUBBNgE/ketLAkA2wq34MWllyAbeR70MKSCrCtfA9aWDIBbiPfgxaWRIDbyveghUUfYBf5HrSwqAPsKt+DFhZtgC7ke9DCogzQlXwPWlh8AWp30uXr5QFIiypA1+RVY9HSxh2gbM7Q0sYeYIqWNuoAk+Pm0P9rN1rcaAN4/G0+aHGjDqCOlntZaT6g5Y03wEWEWezbkYqdSbk48Hea+JsdstI4tNDRBQiNvDQvGCCiCOj3qsYeQRFshB4vTzaJ8OdJBBeh50uTmyKcP4FgIgxwWXJdhEsPkuEjDHRJclWE/x4gw5FXTafn5YQQQgghhBBCCCFEJcVvziifmes93RAAAAAASUVORK5CYII=">
                </div>
                <div class="col d-flex align-items-center">
                  Helpdesk
                </div>
              </div>
            </a>
          </div>

          <!-- Kemenag -->
          <div class="col-md-6 col-lg-4">
            <a href="https://kemenag.go.id/" target="_blank" class="card" data-mdb-ripple-init>
              <div class="card-body row">
                <div class="col-auto">
                  <img src="https://www.uinsaid.ac.id/files/apps/logo-1708606715.jpeg" class="wh-64px">
                </div>
                <div class="col d-flex align-items-center">
                  Kementrian Agama
                </div>
              </div>
            </a>
          </div>

          <!-- Tema -->
          <div class="col-md-6 col-lg-4">
            <a id="themeToggle" href="#" target="_blank" class="card" data-mdb-ripple-init>
              <div class="card-body row">
                <div class="col-auto">
                  <img class="wh-64px" src="data:image/png;base64,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">
                </div>
                <div class="col d-flex align-items-center">
                  Tema gelap/terang
                </div>
              </div>
            </a>
          </div>

        </div>

        <!-- Link tambahan -->
        <div class="row mb-4">
          <div class="col d-flex flex-column flex-sm-row fs-5">

            <a href="#" class="text-underline me-4">
              Arsip
            </a>

            <a href="#" class="text-underline me-4">
              Download
            </a>

            <a href="#" class="text-underline me-4">
              Value BLU
            </a>

          </div>

        </div>

        <!-- Footer -->
        <div class="row">

          <div class="col">
            <p>
              &copy; 2024 UIN Raden Mas Said Surakarta
            </p>
            <!-- <a href="https://icons8.com/icon/114333/student-center">Student Center</a> icon by <a href="https://icons8.com">Icons8</a> -->
          </div>

        </div>

      </div>

    </div>
    <!-- Menu -->

    <!-- Container wrapper -->
  </nav>
  <!-- Navbar -->

  <!-- Search -->
  <div class="collapse w-100 gradient-1 px-5" id="search">

    <div class="d-flex justify-content-center align-items-center h-100 position-relative container p-4">

      <button id="tutupBtn" class="position-absolute align-self-start end-0 nav-link d-flex align-items-center" data-mdb-collapse-init data-mdb-target="#search" aria-controls="search" aria-expanded="false" aria-label="Toggle search">
        <i class="bi bi-x-lg me-4 fs-2"></i>
        Tutup
      </button>

      <div class="position-absolute align-self-end w-100 text-center mb-4">
        <img class="align-self-center" width="128px" src="img/icon.png" />
      </div>

      <div class="position-absolute w-100">
        <div class="form-outline" data-mdb-input-init>
          <input type="text" id="formCari" class="form-control form-control-lg" />
          <label class="form-label" for="formControlLg">Cari</label>
        </div>
        <div id="formCari" class="form-text">
          Masukkan kata kunci lalu tekan ENTER
        </div>
      </div>

    </div>
  </div>
  <!-- Search -->

  <?= $this->renderSection('content') ?>

  <div class="lurik-silk position-relative">

  </div>

  <!-- Footer -->
  <footer id="footer" class="section-batik rev-90">
    <!-- Footer bagian atas -->
    <div class="footer-top">
      <div class="container p-5">
        <div class="row">
          <!-- Footer & alamat -->
          <div class="col-lg-3 col-md-6">
            <img class="mb-4" width="128px" src="img/icon.png" />
            <p>
              Jl. Pandawa, Pucangan, Kartasura, <br>
              Sukoharjo, Jawa Tengah, <br>
              Indonesia.
            </p>
          </div>

          <!-- Kontak -->
          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Kontak</h4>
            <ul>
              <li>
                <i class="bx bx-phone-call"></i>
                <a href="#">+62271 7815 16</a>
              </li>
              <li>
                <i class='bx bx-briefcase'></i>
                <a href="#">+62271 7827 74</a>
              </li>
              <li>
                <i class='bx bx-envelope'></i>
                <a href="#">humas@uinsaid.ac.id</a>
              </li>
            </ul>
          </div>

          <!-- Fakultas dan pascasarjana -->
          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Fakultas dan Pascasarjana</h4>
            <ul>
              <li>
                <a href="#" onclick="tampilkanInformasiPengembangan()">Fakultas Usluhuddin dan Dakwah</a>
              </li>
              <li>
                <a href="#" onclick="tampilkanInformasiPengembangan()">Fakultas Syariah</a>
              </li>
              <li>
                <a href="#" target="_blank">Fakultas Ilmu Tarbiyah</a>
              </li>
              <li>
                <a href="#" target="_blank">Fakultas Ekonomi dan Bisnis Islam</a>
              </li>
              <li>
                <a href="#" target="_blank">Fakultas Adab dan Bahasa</a>
              </li>
              <li>
                <a href="#" target="_blank">Pascasarjana</a>
              </li>
            </ul>
          </div>

          <!-- Media sosial -->
          <div class="col-lg-3 col-md-6">
            <h4>Ikuti kami</h4>

            <a class="fs-1" href="#" target="_blank">
              <i class="bx bxl-instagram me-2"></i>
            </a>
            <a class="fs-1" href="#" target="_blank">
              <i class="bx bxl-tiktok me-2"></i>
            </a>
            <a class="fs-1" href="#" target="_blank">
              <i class="bx bxl-twitter me-2"></i>
            </a>
            <a class="fs-1" href="#" target="_blank">
              <i class="bx bxl-facebook me-2"></i>
            </a>
            <a class="fs-1" href="#" target="_blank">
              <i class="bx bxl-youtube me-2"></i>
            </a>
          </div>
          <!-- Akhir media sosial -->
        </div>
      </div>
    </div>
    <!-- Akhir footer bagian atas -->

    <!-- Hak cipta -->
    <div class="container z-3">
      <div class="copyright-wrap d-md-flex py-4">
        <div class="me-md-auto text-center text-md-start">
          <!-- Teks hak cipta -->
          <div class="copyright">
            &copy; 2024 UIN Raden Mas Said Surakarta
          </div>
          <!-- Akhir teks hak cipta -->
        </div>
      </div>
    </div>
    <!-- Akhir hak cipta -->
  </footer>
  <!-- End Footer -->

  <!-- JQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

  <!-- MDB -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.umd.min.js"></script>

  <!-- AOS -->
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>

  <!-- Accessibility -->
  <script src="<?= base_url("js/sienna-uinsaid.min.js") ?>" defer></script>

  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <!-- Custom scripts -->
  <script type="text/javascript" src="js/main.js"></script>

  <?= $this->renderSection('script') ?>

  <!-- Google translate element -->
  <div id="google_translate_element2" class="d-none"></div>

  <script type="text/javascript">
    function googleTranslateElementInit2() {
      new google.translate.TranslateElement({
        pageLanguage: 'id',
        autoDisplay: false
      }, 'google_translate_element2');
    }
  </script>
  <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2"></script>
  <script type="text/javascript">
    // /* <![CDATA[ */
    // eval(function(p, a, c, k, e, r) {
    //   e = function(c) {
    //     return (c < a ? '' : e(parseInt(c / a))) + ((c = c % a) > 35 ? String.fromCharCode(c + 29) : c.toString(36))
    //   };
    //   if (!''.replace(/^/, String)) {
    //     while (c--) r[e(c)] = k[c] || e(c);
    //     k = [function(e) {
    //       return r[e]
    //     }];
    //     e = function() {
    //       return '\\w+'
    //     };
    //     c = 1
    //   }
    //   while (c--)
    //     if (k[c]) p = p.replace(new RegExp('\\b' + e(c) + '\\b', 'g'), k[c]);
    //   return p
    // }('6 7(a,b){n{4(2.9){3 c=2.9("o");c.p(b,f,f);a.q(c)}g{3 c=2.r();a.s(\'t\'+b,c)}}u(e){}}6 h(a){4(a.8)a=a.8;4(a==\'\')v;3 b=a.w(\'|\')[1];3 c;3 d=2.x(\'y\');z(3 i=0;i<d.5;i++)4(d[i].A==\'B-C-D\')c=d[i];4(2.j(\'k\')==E||2.j(\'k\').l.5==0||c.5==0||c.l.5==0){F(6(){h(a)},G)}g{c.8=b;7(c,\'m\');7(c,\'m\')}}', 43, 43, '||document|var|if|length|function|GTranslateFireEvent|value|createEvent||||||true|else|doGTranslate||getElementById|google_translate_element2|innerHTML|change|try|HTMLEvents|initEvent|dispatchEvent|createEventObject|fireEvent|on|catch|return|split|getElementsByTagName|select|for|className|goog|te|combo|null|setTimeout|500'.split('|'), 0, {}))
    // /* ]]> */
    $(document).ready(function() {
      $("#translateToID").on("click", function() {
        doGTranslate('id|id');
        return false;
      });
      $("#translateToAR").on("click", function() {
        doGTranslate('id|ar');
        return false;
      });
      $("#translateToEN").on("click", function() {
        doGTranslate('id|en');
        return false;
      });

      function GTranslateFireEvent(a, b) {
        try {
          var event;
          if (document.createEvent) {
            event = document.createEvent("HTMLEvents");
            event.initEvent(b, true, true);
            a.dispatchEvent(event);
          } else {
            event = document.createEventObject();
            a.fireEvent('on' + b, event);
          }
        } catch (e) {}
      }

      function doGTranslate(a) {
        if (a.value) a = a.value;
        if (a == '') return;

        var lang = a.split('|')[1];
        var selectElement = null;
        var selectElements = $('select.goog-te-combo');

        selectElements.each(function() {
          selectElement = this;
        });

        if ($('#google_translate_element2').length === 0 ||
          $('#google_translate_element2').html().length === 0 ||
          selectElements.length === 0 ||
          selectElement.innerHTML.length === 0) {
          setTimeout(function() {
            doGTranslate(a);
          }, 500);
        } else {
          selectElement.value = lang;
          GTranslateFireEvent(selectElement, 'change');
          GTranslateFireEvent(selectElement, 'change');
        }

        // Enable RTL if language is arabic
        if (lang == "ar") {
          enableRTL();
        } else {
          disableRTL();
        }
      }

      // Retrieve stored settings or default to light and LTR
      const currentTheme = localStorage.getItem('mdb-theme') || 'light';
      const currentDirection = localStorage.getItem('html-dir') || 'ltr';

      const htmlElement = $("html");
      const mdbCssElement = $('#mdbCSS');
      const swipers = $('.swiper');
      const rtlCssUrl = "<?= base_url("css/mdb.rtl.min.css") ?>";
      const ltrCssUrl = "<?= base_url("css/mdb-dsm-custom-new.css") ?>";

      // Apply initial settings
      htmlElement.attr('data-mdb-theme', currentTheme);
      htmlElement.attr('dir', currentDirection);
      htmlElement.attr('lang', currentDirection === 'rtl' ? 'ar' : 'en');
      mdbCssElement.attr('href', currentDirection === 'rtl' ? rtlCssUrl : ltrCssUrl);

      // Function to enable RTL
      function enableRTL() {
        htmlElement.attr("dir", "rtl");
        htmlElement.attr("lang", "ar");
        localStorage.setItem("html-dir", "rtl");
        mdbCssElement.attr('href', rtlCssUrl);

        // Add RTL attributes and class to Swiper containers
        // swipers.each(function() {
        //   $(this).attr('dir', 'rtl').addClass('swiper-rtl');
        // });
      }

      // Function to disable RTL (set to LTR)
      function disableRTL() {
        htmlElement.attr("dir", "ltr");
        htmlElement.attr("lang", "en");
        mdbCssElement.attr('href', ltrCssUrl);
        localStorage.setItem("html-dir", "ltr");

        // Remove RTL attributes and class from Swiper containers
        // swipers.each(function() {
        //   $(this).attr('dir', 'ltr').removeClass('swiper-rtl');
        // });
      }
      //
    });
  </script>

</body>

</html>