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

    public function add(array $input)
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

            $this->postRepository->createPost($post);

            header('Location: /blog/tous-les-articles');
        }
    }

    public function update(int $id, array $input)
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

    public function list()
    {
        $posts = $this->postRepository->getPosts();

        echo $this->twig->render('summary.html.twig', ['posts' => $posts]);
    }

    public function add(array $input)
    {
        if (empty($input)) {
            echo $this->twig->render('addPost.html.twig');
            return;
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

            $this->postRepository->createPost($post);

            header("Location: /blog");
        }
    }

    public function update(int $id, array $input)
    {
        $post = $this->postRepository->getPost($id);
        if (empty($post)) {
            header("Location: /blog");
        }
        if (empty($input)) {
            echo $this->twig->render('updatePost.html.twig', ['post' => $post]);
            return;
        
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

        header("Location: /blog");
    }
}