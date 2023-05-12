<?php
namespace App\Repository;

use App\Lib\Database;
use App\Entity\Comment;

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
			$comment->setCreatedAt(new \DateTime($row['created_at']));
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
        $comment->setCreatedAt(new \DateTime($row['created_at']));

		return $comment;
	}

	public function createComment(Comment $comment): bool
	{
		$statement = $this->connection->getConnection()->prepare(
			'INSERT INTO comment(post_id, title, content, created_at) VALUES(?, ?, ?, NOW())'
		);
		$affectedLines = $statement->execute([
			$comment->getPost(), 
			$comment->getTitle(), 
			$comment->getContent()
		]);
	
		return ($affectedLines > 0);
	}

	public function updateComment(Comment $comment): bool
	{
		$statement = $this->connection->getConnection()->prepare(
			"UPDATE comment
			SET title = ?,
			content = ?
			WHERE id = ?"
		);
		$affectedLines = $statement->execute([
			$comment->getTitle(), 
			$comment->getContent(), 
			$comment->getId()
		]);

		return ($affectedLines > 0);
	}
}