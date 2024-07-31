<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data['heroTerbaru'] = [
            [
                "kategori"              => "",
                "judul"                 => "UIN Raden Mas Said",
                "slug"                  => "",
                "meta_description"      => "Dengan sejarahnya yang kaya dan potensinya yang melimpah, UIN Raden Mas Said Surakarta siap melangkah ke masa depan yang lebih cerah",
                "featured_image"        => base_url("assets/img/akademik.jpeg"),
                "tgl_terbit_terformat"  => ""
            ],
            [
                "kategori"              => "",
                "judul"                 => "UIN Raden Mas Said",
                "slug"                  => "",
                "meta_description"      => "Dengan sejarahnya yang kaya dan potensinya yang melimpah, UIN Raden Mas Said Surakarta siap melangkah ke masa depan yang lebih cerah",
                "featured_image"        => base_url("assets/img/wisuda.jpeg"),
                "tgl_terbit_terformat"  => ""
            ],
            [
                "kategori"              => "",
                "judul"                 => "Catat, UIN RM Said Masuk Jajaran Top 10 PTKIN",
                "slug"                  => "https://www.uinsaid.ac.id/id/catat-uin-rm-said-masuk-jajaran-top-10-ptkin",
                "meta_description"      => "Masuknya nama UIN RM Said Surakarta di rangking 9 PTKIN dengan rerata nilai UTBK tertinggi tahun 2024 mengindikasikan bahwa pendaftar untuk kuliah di kampus ini memiliki latar belakang dalam bidang akademik yang cukup bagus.",
                "featured_image"        => base_url("assets/img/uin-raden-mas-said.png"),
                "tgl_terbit_terformat"  => ""
            ]
        ];

        $data['poinUtama'] = [
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

        $data['sambutanRektor'] = [
            'judul'       => 'Panca Amanat “LURIK” dalam Mensukseskan Glokalisasi',
            'sambutan'    => 'LURIK yang berakronim “Loyal, Unggul, Responsif, Inovatif dan Kolaboratif” LURIK pertama adalah Loyal, yang menuntut para pejabat untuk memiliki sikap loyal terhadap Negara Kesatuan Republik Indonesia (NKRI), Kementerian Agama, dan UIN Raden Mas Said Surakarta. <br>LURIK kedua adalah Unggul, mengajak para pejabat untuk bekerja maksimal dan optimal, serta sekuat tenaga meraih keunggulan lembaga, dengan cara melakukan Konsolidasi, Mobilisasi dan Orkestrasi (KMO) dengan pimpinan di lembaga masing-masing,untuk merencanakan program-program unggulan dalam rangka Glokalisasi UIN Raden Mas Said Surakarta.'
        ];

        $data['poinAkademik'] = [
            [
                'gambar'        => '',
                'judul'         => 'Program Studi',
                'keterangan'    => 'Berbagai program  pendidikan sarjana, spesialis, magister, dan doktoral tersedia  sesuai minat Anda untuk mendukung karir dan keahlian profesional di masa  depan.',
            ],
            [
                'gambar'        => '',
                'judul'         => 'Pendaftaran Mahasiswa Baru',
                'keterangan'    => 'Penerimaan mahasiswa tahun akademik baru sudah dibuka. klik slengkapnya untuk Informasi jalur  penerimaan dan jadwal penerimaan mahasiswa, serta pendaftaran online  calon mahasiswa baru'
            ],
            [
                'gambar'        => '',
                'judul'         => 'Informasi Beasiswa',
                'keterangan'    => 'Beasiswa diberikan kepada mahasiswa/i yang memiliki prestasi akademik  yang berkomitmen dalam berbagai kegiatan ekstrakurikuler,  dan memenuhi kriteria-kriteria tertentu sesuai dengan ketentuan yang  berlaku.'
            ],
            [
                'gambar'        => '',
                'judul'         => 'Informasi Layanan',
                'keterangan'    => 'Kami menawarkan beragam layanan dan fasilitas mendukung seperti laboratorium, pusat olahraga, dan ruang belajar yang nyaman serta dukungan akademik, bantuan keuangan, dan layanan pengaduan tersedia untuk membantu anda'
            ],
        ];

        $data['poinUinRmSaid'] = [
            'judul'         => 'UIN Raden Mas Said Surakarta',
            'keterangan'    => 'Universitas Islam Negeri Raden Mas Said Surakarta (UIN RM Said), yang  dahulu bernama Sekolah Tinggi Agama Islam Negeri (STAIN) Surakarta  kemudian berubah alih status... ',
            'poin'          => [
                [
                    'gambar'        => '',
                    'judul'         => 'Pendidikan',
                    'keterangan'    => 'Temukan program pendidikan terbaik untuk Anda di UIN Raden Mas Said Surakarta berdasarkan pilihan  program studi dan jenis gelar yang kamu mau. Bergabunglah dengan kami  dan wujudkan potensi diri Anda melalui pendidikan bermutu.'
                ],
                [
                    'gambar'        => '',
                    'judul'         => 'Pengabdian Masyarakat',
                    'keterangan'    => 'UIN Raden Mas Said Surakarta bertujuan mewujudkan pengabdian kepada  masyarakat yang berlandaskan Tri Dharma Perguruan Tinggi. Pengabdian  kepada masyarakat dilakukan melalui kegiatan fakultas, dosen, dan  mahasiswa dalam berbagai bidang. '
                ],
                [
                    'gambar'        => 'assets/img/wisuda.jpeg',
                    'judul'         => 'Riset dan Penelitian',
                    'keterangan'    => 'Kami berkomitmen untuk mewujudkan penelitian  yang berlandaskan Tri Dharma Perguruan Tinggi. Dalam upaya mewujudkan  penelitian yang berhasil, kami mendorong kolaborasi interdisipliner dan  kemitraan dengan berbagai institusi.'
                ]
            ]
        ];

        $data['statistik'] = [
            'utama' => [
                [
                    'gambar'        => '',
                    'namaStatistik' => 'Mahasiswa Aktif',
                    'nilai'         => '21536'
                ],
                [
                    'gambar'        => '',
                    'namaStatistik' => 'Program Studi',
                    'nilai'         => '33'
                ],
                [
                    'gambar'        => '',
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

        $data['prestasiTerbaru'] = [
            [
                'gambar'                => 'assets/img/wisuda.jpeg',
                "judul"                 => "UKM JQH Al-Wustha Kembali Juara Dalam Lomba Hadroh di Surakarta",
                "slug"                  => "https://www.uinsaid.ac.id/id/ukm-jqh-al-wustha-kembali-juara-dalam-lomba-hadroh-di-surakarta",
                "meta_description"      => "Unit Kegiatan Kampus (UKM) Jam'iyyah Al-Qurra' Wa Al-Huffazh atau yang akrab di panggil JQH Al-Wustha kembali juara dalam sebuah lomba Rebana di Surakarta. Lomba ini kebetulan di gelar oleh mitra 10 Supermarket Bahan Bangunan Solo Baru untuk merayakan anniversary-nya yang ke-27 tahun. Dalam perayaannya, instansi tersebut mengadakan “Hadroh dan Rebana Competition”. Dalam lomba tersebut oleh penyelenggara Mitra 10 Solo Baru, UKM (JQH) Al-Wusth UIN Raden Mas Said Surakarta terpilih menjadi juara 3.",
                "featured_image"        => "https://www.uinsaid.ac.id/files/upload/juara.jpg",
                "tgl_terbit_terformat"  => " 30 Maret 2024"
            ],
            [
                'gambar'                => 'assets/img/wisuda.jpeg',
                "judul" => "Tuai Prestasi Membanggakan, Juara 1 Tilawah Putra di RRI Surakarta",
                "slug" => "https://www.uinsaid.ac.id/id/tuai-prestasi-membanggakan-juara-1-tilawah-putra-di-rri-surakarta",
                "meta_description" => "Unit Kegiatan Mahasiswa (UKM) Jam’iyyah Al-Qurra’ Wa Al-Huffazh (JQH) Al-Wustha Universitas Islam Negeri (UIN) Raden Mas (RM) Said Surakarta berhasil juarai Lomba Pekan Tilawatil Qur’an yang diselenggarakan oleh RRI Surakarta. Lomba yang dimenangkan oleh Muhammad Fadhli Azra Maulana atau yang akrab disapa Fadhli tersebut setelah UKM JQH Al-Wustha mengirimkan 2 orang peserta lomba Tahfidz dari Divisi Tahfizh, dan 4 orang peserta lomba Tilawah dari Divisi Tilawah. Fadhli adalah salah satu dari enam mahasiswa yang namanya terpampang sebagai Juara 1 dan berhak mewakili LPP RRI Surakarta. Dirinya juga akan mengikuti perlombaan berikutnya di tingkat Korwil XI yang akan diselenggarakan di Yogyakarta nantinya.",
                "featured_image" => "https://www.uinsaid.ac.id/files/post/cover/tuai-prestasi-membanggakan-juara-1-tilawah-putra-d-1710983872.jpg",
                "tgl_terbit_terformat"  => " 30 Maret 2024"
            ],
            [
                'gambar'                => 'assets/img/wisuda.jpeg',
                "judul" => "UIN RM Said Terima Penghargaan LPM PTKI Challenge 2023",
                "slug" => "https://www.uinsaid.ac.id/id/uin-rm-said-terima-penghargaan-lpm-ptki-challenge-2023",
                "meta_description" => "Universitas Islam Negeri Raden Mas Said (UIN RM Said) Surakarta terus menapak semakin mantap menuju global sesuai dengan Program Besar saat ini yakni Glokalisasi. Hal ini dibuktikan dengan semakin banyaknya prestasi yang diraih oleh kampus di wilayah solo raya ini. Salah satunya adalah dengan diterimanya Penghargaan LPM PTKI Challenge Tahun 2023. Kegiatan yang diselenggarakan oleh Direktorat Pendidikan Tinggi Keagamaan Islam (Dit Diktis PTKI) Direktorat Jenderal Pendidikan Islam (Dirjen Pendis) Kementerian Agama RI pada tahun 2023 ini sebagai bagian dari apresiasi atas kinerja Kampus PTKI dalam melakukan pembinaan terhadap Lembaga Pers Mahasiswa (LPM). ",
                "featured_image" => "https://www.uinsaid.ac.id/files/post/cover/uin-rm-said-terima-penghargaan-lpm-ptki-challenge--1702610374.JPG",
                "tgl_terbit_terformat"  => " 30 Maret 2024"
            ],
            [
                'gambar'                => 'assets/img/wisuda.jpeg',
                "judul" => "Gara-Gara MATI LAMPU, UKM TEATER SIRAT Menang 4 Nominasi",
                "slug" => "https://www.uinsaid.ac.id/id/gara-gara-mati-lampu-ukm-teater-sirat-menang-4-nominasi",
                "meta_description" => "Gara-gara mati lampu, Unit Kegiatan Mahasiswa (UKM) Teater Sirat pulang malah borong sejumlah piala. UKM Teater Sirat Universitas Islam Negeri (UIN) Raden Mas Said (RM Said) Surakarta (15/11/2023) malah memborong sejumlah piala dari Festival Diorama tahun ini.",
                "featured_image" => "https://www.uinsaid.ac.id/files/upload/sirat%201.jpg",
                "tgl_terbit_terformat"  => " 30 Maret 2024"
            ],
            [
                'gambar'                => 'assets/img/wisuda.jpeg',
                "judul" => "JUARA!! Bawa Pulang Emas dan Perak di Detik Akhir",
                "slug" => "https://www.uinsaid.ac.id/id/juara-bawa-pulang-emas-dan-perak-di-detik-akhir",
                "meta_description" => "Raih Juara 1 dan Juara 2 di FINAL. Hari keempat pelaksanaan PORSI JAWARA 1 Sabtu, (4/11) pada pertandingan terakhir cabang olahraga Taekwondo (Poomsae Individu Putra) & Bulu Tangkis (Tinggal Putra) bertempat di Gor Argopuro & Gd. Serba Guna, Kaliwates, Jember.",
                "featured_image" => "https://www.uinsaid.ac.id/files/upload/IMG-20231104-WA0020.jpg",
                "tgl_terbit_terformat"  => " 30 Maret 2024"
            ]
        ];

        $data['berita'] = [
            [
                "image" => "assets/img/uin-raden-mas-said.png",
                "judul" => "Persiapan Akreditasi Internasional, UIN Surakarta Undang Rafiazka Hilman",
                "slug" => "Catat, UIN RM Said Masuk Jajaran Top 10 PTKIN",
                "tgl_terbit" => "30 Maret 2024"
            ],
            [
                "image" => "assets/img/akademik.jpeg",
                "judul" => "Persiapan Akreditasi Internasional, UIN Surakarta Undang Rafiazka Hilman",
                "tgl_terbit" => "30 Maret 2024"
            ],
            [
                "image" => "assets/img/akademik.jpeg",
                "judul" => "Persiapan Akreditasi Internasional, UIN Surakarta Undang Rafiazka Hilman",
                "tgl_terbit" => "30 Maret 2024"
            ],
            [
                "image" => "assets/img/akademik.jpeg",
                "judul" => "Persiapan Akreditasi Internasional, UIN Surakarta Undang Rafiazka Hilman",
                "tgl_terbit" => "30 Maret 2024"
            ],
            [
                "image" => "assets/img/akademik.jpeg",
                "judul" => "Persiapan Akreditasi Internasional, UIN Surakarta Undang Rafiazka Hilman",
                "tgl_terbit" => "30 Maret 2024"
            ],
        ];
        return view('beranda', $data);
    }
}
