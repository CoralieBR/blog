<?php

namespace App\Controllers;

class HomeController extends AbstractController
{
    public function __construct(
        private \Twig\Environment $twig
    ) {
        parent::__construct($twig);
    }

    public function homepage()
    {
        return $this->render('homepage.html.twig');
    }
}