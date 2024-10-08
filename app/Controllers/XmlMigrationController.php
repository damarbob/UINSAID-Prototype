<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use SimpleXMLElement;
use App\Models\KategoriModel;

class XmlMigrationController extends Controller
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

        $statusMapping = [
            'publish' => 'publikasi',
            'draft' => 'draf',
            'trash' => 'sampah'
        ];

        // Assuming XML structure where each item represents a post
        foreach ($xml->channel->item as $item) {
            // Use the registered namespaces to access namespaced tags
            $content = (string) $item->children($namespaces['content'])->encoded;
            $id = (string) $item->children($namespaces['wp'])->post_id;
            $status = (string) $item->children($namespaces['wp'])->status;
            $postDate = (string) $item->children($namespaces['wp'])->post_date;
            $postModified = (string) $item->children($namespaces['wp'])->post_modified;
            $postType = (string) $item->children($namespaces['wp'])->post_type;
            $status = $statusMapping[$status] ?? null;

            if (!$status || strlen($content) == 0) continue;

            if ($postType == "post") {
                $data = [
                    // 'id'                 => $id,
                    'id_penulis'         => 3,  // Mapping logic for author
                    'id_kategori'        => $this->getCategoryId($item->category),  // Mapping logic for category
                    'judul'              => (string) $item->title,
                    'konten'             => $content,
                    'ringkasan'          => isset($item->description) ? (string) $item->description : null,
                    'pengajuan'          => 'tidak diajukan',  // Default value, adjust if needed
                    'slug'               => $this->generateSlug((string) $item->title),  // Example slug generation
                    'status'             => $status,
                    'seo'                => 1,  // Default value, adjust if needed
                    'sumber'             => 'https://fud.uinsaid.ac.id', // Adjust
                    'tanggal_terbit'     => isset($item->pubDate) ? date('Y-m-d H:i:s', strtotime((string) $item->pubDate)) : null,  // Updated: format pubDate to datetime
                    'created_at'         => $postDate,
                    'updated_at'         => $postModified,
                    'gambar_sampul'      => isset($item->featured_image) ? (string) $item->featured_image : null,
                ];

                $dataToInsert[] = $data;
            }
        }

        // Debugging output
        // dd($dataToInsert);

        // Uncomment the following line to insert data after verifying it with dd()
        $db->table('posting')->insertBatch($dataToInsert);
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
