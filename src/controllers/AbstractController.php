<?php

namespace App\Controllers;

abstract class AbstractController
{
    public function __construct(
        private \Twig\Environment $twig
    ) {
        $this->twig = $twig;
    }
}