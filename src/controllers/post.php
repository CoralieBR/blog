<?php

namespace App\Controllers;

// require_once('src/lib/database.php');
// require_once('src/model/comment.php');
// require_once('src/model/post.php');

// spl_autoload_register(function($fqcn){
// 	$path = str_replace(['App', '\\'], ['src', '/'], $fqcn) . '.php';
// 	var_dump($path);
// 	require $path;
// });

use App\Lib\Database;
use App\Model\CommentRepository;
use App\Model\PostRepository;

class Post
{
    public function execute(int $id)
    {
        $connection = new Database();

        $postRepository = new PostRepository();
        $postRepository->connection = $connection;
        $post = $postRepository->getPost($id);
    
        $commentRepository = new CommentRepository();
        $commentRepository->connection = $connection;
        $comments = $commentRepository->getComments($id);
        require('templates/post.php');
    }
}

