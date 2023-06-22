<?php
namespace App\Entity;

use App\Entity\Traits\ContentTrait;
use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TitleTrait;

class Post
{
	use IdTrait;
	use TitleTrait;
	use ContentTrait;
	use CreatedAtTrait;

	private string $introduction;
    private ?\DateTime $updatedAt;
	private User $author;

	public function __toString()
	{
		return $this->title;
	}

	public function getIntroduction(): ?string
	{
		return $this->introduction;
	}

	public function setIntroduction(?string $introduction): self
	{
		$this->introduction = $introduction;

		return $this;
	}

	public function getUpdatedAt(): ?\DateTime
	{
		return $this->updatedAt;
	}

	public function setUpdatedAt(?\DateTime $updatedAt): self
	{
		$this->updatedAt = $updatedAt;

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
}