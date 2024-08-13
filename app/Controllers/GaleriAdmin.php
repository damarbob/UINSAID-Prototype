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
        $this->data['judul'] = 'Galeri';

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

    public function upload()
    {
        $galeriModel = $this->galeriModel;
        $imageFile = $this->request->getFile('image');

        if ($imageFile->isValid() && !$imageFile->hasMoved()) {
            $validTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($imageFile->getMimeType(), $validTypes)) {
                return redirect()->back()->withInput()->with('error', 'Invalid file type. Only JPEG, PNG, and GIF files are allowed.');
            }

            $newName = $imageFile->getRandomName();
            $imageFile->move(FCPATH . 'uploads', $newName);

            $data = [
                'uri' => base_url('uploads/' . $newName),
                'judul' => $this->request->getPost('judul'),
                'alt' => $this->request->getPost('alt'),
                'deskripsi' => $this->request->getPost('deskripsi'),
            ];

            $galeriModel->save($data);

            return redirect()->to('admin/galeri')->with('success', 'Image uploaded successfully.');
        }

        return redirect()->back()->withInput()->with('error', 'Image upload failed.');
    }

    public function updateMetadata($id)
    {
        $galeriModel = $this->galeriModel;

        $data = [
            'id' => $id,
            'judul' => $this->request->getPost('judul'),
            'alt' => $this->request->getPost('alt'),
            'deskripsi' => $this->request->getPost('deskripsi'),
        ];

        if ($galeriModel->save($data)) {
            return redirect()->to('admin/galeri')->with('success', 'Metadata updated successfully.');
        }

        return redirect()->back()->with('error', 'Metadata update failed.');
    }

    public function delete($id)
    {
        $galeriModel = $this->galeriModel;
        $image = $galeriModel->find($id);

        if ($image) {
            $filePath = FCPATH . 'uploads/' . basename($image['uri']);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $galeriModel->delete($id);
            return redirect()->to('admin/galeri')->with('success', 'Image deleted successfully.');
        }

        return redirect()->to('admin/galeri')->with('error', 'Image not found.');
    }

    public function deleteMultiple()
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
            return redirect()->to('admin/galeri')->with('success', 'Selected images deleted successfully.');
        }

        return redirect()->to('admin/galeri')->with('error', 'No images selected for deletion.');
    }
}
