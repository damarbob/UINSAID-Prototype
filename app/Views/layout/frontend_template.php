<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>UIN Raden Mas Said Surakarta</title>
  <!-- MDB icon -->
  <!-- <link rel="icon" href="img/mdb-favicon.ico" type="image/x-icon" /> -->
  <link rel="shortcut icon" href="https://www.uinsaid.ac.id/files/icon-1704942188.png">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <!-- Libre baskerville font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
  <!-- Google Fonts Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
  <!-- MDB -->
  <link rel="stylesheet" href="css/mdb-dsm-custom.css" />
  <link rel="stylesheet" href="css/style.css" />
  <!-- Bootstrap icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Boxicons -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <!-- AOS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
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
          <button class="nav-link d-flex align-items-center px-4" data-mdb-collapse-init data-mdb-target="#search" aria-controls="search" aria-expanded="false" aria-label="Toggle search">
            <i class="bi bi-search me-4 fs-2"></i>
            <span class="d-none d-sm-block">
              Cari
            </span>
          </button>
        </li>

        <!-- Bahasa -->
        <div class="btn-group shadow-0 mb-2">
          <button class="nav-link px-4" type="button" id="dropdownMenuButton" data-mdb-dropdown-init data-mdb-ripple-init aria-expanded="false">
            <i class="bi bi-globe fs-2"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
            <li><a class="dropdown-item" href="#" onclick="doGTranslate('id|id');return false;">Indonesia</a></li>
            <li><a class="dropdown-item" href="#" onclick="doGTranslate('id|ar');return false;">Arabic</a></li>
            <li><a class="dropdown-item" href="#" onclick="doGTranslate('id|en');return false;">English</a></li>
          </ul>
        </div>

        <!-- Menu -->
        <li class="nav-item">
          <button class="nav-link d-flex align-items-center px-4" data-mdb-collapse-init data-mdb-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Toggle menu">
            <i class="bi bi-list fs-2"></i>
            <span class="d-none d-sm-block">
            </span>
          </button>
        </li>
      </ul>

    </div>

    <!-- Menu -->
    <div class="collapse w-100" id="menu">

      <div class="container overflow-auto">
        <div class="row">
          <div class="col">

            <ul class="fs-1">
              <li>
                <a href="#" class="">Akademik</a>
              </li>
              <li>
                <a href="#" class="">Riset dan publikasi</a>
              </li>
              <li>
                <a href="#" class="">Tentang kami</a>
              </li>
              <li>
                <a href="#" class="">Berita</a>
              </li>
              <li>
                <a href="#" class="">SPMB</a>
              </li>
              <li>
                <a href="#" class="">Alumni</a>
              </li>
            </ul>

          </div>
          <div class="col">
          </div>
        </div>
      </div>

    </div>
    <!-- Menu -->

    <!-- Container wrapper -->
  </nav>
  <!-- Navbar -->

  <!-- Search -->
  <div class="collapse w-100" id="search">

    <div class="container p-4">
      <div class="row h-100">
        <div class="col w-100 h-100">

          <button class="nav-link d-flex align-items-center" data-mdb-collapse-init data-mdb-target="#search" aria-controls="search" aria-expanded="false" aria-label="Toggle search">
            <i class="bi bi-x-lg me-4 fs-2"></i>
            Tutup
          </button>

          <div class="w-100 text-center mb-4">
            <img class="align-self-center" width="128px" src="img/icon.png" />
          </div>

          <div class="form-outline w-100" data-mdb-input-init>
            <input type="text" id="formCari" class="form-control form-control-lg" />
            <label class="form-label" for="formControlLg">Cari</label>
          </div>
          <div id="formCari" class="form-text">
            Masukkan kata kunci lalu tekan ENTER
          </div>

        </div>
      </div>
    </div>
  </div>
  <!-- Search -->

  <?= $this->renderSection('content') ?>

  <!-- Footer -->
  <footer id="footer" class="section-batik">
    <!-- Footer bagian atas -->
    <div class="footer-top">
      <div class="container p-5">
        <div class="row">
          <!-- Judul footer & alamat APTMI -->
          <div class="col-lg-3 col-md-6">
            <img class="mb-4" width="128px" src="img/icon.png" />
            <p>
              Jl. Pandawa, Pucangan, Kartasura, <br>
              Sukoharjo, Jawa Tengah, <br>
              Indonesia.
            </p>
          </div>

          <!-- Kontak APTMI -->
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

          <!-- Layanan APTMI -->
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

          <!-- Media sosial APTMI -->
          <div class="col-lg-3 col-md-6">
            <h4>Ikuti kami</h4>

            <a class="fs-1" href="#" target="_blank">
              <i class="bx bxl-instagram me-2"></i>
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
          <!-- Akhir media sosial APTMI -->
        </div>
      </div>
    </div>
    <!-- Akhir footer bagian atas -->

    <!-- Hak cipta -->
    <div class="container">
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
    /* <![CDATA[ */
    eval(function(p, a, c, k, e, r) {
      e = function(c) {
        return (c < a ? '' : e(parseInt(c / a))) + ((c = c % a) > 35 ? String.fromCharCode(c + 29) : c.toString(36))
      };
      if (!''.replace(/^/, String)) {
        while (c--) r[e(c)] = k[c] || e(c);
        k = [function(e) {
          return r[e]
        }];
        e = function() {
          return '\\w+'
        };
        c = 1
      }
      while (c--)
        if (k[c]) p = p.replace(new RegExp('\\b' + e(c) + '\\b', 'g'), k[c]);
      return p
    }('6 7(a,b){n{4(2.9){3 c=2.9("o");c.p(b,f,f);a.q(c)}g{3 c=2.r();a.s(\'t\'+b,c)}}u(e){}}6 h(a){4(a.8)a=a.8;4(a==\'\')v;3 b=a.w(\'|\')[1];3 c;3 d=2.x(\'y\');z(3 i=0;i<d.5;i++)4(d[i].A==\'B-C-D\')c=d[i];4(2.j(\'k\')==E||2.j(\'k\').l.5==0||c.5==0||c.l.5==0){F(6(){h(a)},G)}g{c.8=b;7(c,\'m\');7(c,\'m\')}}', 43, 43, '||document|var|if|length|function|GTranslateFireEvent|value|createEvent||||||true|else|doGTranslate||getElementById|google_translate_element2|innerHTML|change|try|HTMLEvents|initEvent|dispatchEvent|createEventObject|fireEvent|on|catch|return|split|getElementsByTagName|select|for|className|goog|te|combo|null|setTimeout|500'.split('|'), 0, {}))
    /* ]]> */
  </script>

  <!-- Custom scripts -->
  <script type="text/javascript" src="js/main.js"></script>

</body>

</html>