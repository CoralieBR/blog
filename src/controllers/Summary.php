<?php

namespace App\Controllers;

use App\Lib\Database;
use App\Model\PostRepository;

class Summary
{
    public function execute($twig)
    {
        $postRepository = new PostRepository();
        $postRepository->connection = new Database();
        $posts = $postRepository->getPosts();

        echo $twig->render('summary.html.twig', ['posts' => $posts]);
    }
}