<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data['kegiatanTerbaru'] = [
            [
                "kategori"              => "Lomba",
                "judul"                 => "UKM JQH Al-Wustha Kembali Juara Dalam Lomba Hadroh di Surakarta",
                "slug"                  => "https://www.uinsaid.ac.id/id/ukm-jqh-al-wustha-kembali-juara-dalam-lomba-hadroh-di-surakarta",
                "meta_description"      => "Unit Kegiatan Kampus (UKM) Jam'iyyah Al-Qurra' Wa Al-Huffazh atau yang akrab di panggil JQH Al-Wustha kembali juara dalam sebuah lomba Rebana di Surakarta. Lomba ini kebetulan di gelar oleh mitra 10 Supermarket Bahan Bangunan Solo Baru untuk merayakan anniversary-nya yang ke-27 tahun. Dalam perayaannya, instansi tersebut mengadakan “Hadroh dan Rebana Competition”. Dalam lomba tersebut oleh penyelenggara Mitra 10 Solo Baru, UKM (JQH) Al-Wusth UIN Raden Mas Said Surakarta terpilih menjadi juara 3.",
                "featured_image"        => "https://www.uinsaid.ac.id/files/upload/juara.jpg",
                "tgl_terbit_terformat"  => " 30 Maret 2024"
            ],
            [
                "kategori" => "Lomba",
                "judul" => "Tuai Prestasi Membanggakan, Juara 1 Tilawah Putra di RRI Surakarta",
                "slug" => "https://www.uinsaid.ac.id/id/tuai-prestasi-membanggakan-juara-1-tilawah-putra-di-rri-surakarta",
                "meta_description" => "Unit Kegiatan Mahasiswa (UKM) Jam’iyyah Al-Qurra’ Wa Al-Huffazh (JQH) Al-Wustha Universitas Islam Negeri (UIN) Raden Mas (RM) Said Surakarta berhasil juarai Lomba Pekan Tilawatil Qur’an yang diselenggarakan oleh RRI Surakarta. Lomba yang dimenangkan oleh Muhammad Fadhli Azra Maulana atau yang akrab disapa Fadhli tersebut setelah UKM JQH Al-Wustha mengirimkan 2 orang peserta lomba Tahfidz dari Divisi Tahfizh, dan 4 orang peserta lomba Tilawah dari Divisi Tilawah. Fadhli adalah salah satu dari enam mahasiswa yang namanya terpampang sebagai Juara 1 dan berhak mewakili LPP RRI Surakarta. Dirinya juga akan mengikuti perlombaan berikutnya di tingkat Korwil XI yang akan diselenggarakan di Yogyakarta nantinya.",
                "featured_image" => "https://www.uinsaid.ac.id/files/post/cover/tuai-prestasi-membanggakan-juara-1-tilawah-putra-d-1710983872.jpg",
                "tgl_terbit_terformat"  => " 30 Maret 2024"
            ],
            [
                "kategori" => "Lomba",
                "judul" => "UIN RM Said Terima Penghargaan LPM PTKI Challenge 2023",
                "slug" => "https://www.uinsaid.ac.id/id/uin-rm-said-terima-penghargaan-lpm-ptki-challenge-2023",
                "meta_description" => "Universitas Islam Negeri Raden Mas Said (UIN RM Said) Surakarta terus menapak semakin mantap menuju global sesuai dengan Program Besar saat ini yakni Glokalisasi. Hal ini dibuktikan dengan semakin banyaknya prestasi yang diraih oleh kampus di wilayah solo raya ini. Salah satunya adalah dengan diterimanya Penghargaan LPM PTKI Challenge Tahun 2023. Kegiatan yang diselenggarakan oleh Direktorat Pendidikan Tinggi Keagamaan Islam (Dit Diktis PTKI) Direktorat Jenderal Pendidikan Islam (Dirjen Pendis) Kementerian Agama RI pada tahun 2023 ini sebagai bagian dari apresiasi atas kinerja Kampus PTKI dalam melakukan pembinaan terhadap Lembaga Pers Mahasiswa (LPM). ",
                "featured_image" => "https://www.uinsaid.ac.id/files/post/cover/uin-rm-said-terima-penghargaan-lpm-ptki-challenge--1702610374.JPG",
                "tgl_terbit_terformat"  => " 30 Maret 2024"
            ],
            [
                "kategori" => "Lomba",
                "judul" => "Gara-Gara MATI LAMPU, UKM TEATER SIRAT Menang 4 Nominasi",
                "slug" => "https://www.uinsaid.ac.id/id/gara-gara-mati-lampu-ukm-teater-sirat-menang-4-nominasi",
                "meta_description" => "Gara-gara mati lampu, Unit Kegiatan Mahasiswa (UKM) Teater Sirat pulang malah borong sejumlah piala. UKM Teater Sirat Universitas Islam Negeri (UIN) Raden Mas Said (RM Said) Surakarta (15/11/2023) malah memborong sejumlah piala dari Festival Diorama tahun ini.",
                "featured_image" => "https://www.uinsaid.ac.id/files/upload/sirat%201.jpg",
                "tgl_terbit_terformat"  => " 30 Maret 2024"
            ],
            [
                "kategori" => "Lomba",
                "judul" => "JUARA!! Bawa Pulang Emas dan Perak di Detik Akhir",
                "slug" => "https://www.uinsaid.ac.id/id/juara-bawa-pulang-emas-dan-perak-di-detik-akhir",
                "meta_description" => "Raih Juara 1 dan Juara 2 di FINAL. Hari keempat pelaksanaan PORSI JAWARA 1 Sabtu, (4/11) pada pertandingan terakhir cabang olahraga Taekwondo (Poomsae Individu Putra) & Bulu Tangkis (Tinggal Putra) bertempat di Gor Argopuro & Gd. Serba Guna, Kaliwates, Jember.",
                "featured_image" => "https://www.uinsaid.ac.id/files/upload/IMG-20231104-WA0020.jpg",
                "tgl_terbit_terformat"  => " 30 Maret 2024"
            ]
        ];

        $data['berita'] = [
            [
                "image" => "img/akademik.jpeg",
                "judul" => "Persiapan Akreditasi Internasional, UIN Surakarta Undang Rafiazka Hilman",
                "tgl_terbit" => "30 Maret 2024"
            ],
            [
                "image" => "img/akademik.jpeg",
                "judul" => "Persiapan Akreditasi Internasional, UIN Surakarta Undang Rafiazka Hilman",
                "tgl_terbit" => "30 Maret 2024"
            ],
            [
                "image" => "img/akademik.jpeg",
                "judul" => "Persiapan Akreditasi Internasional, UIN Surakarta Undang Rafiazka Hilman",
                "tgl_terbit" => "30 Maret 2024"
            ],
            [
                "image" => "img/akademik.jpeg",
                "judul" => "Persiapan Akreditasi Internasional, UIN Surakarta Undang Rafiazka Hilman",
                "tgl_terbit" => "30 Maret 2024"
            ],
            [
                "image" => "img/akademik.jpeg",
                "judul" => "Persiapan Akreditasi Internasional, UIN Surakarta Undang Rafiazka Hilman",
                "tgl_terbit" => "30 Maret 2024"
            ],
        ];
        return view('beranda', $data);
    }
}
