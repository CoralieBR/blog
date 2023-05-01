<?php
namespace App\Model;

// require_once('src/lib/database.php');

use App\Lib\Database;
use App\Model\Comment;

class CommentRepository
{
	public Database $connection;
	
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
			"SELECT * FROM comment WHERE id = ?"
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