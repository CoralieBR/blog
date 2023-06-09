<?php

namespace App\Controllers;

abstract class AbstractController
{
    public function __construct(
        private \Twig\Environment $twig
    ) {
        $this->twig = $twig;
    }

    protected function render(string $view, array $parameters = [])
    {
        $parameters['app']['user'] = $_SESSION['user'] ?? null;
        echo $this->twig->render($view, $parameters);
        return;
    }
}