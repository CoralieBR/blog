<?php

namespace App\Controllers;

use App\Entity\Post;
use App\Lib\Database;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;

class PostController extends AbstractController
{
    public function __construct(
        private \Twig\Environment $twig,
        private PostRepository $postRepository,
        private CommentRepository $commentRepository
    ) {
        parent::__construct($twig);
        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;
    }

    public function show(int $id)
    {
        $post = $this->postRepository->find($id);
        $comments = $this->commentRepository->getComments($id);
        return $this->render('post.html.twig', [
            'post' => $post,
            'comments' => $comments,
        ]);
    }

    public function list()
    {
        $posts = $this->postRepository->getPosts();

        return $this->render('summary.html.twig', [
            'posts' => $posts,
        ]);
    }

    public function addPost(array $input)
    {
        if (empty($input)) {
            return $this->render('addPost.html.twig');
        } else {
            $post = new Post();
            if (is_string($input['title'])) {
                $post->setTitle($input['title']);
            }
            if (is_string($input['introduction'])) {
                $post->setIntroduction($input['introduction']);
            }
            if (is_string($input['content'])) {
                $post->setContent($input['content']);
            }
            $post->setAuthor($_SESSION['user']);

            $this->postRepository->createPost($post);

            header('Location: /blog/tous-les-articles');
        }
    }

    public function updatePost(int $id, array $input)
    {
        $post = $this->postRepository->find($id);
        if (empty($post)) {
            header("Location: /blog");
        }
        if (empty($input)) {
            return $this->render('updatePost.html.twig', [
                'post' => $post,
            ]);
        }

        if (is_string($input['title'])) {
            $post->setTitle($input['title']);
        }
        if (is_string($input['introduction'])) {
            $post->setIntroduction($input['introduction']);
        }
        if (is_string($input['content'])) {
            $post->setContent($input['content']);
        }

        $this->postRepository->updatePost($post);

        header("Location: /blog/article?id=" . $post->getId());
    }

    public function manage()
    {
        $posts = $this->postRepository->getPosts(); 

        return $this->render('admin/posts.html.twig', [
            'posts' => $posts,
        ]);
    }
}