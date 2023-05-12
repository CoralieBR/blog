<?php

namespace App\Controllers;

use App\Lib\Database;
use App\Repository\CommentRepository;

class CommentController extends AbstractController
{
    public function __construct(
        private \Twig\Environment $twig,
        private CommentRepository $commentRepository
    ) {
        parent::__construct($twig);
        $this->commentRepository = $commentRepository;
    }

    public function show(int $id)
    {
        $comment = $this->commentRepository->getComment($id);
    
        echo $this->twig->render('post.html.twig', ['comment' => $comment]);
    }

    public function add(int $post, array $input)
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

    public function update(int $commentId, array $input)
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

