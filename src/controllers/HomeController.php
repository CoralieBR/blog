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
        echo $this->twig->render('homepage.html.twig');
    }
}