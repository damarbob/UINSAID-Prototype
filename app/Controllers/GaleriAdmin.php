<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use function App\Helpers\delete_many;
use function App\Helpers\format_tanggal;

class GaleriAdmin extends BaseControllerAdmin
{
    public function get()
    {
        // Get the page, per_page, and search parameters from the request
        $page = $this->request->getGet('page') ?? 1;
        $perPage = $this->request->getGet('per_page') ?? 10;
        $search = $this->request->getGet('search') ?? '';

        // Fetch paginated data from the model with the search term
        $data = $this->galeriModel->getPaginated($page, $perPage, $search);

        // Format the data and return as JSON
        return $this->response->setJSON($data);
    }

    public function index()
    {
        $this->data['judul'] = lang('Admin.galeri');

        $page = $this->request->getGet('page') ?? 1;
        $perPage = $this->request->getGet('per_page') ?? 20;
        $search = $this->request->getGet('search') ?? '';

        $galeriModel = $this->galeriModel;
        $paginationData = $galeriModel->getPaginated($page, $perPage, $search);

        $this->data['images'] = $paginationData['data'];
        $this->data['total'] = $paginationData['total'];
        $this->data['perPage'] = $paginationData['perPage'];
        $this->data['currentPage'] = $paginationData['currentPage'];

        return view('admin_galeri', $this->data);
    }

    public function unggah()
    {
        $galeriModel = $this->galeriModel;
        $imageFile = $this->request->getFile('image');

        if ($imageFile->isValid() && !$imageFile->hasMoved()) {
            $validTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($imageFile->getMimeType(), $validTypes)) {
                return redirect()->back()->withInput()->with('error', lang('Admin.jenisFileTidakValidHanyaJPEGPNGGIFYangDiperbolehkan'));
            }

            $originalName = url_title(pathinfo($imageFile->getClientName(), PATHINFO_FILENAME), '-', false); // Get the original filename
            $randomName = $imageFile->getRandomName(); // Generate a random file name
            $imageFile->move(FCPATH . 'uploads', $originalName . '-' . $randomName);

            $data = [
                'uri' => base_url('uploads/' . $originalName . '-' . $randomName),
                'judul' => $this->request->getPost('judul'),
                'alt' => $this->request->getPost('alt'),
                'deskripsi' => $this->request->getPost('deskripsi'),
            ];

            $galeriModel->save($data);

            return redirect()->to('admin/galeri')->with('success', lang('Admin.gambarBerhasilDiunggah'));
        }

        return redirect()->back()->withInput()->with('error', lang('Admin.gagalMengunggahGambar'));
    }

    public function simpanMetadata($id)
    {
        $galeriModel = $this->galeriModel;

        $data = [
            'id' => $id,
            'judul' => $this->request->getPost('judul'),
            'alt' => $this->request->getPost('alt'),
            'deskripsi' => $this->request->getPost('deskripsi'),
        ];

        if ($galeriModel->save($data)) {
            return redirect()->to('admin/galeri')->with('success', lang('Admin.berhasilDiperbarui'));
        }

        return redirect()->back()->with('error', lang('Admin.gagalDiperbarui'));
    }

    public function hapus($id)
    {
        $galeriModel = $this->galeriModel;
        $image = $galeriModel->find($id);

        if ($image) {
            $filePath = FCPATH . 'uploads/' . basename($image['uri']);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $galeriModel->delete($id);
            return redirect()->to('admin/galeri')->with('success', lang('Admin.berhasilDihapus'));
        }

        return redirect()->to('admin/galeri')->with('error', lang('Admin.penghapusanGagal'));
    }

    public function hapusBanyak()
    {
        $galeriModel = $this->galeriModel;
        $ids = $this->request->getPost('image_ids');

        if (!empty($ids)) {
            foreach ($ids as $id) {
                $image = $galeriModel->find($id);
                if ($image) {
                    $filePath = FCPATH . 'uploads/' . basename($image['uri']);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
            }

            $galeriModel->delete($ids);
            return redirect()->to('admin/galeri')->with('success', lang('Admin.berhasilDihapus'));
        }

        return redirect()->to('admin/galeri')->with('error', lang('Admin.pilihItemDahulu'));
    }
}
