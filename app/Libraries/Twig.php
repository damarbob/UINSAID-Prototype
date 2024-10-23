<?php

namespace App\Libraries;

use App\Models\KategoriModel;
use App\Models\PostingModel;
// use CodeIgniter\HTTP\RequestInterface;
// use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use CodeIgniter\I18n\Time;
use Twig\Environment;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\Loader\FilesystemLoader;

use function App\Helpers\format_tanggal_suatu_kolom;

class Twig
{
    protected $twig;
    protected $kategoriModel;
    protected $postingModel;
    protected $request;
    protected $response;

    public function __construct()
    {
        helper('format');

        // Set up the loader (adjust to your views directory)
        $loader = new FilesystemLoader(APPPATH . 'Views');

        $this->kategoriModel = new KategoriModel();
        $this->postingModel = new PostingModel();
        $this->request = Services::request();
        $this->response = Services::response();

        // Create the Twig environment
        $this->twig = new Environment($loader, [
            'cache' => false, // Disable caching during development; set to WRITEPATH . 'cache/twig' in production
            'auto_reload' => true,
        ]);

        // Add custom 'humanize' filter
        $this->twig->addFilter(new TwigFilter('datehumanize', function ($date) {
            if (!$date) {
                return ''; // return an empty string if date is not provided
            }

            // Convert $date to a CodeIgniter Time instance and call humanize()
            return Time::parse($date)->humanize();
        }));

        // Add custom function to get all postings
        $this->twig->addFunction(new TwigFunction('get_all_posts', function () {
            return $this->postingModel->findAll();
        }));

        // Add custom function to get paginated posting
        $this->twig->addFunction(new TwigFunction('get_posting_paginated', function ($jenisNama) {
            $search = $this->request->getGet('search') ?? null;

            $posting = $this->postingModel->getPosting(jenisNama: $jenisNama, search: $search, status: 'publikasi', order: 'posting.tanggal_terbit', dir: 'DESC', paginated: true);
            $data['posting'] = format_tanggal_suatu_kolom($posting, 'tanggal_terbit', humanize: true);
            $data['postingPager'] = $this->postingModel->pager;
            $data['kategori'] = $this->kategoriModel->getKategoriByJenisNama($jenisNama);
            return $data;
        }));
    }

    // Render a view file as a Twig template
    public function render($template, $data = [])
    {
        return $this->twig->render($template, $data);
    }

    // Render a string as a Twig template
    public function renderTemplateString($templateString, $data = [])
    {
        // Use Twig's createTemplate() to render a raw string
        return $this->twig->createTemplate($templateString)->render($data);
    }
}
