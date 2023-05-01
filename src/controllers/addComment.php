<?php

namespace App\Controllers;

use App\Lib\Database;
use App\Model\CommentRepository;

class AddComment
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
		$commentRepository->connection = new Database();
		$success = $commentRepository->createComment($post, $title, $content);
		if (!$success) {
			throw new \Exception('Impossible d\'ajouter le commentaire!');
		} else {
			header('Location: index.php?action=post&id=' . $post);
		}
	}
}
