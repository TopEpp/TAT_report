<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Language extends BaseController
{
    public function index()
    {
        $session = session();
        $language = \Config\Services::language();
        $locale = $this->request->getLocale();
        $session->remove('lang');
        $session->set('lang', $locale);
        return redirect()->to($url);
    }
}

?>