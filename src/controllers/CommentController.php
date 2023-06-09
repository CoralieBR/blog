<?php

namespace App\Controllers;

use App\Entity\Comment;
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

    public function add(int $post, array $input)
	{
        $comment = new Comment();
		if (!empty($input['title']) && !empty($input['content'])) {
			if (is_string($input['title'])) {
                $comment->setTitle($input['title']);
            }
			if (is_string($input['content'])) {
                $comment->setContent($input['content']);
            }
            $comment->setPost($post);
		} else {
			die('Les données du formulaire sont invalides.');
		}

		$success = $this->commentRepository->createComment($comment);

		if (!$success) {
			throw new \Exception('Impossible d\'ajouter le commentaire!');
		} else {
			header('Location: ?action=post&id=' . $post);
		}
	}

    public function update(int $commentId, array $input)
	{
		$comment = $this->commentRepository->getComment($commentId);
        if (empty($comment)) {
            header("Location: /blog");
        }

        if (empty($input)) {
            echo $this->twig->render('updateComment.html.twig', ['comment' => $comment]);
            return;
        }

        if (!empty($input['title']) && is_string($input['title'])) {
            $comment->setTitle($input['title']);
        }
        if (!empty($input['content']) && is_string($input['content'])) {
            $comment->setContent($input['content']);
        }

		$success = $this->commentRepository->updateComment($comment);
		if (!$success) {
			throw new \Exception('Impossible de modifier le commentaire!');
		} else {
			header('Location: index.php?action=post&id=' . $comment->getPost());
		}
	}
}

