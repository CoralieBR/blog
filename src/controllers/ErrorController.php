<?php

namespace App\Controllers;

class ErrorController extends AbstractController
{
    public function __construct(
        private \Twig\Environment $twig
    ) {
        parent::__construct($twig);
    }

    public function errorPage(?int $error = null, ?string $errorMessage = null)
    {
        return $this->render('error.html.twig', ['error' => $error, 'errorMessage' => $errorMessage]);
    }
}