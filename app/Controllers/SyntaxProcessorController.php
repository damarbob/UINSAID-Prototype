<?php

namespace App\Controllers;

use App\Controllers\BaseControllerAdmin;
use App\Libraries\DataSyntaxQueryProcessor;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class SyntaxProcessorController extends BaseControllerAdmin
{

    protected DataSyntaxQueryProcessor $dataSyntaxQueryProcessor;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $this->model = $this->komponenModel;
        $this->dataSyntaxQueryProcessor = new DataSyntaxQueryProcessor();
    }

    public function index()
    {
        return '$_REQUEST';
    }

    public function processDataSyntax()
    {

        $content = $this->request->getPost('content');
        // dd($content);

        $formattedcontent = $this->dataSyntaxQueryProcessor->processDataSyntaxV2($content);

        return $this->response->setJSON(json_encode([
            "data" => $formattedcontent
        ]));
    }

    public function processDataSyntaxTest()
    {

        $content = '[{"type":"meta","content":{"id":"judul_sambutan_rektor","nama":"Judul","tipe":"text","required":true,"value":"Ini adalah judul"}},{"type":"meta","content":{"id":"deskripsi_sambutan_rektor","nama":"Deskripsi","tipe":"editor","required":true,"value":"Ini adalah deskripsi"}},{"type":"meta","content":{"id":"link_selengkapnya","nama":"Link selengkapnya","tipe":"text","required":true,"value":"Ini adalah link selengkapnya"}},{"type":"meta","content":{"id":"checkbox_test","nama":"Ceklis","tipe":"checkbox","checked":true}},{"type":"meta","content":{"id":"gender","nama":"Jenis Kelamin","tipe":"checkboxes","options":{"type":"data","content":{"table":"kategori","select":"nama as value","orderby":"id ASC"}}}},{"type":"meta","content":{"id":"gender_radio","nama":"Jenis Kelamin","tipe":"radio","options":[{"value":"male","label":"Laki-laki"},{"value":"female","label":"Perempuan"}]}},{"type":"meta","content":{"id":"upload_file","nama":"Unggah Berkas","tipe":"file-multiple"}}]';
        // dd($content);

        $formattedcontent = $this->dataSyntaxQueryProcessor->processDataSyntaxV2($content);

        return $formattedcontent;
    }
}
