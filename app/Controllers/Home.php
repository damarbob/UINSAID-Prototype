<?php

namespace App\Controllers;

use App\Libraries\DataSyntaxQueryProcessor;
use App\Libraries\Twig;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

use function App\Helpers\format_tanggal;
use function App\Helpers\format_tanggal_suatu_kolom;
use function App\Helpers\replaceAttributesSyntax;
use function App\Helpers\replaceEnvironmentSyntax;
use function App\Helpers\replaceMetaSyntax;
use function App\Helpers\replaceMetaSyntaxWithDefault;
use function App\Helpers\replaceMetaSyntaxWithEmpty;

class Home extends BaseController
{
    /* Libraries */
    protected $twig; // For twig rendering
    protected DataSyntaxQueryProcessor $dataSyntaxQueryProcessor;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $this->twig = new Twig();
        $this->dataSyntaxQueryProcessor = new DataSyntaxQueryProcessor();
    }

    public function index()
    {
        helper('format');

        $halamanUtamaSitus = setting()->get('App.halamanUtamaSitus');

        if ($halamanUtamaSitus != '') {
            return $this->view($halamanUtamaSitus);
        } else {
            /* Backup main page */
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

            $jenisBeritaId = 1; // Posting jenis berita
            $this->data['prestasiTerbaru'] = $this->postingModel->getByKategoriLimit($jenisBeritaId, "prestasi", 10);

            $beritaCard = $this->postingModel->getTerbaru($jenisBeritaId, 5);
            $beritaSwiper = $this->postingModel->getTerbaru($jenisBeritaId, 5, 5);
            // $this->data['beritaCard'] = format_tanggal($beritaCard);
            // $this->data['beritaSwiper'] = format_tanggal($beritaSwiper);
            $this->data['beritaCard'] = format_tanggal_suatu_kolom($beritaCard, 'tanggal_terbit');
            $this->data['beritaSwiper'] = format_tanggal_suatu_kolom($beritaSwiper, 'tanggal_terbit');

            $this->data['pojokPimpinan'] = $this->postingModel->getByKategoriLimit($jenisBeritaId, "pojok pimpinan", 3);
            $this->data['opini'] = $this->postingModel->getByKategoriLimit($jenisBeritaId, "opini", 3);

            $agenda = $this->agendaPengumumanModel->getAgendaTerbaru(4);
            $this->data['agenda'] = format_tanggal_suatu_kolom($agenda, 'waktu_mulai');

            $pengumuman = $this->pengumumanModel->getTerbaru(3);
            $this->data['pengumuman'] = $pengumuman;

            return view('beranda', $this->data);
        }
    }

    /**
     * Frontend view
     * 
     * @param string slug of the page
     * @return string Halaman page
     */
    function view($slug)
    {
        helper('syntax_processor');

        $halaman = $this->halamanModel->getBySlug($slug);

        $this->data['judul'] = $halaman['judul'];

        $komponenData = json_decode($halaman['id_komponen']);
        $komponen = [];

        if ($komponenData) {
            foreach ($komponenData as $x) {
                $komponen[] = $this->komponenModel->find($x->komponen_id);
            }
        }

        // Set up the Twig environment
        $loader = new ArrayLoader();
        $twig = new Environment($loader);

        $komponenTerformat = []; // Array untuk menyimpan komponen terformat
        foreach ($komponen as $i => $x) {
            // dd($x['konten']);

            $komponenMeta = $this->komponenMetaModel->getById(
                $komponenData[$i]->komponen_instance_id, // Assuming the order of komponenData is the same as komponen[]
                $x['id'],
                $halaman['id']
            );

            // dd(!$komponenMeta);

            // Replace attr syntax
            $x['konten'] = replaceAttributesSyntax($x['konten'], json_encode($komponenData[$i]));

            // Replace meta syntax
            if (!$komponenMeta) {
                // dd(replaceMetaSyntaxWithDefault($x['konten']));

                $x['konten_terformat'] = $this->twig->renderTemplateString(
                    replaceMetaSyntaxWithDefault($x['konten']),
                    [
                        // Add environment variables
                        'base_url' => base_url(),
                        'request_post' => $this->request->getPost(),
                        'request_get' => $this->request->getGet(),
                    ]
                );
            } else {

                // dd($komponenMeta['meta']);

                $x['konten_terformat'] = $this->twig->renderTemplateString(
                    replaceMetaSyntax(
                        $x['konten'],
                        replaceEnvironmentSyntax($komponenMeta['meta'])
                    ),
                    [
                        // Add environment variables
                        'base_url' => base_url(),
                        'request_post' => $this->request->getPost(),
                        'request_get' => $this->request->getGet(),
                    ]
                ); // Format komponen
            }

            // Replace data syntax
            $x['konten_terformat'] = $this->dataSyntaxQueryProcessor->processDataSyntax($x['konten_terformat']);

            // dd($komponenMeta['meta']);
            // dd($x['konten_terformat']);

            // '[{"id":"bold_text","value":"zzsx"},{"id":"italic_text","value":"zzzzzz"},{"id":"underline_text","value":"zzzzzzzzzzzz"},{"id":"strikethrough_text","value":"zzzzzzzzzzzzzzzzz"},{"id":"number","value":"22222"},{"id":"datetime","value":"2024-09-13T10:33"},{"id":"email","value":"simslifepbluns@gmail.com"},{"id":"password","value":"wdqwdqwdqwddqw"},{"id":"color_picker","value":"#000000"},{"id":"range","value":"57"},{"id":"accept_terms","value":"on"},{"id":"gender","value":"female"},{"id":"upload_file","value":["http:\/\/localhost:8000\/assets\/components\/uploads\/1726198454_e301f94e93b09b0533ab.json"]},{"id":"country","value":"us"},{"id":"comments","value":"greargegargerge"},{"id":"favorite_color","value":"green"},{"id":"gender2","value":"female"}]'

            // Store the formatted konten in the Twig loader
            $loader->setTemplate("komponen_$i", $x['konten_terformat']);

            $komponenTerformat[] = $x;
        }

        $this->data['halaman'] = $halaman;
        $this->data['komponen'] = $komponenTerformat;

        // dd($komponenTerformat);

        return view('halaman', $this->data);
    }
}
