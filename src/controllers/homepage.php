<?php

namespace App\Controllers;

require_once('src/lib/database.php');
require_once('src/model/post.php');

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