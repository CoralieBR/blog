<?php

namespace App\Controllers;

use App\Lib\Database;
use App\Model\PostRepository;

class Homepage
{
    public function execute()
    {
        $postRepository = new PostRepository();
        $postRepository->connection = new Database();
        $posts = $postRepository->getPosts();

        require('templates/homepage.php');
    }
}