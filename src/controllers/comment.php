<?php

namespace App\Controllers;

use App\Lib\Database;
use App\Model\CommentRepository;

class Comment
{
    public function execute(int $id, $twig)
    {
        $connection = new Database();

        $commentRepository = new CommentRepository();
        $commentRepository->connection = $connection;
        $comment = $commentRepository->getComment($id);
    
        echo $twig->render('post.html.twig', ['comment' => $comment]);
    }
}

