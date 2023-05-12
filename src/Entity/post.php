<?php
declare(strict_types=1);
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

	private ?string $introduction;
    private ?\DateTime $updatedAt;
	private ?int $author;

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

	public function getAuthor(): int
	{
		return $this->author;
	}

	public function setAuthor(?int $author): self
	{
		$this->author = $author;

		return $this;
	}
}