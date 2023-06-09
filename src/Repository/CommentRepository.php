<?php
namespace App\Repository;

use App\Lib\Database;
use App\Entity\Comment;

class CommentRepository
{
	public Database $connection;
	public PostRepository $postRepository;
	public UserRepository $userRepository;

	public function find(int $commentId): Comment
	{
		$statement = $this->connection->getConnection()->prepare(
			"SELECT * FROM comment WHERE id = ?"
		);
		$statement->execute([$commentId]);
		$row = $statement->fetch();
		return $this->getCommentInformations($row);
	}
	
	public function findALl()
	{
		$statement = $this->connection->getConnection()->query(
			'SELECT * FROM comment'
		);
		$comments = [];
		while ($row = $statement->fetch()) {
			$comments[] = $this->getCommentInformations($row);
		}

		return $comments;
	}
	
	public function getComments($postId): array
	{
		$statement = $this->connection->getConnection()->prepare(
			"SELECT * FROM comment WHERE post_id = ?"
		);
		$statement->execute([$postId]);
	
		$comments = [];
		while ($row = $statement->fetch()) {
			$comments[] = $this->getCommentInformations($row);
		}
	
		return $comments;
	}

	public function createComment(Comment $comment): bool
	{
		$statement = $this->connection->getConnection()->prepare(
			'INSERT INTO comment(
				post_id,
				title,
				content,
				author_id,
				created_at
			) VALUES(?, ?, ?, ?, NOW())'
		);
		$affectedLines = $statement->execute([
			$comment->getPost(), 
			$comment->getTitle(), 
			$comment->getContent(),
			$comment->getAuthor()->getId(),
		]);
	
		return ($affectedLines > 0);
	}

	public function updateComment(Comment $comment): bool
	{
		$statement = $this->connection->getConnection()->prepare(
			"UPDATE comment
			SET title = ?,
			content = ?,
			author_id = ?,
			WHERE id = ?"
		);
		$affectedLines = $statement->execute([
			$comment->getTitle(), 
			$comment->getContent(),
			$comment->getAuthor()->getId(),
			intval($comment->getId())
		]);

		return ($affectedLines > 0);
	}

	public function updateCommentModeration(Comment $comment)
	{
		$statement = $this->connection->getConnection()->prepare(
			"UPDATE comment
			SET is_enabled = ?,
			moderated_at = NOW()
			WHERE id = ?"
		);
		$affectedLines = $statement->execute([
			$comment->checkIfEnabled(),
			$comment->getId()
		]);

		return ($affectedLines > 0);
	}

	private function getCommentInformations($row)
	{
		$comment = new Comment();
		$comment->setId($row['id']);
		$comment->setTitle($row['title']);
		$comment->setContent($row['content']);
		$comment->setCreatedAt(new \DateTime($row['created_at']));
        if (empty($row['moderated_at'])) {
            $comment->setModeratedAt(null);
        } else {
            $comment->setModeratedAt(new \DateTime($row['moderated_at']));
        }
		$comment->setEnableStatus(boolval($row['is_enabled']));
		$comment->setPost($this->postRepository->find($row['post_id']));
		$comment->setAuthor($this->userRepository->find($row['author_id']));

		return $comment;
	}
}