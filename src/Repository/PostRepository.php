<?php
declare(strict_types=1);
namespace App\Repository;

use App\Lib\Database;
use App\Entity\Post;

class PostRepository
{
    public Database $connection;

    public function getPost(int $id): Post
    {
        $statement = $this->connection->getConnection()->prepare('SELECT * FROM post WHERE id = ?');
        $statement->execute([$id]);

        $row = $statement->fetch();
        $post = new Post();
        $post->setId($row['id']);
        $post->setTitle($row['title']);
        $post->setIntroduction($row['introduction']);
        $post->setContent($row['content']);
        $post->setCreatedAt(new \DateTime($row['created_at']));
        if (empty($row['updated_at'])) {
            $post->setUpdatedAt(null);
        } else {
            $post->setUpdatedAt(new \DateTime($row['updated_at']));
        }
        // $post->setAuthor($row['author']);

        return $post;
    }

    public function getPosts():array
    {
        $statement = $this->connection->getConnection()->query('SELECT * FROM post');

        $posts = [];
        while (($row = $statement->fetch())) {
            $post = new Post();
            $post->setId($row['id']);
            $post->setTitle($row['title']);
            $post->setIntroduction($row['introduction']);
            $post->setContent($row['content']);
            if ($row['created_at']) {
                $post->setCreatedAt(new \DateTime($row['created_at']));
            }
            if ($row['updated_at']) {
                $post->setUpdatedAt(new \DateTime($row['updated_at']));
            }
            // $post->setAuthor($row['author']);
    
            $posts[] = $post;
        }
    
        return $posts;
    }

    public function createPost(Post $post): bool
    {
        $connection = new Database();
        $statement = $connection->getConnection()->prepare(
            'INSERT INTO post(
                title,
                introduction,
                content,
                created_at
            ) VALUES (?, ?, ?, NOW())'
        );
        $affectedLines = $statement->execute([
            $post->getTitle(),
            $post->getIntroduction(),
            $post->getContent()
        ]);

        return ($affectedLines > 0);
    }
}