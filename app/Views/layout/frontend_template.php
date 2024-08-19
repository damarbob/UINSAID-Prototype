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
  <!-- Bootstrap -->
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
  <!-- MDB -->
  <link id="mdbCSS" rel="stylesheet" href="<?= base_url("assets/css/c.css") ?>" />
  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= base_url("assets/css/style.css") ?>" />
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
  <nav class="navbar navbar-expand-xl navbar-dark fixed-top" id="frontend-navbar">
    <!-- Container wrapper -->
    <div class="container px-4 px-sm-5">

      <!-- Navbar brand -->
      <div id="navbarBrandWrapper" class="bg-white position-absolute top-0 py-2 px-2 rounded-bottom-3 shadow-lg">
        <a class="navbar-brand" href="/"></a>
      </div>

      <!-- Toggle button -->
      <button data-mdb-collapse-init class="navbar-toggler ms-auto" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Collapsible wrapper -->
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-4 fw-bold">

          <!-- Dropdown Tentang Kami -->
          <li class="nav-item dropdown">
            <a data-mdb-dropdown-init
              data-mdb-ripple-init
              data-mdb-auto-close="true" class="nav-link dropdown-toggle" href="#" id="navbarDropdownTentangKami" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
              Tentang Kami
            </a>
            <!-- Dropdown menu -->
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownTentangKami">
              <li><a href="/tentang-kami" class="dropdown-item">Tentang UIN RM Said</a></li>
              <li><a href="#" class="dropdown-item">Sambutan Rektor</a></li>
              <li><a href="#" class="dropdown-item">Sejarah</a></li>
              <li><a href="#" class="dropdown-item">Profil Universitas</a></li>
              <li><a href="#" class="dropdown-item">Arti Lambang</a></li>
              <li><a href="#" class="dropdown-item">Visi Misi</a></li>
              <li><a href="#" class="dropdown-item">Fasilitas</a></li>
              <li><a href="#" class="dropdown-item">Peta Kampus</a></li>
            </ul>
          </li>

          <!-- Dropdown Pendidikan -->
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              role="button"
              data-mdb-dropdown-init
              data-mdb-ripple-init
              data-mdb-auto-close="true"
              href="/pendidikan" id="navbarDropdownPendidikan"
              data-mdb-toggle="dropdown"
              aria-expanded="false">
              Pendidikan
            </a>
            <!-- Dropdown menu -->
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownPendidikan">
              <li><a href="#" class="dropdown-item">Fakultas Usluhuddin dan Dakwah</a></li>
              <li><a href="#" class="dropdown-item">Fakultas Syariah</a></li>
              <li><a href="#" class="dropdown-item">Fakultas Ilmu Tarbiyah</a></li>
              <li><a href="#" class="dropdown-item">Fakultas Ekonomi dan Bisnis Islam</a></li>
              <li><a href="#" class="dropdown-item">Fakultas Adab dan Bahasa</a></li>
              <li><a href="#" class="dropdown-item">Pascasarjana</a></li>
              <li><a href="#" class="dropdown-item">Lembaga</a></li>
              <li><a href="#" class="dropdown-item">Unit Pelaksana Teknis</a></li>
              <!-- <li>
                <a class="dropdown-item" href="#">Action</a>
              </li>
              <li>
                <a class="dropdown-item" href="#">Another action</a>
              </li>
              <li>
                <hr class="dropdown-divider" />
              </li>
              <li>
                <a class="dropdown-item" href="#">Something else here</a>
              </li> -->
            </ul>
          </li>

          <!-- Dropdown Riset dan Publikasi -->
          <li class="nav-item dropdown">
            <a data-mdb-dropdown-init
              data-mdb-ripple-init
              data-mdb-auto-close="true" class="nav-link dropdown-toggle" href="#" id="navbarDropdownRisetDanPublikasi" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
              Riset dan Publikasi
            </a>
            <!-- Dropdown menu -->
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownRisetDanPublikasi">
              <li><a href="#" class="dropdown-item">Omah Jurnal</a></li>
              <li><a href="#" class="dropdown-item">Repositori Jurnal</a></li>
            </ul>
          </li>

          <!-- Link Pengabdian -->
          <li class="nav-item">
            <a data-mdb-ripple-init class="nav-link" href="#">Pengabdian</a>
          </li>

          <!-- Link Mahasiswa Baru -->
          <li class="nav-item">
            <a data-mdb-ripple-init class="nav-link" href="#">Mahasiswa Baru</a>
          </li>

          <!-- Link PPID -->
          <li class="nav-item">
            <a data-mdb-ripple-init class="nav-link" href="#">PPID</a>
          </li>

        </ul>

        <!-- Notifications -->
        <!-- <div class="dropdown">
          <a
            data-mdb-dropdown-init
            class="text-reset me-3 dropdown-toggle hidden-arrow"
            href="#"
            id="navbarDropdownMenuLink"
            role="button"
            aria-expanded="false">
            <i class="fas fa-bell"></i>
            <span class="badge rounded-pill badge-notification bg-danger">1</span>
          </a>
          <ul
            class="dropdown-menu dropdown-menu-end"
            aria-labelledby="navbarDropdownMenuLink">
            <li>
              <a class="dropdown-item" href="#">Some news</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Another news</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Something else here</a>
            </li>
          </ul>
        </div> -->
        <!-- Avatar -->
        <!-- <div class="dropdown">
          <a
            data-mdb-dropdown-init
            class="dropdown-toggle d-flex align-items-center hidden-arrow"
            href="#"
            id="navbarDropdownMenuAvatar"
            role="button"
            aria-expanded="false">
            <img
              src="https://mdbcdn.b-cdn.net/img/new/avatars/2.webp"
              class="rounded-circle"
              height="25"
              alt="Black and White Portrait of a Man"
              loading="lazy" />
          </a>
          <ul
            class="dropdown-menu dropdown-menu-end"
            aria-labelledby="navbarDropdownMenuAvatar">
            <li>
              <a class="dropdown-item" href="#">My profile</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Settings</a>
            </li>
            <li>
              <a class="dropdown-item" href="#">Logout</a>
            </li>
          </ul>
        </div> -->

        <!-- Search -->
        <form class="w-auto">
          <input type="search" class="form-control" placeholder="Cari" aria-label="Search">
        </form>

      </div>
      <!-- Akhir daro collapsible wrapper -->

    </div>
    <!-- Container wrapper -->
  </nav>
  <!-- Navbar -->

  <!-- Mobile bottom Navbar -->
  <!-- Navbar -->
  <nav class="navbar navbar-expand navbar-dark bg-dark d-md-none fixed-bottom">
    <!-- Container wrapper -->
    <div class="container-fluid">

      <!-- Toggle button -->
      <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
        data-mdb-target="#mobileNavbar" aria-controls="mobileNavbar" aria-expanded="false"
        aria-label="Toggle navigation">
        <i class="fas fa-bars text-light"></i>
      </button>

      <!-- Collapsible wrapper -->
      <div class="collapse navbar-collapse justify-content-evenly" id="mobileNavbar">
        <!-- Left links -->
        <ul class="navbar-nav d-inline-flex flex-row w-100">
          <li class="nav-item text-center" style="flex: 1;"> <!-- todo: style -->
            <a class="nav-link active" aria-current="page" href="#!">
              <div>
                <i class="fas fa-home fa-lg mb-1"></i>
              </div>
              <span style="font-size: small;">Beranda</span> <!-- todo: style -->
            </a>
          </li>
          <li class="nav-item text-center" style="flex: 1;"> <!-- todo: style -->
            <a class="nav-link" href="#!">
              <div>
                <i class="fas fa-globe-americas fa-lg mb-1"></i>
                <!-- <span class="badge rounded-pill badge-notification bg-success">11</span> -->
              </div>
              <span style="font-size: small;">Berita</span> <!-- todo: style -->
            </a>
          </li>
          <li class="nav-item text-center" style="flex: 1;"> <!-- todo: style -->
            <a class="nav-link" href="#!">
              <div>
                <i class="fa-solid fa-user-plus fa-lg mb-1"></i>
              </div>
              <span style="font-size: small;">Penerimaan</span> <!-- todo: style -->
            </a>
          </li>
          <li class="nav-item text-center" style="flex: 1;"> <!-- todo: style -->
            <a class="nav-link" href="#!">
              <div>
                <i class="fa-solid fa-universal-access fa-lg mb-1"></i>
              </div>
              <span style="font-size: small;">Aksesibilitas</span> <!-- todo: style -->
            </a>
          </li>
          <!-- <li class="nav-item dropup text-center mx-2 mx-lg-1">
            <a data-mdb-dropdown-init class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-mdb-toggle="dropdown"
              aria-expanded="false">
              <div>
                <i class="far fa-envelope fa-lg mb-1"></i>
                <span class="badge rounded-pill badge-notification bg-primary">11</span>
              </div>
              Dropdown
            </a>

            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li>
                <hr class="dropdown-divider" />
              </li>
              <li>
                <a class="dropdown-item" href="#">Something else here</a>
              </li>
            </ul>
          </li> -->

        </ul>
        <!-- Left links -->

      </div>
      <!-- Collapsible wrapper -->
    </div>
    <!-- Container wrapper -->
  </nav>
  <!-- Navbar -->

  <?= $this->renderSection('content') ?>

  <div class="lurik-silk position-relative">

  </div>

  <!-- Footer -->
  <footer id="footer" class="section-batik rev-90 text-light">
    <!-- Footer bagian atas -->
    <div class="footer-top container p-5 rounded-top-5" style="background: #013316;">
      <div class="row">
        <!-- Footer & alamat -->
        <div class="col-lg-3 col-md-6">
          <img class="mb-4" width="256px" src="assets/img/logo-uin-only-horizontal-white.png" />
          <p>
            Jl. Pandawa, Pucangan, Kartasura, <br>
            Sukoharjo, Jawa Tengah, <br>
            Indonesia.
          </p>
          <div class="footer-links">
            <ul>
              <li>
                <img src="assets/img/icon/ikon-telepon.png" class="me-2" width="24px">
                <a href="#">+62271 7815 16</a>
              </li>
              <li>
                <img src="assets/img/icon/ikon-surel.png" class="me-2" width="24px">
                <a href="#">humas@uinsaid.ac.id</a>
              </li>
            </ul>
          </div>
        </div>

        <!-- Kontak -->
        <!-- <div class="col-lg-3 col-md-6 footer-links">
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
          </div> -->

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

        <!-- Lembaga -->
        <div class="col-lg-3 col-md-6 footer-links">
          <h4>Lembaga</h4>
          <ul>
            <li>
              <a href="#" onclick="tampilkanInformasiPengembangan()">Lembaga Penelitian dan Pengabdian Masyarakat</a>
            </li>
            <li>
              <a href="#" onclick="tampilkanInformasiPengembangan()">Lembaga Penjaminan Mutu</a>
            </li>
            <li>
              <a href="#" target="_blank">Satuan Pengawas Internal</a>
            </li>
            <li>
              <a href="#" target="_blank">Pusat Pengembangan Bisnis</a>
            </li>
          </ul>
        </div>

        <!-- Unit Pelaksana Teknis -->
        <div class="col-lg-3 col-md-6 footer-links">
          <h4>Lembaga</h4>
          <ul>
            <li>
              <a href="#" onclick="tampilkanInformasiPengembangan()">UPT Perpustakaan</a>
            </li>
            <li>
              <a href="#" onclick="tampilkanInformasiPengembangan()">UPT Bahasa</a>
            </li>
            <li>
              <a href="#" target="_blank">UPT Teknologi Informasi dan Pengkalan Data</a>
            </li>
            <li>
              <a href="#" target="_blank">UPT Ma’had Al-Jami’ah</a>
            </li>
            <li>
              <a href="#" target="_blank">UPT Pengembangan Karir</a>
            </li>
          </ul>
        </div>

      </div>

      <div class="row">
        <!-- Media sosial -->
        <div class="col text-center">
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

      <div class="row">
        <a id="themeToggle" class="card" data-mdb-ripple-init>
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
    <!-- Akhir footer bagian atas -->

    <!-- Hak cipta -->
    <div class="container z-3 bg-black py-4">
      <div class="row">
        <div class="col text-center">
          <!-- Teks hak cipta -->
          <p class="">
            &copy; 2024 UIN Raden Mas Said Surakarta
          </p>
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
  <script src="<?= base_url("assets/js/sienna-uinsaid.min.js") ?>" defer></script>

  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <!-- Custom scripts -->
  <script type="text/javascript" src="<?= base_url("assets/js/main.js") ?>"></script>

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
      const rtlCssUrl = "<?= base_url("assets/css/mdb.rtl.min.css") ?>";
      const ltrCssUrl = "<?= base_url("assets/css/c.css") ?>";

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