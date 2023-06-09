<?php

namespace App\Controllers;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;

class CommentController extends AbstractController
{
    public function __construct(
        private \Twig\Environment $twig,
        private CommentRepository $commentRepository,
        private PostRepository $postRepository,
        private ErrorController $errorController
    ) {
        parent::__construct($twig);
        $this->commentRepository = $commentRepository;
        $this->postRepository = $postRepository;
        $this->errorController = $errorController;
    }

    public function add(int $postId, array $input)
	{
        $comment = new Comment();
		if (!empty($input['title']) && !empty($input['content'])) {
			if (is_string($input['title'])) {
                $comment->setTitle($input['title']);
            }
			if (is_string($input['content'])) {
                $comment->setContent($input['content']);
            }
            $comment->setPost($this->postRepository->find($postId));
		} else {
            $this->errorController->errorPage(null, 'Les données du formulaire sont invalides.');
		}

		$success = $this->commentRepository->createComment($comment);

		if (!$success) {
			throw new \Exception('Impossible d\'ajouter le commentaire!');
		} else {
			header('Location: /blog/article?id=' . $postId);
		}
	}

    public function update(int $commentId, array $input)
	{
		$comment = $this->commentRepository->find($commentId);
        if (empty($comment)) {
            header("Location: /blog");
        }
        if (empty($input)) {
            return $this->render('updateComment.html.twig', [
                'comment' => $comment
            ]);
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
			header('Location: /blog/article?id=' . $comment->getPost());
		}
	}

    public function manage()
    {
        $comments = $this->commentRepository->findAll();
        return $this->render('admin/comments.html.twig', [
            'comments' => $comments,
        ]);
    }

    public function moderate(int $commentId, bool $isAccepted)
    {
        $comment = $this->commentRepository->find($commentId);
        $comment->setEnableStatus($isAccepted);
        $this->commentRepository->updateCommentModeration($comment);
        header('Location: /blog/admin/commentaires');
    }
}

