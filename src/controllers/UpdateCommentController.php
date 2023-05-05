<?php

namespace App\Controllers;

use App\Lib\Database;
use App\Repository\CommentRepository;

class UpdateCommentController
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
