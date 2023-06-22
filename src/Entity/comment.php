<?php
declare(strict_types=1);
namespace App\Entity;

use App\Entity\Traits\ContentTrait;
use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TitleTrait;

class Comment
{
	use IdTrait;
	use TitleTrait;
	use ContentTrait;
	use CreatedAtTrait;

	private ?\Datetime $moderatedAt;
	private string $moderationStatus;
	private User $author;
	private Post $post;
	private bool $isEnabled;

	public function getModeratedAt(): ?\Datetime 
	{
		return $this->moderatedAt ?? null;
	}

	public function setModeratedAt(?\Datetime $moderatedAt): self
	{
		$this->moderatedAt = $moderatedAt;

		return $this;
	}

	public function getAuthor(): User
	{
		return $this->author;
	}

	public function setAuthor(User $author): self
	{
		$this->author = $author;

		return $this;
	}

	public function getPost(): Post
	{
		return $this->post;
	}

	public function setPost(Post $post): self
	{
		$this->post = $post;

		return $this;
	}

	public function checkIfIsEnabled(): bool
	{
		return $this->isEnabled;
	}

	public function setEnableStatus(bool $isEnabled): self
	{
		$this->isEnabled = $isEnabled;

		return $this;
	}
}