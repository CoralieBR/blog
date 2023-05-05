<?php

namespace App\Controllers;

use App\Lib\Database;
use App\Repository\PostRepository;

class SummaryController
{
    public function execute($twig)
    {
        $postRepository = new PostRepository();
        $postRepository->connection = new Database();
        $posts = $postRepository->getPosts();

        echo $twig->render('summary.html.twig', ['posts' => $posts]);
    }
}