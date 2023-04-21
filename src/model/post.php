<?php
declare(strict_types=1);
namespace Application\Model\Post;

require_once('src/lib/database.php');

use Application\Lib\Database\DatabaseConnection;

class Post
{
    public int $id;
    public string $title;
    public string $introduction;
    public string $content;
    public $createdAt;
    public $updatedAt;
}

class PostRepository
{
    public DatabaseConnection $connection;

    public function getPost(int $id): Post
    {
        $statement = $this->connection->getConnection()->prepare('SELECT * FROM post WHERE id = ?');
        $statement->execute([$id]);

        $row = $statement->fetch();
        $post = new Post();
        $post->id = $row['id'];
        $post->title = $row['title'];
        $post->content = $row['content'];

        return $post;
    }

    public function getPosts():array
    {
        $statement = $this->connection->getConnection()->query('SELECT * FROM post');

        $posts = [];
        while (($row = $statement->fetch())) {
            $post = new Post();
            $post->id = $row['id'];
            $post->title = $row['title'];
            $post->content = $row['content'];
    
            $posts[] = $post;
        }
    
        return $posts;
    }
}