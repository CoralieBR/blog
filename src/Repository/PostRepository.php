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
        $post->setContent($row['content']);

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
            $post->setContent($row['content']);
    
            $posts[] = $post;
        }
    
        return $posts;
    }
}