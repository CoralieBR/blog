<?php

namespace App\Repository;

use App\Entity\Post;
use App\Lib\Database;
use App\Repository\UserRepository;

class PostRepository
{
    public Database $connection;
    public UserRepository $userRepository;
    public CommentRepository $commentRepository;

    public function find(int $id): Post
    {
        $statement = $this->connection->getConnection()->prepare(
            'SELECT * FROM post WHERE id = ?'
        );
        $statement->execute([$id]);

        $row = $statement->fetch();
        $post = $this->getPostInformations($row);
        
        return $post;
    }

    public function getPosts(): array
    {
        $statement = $this->connection->getConnection()->query(
            'SELECT * FROM post'
        );

        $posts = [];
        while ($row = $statement->fetch()) {
            $posts[] = $this->getPostInformations($row);
        }
    
        return $posts;
    }

    public function createPost(Post $post): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            'INSERT INTO post(
                title,
                introduction,
                content,
                author_id,
                created_at
            ) VALUES (?, ?, ?, ?, NOW())'
        );
        $affectedLines = $statement->execute([
            $post->getTitle(),
            $post->getIntroduction(),
            $post->getContent(),
            $post->getAuthor()->getId()
        ]);

        return ($affectedLines > 0);
    }

    public function updatePost(Post $post): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            'UPDATE post SET
            title = ?,
            introduction = ?,
            content = ?,
            updated_at = NOW()
            WHERE id = ?'
        );
        $affectedLines = $statement->execute([
            $post->getTitle(),
            $post->getIntroduction(),
            $post->getContent(),
            $post->getId()
        ]);

        return ($affectedLines > 0);
    }

    private function getPostInformations($row): Post
    {
        $post = new Post();
        $post->setId($row['id']);
        $post->setTitle($row['title']);
        $post->setIntroduction($row['introduction']);
        $post->setContent($row['content']);
        if (empty($row['created_at'])) {
            $post->setCreatedAt(null);
        } else {
            $post->setCreatedAt(new \DateTime($row['created_at']));
        }
        if (empty($row['updated_at'])) {
            $post->setUpdatedAt(null);
        } else {
            $post->setUpdatedAt(new \DateTime($row['updated_at']));
        }
        $author = $this->userRepository->find($row['author_id']);
        $post->setAuthor($author);

        return $post;
    }
}