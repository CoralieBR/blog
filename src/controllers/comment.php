<?php

namespace App\Controllers;

use App\Lib\Database;
use App\Model\CommentRepository;

class Comment
{
    public function execute(int $id)
    {
        $connection = new Database();

        $commentRepository = new CommentRepository();
        $commentRepository->connection = $connection;
        $comment = $commentRepository->getComment($id);
    
        require('templates/updateComment.php');
    }
}

