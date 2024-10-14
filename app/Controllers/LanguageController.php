<?php

namespace App\Controllers;

class LanguageController extends BaseController
{
    public function change()
    {
        if (isset($_POST)) {
            // Get the posted language
            $selectedLang = $this->request->getVar('language');

            // Set the locale based on the selected language
            switch ($selectedLang) {
                case 'ar':
                    $locale = 'ar_SA';
                    break;
                case 'en':
                    $locale = 'en_GB';
                    break;
                case 'id':
                    $locale = 'id_ID';
                    break;
                default:
                    $locale = 'id_ID';
            }

            // // Store the selected locale in the session
            session()->set('locale', $locale);

            // Return a JSON response for AJAX
            return $this->response->setJSON(['status' => 'success']);
        }

        // If not a POST request, return an error
        return $this->response->setJSON(['status' => 'error']);
    }
}
