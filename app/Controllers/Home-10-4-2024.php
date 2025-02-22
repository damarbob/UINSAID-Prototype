<?php

namespace App\Controllers;

use function App\Helpers\format_tanggal;
use function App\Helpers\format_tanggal_suatu_kolom;

class Home extends BaseController
{
    public function index()
    {
        helper('format');
        $this->data['heroTerbaru'] = [
            [
                "kategori"              => "",
                "judul"                 => "UIN Raden Mas Said",
                "slug"                  => "",
                "meta_description"      => "Dengan sejarahnya yang kaya dan potensinya yang melimpah, UIN Raden Mas Said Surakarta siap melangkah ke masa depan yang lebih cerah",
                "featured_image"        => base_url("assets/img/hero-oranye.jpg"),
                "featured_image_mobile" => base_url("assets/img/hero-oranye-mobile.jpg"),
                "tgl_terbit_terformat"  => ""
            ],
            [
                "kategori"              => "",
                "judul"                 => "UIN Raden Mas Said",
                "slug"                  => "",
                "meta_description"      => "Dengan sejarahnya yang kaya dan potensinya yang melimpah, UIN Raden Mas Said Surakarta siap melangkah ke masa depan yang lebih cerah",
                "featured_image"        => base_url("assets/img/akademik.jpeg"),
                "featured_image_mobile"        => base_url("assets/img/akademik.jpeg"),
                "tgl_terbit_terformat"  => ""
            ],
            [
                "kategori"              => "",
                "judul"                 => "UIN Raden Mas Said",
                "slug"                  => "",
                "meta_description"      => "Dengan sejarahnya yang kaya dan potensinya yang melimpah, UIN Raden Mas Said Surakarta siap melangkah ke masa depan yang lebih cerah",
                "featured_image"        => base_url("assets/img/wisuda.jpeg"),
                "featured_image_mobile"        => base_url("assets/img/wisuda.jpeg"),
                "tgl_terbit_terformat"  => ""
            ],
            [
                "kategori"              => "",
                "judul"                 => "Catat, UIN RM Said Masuk Jajaran Top 10 PTKIN",
                "slug"                  => "https://www.uinsaid.ac.id/id/catat-uin-rm-said-masuk-jajaran-top-10-ptkin",
                "meta_description"      => "Masuknya nama UIN RM Said Surakarta di rangking 9 PTKIN dengan rerata nilai UTBK tertinggi tahun 2024 mengindikasikan bahwa pendaftar untuk kuliah di kampus ini memiliki latar belakang dalam bidang akademik yang cukup bagus.",
                "featured_image"        => base_url("assets/img/uin-raden-mas-said.png"),
                "featured_image_mobile"        => base_url("assets/img/uin-raden-mas-said.png"),
                "tgl_terbit_terformat"  => ""
            ]
        ];

        $this->data['poinUtama'] = [
            [
                'judul'         => '16 Program Studi Terakreditasi Unggul dan A',
                'keterangan'    => 'Terdapat 16 Program Studi terakreditasi Unggul dan A di UIN Raden Mas Said Surakarta'
            ],
            [
                'judul'         => 'TOP 9 PTKIN dengan Minat Tertinggi',
                'keterangan'    => 'UIN Raden Mas Said Surakarta masuk Top Rank 9 peminatan tertinggi pendaftar jalur UMPTKIN tahun 2024 '
            ],
            [
                'judul'         => '30 Rank Perguruan Tinggi Keagamaan Islam Negeri',
                'keterangan'    => 'Menduduki peringkat 30 versi Webometrics 2023 dari 59 PTKIN'
            ]
        ];

        $this->data['sambutanRektor'] = [
            'judul'       => 'Panca Amanat “LURIK” dalam Mensukseskan Glokalisasi',
            'sambutan'    => 'LURIK yang berakronim “Loyal, Unggul, Responsif, Inovatif dan Kolaboratif” LURIK pertama adalah Loyal, yang menuntut para pejabat untuk memiliki sikap loyal terhadap Negara Kesatuan Republik Indonesia (NKRI), Kementerian Agama, dan UIN Raden Mas Said Surakarta. <br><br>LURIK kedua adalah Unggul, mengajak para pejabat untuk bekerja maksimal dan optimal, serta sekuat tenaga meraih keunggulan lembaga, dengan cara melakukan Konsolidasi, Mobilisasi dan Orkestrasi (KMO) dengan pimpinan di lembaga masing-masing,untuk merencanakan program-program unggulan dalam rangka Glokalisasi UIN Raden Mas Said Surakarta.',
            'link'        => base_url('tentang-kami'),
        ];

        $this->data['poinAkademik'] = [
            [
                'gambar'        => 'assets/img/mahasiswa/mahasiswa-1.png',
                'judul'         => 'Program Studi',
                'keterangan'    => 'Berbagai program  pendidikan sarjana, spesialis, magister, dan doktoral tersedia  sesuai minat Anda untuk mendukung karir dan keahlian profesional di masa  depan.',
                'link'          => base_url('pendidikan'),
            ],
            [
                'gambar'        => 'assets/img/mahasiswa/mahasiswa-2.png',
                'judul'         => 'Pendaftaran Mahasiswa Baru',
                'keterangan'    => 'Penerimaan mahasiswa tahun akademik baru sudah dibuka. klik slengkapnya untuk Informasi jalur  penerimaan dan jadwal penerimaan mahasiswa, serta pendaftaran online  calon mahasiswa baru',
                'link'          => 'https://admisi.uinsaid.ac.id/id',
            ],
            [
                'gambar'        => 'assets/img/mahasiswa/mahasiswa-3.png',
                'judul'         => 'Informasi Beasiswa',
                'keterangan'    => 'Beasiswa diberikan kepada mahasiswa/i yang memiliki prestasi akademik  yang berkomitmen dalam berbagai kegiatan ekstrakurikuler,  dan memenuhi kriteria-kriteria tertentu sesuai dengan ketentuan yang  berlaku.',
                'link'          => 'https://siakad.uinsaid.ac.id/0/index.php/news/beasiswa-b2p5V0tsVzNIYmtITHpjZHNNMys5QzVsaDA9QWlzdEwwb05ZL0pheUc0R3k=',
            ],
            [
                'gambar'        => 'assets/img/mahasiswa/mahasiswa-4.png',
                'judul'         => 'Informasi Layanan',
                'keterangan'    => 'Kami menawarkan beragam layanan dan fasilitas mendukung seperti laboratorium, pusat olahraga, dan ruang belajar yang nyaman serta dukungan akademik, bantuan keuangan, dan layanan pengaduan tersedia untuk membantu anda',
                'link'          => base_url('entitas'),
            ],
        ];

        $this->data['poinUinRmSaid'] = [
            'judul'         => 'UIN Raden Mas Said Surakarta',
            'keterangan'    => 'Universitas Islam Negeri Raden Mas Said Surakarta (UIN RM Said), yang  dahulu bernama Sekolah Tinggi Agama Islam Negeri (STAIN) Surakarta  kemudian berubah alih status... ',
            'poin'          => [
                [
                    'gambar'        => 'assets/img/icon/ikon-akademik.png',
                    'judul'         => 'Pendidikan',
                    'keterangan'    => 'Temukan program pendidikan terbaik untuk Anda di UIN Raden Mas Said Surakarta berdasarkan pilihan  program studi dan jenis gelar yang kamu mau. Bergabunglah dengan kami  dan wujudkan potensi diri Anda melalui pendidikan bermutu.'
                ],
                [
                    'gambar'        => 'assets/img/icon/ikon-orang.png',
                    'judul'         => 'Pengabdian Masyarakat',
                    'keterangan'    => 'UIN Raden Mas Said Surakarta bertujuan mewujudkan pengabdian kepada  masyarakat yang berlandaskan Tri Dharma Perguruan Tinggi. Pengabdian  kepada masyarakat dilakukan melalui kegiatan fakultas, dosen, dan  mahasiswa dalam berbagai bidang. '
                ],
                [
                    'gambar'        => 'assets/img/icon/ikon-cari.png',
                    'judul'         => 'Riset dan Publikasi',
                    'keterangan'    => 'Kami berkomitmen untuk mewujudkan penelitian  yang berlandaskan Tri Dharma Perguruan Tinggi. Dalam upaya mewujudkan  penelitian yang berhasil, kami mendorong kolaborasi interdisipliner dan  kemitraan dengan berbagai institusi.'
                ]
            ]
        ];

        $this->data['statistik'] = [
            'utama' => [
                [
                    'gambar'        => 'assets/img/icon/ikon-orang-oranye.png',
                    'namaStatistik' => 'Mahasiswa Aktif',
                    'nilai'         => '21536'
                ],
                [
                    'gambar'        => 'assets/img/icon/ikon-akademik-oranye.png',
                    'namaStatistik' => 'Program Studi',
                    'nilai'         => '33'
                ],
                [
                    'gambar'        => 'assets/img/icon/ikon-akademik-oranye.png',
                    'namaStatistik' => 'Program Pascasarjana',
                    'nilai'         => '9'
                ]
            ],
            'lainnya' => [
                [
                    'namaStatistik' => 'Guru Besar',
                    'nilai'         => '21'
                ],
                [
                    'namaStatistik' => 'Lektor Kepala',
                    'nilai'         => '59'
                ],
                [
                    'namaStatistik' => 'Lektor',
                    'nilai'         => '224'
                ],
                [
                    'namaStatistik' => 'Dosen',
                    'nilai'         => '371'
                ],
                [
                    'namaStatistik' => 'Asisten Ahli',
                    'nilai'         => '54'
                ],
                [
                    'namaStatistik' => 'Staff Administrasi',
                    'nilai'         => '245'
                ]
            ]
        ];

        $this->data['prestasiTerbaru'] = $this->beritaModel->getByKategoriLimit("prestasi", 10);
        // $this->data['prestasiTerbaru'] = [
        //     [
        //         'gambar'                => 'assets/img/wisuda.jpeg',
        //         "judul"                 => "UKM JQH Al-Wustha Kembali Juara Dalam Lomba Hadroh di Surakarta",
        //         "slug"                  => "https://www.uinsaid.ac.id/id/ukm-jqh-al-wustha-kembali-juara-dalam-lomba-hadroh-di-surakarta",
        //         "meta_description"      => "Unit Kegiatan Kampus (UKM) Jam'iyyah Al-Qurra' Wa Al-Huffazh atau yang akrab di panggil JQH Al-Wustha kembali juara dalam sebuah lomba Rebana di Surakarta. Lomba ini kebetulan di gelar oleh mitra 10 Supermarket Bahan Bangunan Solo Baru untuk merayakan anniversary-nya yang ke-27 tahun. Dalam perayaannya, instansi tersebut mengadakan “Hadroh dan Rebana Competition”. Dalam lomba tersebut oleh penyelenggara Mitra 10 Solo Baru, UKM (JQH) Al-Wusth UIN Raden Mas Said Surakarta terpilih menjadi juara 3.",
        //         "featured_image"        => "https://www.uinsaid.ac.id/files/upload/juara.jpg",
        //         "tgl_terbit_terformat"  => " 30 Maret 2024"
        //     ],
        //     [
        //         'gambar'                => 'assets/img/wisuda.jpeg',
        //         "judul" => "Tuai Prestasi Membanggakan, Juara 1 Tilawah Putra di RRI Surakarta",
        //         "slug" => "https://www.uinsaid.ac.id/id/tuai-prestasi-membanggakan-juara-1-tilawah-putra-di-rri-surakarta",
        //         "meta_description" => "Unit Kegiatan Mahasiswa (UKM) Jam’iyyah Al-Qurra’ Wa Al-Huffazh (JQH) Al-Wustha Universitas Islam Negeri (UIN) Raden Mas (RM) Said Surakarta berhasil juarai Lomba Pekan Tilawatil Qur’an yang diselenggarakan oleh RRI Surakarta. Lomba yang dimenangkan oleh Muhammad Fadhli Azra Maulana atau yang akrab disapa Fadhli tersebut setelah UKM JQH Al-Wustha mengirimkan 2 orang peserta lomba Tahfidz dari Divisi Tahfizh, dan 4 orang peserta lomba Tilawah dari Divisi Tilawah. Fadhli adalah salah satu dari enam mahasiswa yang namanya terpampang sebagai Juara 1 dan berhak mewakili LPP RRI Surakarta. Dirinya juga akan mengikuti perlombaan berikutnya di tingkat Korwil XI yang akan diselenggarakan di Yogyakarta nantinya.",
        //         "featured_image" => "https://www.uinsaid.ac.id/files/post/cover/tuai-prestasi-membanggakan-juara-1-tilawah-putra-d-1710983872.jpg",
        //         "tgl_terbit_terformat"  => " 30 Maret 2024"
        //     ],
        //     [
        //         'gambar'                => 'assets/img/wisuda.jpeg',
        //         "judul" => "UIN RM Said Terima Penghargaan LPM PTKI Challenge 2023",
        //         "slug" => "https://www.uinsaid.ac.id/id/uin-rm-said-terima-penghargaan-lpm-ptki-challenge-2023",
        //         "meta_description" => "Universitas Islam Negeri Raden Mas Said (UIN RM Said) Surakarta terus menapak semakin mantap menuju global sesuai dengan Program Besar saat ini yakni Glokalisasi. Hal ini dibuktikan dengan semakin banyaknya prestasi yang diraih oleh kampus di wilayah solo raya ini. Salah satunya adalah dengan diterimanya Penghargaan LPM PTKI Challenge Tahun 2023. Kegiatan yang diselenggarakan oleh Direktorat Pendidikan Tinggi Keagamaan Islam (Dit Diktis PTKI) Direktorat Jenderal Pendidikan Islam (Dirjen Pendis) Kementerian Agama RI pada tahun 2023 ini sebagai bagian dari apresiasi atas kinerja Kampus PTKI dalam melakukan pembinaan terhadap Lembaga Pers Mahasiswa (LPM). ",
        //         "featured_image" => "https://www.uinsaid.ac.id/files/post/cover/uin-rm-said-terima-penghargaan-lpm-ptki-challenge--1702610374.JPG",
        //         "tgl_terbit_terformat"  => " 30 Maret 2024"
        //     ],
        //     [
        //         'gambar'                => 'assets/img/wisuda.jpeg',
        //         "judul" => "Gara-Gara MATI LAMPU, UKM TEATER SIRAT Menang 4 Nominasi",
        //         "slug" => "https://www.uinsaid.ac.id/id/gara-gara-mati-lampu-ukm-teater-sirat-menang-4-nominasi",
        //         "meta_description" => "Gara-gara mati lampu, Unit Kegiatan Mahasiswa (UKM) Teater Sirat pulang malah borong sejumlah piala. UKM Teater Sirat Universitas Islam Negeri (UIN) Raden Mas Said (RM Said) Surakarta (15/11/2023) malah memborong sejumlah piala dari Festival Diorama tahun ini.",
        //         "featured_image" => "https://www.uinsaid.ac.id/files/upload/sirat%201.jpg",
        //         "tgl_terbit_terformat"  => " 30 Maret 2024"
        //     ],
        //     [
        //         'gambar'                => 'assets/img/wisuda.jpeg',
        //         "judul" => "JUARA!! Bawa Pulang Emas dan Perak di Detik Akhir",
        //         "slug" => "https://www.uinsaid.ac.id/id/juara-bawa-pulang-emas-dan-perak-di-detik-akhir",
        //         "meta_description" => "Raih Juara 1 dan Juara 2 di FINAL. Hari keempat pelaksanaan PORSI JAWARA 1 Sabtu, (4/11) pada pertandingan terakhir cabang olahraga Taekwondo (Poomsae Individu Putra) & Bulu Tangkis (Tinggal Putra) bertempat di Gor Argopuro & Gd. Serba Guna, Kaliwates, Jember.",
        //         "featured_image" => "https://www.uinsaid.ac.id/files/upload/IMG-20231104-WA0020.jpg",
        //         "tgl_terbit_terformat"  => " 30 Maret 2024"
        //     ]
        // ];
        // $this->data['kegiatanTerbaru'] = $this->beritaModel->getByKategoriLimit('kegiatan', 10);
        // $this->data['kegiatanTerbaru'] = [
        //     [
        //         'gambar'                => 'assets/img/wisuda.jpeg',
        //         "judul"                 => "UKM JQH Al-Wustha Kembali Juara Dalam Lomba Hadroh di Surakarta",
        //         "slug"                  => "https://www.uinsaid.ac.id/id/ukm-jqh-al-wustha-kembali-juara-dalam-lomba-hadroh-di-surakarta",
        //         "meta_description"      => "Unit Kegiatan Kampus (UKM) Jam'iyyah Al-Qurra' Wa Al-Huffazh atau yang akrab di panggil JQH Al-Wustha kembali juara dalam sebuah lomba Rebana di Surakarta. Lomba ini kebetulan di gelar oleh mitra 10 Supermarket Bahan Bangunan Solo Baru untuk merayakan anniversary-nya yang ke-27 tahun. Dalam perayaannya, instansi tersebut mengadakan “Hadroh dan Rebana Competition”. Dalam lomba tersebut oleh penyelenggara Mitra 10 Solo Baru, UKM (JQH) Al-Wusth UIN Raden Mas Said Surakarta terpilih menjadi juara 3.",
        //         "featured_image"        => "https://www.uinsaid.ac.id/files/upload/juara.jpg",
        //         "tgl_terbit_terformat"  => " 30 Maret 2024",
        //         "kategori"  => " 30 Maret 2024"
        //     ],
        //     [
        //         'gambar'                => 'assets/img/wisuda.jpeg',
        //         "judul" => "Tuai Prestasi Membanggakan, Juara 1 Tilawah Putra di RRI Surakarta",
        //         "slug" => "https://www.uinsaid.ac.id/id/tuai-prestasi-membanggakan-juara-1-tilawah-putra-di-rri-surakarta",
        //         "meta_description" => "Unit Kegiatan Mahasiswa (UKM) Jam’iyyah Al-Qurra’ Wa Al-Huffazh (JQH) Al-Wustha Universitas Islam Negeri (UIN) Raden Mas (RM) Said Surakarta berhasil juarai Lomba Pekan Tilawatil Qur’an yang diselenggarakan oleh RRI Surakarta. Lomba yang dimenangkan oleh Muhammad Fadhli Azra Maulana atau yang akrab disapa Fadhli tersebut setelah UKM JQH Al-Wustha mengirimkan 2 orang peserta lomba Tahfidz dari Divisi Tahfizh, dan 4 orang peserta lomba Tilawah dari Divisi Tilawah. Fadhli adalah salah satu dari enam mahasiswa yang namanya terpampang sebagai Juara 1 dan berhak mewakili LPP RRI Surakarta. Dirinya juga akan mengikuti perlombaan berikutnya di tingkat Korwil XI yang akan diselenggarakan di Yogyakarta nantinya.",
        //         "featured_image" => "https://www.uinsaid.ac.id/files/post/cover/tuai-prestasi-membanggakan-juara-1-tilawah-putra-d-1710983872.jpg",
        //         "tgl_terbit_terformat"  => " 30 Maret 2024",
        //         "kategori"  => " 30 Maret 2024"
        //     ],
        //     [
        //         'gambar'                => 'assets/img/wisuda.jpeg',
        //         "judul" => "UIN RM Said Terima Penghargaan LPM PTKI Challenge 2023",
        //         "slug" => "https://www.uinsaid.ac.id/id/uin-rm-said-terima-penghargaan-lpm-ptki-challenge-2023",
        //         "meta_description" => "Universitas Islam Negeri Raden Mas Said (UIN RM Said) Surakarta terus menapak semakin mantap menuju global sesuai dengan Program Besar saat ini yakni Glokalisasi. Hal ini dibuktikan dengan semakin banyaknya prestasi yang diraih oleh kampus di wilayah solo raya ini. Salah satunya adalah dengan diterimanya Penghargaan LPM PTKI Challenge Tahun 2023. Kegiatan yang diselenggarakan oleh Direktorat Pendidikan Tinggi Keagamaan Islam (Dit Diktis PTKI) Direktorat Jenderal Pendidikan Islam (Dirjen Pendis) Kementerian Agama RI pada tahun 2023 ini sebagai bagian dari apresiasi atas kinerja Kampus PTKI dalam melakukan pembinaan terhadap Lembaga Pers Mahasiswa (LPM). ",
        //         "featured_image" => "https://www.uinsaid.ac.id/files/post/cover/uin-rm-said-terima-penghargaan-lpm-ptki-challenge--1702610374.JPG",
        //         "tgl_terbit_terformat"  => " 30 Maret 2024",
        //         "kategori"  => " 30 Maret 2024"
        //     ],
        //     [
        //         'gambar'                => 'assets/img/wisuda.jpeg',
        //         "judul" => "Gara-Gara MATI LAMPU, UKM TEATER SIRAT Menang 4 Nominasi",
        //         "slug" => "https://www.uinsaid.ac.id/id/gara-gara-mati-lampu-ukm-teater-sirat-menang-4-nominasi",
        //         "meta_description" => "Gara-gara mati lampu, Unit Kegiatan Mahasiswa (UKM) Teater Sirat pulang malah borong sejumlah piala. UKM Teater Sirat Universitas Islam Negeri (UIN) Raden Mas Said (RM Said) Surakarta (15/11/2023) malah memborong sejumlah piala dari Festival Diorama tahun ini.",
        //         "featured_image" => "https://www.uinsaid.ac.id/files/upload/sirat%201.jpg",
        //         "tgl_terbit_terformat"  => " 30 Maret 2024",
        //         "kategori"  => " 30 Maret 2024"
        //     ],
        //     [
        //         'gambar'                => 'assets/img/wisuda.jpeg',
        //         "judul" => "JUARA!! Bawa Pulang Emas dan Perak di Detik Akhir",
        //         "slug" => "https://www.uinsaid.ac.id/id/juara-bawa-pulang-emas-dan-perak-di-detik-akhir",
        //         "meta_description" => "Raih Juara 1 dan Juara 2 di FINAL. Hari keempat pelaksanaan PORSI JAWARA 1 Sabtu, (4/11) pada pertandingan terakhir cabang olahraga Taekwondo (Poomsae Individu Putra) & Bulu Tangkis (Tinggal Putra) bertempat di Gor Argopuro & Gd. Serba Guna, Kaliwates, Jember.",
        //         "featured_image" => "https://www.uinsaid.ac.id/files/upload/IMG-20231104-WA0020.jpg",
        //         "tgl_terbit_terformat"  => " 30 Maret 2024",
        //         "kategori"  => " 30 Maret 2024"
        //     ]
        // ];

        $beritaCard = $this->beritaModel->getTerbaru(5);
        $beritaSwiper = $this->beritaModel->getTerbaru(5, 5);
        $this->data['beritaCard'] = format_tanggal($beritaCard);
        $this->data['beritaSwiper'] = format_tanggal($beritaSwiper);

        // $this->data['berita'] = [
        //     [
        //         "image" => "https://www.uinsaid.ac.id/files/post/cover/persiapan-akreditasi-internasional-uin-surakarta-m-1714970024.JPG",
        //         "judul" => "Persiapan Akreditasi Internasional, UIN Surakarta Undang Rafiazka Hilman",
        //         "slug" => "Catat, UIN RM Said Masuk Jajaran Top 10 PTKIN",
        //         "tgl_terbit" => "30 Maret 2024"
        //     ],
        //     [
        //         "image" => "https://www.uinsaid.ac.id/files/post/cover/jauh-datang-dari-batam-kami-ucapkan-selamat-datang-1715059577.jpg",
        //         "judul" => "Jauh Datang Dari Batam, Kami Ucapkan Selamat Datang. Kami Sambut Dengan Senyuman",
        //         "tgl_terbit" => "30 Maret 2024"
        //     ],
        //     [
        //         "image" => "https://www.uinsaid.ac.id/files/post/cover/uin-raden-mas-said-surakarta-raih-wtp-atas-laporan-1715060511.jpg",
        //         "judul" => "UIN Raden Mas Said Surakarta Raih WTP atas Laporan Keuangan BLU Tahun Laporan 2023 dari Kantor Akuntan Publik",
        //         "tgl_terbit" => "30 Maret 2024"
        //     ],
        //     [
        //         "image" => "https://www.uinsaid.ac.id/files/post/cover/fab-uin-rm-said-holds-iccl-1716892667.jpg",
        //         "judul" => "FAB UIN RM Said Holds 2nd ICCL 2024",
        //         "tgl_terbit" => "30 Maret 2024"
        //     ],
        //     [
        //         "image" => "https://www.uinsaid.ac.id/files/post/cover/optimalkan-blu-uin-rm-said-perkuat-kerjasama-1717059990.jpg",
        //         "judul" => "Optimalkan BLU, UIN RM Said Perkuat Kerjasama",
        //         "tgl_terbit" => "30 Maret 2024"
        //     ],
        // ];
        $this->data['pojokPimpinan'] = $this->beritaModel->getByKategoriLimit("pojok pimpinan", 3);
        // $this->data['pojokPimpinan'] = [
        //     [
        //         "judul"     => "KKN Internasional & Upaya Peningkatan Daya Saing Global",
        //         "ringkasan" => "Mahasiswa UIN Raden Mas Said Surakarta, seperti mahasiswa di seluruh dunia lainnya, dihadapkan pada persaingan global yang menuntut kemampuan adaptasi dan bersaing di berbagai bidang."
        //     ],
        //     [
        //         "judul"     => "KKN Internasional & Upaya Peningkatan Daya Saing Global",
        //         "ringkasan" => "Mahasiswa UIN Raden Mas Said Surakarta, seperti mahasiswa di seluruh dunia lainnya, dihadapkan pada persaingan global yang menuntut kemampuan adaptasi dan bersaing di berbagai bidang."
        //     ],
        // ];
        $this->data['opini'] = $this->beritaModel->getByKategoriLimit("opini", 3);
        // $this->data['opini'] = [
        //     [
        //         "judul"     => "KKN Internasional & Upaya Peningkatan Daya Saing Global",
        //         "ringkasan" => "Mahasiswa UIN Raden Mas Said Surakarta, seperti mahasiswa di seluruh dunia lainnya, dihadapkan pada persaingan global yang menuntut kemampuan adaptasi dan bersaing di berbagai bidang."
        //     ],
        //     [
        //         "judul"     => "KKN Internasional & Upaya Peningkatan Daya Saing Global",
        //         "ringkasan" => "Mahasiswa UIN Raden Mas Said Surakarta, seperti mahasiswa di seluruh dunia lainnya, dihadapkan pada persaingan global yang menuntut kemampuan adaptasi dan bersaing di berbagai bidang."
        //     ],
        // ];

        $agenda = $this->agendaModel->getTerbaru(4);
        $this->data['agenda'] = format_tanggal_suatu_kolom($agenda, 'waktu_mulai');
        // $this->data['agenda'] = [
        //     [
        //         "judul" => "Piala Rektor UIN RM Said Surakarta Tahun 2024 Piala Rektor 2024",
        //         "slug" => "Catat, UIN RM Said Masuk Jajaran Top 10 PTKIN",
        //         "tgl_terbit" => "30 Maret 2024"
        //     ],
        //     [
        //         "judul" => "Wisuda Ke-56 UIN Raden Mas Said Surakarta Juli 2024",
        //         "tgl_terbit" => "30 Maret 2024"
        //     ],
        //     [
        //         "judul" => "Seminar Moderasi & Toleransi bersama Kemenag Sukoharjo ",
        //         "tgl_terbit" => "30 Maret 2024"
        //     ],
        //     [
        //         "judul" => "Call for Papers and Participants 4th International Conference",
        //         "tgl_terbit" => "30 Maret 2024"
        //     ]
        // ];

        $pengumuman = $this->pengumumanModel->getTerbaru(3);
        $this->data['pengumuman'] = $pengumuman;
        // $this->data['pengumuman'] = [
        //     [
        //         "judul" => "Prosedur Pembuatan KTM Untuk Mahasiswa Baru",
        //         "slug" => "Catat, UIN RM Said Masuk Jajaran Top 10 PTKIN",
        //         "tanggal" => $this->formatDateToArray("30 Maret 2024")[0],
        //         "bulan" => $this->formatDateToArray("30 Maret 2024")[1]
        //     ],
        //     [
        //         "judul" => "Pendaftaran Wisuda Ke-56 UIN Raden Mas Said Surakarta Juli 2024",
        //         "tanggal" => $this->formatDateToArray("30 Maret 2024")[0],
        //         "bulan" => $this->formatDateToArray("30 Maret 2024")[1]
        //     ],
        //     [
        //         "judul" => "Registrasi Mahasiswa Baru UIN Raden Mas Said Surakarta Jalur SNBT ",
        //         "tanggal" => $this->formatDateToArray("30 Maret 2024")[0],
        //         "bulan" => $this->formatDateToArray("30 Maret 2024")[1]
        //     ],
        // ];
        return view('beranda', $this->data);
    }

    function formatDate($date)
    {
        // Convert the date string to a timestamp
        $timestamp = strtotime($date);

        // Format the date to display only the day and the first three letters of the month
        return date('d M', $timestamp);
    }
}
