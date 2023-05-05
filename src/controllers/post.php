<?php

namespace App\Controllers;

use App\Lib\Database;
use App\Model\CommentRepository;
use App\Model\PostRepository;

class Post
{
    public function execute(int $id, $twig)
    {
        $connection = new Database();

        $postRepository = new PostRepository();
        $postRepository->connection = $connection;
        $post = $postRepository->getPost($id);
    
        $commentRepository = new CommentRepository();
        $commentRepository->connection = $connection;
        $comments = $commentRepository->getComments($id);
        echo $twig->render('post.html.twig', [
            'post' => $post,
            'comments' => $comments
        ]);
    }
}

