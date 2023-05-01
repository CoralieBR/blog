<?php

namespace App\Controllers;

// require_once('src/lib/database.php');
// require_once('src/model/comment.php');

use App\Lib\Database;
use App\Model\CommentRepository;

class UpdateComment
{
	public function execute(int $commentId, array $input)
	{
		$commentRepository = new CommentRepository();
		$commentRepository->connection = new Database();

		$comment = $commentRepository->getComment($commentId);

		$title = $input['title'] ?? $comment->getTitle();
		$content = $input['content'] ?? $comment->getContent();

		$success = $commentRepository->updateComment($commentId, $title, $content);
		if (!$success) {
			throw new \Exception('Impossible de modifier le commentaire!');
		} else {
			header('Location: index.php?action=post&id=' . $comment->getPost());
		}
	}
}
