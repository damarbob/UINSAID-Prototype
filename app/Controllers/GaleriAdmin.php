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
        return $this->response->setJSON([
            "data" => format_tanggal($data)
        ]);
    }

    public function index()
    {
        $this->data['judul'] = 'Galeri';

        $galeriModel = $this->galeriModel;
        $this->data['images'] = $galeriModel->get();

        return view('admin_galeri', $this->data);
    }

    public function upload()
    {
        $galeriModel = $this->galeriModel;
        $imageFile = $this->request->getFile('image');

        // if ($imageFile->isValid() && !$imageFile->hasMoved()) {
        //     // Debugging output
        //     echo 'File is valid and not moved';
        //     // Your existing code
        // } else {
        //     echo 'File upload error: ' . $imageFile->getErrorString();
        // }

        if ($imageFile->isValid() && !$imageFile->hasMoved()) {
            $newName = $imageFile->getRandomName();
            $imageFile->move(FCPATH . 'uploads', $newName);

            $data = [
                'uri' => base_url('uploads/' . $newName),
                'judul' => $this->request->getPost('judul'),
                'alt' => $this->request->getPost('alt'),
                'deskripsi' => $this->request->getPost('deskripsi'),
            ];

            $galeriModel->save($data);

            return redirect()->to('admin/galeri')->with('message', 'Image uploaded successfully.');
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
            return redirect()->to('admin/galeri')->with('message', 'Metadata updated successfully.');
        }

        return redirect()->back()->with('error', 'Metadata update failed.');
    }
}
