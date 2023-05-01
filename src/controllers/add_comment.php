<?php

namespace Application\Controllers\AddComment;

require_once('src/lib/database.php');
require_once('src/model/comment.php');

use Application\Lib\Database\DatabaseConnection;
use Application\Model\Comment\CommentRepository;

class addComment
{
	public function execute(int $post, array $input)
	{
		$title = null;
		$content = null;
		if (!empty($input['title']) && !empty($input['content'])) {
			$title = $input['title'];
			$content = $input['content'];
		} else {
			die('Les données du formulaire sont invalides.');
		}

		$commentRepository = new CommentRepository();
		$commentRepository->connection = new DatabaseConnection();
		$success = $commentRepository->createComment($post, $title, $content);
		if (!$success) {
			throw new \Exception('Impossible d\'ajouter le commentaire!');
		} else {
			header('Location: index.php?action=post&id=' . $post);
		}
	}
}
