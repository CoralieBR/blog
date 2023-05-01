<?php

namespace App\Controllers;

// require_once('src/lib/database.php');
// require_once('src/model/comment.php');

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

