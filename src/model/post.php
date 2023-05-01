<?php
declare(strict_types=1);
namespace App\Model;

require_once('src/lib/database.php');
require_once('src/model/traits/idTrait.php');
require_once('src/model/traits/titleTrait.php');
require_once('src/model/traits/contentTrait.php');
require_once('src/model/traits/createdAtTrait.php');

use App\Lib\Database;
use App\Model\Traits\contentTrait;
use App\Model\Traits\createdAtTrait;
use App\Model\Traits\idTrait;
use App\Model\Traits\titleTrait;

class Post
{
	use idTrait;
	use titleTrait;
	use contentTrait;
	use createdAtTrait;
    private string $introduction;
    private $updatedAt;
	private int $author;

	public function getIntroduction()
	{
		return $this->introduction;
	}

	public function setIntroduction($introduction)
	{
		$this->introduction = $introduction;

		return $this;
	}

	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}

	public function setUpdatedAt($updatedAt)
	{
		$this->updatedAt = $updatedAt;

		return $this;
	}

	public function getAuthor()
	{
		return $this->author;
	}

	public function setAuthor($author)
	{
		$this->author = $author;

		return $this;
	}
}

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