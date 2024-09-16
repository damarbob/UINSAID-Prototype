<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use DateTime;
use Psr\Log\LoggerInterface;

use function App\Helpers\format_tanggal;
use function App\Helpers\format_tanggal_suatu_kolom;

class HalamanAdmin extends BaseControllerAdmin
{
    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $this->model = $this->halamanModel;
    }

    public function index()
    {
        $this->data['judul'] = lang('Admin.halaman');
        $this->data['halaman'] = $this->model->findAll();
        return view('admin_halaman', $this->data);
    }

    /**
     * Get data for DataTables server-side processing
     *
     * @param string|null $status Optional status filter
     * @return $this
     */
    public function getDT($status = null)
    {
        $columns = ['id', 'judul', 'slug', 'id_komponen', 'css', 'js', 'status', 'created_at'];

        $limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];

        $search = $this->request->getPost('search')['value'] ?? null;
        $totalData = $this->model->countAll();
        $totalFiltered = $totalData;

        $halaman = $this->model->getDT($limit, $start, $status, $search, $order, $dir);

        if ($search || $status) {
            $totalFiltered = $this->model->getTotalFilteredRecordsDT($status, $search);
        }

        $data = [];
        if (!empty($halaman)) {
            foreach ($halaman as $row) {

                $nestedData['id'] = $row['id'];
                $nestedData['judul'] = $row['judul'];
                $nestedData['slug'] = $row['slug'];
                $nestedData['id_komponen'] = $row['id_komponen'];
                $nestedData['css'] = $row['css'];
                $nestedData['js'] = $row['js'];
                $nestedData['status'] = $row['status'];
                $nestedData['created_at'] = $row['created_at'];
                $data[] = $nestedData;
            }
        }

        $json_data = [
            "draw" => intval($this->request->getPost('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        ];

        return $this->response->setJSON($json_data);
    }

    public function tambah()
    {
        $this->data['judul'] = lang('Admin.buatHalaman');
        $this->data['availableComponents'] = $this->komponenModel->findAll();
        return view('admin_halaman_editor', $this->data);
    }

    // Edit a specific page
    public function sunting($id)
    {
        $halaman = $this->model->find($id);
        $this->data['judul'] = lang('Admin.suntingHalaman') . " - " . $halaman['judul'];
        $id_komponen = json_decode($halaman['id_komponen']);
        $komponen = [];
        if ($id_komponen) {
            foreach ($id_komponen as $id) {
                $komponen[] = $this->komponenModel->find($id);
            }
        }
        $this->data['halaman'] = $halaman;
        $this->data['komponen'] = $komponen;
        $this->data['availableComponents'] = $this->komponenModel->findAll();

        return view('admin_halaman_editor', $this->data);
    }

    // Save the reordered components
    public function simpan($id = null)
    {
        $newOrder = $this->request->getPost('id_komponen'); // List ID komponen

        // Check for file uploads
        $cssFile = $this->request->getFile('css_file');
        $jsFile = $this->request->getFile('js_file');

        // Initialize file paths
        $cssPath = null;
        $jsPath = null;

        // Handle CSS file upload
        if ($cssFile && $cssFile->isValid() && !$cssFile->hasMoved()) {
            $originalName = url_title(pathinfo($cssFile->getClientName(), PATHINFO_FILENAME), '-', false); // Get the original filename
            $randomName = $cssFile->getRandomName(); // Generate a random file name
            $cssFile->move(FCPATH . 'assets/pages/css/', $originalName . '-' . $randomName);
            $cssPath = base_url('assets/pages/css/' . $originalName . '-' . $randomName);
        }

        // Handle JS file upload
        if ($jsFile && $jsFile->isValid() && !$jsFile->hasMoved()) {
            $originalName = url_title(pathinfo($jsFile->getClientName(), PATHINFO_FILENAME), '-', false); // Get the original filename
            $randomName = $jsFile->getRandomName(); // Generate a random file name
            $jsFile->move(FCPATH . 'assets/pages/js/', $originalName . '-' . $randomName);
            $jsPath = base_url('assets/pages/js/' . $originalName . '-' . $randomName);
        }

        $data = [
            'judul' => $this->request->getPost('judul'),
            'slug' => $this->request->getPost('slug'),
            'id_komponen' => $newOrder,
            'css' => $cssPath,
            'js' => $jsPath,
        ];

        if ($id) {
            $this->model->update($id, $data);
        } else {
            $this->model->insert($data);
        }

        return redirect()->to('/admin/halaman')->with('message', 'Halaman saved successfully.');
    }

    // Rename the function to avoid conflicts
    function formatDateTime($datetime)
    {
        return date('M Y, H:i', strtotime($datetime));
    }

    function replaceMetaSyntax($htmlSource, $metaSource)
    {
        // Decode the meta source JSON into an associative array
        $metaDataArray = json_decode($metaSource, true);

        // Create an associative array for quick lookup by ID
        $metaDataMap = [];
        foreach ($metaDataArray as $metaData) {
            $metaDataMap[$metaData['id']] = $metaData;
        }

        // Function to replace meta syntax with values
        $pattern = '/\/\* meta \{(.*?)\} meta \*\//';
        $replacementCallback = function ($matches) use ($metaDataMap) {
            // Decode the meta data from the match
            $meta = json_decode('{' . $matches[1] . '}', true);

            // Check if the meta ID exists
            if (!isset($metaDataMap[$meta['id']])) {
                return $matches[0]; // Return the original if not found
            }

            $metaData = $metaDataMap[$meta['id']];
            $value = $metaData['value'];
            $output = '';

            // Handle different types
            switch ($meta['tipe']) {
                case 'text':
                case 'number':
                case 'email':
                case 'password':
                case 'color':
                case 'textarea':
                    $output = htmlspecialchars($value); // Use htmlspecialchars for safety
                    break;

                case 'datetime-local':
                    $output = $this->formatDateTime($value);
                    break;

                case 'radio':
                    // Assuming the value is one of the options' values
                    foreach ($meta['options'] as $option) {
                        if ($option['value'] === $value) {
                            $output = $option['label'];
                            break;
                        }
                    }
                    break;

                case 'checkbox':
                    $output = $value ? 'on' : 'off'; // Assuming 'on' for checked, 'off' for unchecked
                    break;

                case 'file':
                    $output = is_array($value) ? implode(', ', $value) : $value;
                    break;

                case 'select':
                    // Assuming the value is one of the options' values
                    foreach ($meta['options'] as $option) {
                        if ($option['value'] === $value) {
                            $output = $option['label'];
                            break;
                        }
                    }
                    break;

                default:
                    $output = htmlspecialchars($value); // Default case
                    break;
            }

            return $output;
        };

        // Replace the meta syntax in the HTML source
        $result = preg_replace_callback($pattern, $replacementCallback, $htmlSource);

        return $result;
    }

    /**
     * Frontend view
     * 
     * @param int Id of the page
     * @return string Halaman page
     */
    public function view($id)
    {
        $halaman = $this->model->find($id);
        $id_komponen = json_decode($halaman['id_komponen']);
        $komponen = [];

        if ($id_komponen) {
            foreach ($id_komponen as $id_komponen) {
                $komponen[] = $this->komponenModel->find($id_komponen);
            }
        }

        $komponenTerformat = [];
        foreach ($komponen as $x) {
            // dd($x['konten']);
            $x['konten_terformat'] = $this->replaceMetaSyntax($x['konten'], '[{"id":"bold_text","value":"zzsx"},{"id":"italic_text","value":"zzzzzz"},{"id":"underline_text","value":"zzzzzzzzzzzz"},{"id":"strikethrough_text","value":"zzzzzzzzzzzzzzzzz"},{"id":"number","value":"22222"},{"id":"datetime","value":"2024-09-13T10:33"},{"id":"email","value":"simslifepbluns@gmail.com"},{"id":"password","value":"wdqwdqwdqwddqw"},{"id":"color_picker","value":"#000000"},{"id":"range","value":"57"},{"id":"accept_terms","value":"on"},{"id":"gender","value":"female"},{"id":"upload_file","value":["http:\/\/localhost:8000\/assets\/components\/uploads\/1726198454_e301f94e93b09b0533ab.json"]},{"id":"country","value":"us"},{"id":"comments","value":"greargegargerge"},{"id":"favorite_color","value":"green"},{"id":"gender2","value":"female"}]');
            // dd($x['konten_terformat']);
            $komponenTerformat[] = $x;
        }

        $this->data['halaman'] = $halaman;
        $this->data['komponen'] = $komponenTerformat;

        ///////////////
        helper('format');
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
            'sambutan'    => 'LURIK yang berakronim “Loyal, Unggul, Responsif, Inovatif dan Kolaboratif” LURIK pertama adalah Loyal, yang menuntut para pejabat untuk memiliki sikap loyal terhadap Negara Kesatuan Republik Indonesia (NKRI), Kementerian Agama, dan UIN Raden Mas Said Surakarta. <br><br>LURIK kedua adalah Unggul, mengajak para pejabat untuk bekerja maksimal dan optimal, serta sekuat tenaga meraih keunggulan lembaga, dengan cara melakukan Konsolidasi, Mobilisasi dan Orkestrasi (KMO) dengan pimpinan di lembaga masing-masing,untuk merencanakan program-program unggulan dalam rangka Glokalisasi UIN Raden Mas Said Surakarta.'
        ];

        $this->data['poinAkademik'] = [
            [
                'gambar'        => 'assets/img/mahasiswa/mahasiswa-1.png',
                'judul'         => 'Program Studi',
                'keterangan'    => 'Berbagai program  pendidikan sarjana, spesialis, magister, dan doktoral tersedia  sesuai minat Anda untuk mendukung karir dan keahlian profesional di masa  depan.',
            ],
            [
                'gambar'        => 'assets/img/mahasiswa/mahasiswa-2.png',
                'judul'         => 'Pendaftaran Mahasiswa Baru',
                'keterangan'    => 'Penerimaan mahasiswa tahun akademik baru sudah dibuka. klik slengkapnya untuk Informasi jalur  penerimaan dan jadwal penerimaan mahasiswa, serta pendaftaran online  calon mahasiswa baru'
            ],
            [
                'gambar'        => 'assets/img/mahasiswa/mahasiswa-3.png',
                'judul'         => 'Informasi Beasiswa',
                'keterangan'    => 'Beasiswa diberikan kepada mahasiswa/i yang memiliki prestasi akademik  yang berkomitmen dalam berbagai kegiatan ekstrakurikuler,  dan memenuhi kriteria-kriteria tertentu sesuai dengan ketentuan yang  berlaku.'
            ],
            [
                'gambar'        => 'assets/img/mahasiswa/mahasiswa-4.png',
                'judul'         => 'Informasi Layanan',
                'keterangan'    => 'Kami menawarkan beragam layanan dan fasilitas mendukung seperti laboratorium, pusat olahraga, dan ruang belajar yang nyaman serta dukungan akademik, bantuan keuangan, dan layanan pengaduan tersedia untuk membantu anda'
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
                    'judul'         => 'Riset dan Penelitian',
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

        $this->data['prestasiTerbaru'] = [
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
        $this->data['kegiatanTerbaru'] = [
            [
                'gambar'                => 'assets/img/wisuda.jpeg',
                "judul"                 => "UKM JQH Al-Wustha Kembali Juara Dalam Lomba Hadroh di Surakarta",
                "slug"                  => "https://www.uinsaid.ac.id/id/ukm-jqh-al-wustha-kembali-juara-dalam-lomba-hadroh-di-surakarta",
                "meta_description"      => "Unit Kegiatan Kampus (UKM) Jam'iyyah Al-Qurra' Wa Al-Huffazh atau yang akrab di panggil JQH Al-Wustha kembali juara dalam sebuah lomba Rebana di Surakarta. Lomba ini kebetulan di gelar oleh mitra 10 Supermarket Bahan Bangunan Solo Baru untuk merayakan anniversary-nya yang ke-27 tahun. Dalam perayaannya, instansi tersebut mengadakan “Hadroh dan Rebana Competition”. Dalam lomba tersebut oleh penyelenggara Mitra 10 Solo Baru, UKM (JQH) Al-Wusth UIN Raden Mas Said Surakarta terpilih menjadi juara 3.",
                "featured_image"        => "https://www.uinsaid.ac.id/files/upload/juara.jpg",
                "tgl_terbit_terformat"  => " 30 Maret 2024",
                "kategori"  => " 30 Maret 2024"
            ],
            [
                'gambar'                => 'assets/img/wisuda.jpeg',
                "judul" => "Tuai Prestasi Membanggakan, Juara 1 Tilawah Putra di RRI Surakarta",
                "slug" => "https://www.uinsaid.ac.id/id/tuai-prestasi-membanggakan-juara-1-tilawah-putra-di-rri-surakarta",
                "meta_description" => "Unit Kegiatan Mahasiswa (UKM) Jam’iyyah Al-Qurra’ Wa Al-Huffazh (JQH) Al-Wustha Universitas Islam Negeri (UIN) Raden Mas (RM) Said Surakarta berhasil juarai Lomba Pekan Tilawatil Qur’an yang diselenggarakan oleh RRI Surakarta. Lomba yang dimenangkan oleh Muhammad Fadhli Azra Maulana atau yang akrab disapa Fadhli tersebut setelah UKM JQH Al-Wustha mengirimkan 2 orang peserta lomba Tahfidz dari Divisi Tahfizh, dan 4 orang peserta lomba Tilawah dari Divisi Tilawah. Fadhli adalah salah satu dari enam mahasiswa yang namanya terpampang sebagai Juara 1 dan berhak mewakili LPP RRI Surakarta. Dirinya juga akan mengikuti perlombaan berikutnya di tingkat Korwil XI yang akan diselenggarakan di Yogyakarta nantinya.",
                "featured_image" => "https://www.uinsaid.ac.id/files/post/cover/tuai-prestasi-membanggakan-juara-1-tilawah-putra-d-1710983872.jpg",
                "tgl_terbit_terformat"  => " 30 Maret 2024",
                "kategori"  => " 30 Maret 2024"
            ],
            [
                'gambar'                => 'assets/img/wisuda.jpeg',
                "judul" => "UIN RM Said Terima Penghargaan LPM PTKI Challenge 2023",
                "slug" => "https://www.uinsaid.ac.id/id/uin-rm-said-terima-penghargaan-lpm-ptki-challenge-2023",
                "meta_description" => "Universitas Islam Negeri Raden Mas Said (UIN RM Said) Surakarta terus menapak semakin mantap menuju global sesuai dengan Program Besar saat ini yakni Glokalisasi. Hal ini dibuktikan dengan semakin banyaknya prestasi yang diraih oleh kampus di wilayah solo raya ini. Salah satunya adalah dengan diterimanya Penghargaan LPM PTKI Challenge Tahun 2023. Kegiatan yang diselenggarakan oleh Direktorat Pendidikan Tinggi Keagamaan Islam (Dit Diktis PTKI) Direktorat Jenderal Pendidikan Islam (Dirjen Pendis) Kementerian Agama RI pada tahun 2023 ini sebagai bagian dari apresiasi atas kinerja Kampus PTKI dalam melakukan pembinaan terhadap Lembaga Pers Mahasiswa (LPM). ",
                "featured_image" => "https://www.uinsaid.ac.id/files/post/cover/uin-rm-said-terima-penghargaan-lpm-ptki-challenge--1702610374.JPG",
                "tgl_terbit_terformat"  => " 30 Maret 2024",
                "kategori"  => " 30 Maret 2024"
            ],
            [
                'gambar'                => 'assets/img/wisuda.jpeg',
                "judul" => "Gara-Gara MATI LAMPU, UKM TEATER SIRAT Menang 4 Nominasi",
                "slug" => "https://www.uinsaid.ac.id/id/gara-gara-mati-lampu-ukm-teater-sirat-menang-4-nominasi",
                "meta_description" => "Gara-gara mati lampu, Unit Kegiatan Mahasiswa (UKM) Teater Sirat pulang malah borong sejumlah piala. UKM Teater Sirat Universitas Islam Negeri (UIN) Raden Mas Said (RM Said) Surakarta (15/11/2023) malah memborong sejumlah piala dari Festival Diorama tahun ini.",
                "featured_image" => "https://www.uinsaid.ac.id/files/upload/sirat%201.jpg",
                "tgl_terbit_terformat"  => " 30 Maret 2024",
                "kategori"  => " 30 Maret 2024"
            ],
            [
                'gambar'                => 'assets/img/wisuda.jpeg',
                "judul" => "JUARA!! Bawa Pulang Emas dan Perak di Detik Akhir",
                "slug" => "https://www.uinsaid.ac.id/id/juara-bawa-pulang-emas-dan-perak-di-detik-akhir",
                "meta_description" => "Raih Juara 1 dan Juara 2 di FINAL. Hari keempat pelaksanaan PORSI JAWARA 1 Sabtu, (4/11) pada pertandingan terakhir cabang olahraga Taekwondo (Poomsae Individu Putra) & Bulu Tangkis (Tinggal Putra) bertempat di Gor Argopuro & Gd. Serba Guna, Kaliwates, Jember.",
                "featured_image" => "https://www.uinsaid.ac.id/files/upload/IMG-20231104-WA0020.jpg",
                "tgl_terbit_terformat"  => " 30 Maret 2024",
                "kategori"  => " 30 Maret 2024"
            ]
        ];

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
        $this->data['pojokPimpinan'] = [
            [
                "judul"     => "KKN Internasional & Upaya Peningkatan Daya Saing Global",
                "ringkasan" => "Mahasiswa UIN Raden Mas Said Surakarta, seperti mahasiswa di seluruh dunia lainnya, dihadapkan pada persaingan global yang menuntut kemampuan adaptasi dan bersaing di berbagai bidang."
            ],
            [
                "judul"     => "KKN Internasional & Upaya Peningkatan Daya Saing Global",
                "ringkasan" => "Mahasiswa UIN Raden Mas Said Surakarta, seperti mahasiswa di seluruh dunia lainnya, dihadapkan pada persaingan global yang menuntut kemampuan adaptasi dan bersaing di berbagai bidang."
            ],
        ];
        $this->data['opini'] = [
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
        //////////////

        return view('halaman', $this->data);
    }
}
