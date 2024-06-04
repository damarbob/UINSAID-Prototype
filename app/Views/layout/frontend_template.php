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
        <li class="nav-item me-sm-4">
          <button class="nav-link d-flex align-items-center" data-mdb-collapse-init data-mdb-target="#search" aria-controls="search" aria-expanded="false" aria-label="Toggle search">
            <i class="bi bi-search me-4 fs-2"></i>
            <span class="d-none d-sm-block">
              Cari
            </span>
          </button>
        </li>
        <li class="nav-item me-sm-4">
          <button class="nav-link d-flex align-items-center" data-mdb-collapse-init data-mdb-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Toggle menu">
            <i class="bi bi-list me-4 fs-2"></i>
            <span class="d-none d-sm-block">
              Menu
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
  <footer id="footer" class="section-batik rev-90">
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

  <!-- Custom scripts -->
  <script type="text/javascript" src="js/main.js"></script>

</body>

</html>