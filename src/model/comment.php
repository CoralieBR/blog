<?php
namespace Application\Model\Comment;
// declare(strict_types=1);
require_once('src/lib/database.php');


use Application\Lib\Database\DatabaseConnection;

class Comment
{
	private int $id;
	private string $title;
	private string $content;
	private $createdAt;
	private $moderatedAt;
	private string $moderationStatus;
	private int $author;
	private int $post;

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setTitle($title)
	{
		$this->title = $title;

		return $this;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function setContent($content)
	{
		$this->content = $content;

		return $this;
	}

	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	public function setCreatedAt($createdAt)
	{
		$this->createdAt = $createdAt;

		return $this;
	}

	public function getModeratedAt()
	{
		return $this->moderatedAt;
	}

	public function setModeratedAt($moderatedAt)
	{
		$this->moderatedAt = $moderatedAt;

		return $this;
	}

	public function getModerationStatus()
	{
		return $this->moderationStatus;
	}

	public function setModerationStatus($moderationStatus)
	{
		$this->moderationStatus = $moderationStatus;

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

	public function getPost()
	{
		return $this->post;
	}

	public function setPost($post)
	{
		$this->post = $post;

		return $this;
	}
}

class CommentRepository
{
	public DatabaseConnection $connection;
	
	public function getComments($post)
	{
		$statement = $this->connection->getConnection()->prepare(
			"SELECT * FROM comment WHERE post_id = ?"
		);
		$statement->execute([$post]);
	
		$comments = [];
		while ($row = $statement->fetch()) {
			$comment = new Comment();
			$comment->setId($row['id']);
			$comment->setTitle($row['title']);
			$comment->setContent($row['content']);
			$comments[] = $comment;
		}
	
		return $comments;
	}

	public function getComment(int $commentId): Comment
	{
		$statement = $this->connection->getConnection()->prepare(
			"SELECT * FROM comment WHERE id - ?"
		);
		$statement->execute([$commentId]);
		
		$row = $statement->fetch();
		$comment = new Comment();
		$comment->setId($row['id']);
		$comment->setTitle($row['title']);
		$comment->setContent($row['content']);
		$comment->setPost($row['post_id']);

		return $comment;
	}

	public function createComment(int $post, string $title, string $content): bool
	{
		$statement = $this->connection->getConnection()->prepare(
			'INSERT INTO comment(post_id, title, content, created_at) VALUES(?, ?, ?, NOW())'
		);
		$affectedLines = $statement->execute([$post, $title, $content]);
	
		return ($affectedLines > 0);
	}

	public function updateComment(int $commentId, string $title, string $content): bool
	{
		$statement = $this->connection->getConnection()->prepare(
			"UPDATE comment
			SET title = ?,
			content = ?
			WHERE id = ?"
		);
		$affectedLines = $statement->execute([$title, $content, $commentId]);

		return ($affectedLines > 0);
	}
}