<?php

namespace Application\Controllers\Comment;

require_once('src/lib/database.php');
require_once('src/model/comment.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\Comment\CommentRepository;

class Comment
{
    public function execute(int $id)
    {
        $connection = new DatabaseConnection();

        $commentRepository = new CommentRepository();
        $commentRepository->connection = $connection;
        $comment = $commentRepository->getComment($id);
    
        require('templates/updateComment.php');
    }
}

