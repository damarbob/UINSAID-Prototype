<?php

namespace App\Controllers;

use function App\Helpers\format_tanggal;
use function App\Helpers\format_tanggal_suatu_kolom;

class BerandaProdi extends BaseController
{
    public function index()
    {
        helper('format');
        $this->data['prodi'] = 'Program Studi Manajemen Bisnis Islam';
        $this->data['heroTerbaru'] = [
            [
                "kategori"              => "",
                "judul"                 => "UIN Raden Mas Said",
                "slug"                  => "",
                "meta_description"      => "Dengan sejarahnya yang kaya dan potensinya yang melimpah, UIN Raden Mas Said Surakarta siap melangkah ke masa depan yang lebih cerah",
                "featured_image"        => base_url("assets/img/hero-oranye.jpg"),
                "featured_image_mobile"        => base_url("assets/img/hero-oranye-mobile.jpg"),
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

        $this->data['sambutanRektor'] = [
            'judul'       => 'Tentang Program Studi Manajemen Bisnis Islam',
            'sambutan'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially. unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more rany web sites still in their inf. It was popularised in the 1960s with the release set sheets containing Lorem Ipsum passages.'
        ];

        $beritaCard = $this->beritaModel->getTerbaru(5);
        // $beritaSwiper = $this->beritaModel->getTerbaru(5, 5);
        $this->data['beritaCard'] = format_tanggal($beritaCard);
        // $this->data['beritaSwiper'] = format_tanggal($beritaSwiper);

        $this->data['artikelOpini'] = [
            [
                "judul"     => "KKN Internasional & Upaya Peningkatan Daya Saing Global",
                "ringkasan" => "Mahasiswa UIN Raden Mas Said Surakarta, seperti mahasiswa di seluruh dunia lainnya, dihadapkan pada persaingan global yang menuntut kemampuan adaptasi dan bersaing di berbagai bidang."
            ],
            [
                "judul"     => "KKN Internasional & Upaya Peningkatan Daya Saing Global",
                "ringkasan" => "Mahasiswa UIN Raden Mas Said Surakarta, seperti mahasiswa di seluruh dunia lainnya, dihadapkan pada persaingan global yang menuntut kemampuan adaptasi dan bersaing di berbagai bidang."
            ],
            [
                "judul"     => "KKN Internasional & Upaya Peningkatan Daya Saing Global",
                "ringkasan" => "Mahasiswa UIN Raden Mas Said Surakarta, seperti mahasiswa di seluruh dunia lainnya, dihadapkan pada persaingan global yang menuntut kemampuan adaptasi dan bersaing di berbagai bidang."
            ],
            [
                "judul"     => "KKN Internasional & Upaya Peningkatan Daya Saing Global",
                "ringkasan" => "Mahasiswa UIN Raden Mas Said Surakarta, seperti mahasiswa di seluruh dunia lainnya, dihadapkan pada persaingan global yang menuntut kemampuan adaptasi dan bersaing di berbagai bidang."
            ],
        ];

        $agenda = $this->agendaModel->getTerbaru(4);
        $this->data['agenda'] = format_tanggal_suatu_kolom($agenda, 'waktu_mulai');

        $pengumuman = $this->pengumumanModel->getTerbaru(3);
        $this->data['pengumuman'] = $pengumuman;

        return view('beranda_prodi', $this->data);
    }

    function formatDate($date)
    {
        // Convert the date string to a timestamp
        $timestamp = strtotime($date);

        // Format the date to display only the day and the first three letters of the month
        return date('d M', $timestamp);
    }
}