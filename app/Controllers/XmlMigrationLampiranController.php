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
        $xmlFilePath = FCPATH . 'uploads/bahan-migrasi.xml'; // Adjust path as necessary
        $xmlContent = file_get_contents($xmlFilePath);

        $xml = new SimpleXMLElement($xmlContent);

        // Register namespaces (if known) - example namespaces, adjust to your XML's namespaces
        $namespaces = $xml->getNamespaces(true);

        $dataToInsertToFile = [];
        $dataToInsertToGaleri = [];

        $ekstensiGambar = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg', 'tiff', 'raw'];
        $ekstensiFile = ['csv', 'pdf', 'pptx', 'docx', 'xlsx', 'ppt', 'doc', 'xls'];

        // Assuming XML structure where each item represents a post
        foreach ($xml->channel->item as $item) {

            $postType = (string) $item->children($namespaces['wp'])->post_type;

            if ($postType == 'attachment') {

                // Use the registered namespaces to access namespaced tags
                $uri = (string) $item->children($namespaces['wp'])->attachment_url;
                $ekstensi = pathinfo($uri, PATHINFO_EXTENSION);

                // Check extension for file
                if (in_array($ekstensi, $ekstensiFile)) {

                    $postDate = (string) $item->children($namespaces['wp'])->post_date;
                    $postModified = (string) $item->children($namespaces['wp'])->post_modified;

                    $data = [
                        'uri'                 => $uri,
                        'judul'              => (string) $item->title,
                        'deskripsi'          => isset($item->description) ? (string) $item->description : null,
                        'created_at'         => $postDate,
                        'updated_at'         => $postModified,
                    ];

                    $dataToInsertToFile[] = $data;
                }

                // Check extension for galeri
                elseif (in_array($ekstensi, $ekstensiGambar)) {

                    $postDate = (string) $item->children($namespaces['wp'])->post_date;
                    $postModified = (string) $item->children($namespaces['wp'])->post_modified;

                    $data = [
                        'uri'                 => $uri,
                        'judul'              => (string) $item->title,
                        'deskripsi'          => isset($item->description) ? (string) $item->description : null,
                        'created_at'         => $postDate,
                        'updated_at'         => $postModified,
                    ];

                    $dataToInsertToGaleri[] = $data;
                } else echo nl2br("Tidak ada data \n");
            }
        }

        // Debugging output
        // d($dataToInsertToFile);
        // dd($dataToInsertToGaleri);

        // Insert to file
        if ($dataToInsertToFile) {
            if ($db->table('file')->insertBatch($dataToInsertToFile) == false) {
                echo nl2br("Gagal migrasi data File \n");
            } else echo nl2br("Berhasil migrasi data File \n");
        } else echo nl2br("Tidak ada data file untuk dimigrasi \n");

        // Insert to galeri
        if ($dataToInsertToGaleri) {
            if ($db->table('galeri')->insertBatch($dataToInsertToGaleri) == false) {
                echo nl2br("Gagal migrasi data Galeri \n");
            } else echo nl2br("Berhasil migrasi data Galeri \n");
        } else echo nl2br("Tidak ada data galeri untuk dimigrasi \n");
    }
}
