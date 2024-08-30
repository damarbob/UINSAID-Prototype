<?php helper('text'); ?>

<?= $this->extend('layout/frontend_template') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url("assets/css/style-pendidikan.css") ?>" type="text/css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Section Hero -->
<section class="hero">

</section>
<!-- End section Hero -->

<!-- Section Call to Action -->
<section id="call-to-action" class="fluid d-flex justify-content-center">
  <div class="lurik align-self-start"></div>

  <div class="container p-5 mt-4">
    <div class="row g-2 align-items-center">
      <div class="col-lg-3 pt-3">
        <h2>Program Pendidikan</h2>
      </div>
      <div class="col-lg-9 col-md-12 d-flex flex-wrap flex-sm-wrap flex-md-nowrap">
        <div class="p-2 flex-shrink-1 mb-2">
          Berbagai program pendidikan sarjana, magister, dan doktoral tersedia sesuai minat Anda untuk mendukung karir dan keahlian profesional di masa depan.
        </div>
        <div class="text-center align-self-center flex-shrink-0">
          <button class="btn btn-primary">Mulai Pendaftaran</button>
        </div>
      </div>
    </div>
  </div>
  <div class="lurik-2 align-self-end"></div>
</section>
<!-- End of Section Call to Action -->

<!-- Section cari prodi -->
<section id="cari-prodi">
  <div class="container p-5">
    <div class="row align-items-center bg-secondary rounded-3" id="text-cari-prodi">
      <div class="col-lg-4 col-md-6 text-center text-light">
        Cari Program Studi
      </div>
      <div class="col-lg-8 col-md-6 p-0">
        <form class="d-flex" role="search">
          <input class="form-control rounded-0 border-primary" type="search" placeholder="Search" aria-label="Search">
          <button class="cari me-0 btn btn-primary rounded-0 rounded-end-3" type="submit" data-mdb-ripple-init>Search</button>
        </form>
      </div>
    </div>
  </div>
</section>
<!-- End cari prodi -->

<section id="prodi">
  <div class="container p-5">
    <div class="row g-5">

      <!-- program sarjana -->
      <div class="col">
        <h1>Program Sarjana</h1>
        <div class="lurik-3 mb-4"></div>
        <h4>Mari Raih Gelar Pertama Anda!</h4>
        <p>Program sarjana merupakan gelar pertama yang dapat diperoleh di universitas bagi para lulusan SMA/SMK/MA atau lembaga pendidikan yang setara, yang tengah mencari kesempatan untuk melanjutkan pendidikan di tingkat perguruan tinggi.<br /><br />Mahasiswa dapat memilih dari berbagai program pendidikan yang kami tawarkan, yakni 33 program sarjana. Untuk informasi lebih lanjut mengenai profil setiap program pendidikan, persyaratan penerimaan, perkiraan biaya studi, serta informasi penting lainnya, silakan kunjungi tautan yang tersedia di bawah ini.</p>
        <h4><span class="text-primary fw-bold">Program Studi Sarjana (S1)</span></h4>
        <p>Program Studi Sarjana (S1) yang ditawarkan di UIN Raden Mas Said Surakarta:</p>
        <p><strong>Fakultas Adab dan Bahasa</strong></p>
        <ul>
          <li>S1 - Bahasa dan Sastra Arab</li>
          <li>S1 - Ilmu Perpustakaan dan Informasi Islam</li>
          <li>S1 - Pendidikan Bahasa Inggris</li>
          <li>S1 - Sastra Inggris</li>
          <li>S1 - Sejarah Peradaban Islam</li>
          <li>S1 - Tadris Bahasa Indonesia</li>
        </ul>
        <p><strong>Fakultas Ekonomi Dan Bisnis Islam</strong></p>
        <ul>
          <li>S1 - Akuntansi Syariah</li>
          <li>S1 - Ekonomi Syariah</li>
          <li>S1 - Manajemen Bisnis Syariah</li>
          <li>S1 - Perbankan Syariah</li>
        </ul>
        <p><strong>Fakultas Ilmu Tarbiyah</strong></p>
        <ul>
          <li>S1 - Bioteknologi</li>
          <li>S1 - Ilmu Lingkungan</li>
          <li>S1 - Manajemen Pendidikan Islam</li>
          <li>S1 - Pendidikan Agama Islam</li>
          <li>S1 - Pendidikan Bahasa Arab</li>
          <li>S1 - Pendidikan Guru Madrasah Ibtidaiyah</li>
          <li>S1 - Pendidikan Islam Anak Usia Dini</li>
          <li>S1 - Sains Data</li>
          <li>S1 - Tadris Biologi</li>
          <li>S1 - Tadris Matematika</li>
          <li>S1 - Teknologi Pangan</li>
        </ul>
        <p><strong>Fakultas Ushuluddin dan Dakwah</strong></p>
        <ul>
          <li>S1 - Aqidah dan Filsafat Islam</li>
          <li>S1 - Bimbingan dan Konseling Islam</li>
          <li>S1 - Ilmu Al-Qur&rsquo;an dan Tafsir</li>
          <li>S1 - Komunikasi dan Penyiaran Islam</li>
          <li>S1 - Manajemen Dakwah</li>
          <li>S1 - Psikologi Islam</li>
          <li>S1 - Pemikiran Politik Islam</li>
          <li>S1 - Tasawuf dan Psikoterapi</li>
        </ul>
        <p><strong>Fakultas Syariah</strong></p>
        <ul>
          <li>S1 - Hukum Ekonomi Syariah&nbsp;</li>
          <li>S1 - Hukum Keluarga Islam&nbsp;</li>
          <li>S1 - Hukum Pidana Islam</li>
          <li>S1 - Manajemen Zakat dan Wakaf</li>
        </ul>
      </div>

      <!-- program pascasarjana -->
      <div class="col">
        <h1>Program Pascasarjana</h1>
        <div class="lurik-3 mb-4"></div>
        <h4>Mari Tingkatkan Kompetensi Profesional Anda!</h4>
        <p>UIN Raden Mas Said menyediakan berbagai macam program pendidikan lanjutan, termasuk gelar master (S2), doktor (S3). Anda dapat menemukan daftar lengkap program-program ini untuk melanjutkan studi Anda dan memperdalam pengalaman belajar di kampus kami.<br /><br />Terdapat 9 pilihan program pasca sarjana yang dapat Anda pilih sesuai dengan kebutuhan Anda.</p>
        <h4><span class="text-primary fw-bold">Program Studi Magister (S2)</span></h4>
        <p>Program Studi Magister (S2) yang ditawarkan di UIN Raden Mas Said Surakarta:</p>
        <ul>
          <li>Hukum Ekonomi Syariah</li>
          <li>Manajemen Bisnis Syariah</li>
          <li>Manajemen Pendidikan Islam</li>
          <li>Pendidikan Agama Islam&nbsp;</li>
          <li>Pendidikan Bahasa Arab&nbsp;</li>
          <li>Hukum Ekonomi Syariah</li>
          <li>Tadris Bahasa Inggris</li>
        </ul>
        <h4><span class="text-primary fw-bold">Program Doktor (S3)</span></h4>
        <p>Program Studi Doktor (S3) yang ditawarkan di UIN Raden Mas Said Surakarta:</p>
        <ul>
          <li>Manajemen Pendidikan Islam</li>
        </ul>
      </div>
    </div>
  </div>
</section>
<!-- End prodi -->

<section id="telusuri-prodi">
  <div class="container p-5">
    <div class="row g-4">
      <div class="col">
        <div class="card">
          <div class="card-body text-center">
            <h4 class="card-title">Telusuri Program Studi Berdasarkan Fakultas</h4>
            <p class="text-light">Kunjungi situs web fakultas untuk mendapatkan informasi tentang program studi dan beragam aktivitas lainnya</p>
            <a class="btn btn-primary">
              Fakultas Adab dan Bahasa
            </a>
            <a class="btn btn-primary">
              Fakultas Ekonomi dan Bisnis Islam
            </a>
            <a class="btn btn-primary">
              Fakultas Ushuluddin dan Dakwah
            </a>
            <a class="btn btn-primary">
              Fakultas Ilmu Tarbiyah
            </a>
            <a class="btn btn-primary">
              Fakultas Syariah
            </a>
            <a class="btn btn-primary">
              Pascasarjana
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script type="text/javascript" src="<?= base_url("assets/js/beranda.js") ?>"></script>
<?= $this->endSection() ?>