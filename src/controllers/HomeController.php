<?php

namespace App\Controllers;

class HomeController extends AbstractController
{
    public function __construct(
        private \Twig\Environment $twig
    ) {
        parent::__construct($twig);
    }

    public function homepage($input)
    {
        if (!empty($input)) {   
            mail('coralie.burtin@protonmail.com', $input['subject'], $input['message']);
        }
        return $this->render('homepage.html.twig'); 
    }
}