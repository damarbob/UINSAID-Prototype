<?php

namespace App\Libraries;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Twig
{
    protected $twig;

    public function __construct()
    {
        // Set up the loader (adjust to your views directory)
        $loader = new FilesystemLoader(APPPATH . 'Views');

        // Create the Twig environment
        $this->twig = new Environment($loader, [
            'cache' => false, // Disable caching during development; set to WRITEPATH . 'cache/twig' in production
            'auto_reload' => true,
        ]);
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
