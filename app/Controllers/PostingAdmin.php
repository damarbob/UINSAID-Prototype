<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use function App\Helpers\create_slug;
use function App\Helpers\delete_many;
use function App\Helpers\format_tanggal;
use function App\Helpers\update_many;

class PostingAdmin extends BaseControllerAdmin
{

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index(): string
    {
        $this->data['judul'] = lang('Admin.posting');
        $this->data['jenis'] = $this->postingJenisModel->findAll();
        $this->data['is_parent_site'] = $this->isParentSite;
        $this->data['is_child_site'] = $this->isChildSite;
        return view('admin_posting', $this->data);
    }

    public function tambah(): string
    {
        $this->data['judul'] = lang('Admin.tambahPosting');
        $this->data['mode'] = "tambah";
        $this->data['kategori'] = $this->kategoriModel->findAll();
        $this->data['postingJenis'] = $this->postingJenisModel->findAll();
        return view('admin_posting_editor', $this->data);
    }

    public function sunting(): string
    {
        $id = $this->request->getGet('id');
        $this->data['judul'] = lang('Admin.suntingPosting');
        $this->data['mode'] = "sunting";
        $this->data['posting'] = $this->postingModel->getById($id); // 
        $this->data['kategori'] = $this->kategoriModel->findAll();
        $this->data['postingJenis'] = $this->postingJenisModel->findAll();

        return view('admin_posting_editor', $this->data);
    }

    // Fetch data untuk datatable
    public function fetchData()
    {

        $columns = ['judul', 'penulis', 'kategori', 'tanggal_terbit', 'status', 'posting_jenis_nama'];

        // $columns = [lang('Admin.judul'), lang('Admin.penulis'), lang('Admin.kategori'), lang('Admin.tanggal'), lang('Admin.status')];
        // Only if this is child site change the columns with 'pengajuan'
        if ($this->isChildSite) {
            // Child dan super ada kolom pengajuan (di view juga)
            $columns = ['judul', 'penulis', 'kategori', 'tanggal_terbit', 'status', 'posting_jenis_nama'];
        }

        $limit = $this->request->getPost('length');
        $start = $this->request->getPost('start');
        $order = $columns[$this->request->getPost('order')[0]['column']];
        $dir = $this->request->getPost('order')[0]['dir'];

        $search = $this->request->getPost('search')['value'] ?? null;
        $statusX = $this->request->getPost('status');
        $jenisNama = $this->request->getPost('jenisNama');

        $draw = $this->request->getPost('draw');
        $totalData = $this->postingModel->getTotalRecords();
        $totalFiltered = $totalData;

        $posting = $this->postingModel->getByFilter($limit, $start, $statusX, $search, $order, $dir, $jenisNama);

        if ($search || $statusX || $jenisNama) {
            $totalFiltered = $this->postingModel->getTotalRecords($jenisNama, $statusX, $search);
        }

        $data = [];
        if (!empty($posting)) {
            foreach ($posting as $row) {

                $nestedData['id'] = $row->id;
                $nestedData['judul'] = $row->judul;
                $nestedData['penulis'] = $row->penulis;
                $nestedData['kategori'] = $row->kategori;
                $nestedData['konten'] = $row->konten;
                $nestedData['ringkasan'] = $row->ringkasan;
                $nestedData['pengajuan'] = $row->pengajuan;
                $nestedData['tanggal_terbit'] = $row->tanggal_terbit;
                $nestedData['created_at'] = $row->created_at;
                $nestedData['status'] = $row->status;
                $nestedData['sumber'] = $row->sumber;
                $nestedData['seo'] = $row->seo;
                $nestedData['gambar_sampul'] = $row->gambar_sampul;
                $nestedData['posting_jenis_nama'] = $row->posting_jenis_nama;
                $data[] = $nestedData;
            }
        }

        $json_data = [
            "draw" => intval($draw),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        ];

        return $this->response->setJSON($json_data);
    }

    public function getPublikasi()
    {
        return $this->response->setJSON(json_encode([
            "data" => format_tanggal($this->postingModel->getPublikasi('berita'))
        ]));
    }

    public function getDraf()
    {
        return $this->response->setJSON(json_encode([
            "data" => format_tanggal($this->postingModel->getDraf('berita'))
        ]));
    }

    /**
     * Simpan posting, baik untuk menambah baru atau memperbarui data yang ada.
     *
     * Jika parameter $id bernilai null, fungsi ini akan menambah posting baru.
     * Jika $id berisi, maka fungsi ini akan memperbarui posting yang ada.
     *
     * Fungsi ini memvalidasi input berdasarkan mode (tambah atau perbarui). Untuk mode tambah,
     * judul harus unik. Kategori akan diperiksa, dan jika tidak ada, akan dibuat baru.
     * Setelah data berhasil disimpan, pengguna akan diarahkan kembali ke halaman yang sesuai.
     *
     * @param int|null $id ID dari posting yang akan diperbarui. Jika null, akan membuat posting baru.
     * @return \CodeIgniter\HTTP\RedirectResponse Mengembalikan respons redireksi ke halaman sebelumnya atau halaman edit.
     */
    public function simpan($id = null)
    {
        $modeTambah = is_null($id);

        $posting = $id ? $this->postingModel->find($id) : null;

        $judulLama = $id ? $posting['judul'] : null;
        $judulBaru = $this->request->getPost('judul');

        // Validasi input: jika buat baru, tambahkan 'is_unique' untuk mencegah judul yang sama.
        $rules = $this->formRules('required' . ($modeTambah || $judulLama != $judulBaru ? '|is_unique[posting.judul]' : ''));

        // URL untuk redireksi setelah penyimpanan
        $redirectTo = base_url('/admin/posting/' . ($modeTambah ? '' : 'sunting?id=' . $id));

        // Jika validasi gagal, kembalikan ke halaman sebelumnya (halaman buat posting) dengan input.
        if (!$this->validate($rules)) {
            return $modeTambah ? redirect()->back() : redirect()->to($redirectTo)->withInput();
        }

        // Dapatkan jenis postingan dan kategori dari input
        $postingJenisId = $this->request->getVar('posting_jenis');
        $postingJenisNama = $this->request->getVar('posting_jenis_lainnya'); // New posting_jenis name if "Add New" is selected
        $kategoriNama = $this->request->getVar('kategori') ?: $this->request->getVar('kategori_lainnya'); // New kategori name if "Add New" is selected

        // Check if a new posting_jenis needs to be created
        if (!$postingJenisId && $postingJenisNama) {
            $this->postingJenisModel->save(['nama' => $postingJenisNama]);
            $postingJenisId = $this->postingJenisModel->getInsertID(); // Get the newly inserted id
        }

        // Check if a new kategori needs to be created
        $kategori = $this->kategoriModel->getKategoriByNama($kategoriNama);
        if (!$kategori) {
            $this->kategoriModel->save(['nama' => $kategoriNama, 'id_jenis' => $postingJenisId]);
            $kategori = $this->kategoriModel->getKategoriByNama($kategoriNama);
        }

        $konten = $this->request->getVar('konten');

        $gambarDefault = base_url('assets/img/icon-notext.png');
        $gambarDiPosting = $this->postingModel->extract_all_images_from_html($konten, $gambarDefault, false);
        $gambarPertama = $gambarDiPosting[0]; // Gambar pertama di konten

        // Jika tidak ada gambar di konten, gunakan gambar default
        if ($gambarDefault == $gambarPertama) {
            $thumbnailPath = $gambarPertama;
        } else {

            $direktori = 'uploads/thumbnails/';

            foreach ($gambarDiPosting as $x) {
                $relativeThumbnailPath = $direktori . basename($x); //  relative path for thumbnail
                $thumbnailPath = base_url($relativeThumbnailPath);

                // Cek gambar thumbnail. Jika tidak ada thumbnail, buat file dan kompres gambar
                if (!file_exists(FCPATH . $relativeThumbnailPath)) {

                    // jika berhasil membuat thumbnail, simpan thumbnail path dan keluar loop
                    if ($this->kompresGambarThumbnail($x)) {
                        break;
                    }
                } else break; // Hentikan loop kalau ada file
            }
        }

        if (!file_exists(FCPATH . $relativeThumbnailPath)) {
            session()->setFlashdata('peringatan', lang('Admin.thumbnailTidakDitemukan'));
        }

        // Data yang akan disimpan
        $data = [
            'id_penulis' => auth()->id(),
            'id_kategori' => $kategori['id'],
            'id_jenis' => $postingJenisId ?? null, // Jenis postingan (null jika tidak ada)
            'judul' => $this->request->getVar('judul'),
            'slug' => create_slug($this->request->getVar('judul')),
            'konten' => $konten,
            'ringkasan' => $this->request->getVar('ringkasan'),
            'status' => $this->request->getVar('status'),
            'tanggal_terbit' => $this->request->getVar('tanggal_terbit'),
            'sumber' => base_url(),
            'gambar_sampul' => $thumbnailPath,
        ];

        // Jika id ada, tambahkan ke array data untuk pembaruan
        if (!$modeTambah) {
            $data['id'] = $id;
        }

        // Simpan atau perbarui data posting
        $this->postingModel->save($data);

        // Set pesan flash untuk hasil operasi
        session()->setFlashdata('sukses', lang('Admin.' . ($modeTambah ? 'berhasilDibuat' : 'berhasilDiperbarui')));

        return redirect()->to($redirectTo)->withInput();
    }


    // // Tambah rilis media. Jika ID kosong, buat baru. Jika id berisi, perbarui yang sudah ada.
    // public function simpan($id = null)
    // {

    //     $isCreateMode = ($id == null);

    //     // Validasi
    //     // Jika buat baru, tambahkan kondisi is_unique agar tidak ada judul posting yang sama.
    //     $rules = ($isCreateMode) ? $this->formRules('required|is_unique[posting.judul]') : $this->formRules('required');

    //     // Redireksi
    //     $redirectTo = ($isCreateMode) ? base_url('/admin/posting/') : base_url('/admin/posting/sunting?id=') . $id;

    //     // Cek validasi
    //     if (!$this->validate($rules)) {
    //         // dd("Dead by input validation");

    //         if ($isCreateMode) {
    //             return redirect()->back()->withInput();
    //         }

    //         return redirect()->to($redirectTo)->withInput();
    //     }

    //     // Get jenis postingan dari request
    //     $jenisNama = $this->request->getVar('jenis');

    //     // 
    //     $jenis = $this->postingJenisModel->getByNama($jenisNama);

    //     // Get kategori from the request
    //     $kategoriNama = $this->request->getVar('kategori') ?: $this->request->getVar('kategori_lainnya');

    //     // Check if the kategori exists
    //     $kategori = $this->kategoriModel->getKategoriByNama($kategoriNama);

    //     // If the kategori does not exist, create a new one
    //     if (!$kategori) {
    //         $this->kategoriModel->save(['nama' => $kategoriNama]);
    //         $kategori = $this->kategoriModel->getKategoriByNama($kategoriNama);
    //     }

    //     // Simpan rilis media
    //     if ($isCreateMode) {
    //         $user = [
    //             'id_penulis' => auth()->id(),
    //             'id_kategori' => $kategori['id'],
    //             'id_jenis' => ($jenis) ? $jenis['id'] : null, // Jenis postingan, jika $jenis tidak null, ambil 'id' nya
    //             'judul' => $this->request->getVar('judul'),
    //             'slug' => create_slug($this->request->getVar('judul')),
    //             'konten' => $this->request->getVar('konten'),
    //             'ringkasan' => $this->request->getVar('ringkasan'),
    //             'status' => $this->request->getVar('status'),
    //             'sumber' => base_url(),
    //             'tanggal_terbit' => $this->request->getVar('tanggal_terbit'),
    //         ];

    //         // Jika ID kosong, buat entri baru
    //         $this->postingModel->save($user);

    //         // dd($user);

    //         // Pesan berhasil diperbarui
    //         session()->setFlashdata('sukses', lang('Admin.berhasilDibuat'));
    //     } else {
    //         $user = [
    //             'id' => $id,
    //             'id_kategori' => $kategori['id'],
    //             'id_jenis' => $jenis['id'], // Jenis postingan
    //             'judul' => $this->request->getVar('judul'),
    //             'konten' => $this->request->getVar('konten'),
    //             'ringkasan' => $this->request->getVar('ringkasan'),
    //             'status' => $this->request->getVar('status'),
    //             'tanggal_terbit' => $this->request->getVar('tanggal_terbit'),
    //         ];

    //         // Jika id terisi, perbarui yang sudah ada
    //         $this->postingModel->save($user);

    //         // dd($user);

    //         // Pesan berhasil diperbarui
    //         session()->setFlashdata('sukses', lang('Admin.berhasilDiperbarui'));
    //     }

    //     return redirect()->to($redirectTo)->withInput();
    // }

    /**
     * Simpan gambar di uploads/thumbnails/ dan kompres gambar tersebut
     * 
     * @param string $gambar Absolut URL gambar yang akan dikompres
     * @return bool return false if thumbnail not created

     */
    private function kompresGambarThumbnail($gambar, $direktori = 'uploads/thumbnails/')
    {
        helper('setting');
        $sameHost = parse_url($gambar, PHP_URL_HOST) == parse_url(base_url(), PHP_URL_HOST);

        $relativeThumbnailPath = $direktori . basename($gambar); //  relative path for thumbnail
        $thumbnailPath = FCPATH . $relativeThumbnailPath; //  Destination path for thumbnail

        $targetFileSize = setting()->get('App.targetUkuranThumbnail') ?: 500 * 1024; // 300 KB in bytes
        // Introduce a buffer factor to prevent larger sizes (tweak if necessary)
        $bufferFactor = setting()->get('App.bufferFactorThumbnail') ?: 2; // A bit more aggressive to ensure we meet the target size

        // Cek link gambar, internal atau eksternal
        if ($sameHost) {

            $gambarFile = FCPATH . str_replace(base_url(), '', $gambar); // Get gambar file path

            if (!file_exists($gambarFile)) {
                return false;
            }

            $image = service('image')->withFile($gambarFile); // Just load the image, don't save yet

            $tipeGambar = $image->getMimeType(); // MIME Int

            if (filesize($gambarFile) <= $targetFileSize) {

                // Temporarily suppress warnings for image processing
                $oldErrorLevel = error_reporting(E_ERROR | E_PARSE);

                $image->save($thumbnailPath, 85);

                // Restore previous error reporting level
                error_reporting($oldErrorLevel);

                if (file_exists($thumbnailPath)) return true;
                else return false;
            }

            // Compress based on extension
            switch ($tipeGambar) {
                case image_type_to_mime_type(IMAGETYPE_GIF):
                    // GIF files are tricky; just save them directly
                    $image->save($thumbnailPath);
                    break;

                case image_type_to_mime_type(IMAGETYPE_JPEG):
                case image_type_to_mime_type(IMAGETYPE_JPEG2000):
                case image_type_to_mime_type(IMAGETYPE_PNG):
                case image_type_to_mime_type(IMAGETYPE_TIFF_II):
                case image_type_to_mime_type(IMAGETYPE_WEBP):

                    // Default compression is mainly based on resizing
                    $currentFileSize = filesize($gambarFile);
                    list($originalWidth, $originalHeight) = getimagesize($gambarFile);

                    // Calculate scaling factor with buffer
                    $scalingFactor = sqrt(($targetFileSize / $currentFileSize) / $bufferFactor);

                    // Calculate new dimensions
                    $newWidth = (int) ($originalWidth * $scalingFactor);
                    $newHeight = (int) ($originalHeight * $scalingFactor);

                    // Temporarily suppress warnings for image processing
                    $oldErrorLevel = error_reporting(E_ERROR | E_PARSE);

                    $image->resize($newWidth, $newHeight, true, 'width')->save($thumbnailPath, 80);

                    // Restore previous error reporting level
                    error_reporting($oldErrorLevel);

                    break;
                default:
                    // session()->setFlashdata('peringatan', lang('Admin.thumbnailGagalDisimpanFileTidakValid'));
                    return false;
            }
            if (file_exists($thumbnailPath)) return true;
            else return false;
        } else {

            // // Fetch the image content from the URL
            // $imageContent = file_get_contents($gambar);

            // if ($imageContent === false) {
            //     // Handle the error if the image cannot be retrieved
            //     return false;
            // }

            // // Get MIME type from the image URL headers
            // $mimeType = get_headers($gambar, 1)["Content-Type"] ?? null;

            // Download the image to a temporary file
            $tempPath = tempnam(sys_get_temp_dir(), 'image_');

            $ch = curl_init($gambar);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $imageContent = curl_exec($ch);
            curl_close($ch);

            if ($imageContent === false) {
                return false;
            }

            if (!file_put_contents($tempPath, file_get_contents($gambar))) {
                if (!file_put_contents($tempPath, $imageContent)) {
                    return false;
                }
            }

            if (!file_exists($tempPath)) {
                return false;
            }

            // Get MIME type of the downloaded image
            $mimeType = mime_content_type($tempPath);

            // Handle different MIME types
            switch ($mimeType) {
                case image_type_to_mime_type(IMAGETYPE_JPEG):
                case image_type_to_mime_type(IMAGETYPE_JPEG2000):
                case image_type_to_mime_type(IMAGETYPE_GIF):
                case image_type_to_mime_type(IMAGETYPE_PNG):
                case image_type_to_mime_type(IMAGETYPE_WEBP):
                    // $imageResource = imagecreatefromstring($imageContent);

                    break;
                default:
                    unlink($tempPath);
                    return false;
            }

            // if (!$imageResource) {
            //     unlink($tempPath);
            //     return false;
            // }
            $image = service('image')->withFile($tempPath);

            if ($image == null || $image->isValid() == false) {
                unlink($tempPath);
                return false;
            }

            // $originalFileSize = strlen($imageContent);
            $originalFileSize = filesize($tempPath);

            if ($originalFileSize <= $targetFileSize) {
                // Temporarily suppress warnings for image processing
                $oldErrorLevel = error_reporting(E_ERROR | E_PARSE);

                $image->save($thumbnailPath, 85);

                // Restore previous error reporting level
                error_reporting($oldErrorLevel);
                unlink($tempPath);
                if (file_exists($thumbnailPath)) return true;
                else return false;
            }

            // Calculate scaling factor
            $scalingFactor = sqrt(($targetFileSize / $originalFileSize) / $bufferFactor);
            // $newWidth = imagesx($imageResource) * $scalingFactor;
            // $newHeight = imagesy($imageResource) * $scalingFactor;
            $newWidth = $image->getWidth() * $scalingFactor;
            $newHeight = $image->getHeight() * $scalingFactor;

            // Temporarily suppress warnings for image processing
            $oldErrorLevel = error_reporting(E_ERROR | E_PARSE);

            // Resize and save the image
            $image->resize($newWidth, $newHeight, true) // Keep aspect ratio
                ->save($thumbnailPath, 85); // Save with 85% quality

            // Restore previous error reporting level
            error_reporting($oldErrorLevel);

            unlink($tempPath);

            if (file_exists($thumbnailPath)) return true;
            else return false;

            // Resize the image based on calculated scaling
            // $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
            // imagecopyresampled($resizedImage, $imageResource, 0, 0, 0, 0, $newWidth, $newHeight, imagesx($imageResource), imagesy($imageResource));

            // // Save image based on MIME type and compression
            // switch ($mimeType) {
            //     case image_type_to_mime_type(IMAGETYPE_JPEG):
            //     case image_type_to_mime_type(IMAGETYPE_JPEG2000):
            //         imagejpeg($resizedImage, $thumbnailPath, 85);
            //         break;

            //     case image_type_to_mime_type(IMAGETYPE_PNG):
            //         imagepng($resizedImage, $thumbnailPath, 8); // Compression level 0-9 (lower is higher quality)
            //         break;

            //     case image_type_to_mime_type(IMAGETYPE_GIF):
            //         imagegif($resizedImage, $thumbnailPath);
            //         break;

            //     case image_type_to_mime_type(IMAGETYPE_WEBP):
            //         imagewebp($resizedImage, $thumbnailPath, 80);
            //         break;
            // }

            // // Clean up resources
            // imagedestroy($imageResource);
            // imagedestroy($resizedImage);
        }

        // Final check if file size is still too large
        // if (filesize($thumbnailPath) > $targetFileSize) {
        //     throw new \RuntimeException('Unable to compress the image to the desired size');
        // }
        // return true;
    }

    public function ajukanBanyak()
    {
        $selectedData = $this->request->getPost('selectedData');

        // Extract IDs from the selected data
        $ids = array_column($selectedData, 'id');

        // Define the data to update for all selected records
        $updateData = [
            'pengajuan' => 'diajukan',
        ];

        // Call update_many with the array of IDs
        $result = update_many($ids, $this->postingModel, $updateData);

        // If the update was successful, send the data to another route
        if ($result) {
            // Send the data to the 'terima-posting' route
            $response = $this->sendToTerimaBerita($selectedData);

            $statusCode = $response->getStatusCode();
            $responseBody = json_decode((string) $response->getBody(), true);

            switch ($statusCode) {
                case 200:
                    if ($responseBody['status'] === 'success') {
                        return $this->response->setJSON(['status' => 'success', 'message' => lang('Admin.berhasilDiajukan')]);
                    } else {
                        return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.berhasilDiajukanTapiAdaMasalahPenerimaan')]);
                    }

                case 400:
                    return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.permintaanTidakValid')]);

                case 401:
                    return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.tidakDiizinkanAndaPerluLogin')]);

                case 403:
                    return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.aksesDitolakAndaTidakMemilikiIzin')]);

                case 404:
                    return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.ruteAtauSumberDayaTidakDitemukan')]);

                case 500:
                    return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.kesalahanServerSilakanCobaLagiNanti')]);

                default:
                    return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.terjadiKesalahanTidakTerdugaKodeStatus', ['kode' => $statusCode])]);
            }
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.gagalDiajukan')]);
        }
    }


    private function sendToTerimaBerita($selectedData)
    {
        $client = \Config\Services::curlrequest();

        $response = $client->post(base_url('api/posting-diajukan/terima-posting'), [
            'form_params' => [
                'selectedData' => $selectedData
            ]
        ]);

        return $response;
    }


    // TODO: USE TRANSLATION
    public function batalAjukanBanyak()
    {
        $selectedData = $this->request->getPost('selectedData');

        // Extract IDs from the selected data
        $selectedIds = array_column($selectedData, 'id');

        // Define the data to update for each record
        $updateData = [
            'pengajuan' => 'tidak diajukan',
        ];

        $result = update_many($selectedIds, $this->postingModel, $updateData);

        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'message' => lang('Admin.berhasilDibatalkan')]);
        } else {
            // Return an error message or any relevant response
            return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.gagalDibatalkan')]);
        }
    }

    public function hapusBanyak()
    {
        $selectedIds = $this->request->getPost('selectedIds');

        $result = delete_many($selectedIds, $this->postingModel);

        if ($result) {
            return $this->response->setJSON(['status' => 'success', 'message' => lang('Admin.berhasilDihapus')]);
        } else {
            // Return an error message or any relevant response
            return $this->response->setJSON(['status' => 'error', 'message' => lang('Admin.penghapusanGagal')]);
        }
    }

    // Aturan validasi form artikel
    public function formRules($rules_nama)
    {
        $rules = [
            'judul' => [
                'rules' => $rules_nama,
            ],
            'konten' => [
                'rules' => 'required',
            ],
            'status' => [
                'rules' => 'required',
            ],
            'tanggal_terbit' => [
                'rules' => 'required',
            ],
        ];

        return $rules;
    }

    // API Endpoint: unggah gambar ke server (untuk tinyMCE)
    public function unggahGambar()
    {
        $file = $this->request->getFile('file');

        if ($file->isValid() && !$file->hasMoved()) {
            $validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/heic', 'image/tiff', 'image/webp'];
            if (!in_array($file->getMimeType(), $validTypes)) {
                return $this->response->setStatusCode(400)->setJSON(['error' => lang('Admin.jenisFileTidakValid')]);
            }

            $originalName = url_title(pathinfo(pathinfo($file->getClientName(), PATHINFO_FILENAME), PATHINFO_FILENAME)); // Get the original filename
            $randomName = $file->getRandomName();

            $file->move(FCPATH . 'uploads/', $originalName . '-' . $randomName);

            $data = [
                'uri' => base_url('uploads/' . $originalName . '-' . $randomName),
                'judul' => $originalName,
                'alt' => $originalName,
            ];

            if ($this->galeriModel->insert($data)) {
                // Respons yang diharapkan tinyMCE
                $response = [
                    'location' => base_url('uploads/' . $originalName . '-' . $randomName),
                ];

                return $this->response->setStatusCode(200)->setJSON($response);
            } else $this->response->setStatusCode(400)->setJSON(['error' => lang('Admin.gagalMenyimpanGambar')]);
        } else {
            return $this->response->setStatusCode(400)->setJSON(['error' => lang('Admin.fileTidakValid')]);
        }
    }

    // API Endpoint: hapus gambar dari server
    public function hapusGambar()
    {
        $imageUrl = $this->request->getVar('image_url');

        // Extract the filename from the URL
        $filename = pathinfo($imageUrl, PATHINFO_BASENAME);

        // Construct the full server path
        $filePath = FCPATH . 'uploads/' . $filename;

        // Check if the file exists before attempting to delete
        if (file_exists($filePath)) {
            unlink($filePath);

            return $this->response->setStatusCode(200)->setJSON(['message' => lang('Admin.gambarTerhapus')]);
        } else {
            return $this->response->setStatusCode(404)->setJSON(['error' => lang('Admin.gambarTidakDitemukan')]);
        }
    }

    /**
     * Get kategori by posting jenis
     * 
     * @return JSON kategori Kategori based on posting jenis
     */
    public function getKategoriByJenis()
    {
        $id_jenis = $this->request->getPost('id_jenis');

        // Fetch kategori based on posting_jenis
        $kategori = $this->kategoriModel->where('id_jenis', $id_jenis)->findAll();

        // Return the results as JSON
        return $this->response->setJSON(['kategori' => $kategori]);
    }
}
