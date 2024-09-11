<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use function App\Helpers\delete_many;
use function App\Helpers\format_tanggal;

class FileAdmin extends BaseControllerAdmin
{
    public function get()
    {
        // Get the page, per_page, and search parameters from the request
        $page = $this->request->getGet('page') ?? 1;
        $perPage = $this->request->getGet('per_page') ?? 10;
        $search = $this->request->getGet('search') ?? '';

        // Fetch paginated data from the model with the search term
        $data = $this->fileModel->getPaginated($page, $perPage, $search);

        // Format the data and return as JSON
        return $this->response->setJSON($data);
    }

    public function index()
    {
        $this->data['judul'] = lang('Admin.file');

        $page = $this->request->getGet('page') ?? 1;
        $perPage = $this->request->getGet('per_page') ?? 20;
        $search = $this->request->getGet('search') ?? '';

        $fileModel = $this->fileModel;
        $paginationData = $fileModel->getPaginated($page, $perPage, $search);

        // $this->data['file'] = $fileModel->findAll();
        $this->data['file'] = $paginationData['data'];
        $this->data['total'] = $paginationData['total'];
        $this->data['perPage'] = $paginationData['perPage'];
        $this->data['currentPage'] = $paginationData['currentPage'];

        return view('admin_file', $this->data);
    }

    public function unggah()
    {
        $fileModel = $this->fileModel;
        $fileFile = $this->request->getFile('file');

        if ($fileFile->isValid() && !$fileFile->hasMoved()) {
            $validTypes = ['file', 'application/pdf'];
            if (!in_array($fileFile->getMimeType(), $validTypes)) {
                return redirect()->back()->withInput()->with('error', lang('Admin.jenisFileTidakValid'));
            }

            $newName = $fileFile->getRandomName();
            $fileFile->move(FCPATH . 'uploads', $newName);

            $data = [
                'uri' => base_url('uploads/' . $newName),
                'judul' => $this->request->getPost('judul'),
                'alt' => $this->request->getPost('alt'),
                'deskripsi' => $this->request->getPost('deskripsi'),
            ];

            $fileModel->save($data);

            return redirect()->to('admin/file')->with('success', lang('Admin.fileBerhasilDiunggah'));
        }

        return redirect()->back()->withInput()->with('error', lang('Admin.gagalMengunggahFile'));
    }

    public function simpanMetadata($id)
    {
        $fileModel = $this->fileModel;

        $data = [
            'id' => $id,
            'judul' => $this->request->getPost('judul'),
            'alt' => $this->request->getPost('alt'),
            'deskripsi' => $this->request->getPost('deskripsi'),
        ];

        if ($fileModel->save($data)) {
            return redirect()->to('admin/file')->with('success', lang('Admin.berhasilDiperbarui'));
        }

        return redirect()->back()->with('error', lang('Admin.gagalDiperbarui'));
    }

    public function hapus($id)
    {
        $fileModel = $this->fileModel;
        $file = $fileModel->find($id);

        if ($file) {
            $filePath = FCPATH . 'uploads/' . basename($file['uri']);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $fileModel->delete($id);
            return redirect()->to('admin/file')->with('success', lang('Admin.berhasilDihapus'));
        }

        return redirect()->to('admin/file')->with('error', lang('Admin.penghapusanGagal'));
    }

    public function hapusBanyak()
    {
        $fileModel = $this->fileModel;
        $ids = $this->request->getPost('file_ids');

        if (!empty($ids)) {
            foreach ($ids as $id) {
                $file = $fileModel->find($id);
                if ($file) {
                    $filePath = FCPATH . 'uploads/' . basename($file['uri']);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
            }

            $fileModel->delete($ids);
            return redirect()->to('admin/file')->with('success', lang('Admin.berhasilDihapus'));
        }

        return redirect()->to('admin/file')->with('error', lang('Admin.pilihItemDahulu'));
    }
}
