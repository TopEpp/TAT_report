<?php 

namespace App\Libraries;

class Template 
{
    public function render($view, $data = [])
    {
        echo view('templates/header', $data);
        echo view($view, $data);
        echo view('templates/footer', $data);

        // echo view('templates/main', $data);
    }
}