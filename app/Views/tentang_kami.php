<?php helper('text'); ?>

<?= $this->extend('layout/frontend_template') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url("assets/css/style-tentang-kami.css") ?>" type="text/css" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Hero -->
<section class="hero" class="bg-primary p-0 d-flex align-items-center justify-content-center mt-navbar">

</section>

<!-- Judul -->
<section class="menu-title d-flex align-items-center gradient-1">
    <div class="lurik align-self-start"></div>
    <div class="container text-center">
        <h1 class="">Menu Title</h1>
    </div>
    <div class="lurik-2 align-self-end"></div>
</section>

<!-- Section CTNA -->
<section class="fluid section-batik mt-navbar" id="akademik">
    <div class="container p-5">
        <div class="row d-flex align-items-center g-5">

            <!-- Akademik column -->
            <div class="col-lg-6 ps-5" data-aos="fade-left">
                <h1 class="pb-2 fw-bold">
                    Lorem Ipsum is simply dummy
                    text of the printing
                </h1>
                <div class="lurik-3"></div>
            </div>

            <!-- Picture grid column -->
            <div class="col-lg-6">

                <!-- Picture grid -->
                <div class="row g-0">
                    <div class="col">
                        <img data-aos="fade-up" class="" style="border-radius: 5rem; width: 100%; max-height: 512px;object-fit: contain;" src="assets/img/foto-rektor-wisuda.png" />
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>
<!-- Section CTNA -->

<!-- Section Tentang Kami -->
<section class="fluid section-batik" id="akademik">
    <div class="container p-5">
        <div class="row d-flex g-5">

            <div class="col-md-4 col-lg-3">

                <div class="container bg-gradient border rounded-5">
                    <div class="row">
                        <div class="col">

                            <!-- Tab navs -->
                            <div class="nav py-4 flex-column nav-tabs text-start" id="v-tabs-tab" role="tablist" aria-orientation="vertical">
                                <h5 class="ps-3 fw-bold">Universitas</h5>
                                <a data-mdb-tab-init class="nav-link active text" id="v-tabs-home-tab" href="#v-tabs-home" role="tab" aria-controls="v-tabs-home" aria-selected="true">Sambutan Rektor</a>
                                <a data-mdb-tab-init class="nav-link text" id="v-tabs-sejarah-tab" href="#v-tabs-sejarah" role="tab" aria-controls="v-tabs-sejarah" aria-selected="false">Sejarah</a>
                                <a data-mdb-tab-init class="nav-link text" id="v-tabs-profil-tab" href="#v-tabs-profil" role="tab" aria-controls="v-tabs-profil" aria-selected="false">Profil Universitas</a>
                                <a data-mdb-tab-init class="nav-link text" id="v-tabs-visi-tab" href="#v-tabs-visi" role="tab" aria-controls="v-tabs-visi" aria-selected="false">Visi-Misi</a>
                                <a data-mdb-tab-init class="nav-link text" id="v-tabs-peta-tab" href="#v-tabs-peta" role="tab" aria-controls="v-tabs-peta" aria-selected="false">Peta Kampus</a>
                                <br>
                                <h5 class="ps-3 fw-bold">Struktur Organisasi</h5>
                                <a data-mdb-tab-init class="nav-link text" id="v-tabs-pimpinan-tab" href="#v-tabs-pimpinan" role="tab" aria-controls="v-tabs-pimpinan" aria-selected="false">Pimpinan</a>
                                <a data-mdb-tab-init class="nav-link text" id="v-tabs-universitas-tab" href="#v-tabs-universitas" role="tab" aria-controls="v-tabs-universitas" aria-selected="false">Universitas</a>
                                <a data-mdb-tab-init class="nav-link text" id="v-tabs-pimpinan-biro-tab" href="#v-tabs-pimpinan-biro" role="tab" aria-controls="v-tabs-pimpinan-biro" aria-selected="false">Pimpinan Biro</a>
                                <a data-mdb-tab-init class="nav-link text" id="v-tabs-pimpinan-lembaga-tab" href="#v-tabs-pimpinan-lembaga" role="tab" aria-controls="v-tabs-pimpinan-lembaga" aria-selected="false">Pimpinan Lembaga</a>
                                <br>
                                <h5 class="ps-3 fw-bold">Identitas</h5>
                                <a data-mdb-tab-init class="nav-link text" id="v-tabs-arti-lambang-tab" href="#v-tabs-arti-lambang" role="tab" aria-controls="v-tabs-arti-lambang" aria-selected="false">Arti Lambang</a>
                                <a data-mdb-tab-init class="nav-link text" id="v-tabs-mars-tab" href="#v-tabs-mars" role="tab" aria-controls="v-tabs-mars" aria-selected="false">Mars</a>
                                <a data-mdb-tab-init class="nav-link text" id="v-tabs-hymne-tab" href="#v-tabs-hymne" role="tab" aria-controls="v-tabs-hymne" aria-selected="false">Hymne</a>

                            </div>
                            <!-- Tab navs -->
                        </div>


                    </div>
                </div>

            </div>

            <div class="col-md-8 col-lg-9">
                <!-- Tab content -->
                <div class="tab-content" id="v-tabs-tabContent">
                    <!-- Home / sambutan rektor -->
                    <div class="tab-pane fade show active" id="v-tabs-home" role="tabpanel" aria-labelledby="v-tabs-home-tab">
                        <h2>Sambutan Rektor</h2>
                        <img src="https://www.uinsaid.ac.id/files/post/cover/sambutan-rektor-1704698535.jpg" alt="Sambutan Rektor" onerror="this.src='https://www.uinsaid.ac.id/files/no-image.jpg';" class="w-100">
                        <p><strong>Menuju UIN Raden Mas Said Surakarta sebagai Moderate<br />
                                Global-Local Islamic University<br />
                                Oleh: Toto Suharto</strong></p>
                        <p><br />
                            Muhammad al-Quthari dalam Al-Jāmi&rsquo;āt al-Islāmiyyah wa Dawruhā fī Masīrah al-Fikr al-Tarbawiyy (1985) menyebutkan bahwa pembeda antara universitas Islam dengan universitas lainnya terletak pada komponen tujuannya. Tujuan universitas Islam dirumuskan sejalan dengan tujuan ajaran Islam itu sendiri, yaitu &ldquo;membentuk manusia Muslim yang taat beribadah kepada Allah secara total, serta dapat memakmurkan dan memanfaatkan sumber daya alam yang dilimpahkan Allah kepadanya bagi kemaslahatan kehidupan manusia&rdquo;. Dari tujuan yang bersifat idealis ini tampak bahwa universitas Islam sejatinya berusaha mengintegrasikan antara aspek teosentris (ketuhanan: &ldquo;manusia Muslim yang taat beribadah kepada Allah secara total&rdquo;), kosmosentris (kelaman: &ldquo;memakmurkan dan memanfaatkan sumber daya alam yang dilimpahkan Allah&rdquo;), dan antroposentris (kemanusiaan: &ldquo;bagi kemaslahatan kehidupan manusia&rdquo;). Oleh karena itu, penggunaan paradigma integrasi keilmuan teo-anropo-kosmosentrisme (Toto Suharto 2015a), secara praksis dapat menjadi suatu keniscayaan yang dapat dikembangakan di berbagai perguruan tinggi keagamaan Islam (Toto Suharto 2018a), karena memiliki basis epistemologi keilmuan yang jelas.</p>
                        <p>UIN Raden Mas Said Surakarta yang telah bertransformasi secara kelembagaan menjadi UIN sejak 2021, secara geografis, berada di wilayah Solo Raya, yang menurut beberapa kajian berada pada posisi yang &ldquo;rawan&rdquo; bagi muncul dan berkembangnya pemahaman dan tindakan yang dapat mengarah pada radikalisme-ekstremisme (UNUSIA 2019; SETARA Institute 2012; Wildan 2013; Baidhawy 2015 dan Abdil Mughis Mudhoffir 2017). Bahkan Islah Bahrawi dalam suatu Dialog Kebangsaan yang diselenggarakan pada 22 Desember 2022 (YouTube.com) menyebut bahwa Solo menjadi &ldquo;melting pot semua ideologi, termasuk ideologi transnasional&rdquo;. Dengan ini, gagasan menjadikan UIN Raden Mas Said sebagai kampus moderasi bukanlah tanpa alasan yang ilmiah rasional. Terdapat basis sosiologis yang jelas untuk memperkuat moderasi beragama di kampus PTKIN ini (Toto Suharto 2014; 2015b; 2017; 2018b; 2019; dan 2022). Di tambah lagi, saat ini, data mahasiswa semester ganjil 2023/2024 menunjukan jumlah mahasiswa aktif sebanyak 18.393 mahasiswa, yang 60 persen lebih berasal dari mereka yang berlatar belakang pendidikan nonmadrasah-pesantren, sehingga sangat memungkinkan bagi penguatan moderasi beragama di PTKIN ini yang secara nyata masuk dalam 10 besar PTKIN paling banyak peminatnya.</p>
                        <p>Dunia PTKI saat ini memasuki era Masyarakat 5.0 yang tidak dapat melepaskan diri dari pesatnya perkembangan digital, yang tampak bertransformasi dalam bentuk Big Data, Kecerdasan Buatan atau Internter of Things. Dalam konteks ini, mengembangkan universitas Islam yang mengusung moderasi beragama menjadi penting, tapi lebih urgen lagi adalah mengembangkannya menjadi universitas Islam yang berbasis Global-Local, agar dapat berpacu, bersanding dan berkolaborasi dengan universitas-universitas global, dengan tetap mempertahankan lokalitasnya. Menurut Emmanuel Jean- Francois dalam Building Global Education with a Local Perspective: an Introduction to Glocal Higher Education (2015), Glocal University adalah &ldquo;interwoven of the global with the local to design, plan, and deliver higher education programs based on the principles: Think globally, act locally; and think locally, act globally&rdquo;. Sebuah perguruan tinggi Glocal dengan demikian menjadi model alternatif untuk menegembangkan pendidikan global yang melibatkan perpaduan perspektif global dengan perspektif lokal, dalam ranagka mencapai tujuan, sasaran, dan luaran, baik dalam kerangka lokal/nasional, internasional, atau transnasional. Dengan demikian, ke depan, UIN Raden Mas Said Surakarta dapat diarahkan pengembangannya menjadi Moderate Global- Local Islamic University.</p>
                        <p><strong>Pengembangan Tridharma Perguruan Tinggi</strong></p>
                        <p>Dalam rangka pengembangan Moderate Global-Local Islamic University, beberapa program tridharma dapat dicanangkan. Untuk dharma Pendidikan: 1) Standar kompetensi lulusan dapat dirancang mengikuti Skills abad ke-21 dari Forum Ekonomi Dunia, yaitu menyangkut Foundational Literacies, Competencies, dan Character Qualities. Dari SKL ini, Standar Isi (2) dapat memuat mata kuliah seperti Literasi Digital untuk Foundational Literacies, Digitalpreneurship untuk Competencies, dan mata kuliah seperti ilmu-ilmu dasar keislaman, Pancasila, Kewarganegaraan, Bahasa Indonesia, dan Wawasan Moderasi Beragama untuk Character Qualities. Standar Proses (3) dapat diarahkan pada penguatan MBKM, Problem Based Learning, Project Based Learning, serta International Camp untuk menumbuhkan 4Cs (critical thinking, creative, communivative dan collaborative) mahasiswa dan menarik mahasiswa asing. Standar Penilaian (4) dapat dilakukan dengan pengembangan penilaian otentik, penilaian berbasis proyek dan kinerja serta penilaian berbasis proses. Untuk ini, Standar Dosen dan Tendik (5), yang dimiliki saat ini (dosen: 318 PNS, 68 DTNP, 14 GB, 56 LK; tendik: 60 PNS, 162 kontrak) dapat dikuatkan dengan penambahan dosen, internasionalisasi dosen, percepatan GB, sertifikasi kompetensi dosen, literasi digital tendik, serta penguatan Moderasi Beragama dosen dan tendik. Adapun Standar Sarpras (6) yang dimiliki saat ini, yaitu tanah seluas 9.3 ha, 8 gedung untuk 22.679 mahasiswa S1, S2 dan S3, perlu dikembangkan melalui penambahan lahan dan gedung, serta pemenuhan sarana digital dan nondigital untuk penguatan BLU berbasis Green Campus. Untuk Standar Pengelolaan (7), penguatan otonomi BLU yang transparan dan akuntabel menuju Good University Governance menjadi tawaran niscaya dalam rangka pengembangan Integrated Digital Servieces. Terkait Standar Pembiayaan (8) yang diperoleh dari PNBP, RM, dan BOPT dapat dikembangkan dengan penguatan aset BLU nonakademik yang dapat diperoleh melalui kerja sama lokal-nasional-internasional, seperti pengembangan poliklinik, pendirian pom bensin, pendirian Said Market, serta kewirausahaan digital yang relevan.</p>
                        <p>Sementara itu, untuk dharma penelitian, baik standar hasil penelitian, isi penelitian, proses penelitian, penilaian penelitian, standar peneliti, standar sarpras penelitian, standar pengelolaan penelitian, dan standar pendanaan dan pembiayaan penelitian, dapat dikembangkan arah dan kebijakannya melalui<br />
                            pengembangan penelitian multidisiplin, interdisiplin dan transdisiplin berbasis lokal sesuai keilmuan Dosen dari BOPT, Penelitian mandatori keilmuan berbasis integrasi dari BLU, Penelitian kolaborasi dengan Lembaga mitra nasioonal dan internasional, academic writing untuk publikasi internasional, konferensi internasional tahunan bekerja sama dengan lembaga indeksasi internasional, penerbitan karya ilmiah dalam bahasa nasional dan internasional, Penguatan jurnal ilmiah agar terindeks Sinta dan pengindeks internasional, Penguatan dan Pengembangan Paten dan HKI, serta Literasi Big Data dan Kecerdasan Buatan untuk penguatan etika penelitian.</p>
                        <p>Adapun untuk dhrama pengabdian, arah dan pengembangannya dapat dilakukan melalui KKN standar internasional kerja sama mitra, Pertukaran dosen dan mahasiswa dalam pengabdian internasional Kerja Sama Mitra, Pelibatan mahasiswa dalam pengabdian dosen, Pengembangan pengabdian berbasis riset keilmuan Prodi, Peningkatan model-model pengabdian sesuai bidang keilmuan, Peningkatan Anggaran Pengabdian dari BLU, serta Penguatan Jurnal Pengabdian.</p>
                        <p>Semua kebijakan dan program kerja Tridharma di atas dikembangkan dan diimplementasikan dalam rangka Glokalisasi UIN Raden Mas Siad Surakarta, dengan mengikuti Tahapan RIP, yaitu dari Tahapan Tanggap UIN Raden Mas Said Surakarta sebagai creative university pada 2020-2024, menuju Tahapan Tangguh UIN Raden Mas Said Surakarta sebagai competitive university pada 2025-2029. Semoga gagasan menuju UIN Raden Mas Said Surakarta sebagai Moderate Global-Local Islamic University dapat diwujudkan secara bersama sivitas academica, melalui tradisi Konsolidasi, Mobilisasi dan Orkestrasi (KMO), sebagaimana yang sudah berjalan selama ini.</p>
                        <p>&nbsp;</p>
                    </div>

                    <!-- Sejarah -->
                    <div class="tab-pane fade" id="v-tabs-sejarah" role="tabpanel" aria-labelledby="v-tabs-sejarah-tab">
                        <h2>Sejarah</h2>
                        <img src="https://www.uinsaid.ac.id/files/post/cover/sejarah-1708064732.jpeg" alt="Sejarah" class="w-100">
                        <br />
                        <p>Universitas Islam Negeri (UIN) Raden Mas (RM) Said Surakarta sebelumnya adalah IAIN Surakarta sebelumnya pula adalah STAIN Surakarta yang berlokasi di Kartasura, Sukoharjo. STAIN Surakarta yang berdiri sejak 30 Juni 1997 (25 Safar 1418 H) awalnya berasal dari IAIN Walisongo di Surakarta yang berdiri pada 12 September 1992. Berdirinya IAIN Walisongo di Surakarta ini merupakan gagasan H. Munawir Sadzali, MA.&mdash;yang waktu itu menjabat sebagai Menteri Agama Republik Indonesia&mdash; sebagai pilot project untuk memperbaiki mutu IAIN yang sudah ada dan dianggap belum ideal serta masih banyak memerlukan pembenahan. Harapan H. Munawir Sadzali, MA waktu itu adalah agar IAIN Walisongo di Surakarta mampu menampilkan diri sebagai IAIN unggulan yang mencetak para lulusan berdaya saing tinggi dan memiliki prestasi-prestasi akademik yang diakui oleh lembaga-lembaga yang kredibel. Kemudian IAIN Walisongo yang Berada di Surakarta diberikan nama STAIN Surakarta. Lalu STAIN Surakarta beralih status menjadi&nbsp; IAIN Surakarta yang disahkan melalui Peraturan Presiden No. 1 Tahun 2011.</p>
                        <p>Itulah sebabnya, input mahasiswa IAIN Walisongo di Surakarta berasal dari para lulusan &nbsp;MANPK &nbsp; (Madrasah Aliyah Negeri Program Khusus &nbsp;dari &nbsp;seluruh &nbsp;Indonesia) sebuah input mahasiswa yang sangat unggul dan pilihan serta diharapkan menjadi pilot project. Namun selama lebih kurang 5 tahun IAIN Walisongo di Surakarta berjalan, pada 30 Juni 1997 melalui kebijakan Menteri Agama yang baru waktu itu, Drs. Malik Fadjar, M.Sc. IAIN Walisongo di Surakarta ini diubah menjadi Sekolah Tinggi Agama Islam Negeri (STAIN) Surakarta. Kebijakan ini juga menetapkan seluruh fakultas filial (fakultas daerah) seperti Fakultas Syari&rsquo;ah di Pekalongan dan Fakultas Ushuludin di Kudus yang tadinya telah direlokasi ke Surakarta menjadi STAIN Pekalongan dan STAIN Kudus.</p>
                        <p>Kebijakan Menteri Agama waktu itu Drs. Malik Fadjar, M.Sc. diambil untuk mengembalikan fakultas-fakultas filial, termasuk STAIN Surakarta, dapat menjadi kebanggaan umat Islam di daerah dan dapat berkembang sesuai dengan potensi lokal yang dimiliki. Nampaknya, kebijakan Menteri Agama tentang pendirian fakultas-fakultas daerah menjadi STAIN, terutama sekali STAIN Surakarta, memberikan semacam blessing in disguise (berkah tersembunyi). &nbsp;Melalui kerja keras dan usaha terus-menerus ke arah peningkatan mutu akademik selama 13 tahun, akhirnya pada 3 Januari 2011 STAIN Surakarta bertransformasi menjadi IAIN Surakarta dengan tiga fakultas, yakni: Fakultas Ushuludin dan Dakwah, Fakultas Syari&rsquo;ah dan Ekonomi Islam, serta Fakultas Tarbiyah dan Bahasa. Peralihan ini, sungguh merupakan suatu kebahagiaan dan kebanggaan bagi seluruh civitas akademika dan seluruh masyarakat Islam di Surakarta. Kebanggaan makin bertambah ketika pada 28 Juli 2011 IAIN Surakarta diresmikan oleh Menteri Agama Drs. H. Suryadharma Ali, M.Si sekaligus pelantikan Rektor yang pertama tanpa hambatan apapun. Dengan demikian, peralihan ini merupakan amanah yang harus diemban dengan penuh tanggung jawab dan harus terus dijadikan moment of truth bagi IAIN Surakarta untuk memerankan diri sebagai agent of Islamization dan agent of social change.</p>
                        <p>Selanjutnya, dengan statusnya yang baru IAIN Surakarta yang memiliki potensi-potensi di antaranya: potensi sejarah (memiliki sejarah panjang peradaban Jawa), letak geografis (terletak di segi tiga emas: Yogyakarta-Semarang/Salatiga-Surabaya ditambah tersedianya Bandar Udara Internasional Adisumarmo), dan sumber-sumber daya manusia yang melimpah (karena berdekatan dengan lembaga-lembaga perguruan tinggi di sekitarnya), maka pengembangannya ke depan sangat dimungkinkan dan memiliki peluang terbuka. Argumen ini ditunjukkan melalui catatan atau data lulusan yang sejak berdirinya pada 12 September 1992 hingga 2011/2012 lembaga ini telah meluluskan lebih kurang 13.000 mahasiswa. Data yang lainnya juga dapat disebutkan oleh fakta bahwa dari tahun ke tahun animo mahasiswa yang memilih studi di IAIN Surakarta terus meningkat. Kini dengan memiliki 23 Program Studi S1, 4 Program Studi di S2 dan 1 Program Studi Doktoral S3 di Pasacasarjana) serta persiapan pembukaan program studi-program studi lain yang relevan dengan tuntutan-tuntutan masyarakat pendidikan, maka IAIN Surakarta diharapkan mampu mengemban amanah alih status ke arah yang lebih baik dan lebih berkapasitas.</p>
                        <p>Berkembangnya IAIN Surakarta akhirnya menginisiasi berdirinya Universitas Islam Negeri (UIN) Raden Mas (RM) Said Surakarta sebagai lembaga pendidikan yang dapat memberikan kemanfaatan lebih luas untuk masyarakat.&nbsp; Universitas Islam Negeri (UIN) Raden Mas (RM) Said Surakarta yang selanjutnya disebut UIN RM Said Surakarta adalah perguruan tinggi keagamaan yang diselenggarakan oleh Kementerian Agama RI yang menyelenggarakan urusan pemerintahan di bidang agama,berada di bawah dan bertanggungjawab kepada Menteri Agama RI.&nbsp;</p>
                    </div>

                    <!-- Profil -->
                    <div class="tab-pane fade" id="v-tabs-profil" role="tabpanel" aria-labelledby="v-tabs-profil-tab">
                        <h2>Profil Universitas</h2>
                        <img src="https://www.uinsaid.ac.id/files/post/cover/profil-universitas-1708058171.jpeg" alt="Profil Universitas" class="w-100">
                        <br />
                        <p>Universitas Islam Negeri (UIN) Raden Mas (RM) Said Surakarta sebelumnya adalah IAIN Surakarta sebelumnya pula adalah STAIN Surakarta yang berlokasi di Kartasura, Sukoharjo. STAIN Surakarta yang berdiri sejak 30 Juni 1997 (25 Safar 1418 H) awalnya berasal dari IAIN Walisongo di Surakarta yang berdiri pada 12 September 1992. Berdirinya IAIN Walisongo di Surakarta ini merupakan gagasan H. Munawir Sadzali, MA.&mdash;yang waktu itu menjabat sebagai Menteri Agama Republik Indonesia&mdash; sebagai pilot project untuk memperbaiki mutu IAIN yang sudah ada dan dianggap belum ideal serta masih banyak memerlukan pembenahan. Harapan H. Munawir Sadzali, MA waktu itu adalah agar IAIN Walisongo di Surakarta mampu menampilkan diri sebagai IAIN unggulan yang mencetak para lulusan berdaya saing tinggi dan memiliki prestasi-prestasi akademik yang diakui oleh lembaga-lembaga yang kredibel. Kemudian IAIN Walisongo yang Berada di Surakarta diberikan nama STAIN Surakarta. Lalu STAIN Surakarta beralih status menjadi&nbsp; IAIN Surakarta yang disahkan melalui Peraturan Presiden No. 1 Tahun 2011.</p>
                        <p>Itulah sebabnya, input mahasiswa IAIN Walisongo di Surakarta berasal dari para lulusan &nbsp;MANPK (Madrasah Aliyah Negeri Program Khusus &nbsp;dari &nbsp;seluruh &nbsp;Indonesia) sebuah input mahasiswa yang sangat unggul dan pilihan serta diharapkan menjadi pilot project. Namun selama lebih kurang 5 tahun IAIN Walisongo di Surakarta berjalan, pada 30 Juni 1997 melalui kebijakan Menteri Agama yang baru waktu itu, Drs. Malik Fadjar, M.Sc. IAIN Walisongo di Surakarta ini diubah menjadi Sekolah Tinggi Agama Islam Negeri (STAIN) Surakarta. Kebijakan ini juga menetapkan seluruh fakultas filial (fakultas daerah) seperti Fakultas Syari&rsquo;ah di Pekalongan dan Fakultas Ushuludin di Kudus yang tadinya telah direlokasi ke Surakarta menjadi STAIN Pekalongan dan STAIN Kudus.</p>
                        <p>Kebijakan Menteri Agama waktu itu Drs. Malik Fadjar, M.Sc. diambil untuk mengembalikan fakultas-fakultas filial, termasuk STAIN Surakarta, dapat menjadi kebanggaan umat Islam di daerah dan dapat berkembang sesuai dengan potensi lokal yang dimiliki. Nampaknya, kebijakan Menteri Agama tentang pendirian fakultas-fakultas daerah menjadi STAIN, terutama sekali STAIN Surakarta, memberikan semacam blessing in disguise (berkah tersembunyi). &nbsp;Melalui kerja keras dan usaha terus-menerus ke arah peningkatan mutu akademik selama 13 tahun, akhirnya pada 3 Januari 2011 STAIN Surakarta bertransformasi menjadi IAIN Surakarta dengan tiga fakultas, yakni: Fakultas Ushuludin dan Dakwah, Fakultas Syari&rsquo;ah dan Ekonomi Islam, serta Fakultas Tarbiyah dan Bahasa. Peralihan ini, sungguh merupakan suatu kebahagiaan dan kebanggaan bagi seluruh civitas akademika dan seluruh masyarakat Islam di Surakarta. Kebanggaan makin bertambah ketika pada 28 Juli 2011 IAIN Surakarta diresmikan oleh Menteri Agama Drs. H. Suryadharma Ali, M.Si sekaligus pelantikan Rektor yang pertama tanpa hambatan apapun. Dengan demikian, peralihan ini merupakan amanah yang harus diemban dengan penuh tanggung jawab dan harus terus dijadikan moment of truth bagi IAIN Surakarta untuk memerankan diri sebagai <em>agent of Islamization dan agent of social change</em>.</p>
                        <p>Selanjutnya, dengan statusnya yang baru IAIN Surakarta yang memiliki potensi-potensi di antaranya: potensi sejarah (memiliki sejarah panjang peradaban Jawa), letak geografis (terletak di segi tiga emas: Yogyakarta-Semarang/Salatiga-Surabaya ditambah tersedianya Bandar Udara Internasional Adisumarmo), dan sumber-sumber daya manusia yang melimpah (karena berdekatan dengan lembaga-lembaga perguruan tinggi di sekitarnya), maka pengembangannya ke depan sangat dimungkinkan dan memiliki peluang terbuka. Argumen ini ditunjukkan melalui catatan atau data lulusan yang sejak berdirinya pada 12 September 1992 hingga 2011/2012 lembaga ini telah meluluskan lebih kurang 13.000 mahasiswa. Data yang lainnya juga dapat disebutkan oleh fakta bahwa dari tahun ke tahun animo mahasiswa yang memilih studi di IAIN Surakarta terus meningkat. Kini dengan memiliki 23 Program Studi S1, 4 Program Studi di S2 dan 1 Program Studi Doktoral S3 di Pasacasarjana) serta persiapan pembukaan program studi-program studi lain yang relevan dengan tuntutan-tuntutan masyarakat pendidikan, maka IAIN Surakarta diharapkan mampu mengemban amanah alih status ke arah yang lebih baik dan lebih berkapasitas.</p>
                        <p>Berkembangnya IAIN Surakarta akhirnya menginisiasi berdirinya Universitas Islam Negeri (UIN) Raden Mas (RM) Said Surakarta sebagai lembaga pendidikan yang dapat memberikan kemanfaatan lebih luas untuk masyarakat.&nbsp; Universitas Islam Negeri (UIN) Raden Mas (RM) Said Surakarta yang selanjutnya disebut UIN RM Said Surakarta adalah perguruan tinggi keagamaan yang diselenggarakan oleh Kementerian Agama RI yang menyelenggarakan urusan pemerintahan di bidang agama,berada di bawah dan bertanggungjawab kepada Menteri Agama RI.&nbsp;</p>
                        <p>UIN RM Said Surakarta kini berkembang bukan hanya secara fisik melainkan juga secara fasilitas terus berkembang. Secara fisik, UIN RM Said Surakarta terbagi menjadi beberapa tempat yakni:<br />
                            Kampus 1 di tempat yang sama yakni beralamat di Jl. Pandawa, Pucangan, Kartasura, Sukoharjo.<br />
                            Kampus 2 beralamat di Jl. Pakis-Wonosari, Kepanjen, Delanggu, Klaten</p>
                    </div>

                    <!-- Visi misi -->
                    <div class="tab-pane fade" id="v-tabs-visi" role="tabpanel" aria-labelledby="v-tabs-visi-tab">
                        <h2>Visi Misi</h2>
                        <p><b id="docs-internal-guid-38c374e8-7fff-2938-87df-e485bf6b90ec">UNIVERSITAS ISLAM NEGERI RADEN MAS SAID SURAKARTA</b></p>
                        <p>
                            <meta charset="utf-8" />
                        </p>
                        <p dir="ltr">
                            <meta charset="utf-8" />
                        </p>
                        <p dir="ltr">
                            <meta charset="utf-8" />
                        </p>
                        <p dir="ltr"><strong>VISI</strong><br />
                            Menjadi Universitas Islam Unggul dan Inovatif untuk Mewujudkan Masyrarakat Indonesia Maju Berkeadaban pada 2034.</p>
                        <p dir="ltr"><strong>MISI</strong></p>
                        <ol dir="ltr">
                            <li>Menyelenggarakan pendidikan pengajaran keilmuan keislaman, sains, teknologi dan seni yang berwawasan lingkungan dan lokalitas untuk mewujudkan masyarakat Indonesia maju yang berkeadaban.</li>
                            <li>Mengembangkan tradisi ilmiah melalui penelitian transdisiplin dan publikasi ilmiah bagi penguatan inovasi ilmu pengetahuan dan teknologi.</li>
                            <li>Meningkatkan kontribusi universitas bagi pemberdayaan kesejahteraan masyarakat</li>
                            <li>Meningkatkan kerja sama nasional dan internasional dalam bidang pendidikan pengajaran, penelitian, publikasi ilmiah dan pengabdian masyarakat untuk menciptakan tatanan dunia yang damai dan bermartabat.</li>
                        </ol>
                        <p dir="ltr"><strong>TUJUAN</strong></p>
                        <ol dir="ltr">
                            <li>Menghasilkan lulusan berdaya saing tinggi dan profesional dalam bidang keislaman, sains, teknologi dan seni yang berkarakter ibadurrahman.</li>
                            <li>Menghasilkan temuan-temuan penelitian transdisiplin dan publikasi ilmiah untuk inovasi ilmu pengetahuan dan teknologi.</li>
                            <li>Menghasilkan produk-produk pengabdian kepada masyarakat untuk pemberdayaan kesejahteraan masyarakat.</li>
                            <li>Memperluas kemitraan strategis nasional dan internasional dalam bidang pendidikan pengajaran, penelitian, publikasi ilmiah dan pengabdian masyarakat untuk penguatan layanan dan kontribusi universitas.<br />
                                &nbsp;</li>
                        </ol>
                    </div>

                    <!-- Peta -->
                    <div class="tab-pane fade" id="v-tabs-peta" role="tabpanel" aria-labelledby="v-tabs-peta-tab">
                        <h2>Peta Kampus</h2>
                        <p><iframe allowfullscreen height="650" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1977.5744115985945!2d111.45637101356911!3d-7.558747306834314!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a14c215cc8bbd%3A0x27c268341f7725a!2sUniversitas%20Islam%20Negeri%20Raden%20Mas%20Said%20Surakarta!5e0!3m2!1sid!2sid!4v1708316194843!5m2!1sid!2sid" style="border:0;" width="100%"></iframe></p>
                    </div>

                    <!-- Pimpinan -->
                    <div class="tab-pane fade" id="v-tabs-pimpinan" role="tabpanel" aria-labelledby="v-tabs-pimpinan-tab">
                        <h1>Struktur Organisasi</h1>
                        <p><img alt src="https://www.uinsaid.ac.id/files/upload/STRUKTUR ORGANISASI UIN RM SAID SURAKARTA.png" width="100%" /></p>
                    </div>

                    <!-- Universitas -->
                    <div class="tab-pane fade" id="v-tabs-universitas" role="tabpanel" aria-labelledby="v-tabs-universitas-tab">

                    </div>

                    <!-- Pimpinan biro -->
                    <div class="tab-pane fade" id="v-tabs-pimpinan-biro" role="tabpanel" aria-labelledby="v-tabs-pimpinan-biro-tab">

                    </div>

                    <!-- Pimpinan lembaga -->
                    <div class="tab-pane fade" id="v-tabs-pimpinan-lembaga" role="tabpanel" aria-labelledby="v-tabs-pimpinan-lembaga-tab">

                    </div>

                    <!-- Arti lambang -->
                    <div class="tab-pane fade" id="v-tabs-arti-lambang" role="tabpanel" aria-labelledby="v-tabs-arti-lambang-tab">
                        <h2>Arti Lambang</h2>
                        <img src="https://www.uinsaid.ac.id/files/post/cover/arti-lambang-1708069659.png" alt="Arti Lambang" class="w-100">
                        <ol>
                            <li aria-level="1" dir="ltr">
                                <p dir="ltr" role="presentation"><b id="docs-internal-guid-8a616a7c-7fff-b61b-d781-716e369da6ea">Lambang Universitas sebagaimana dimaksud pada ayat</b></p>
                                <ol>
                                    <li aria-level="2" dir="ltr">
                                        <p dir="ltr" role="presentation"><b id="docs-internal-guid-8a616a7c-7fff-b61b-d781-716e369da6ea">terdiri atas unsur yang memiliki makna:</b></p>
                                        <ol>
                                            <li aria-level="3" dir="ltr">
                                                <p dir="ltr" role="presentation"><b id="docs-internal-guid-8a616a7c-7fff-b61b-d781-716e369da6ea">bintang segi delapan yang berada di atas buku terbuka, bermakna pengaplikasian Al-Qur&rsquo;an dalam berdakwah, menyebarkan Islam berikut ilmu pengetahuannya ke delapan penjuru arah mata angin. Bintang segi delapan juga menggambarkan kejayaan, kemajuan, dan kemakmuran yang hendak dicapai dan dibangun oleh Universitas sebagai perguruan tinggi yang terkemuka dan kompetitif dalam pengembangan ilmu pengetahuan, teknologi, dan seni;</b></p>
                                            </li>
                                            <li aria-level="3" dir="ltr">
                                                <p dir="ltr" role="presentation"><b id="docs-internal-guid-8a616a7c-7fff-b61b-d781-716e369da6ea">bintang segi delapan ini merupakan hasil perputaran geometri bujur sangkar dari rubu&rsquo; al-hizb dari Al-Qur&rsquo;an yang menjadi elemen dalam simbol lambang;</b></p>
                                            </li>
                                            <li aria-level="3" dir="ltr">
                                                <p dir="ltr" role="presentation"><b id="docs-internal-guid-8a616a7c-7fff-b61b-d781-716e369da6ea">Rubu&rsquo; al hizb yang dibentuk melalui proses perputaran geometri melambangkan integrasi dan interkoneksi semua elemen yang ada sehingga mampu bersinergi;</b><br />
                                                    <br />
                                                    <b><img alt height="134" src="https://lh7-us.googleusercontent.com/gOtHne33cVVk7I4K_BMrEMEKZ2P7XoZPrKxJLfhHGObOJNadiwJppFRqm3t9seRI_WJ18Z1XGrwczyBH2YMIPe3AkEx3rYIUV6xdwxJIkr3wXIzQmL2MKdDa45fXPgL3O5C4k2iKKgqPyLcn8HeIJeQ" width="139" /><br />
                                                        &nbsp;</b>
                                                </p>
                                            </li>
                                            <li aria-level="3" dir="ltr">
                                                <p dir="ltr" role="presentation"><b id="docs-internal-guid-8a616a7c-7fff-b61b-d781-716e369da6ea">Komponen yang terkandung dalam rubu&rsquo; al-hizb merupakan trilogos yaitu theos (Allah), anthropos (manusia) dan kosmos (alam), menggambarkan tiga relasi suci yang merupakan tema pokok Al-Qur&#39;an;<br />
                                                        <img alt height="123" src="https://lh7-us.googleusercontent.com/pEkuIg7FdiNtlfUvwM1wtj4drWM82_tzlGieKHwF_Fp_wFfgemFHQqopDsVw5WIQC0aGNcpQG5ZllNhQ1jF-_LxYiQrd0AognUqEwvZ6b9iUHzXr_gqP1K8ZYi3Tpp28XA7zbTzgJZ2plRUkNNAugQc" width="135" /><br />
                                                        &nbsp;</b></p>
                                            </li>
                                            <li aria-level="3" dir="ltr">
                                                <p dir="ltr" role="presentation"><b id="docs-internal-guid-8a616a7c-7fff-b61b-d781-716e369da6ea">Garis puncak melambangkan Allah sebagai pusat tujuan, dua garis yang berdampingan menggambarkan harmonisasi, garis kiri menggambarkan manusia sebagai abdullah sekaligus khalifatullah fil ardh dan garis kanan menggambarkan alam semesta yang merupakan wahana manusia dalam membangun peradaban;<br />
                                                        <img alt height="158" src="https://lh7-us.googleusercontent.com/boUBcNOww5KM_nQ_Cd8jkzF37YhLmiBAnlLXMyQZRlVHEUnw3MaI7aA52ot-5UB_ot6r78zPcnFdHM5eVFkl6HgW-LQFInAXObu_dUCm5FRAqXufbWlNe8FOgWw0kmau-aMaokP_xmyA9Z5wE52Juwc" width="115" /><br />
                                                        &nbsp;</b></p>
                                            </li>
                                            <li aria-level="3" dir="ltr">
                                                <p dir="ltr" role="presentation"><b id="docs-internal-guid-8a616a7c-7fff-b61b-d781-716e369da6ea">Dua garis yang membentuk buku terbuka melambangkan kitab Al-Qur&rsquo;an dan Hadis sebagai the book of guidance yang mencakup harmonisasi dari relasi trilogi suci; Allah, manusia, dan alam semesta, serta buku yang terbuka juga menggambarkan sumber ilmu pengetahuan yang bersifat dinamis, terus mengalir, dan tumbuh berkembang;<br />
                                                        <img alt height="160" src="https://lh7-us.googleusercontent.com/fhu0cwa5IpAEgajiSmchFThBjjSkZKndODM9nVUaecmPyeqGWp5mxkjz5hCnQU9H76c2DCV68E-2t9BM_WwWNf0VJ19L-jd-OSDdahNAcj0j1A6j6ogxjqVYdmr5HGWgx5FUNsFUhSMEUb_duTxvGv0" width="119" /><br />
                                                        &nbsp;</b></p>
                                            </li>
                                            <li aria-level="3" dir="ltr">
                                                <p dir="ltr" role="presentation"><b id="docs-internal-guid-8a616a7c-7fff-b61b-d781-716e369da6ea">Garis lurus horizontal kemudian ke atas (sebelah kiri) menggambarkan hablum minannas yaitu mal shaleh, dedikasi, pengabdian, dan tindakan baik melalui penalaran deduktif maupun induktif, melalui pendidikan, penelitian, dan pengabdian (tridharma perguruan tinggi), serta garis vertikal melambangkan hablum minallah;</b></p>
                                            </li>
                                            <li aria-level="3" dir="ltr">
                                                <p dir="ltr" role="presentation"><b id="docs-internal-guid-8a616a7c-7fff-b61b-d781-716e369da6ea">Garis dari atas kemudian menjadi datar (sebelah kanan) menggambarkan buah atau hasil dari penerapan amal sholeh, dedikasi, pengabdian yang berujung pada kebahagiaan dan kesejahteraan umat manusia dan lingkungan.<br />
                                                        <img alt height="77" src="https://lh7-us.googleusercontent.com/lh7RhlBsdu2762fSxUnPVJIZe8b-zrP-y2CrP_UVucxwi743WrOvObhnWIgUomSpneSTbV6s0eqpnQa7_B8yv___jLpZCOVjc4t-J5da1UGYGvhJ2PkW_4Lx7nMbya3hPAHr-V4DfwffqzcWc49VCMk" width="222" /><br />
                                                        &nbsp;</b></p>
                                            </li>
                                            <li aria-level="3" dir="ltr">
                                                <p dir="ltr" role="presentation"><b id="docs-internal-guid-8a616a7c-7fff-b61b-d781-716e369da6ea">Huruf UIN berbentuk buku yang terbuka, yang merupakan simbol lembaga pendidikan.</b></p>
                                            </li>
                                            <li aria-level="3" dir="ltr">
                                                <p dir="ltr" role="presentation"><b id="docs-internal-guid-8a616a7c-7fff-b61b-d781-716e369da6ea">Kode gradasi warna pada lambang Universitas:</b></p>
                                                <ol>
                                                    <li aria-level="4" dir="ltr">
                                                        <p dir="ltr" role="presentation"><b id="docs-internal-guid-8a616a7c-7fff-b61b-d781-716e369da6ea">Warna hijau atau pantone 356C C100, Y100, K37 (kode gradasi #007A33) melambangkan kehidupan, pembangunan, kreativitas, dan keberlanjutan;</b></p>
                                                    </li>
                                                    <li aria-level="4" dir="ltr">
                                                        <p dir="ltr" role="presentation"><b id="docs-internal-guid-8a616a7c-7fff-b61b-d781-716e369da6ea">Warna hijau atau pantone 376C C50, Y100 (kode gradasi #7dba00) melambangkan ketenangan, keseimbangan, harmoni; dan</b></p>
                                                    </li>
                                                    <li aria-level="4" dir="ltr">
                                                        <p dir="ltr" role="presentation"><b id="docs-internal-guid-8a616a7c-7fff-b61b-d781-716e369da6ea">Warna orange M40, Y80 (kode gradasi #F5A33E) menggambarkan kejayaan, kesuksesan, dan kemakmuran.</b></p>
                                                    </li>
                                                </ol>
                                            </li>
                                        </ol>
                                    </li>
                                </ol>
                            </li>
                        </ol>
                        <p>&nbsp;</p>
                    </div>

                    <!-- Mars -->
                    <div class="tab-pane fade" id="v-tabs-mars" role="tabpanel" aria-labelledby="v-tabs-mars-tab">

                    </div>

                    <!-- Hymne -->
                    <div class="tab-pane fade" id="v-tabs-hymne" role="tabpanel" aria-labelledby="v-tabs-hymne-tab">

                    </div>
                </div>
                <!-- Tab content -->

            </div>

        </div>
    </div>
</section>
<!-- Section Tentang Kami -->

<!-- Section CTNA -->
<section class="fluid section-batik" id="akademik">
    <div class="container p-5">
        <div class="row d-flex align-items-center g-5">

            <!-- Picture grid column -->
            <div class="col-lg-6">

                <!-- Picture grid -->
                <div class="row g-0">
                    <div class="col">
                        <img class="" style="border-radius: 5rem; width: 100%; max-height: 512px;object-fit: contain;" src="assets/img/foto-rektor-wisuda.png" />
                    </div>
                </div>

            </div>

            <!-- Akademik column -->
            <div class="col-lg-6">
                <h1 class="pb-2 fw-bold">
                    Lorem Ipsum is simply dummy
                    text of the printing
                </h1>
            </div>

        </div>
    </div>
</section>
<!-- Section CTNA -->

<?= $this->endSection() ?>

<?= $this->section('script') ?>

<?= $this->endSection() ?>