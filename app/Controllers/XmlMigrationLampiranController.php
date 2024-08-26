<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use SimpleXMLElement;
use App\Models\KategoriModel;

class XmlMigrationLampiranController extends Controller
{
    protected $kategoriModel;
    function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        $this->kategoriModel = new KategoriModel();
    }
    public function migrate()
    {
        $db = \Config\Database::connect();
        $xmlFilePath = FCPATH . 'uploads/fakultasushuluddindandakwah.WordPress.2024-08-23.xml'; // Adjust path as necessary
        $xmlContent = file_get_contents($xmlFilePath);

        $xml = new SimpleXMLElement($xmlContent);

        // Register namespaces (if known) - example namespaces, adjust to your XML's namespaces
        $namespaces = $xml->getNamespaces(true);

        $dataToInsert = [];

        // Assuming XML structure where each item represents a post
        foreach ($xml->channel->item as $item) {
            // Use the registered namespaces to access namespaced tags
            $id = (string) $item->children($namespaces['wp'])->post_id;
            $uri = (string) $item->children($namespaces['wp'])->attachment_url;
            $postDate = (string) $item->children($namespaces['wp'])->post_date;
            $postModified = (string) $item->children($namespaces['wp'])->post_modified;
            $postType = (string) $item->children($namespaces['wp'])->post_type;

            if ($postType == 'attachment') {
                $data = [
                    'id'                 => $id,
                    'id_user'            => 3,  // Mapping logic for author
                    'uri'                 => $uri,
                    'judul'              => (string) $item->title,
                    'deskripsi'          => isset($item->description) ? (string) $item->description : null,
                    'created_at'         => $postDate,
                    'updated_at'         => $postModified,
                ];

                $dataToInsert[] = $data;
            }
        }

        // Debugging output
        // dd($dataToInsert);

        // Uncomment the following line to insert data after verifying it with dd()
        $db->table('lampiran')->insertBatch($dataToInsert);
    }

    private function getUserId($authorName)
    {
        // Logic to get user ID from author name
        // e.g., query your users table to find the matching author
    }

    private function getCategoryId($categoryName)
    {
        // Logic to get category ID from category name
        // e.g., query your categories table to find the matching category
        $kategori = $this->kategoriModel->getKategoriByNama($categoryName);

        if ($kategori) return $kategori['id'];
        else {
            $this->kategoriModel->save(['nama' => $categoryName]);
            return $this->kategoriModel->getInsertID();
        }
    }

    private function generateSlug($title)
    {
        return url_title($title, '-', true);
    }
}
