<?php
declare(strict_types=1);
namespace App\Entity;

use App\Entity\Traits\contentTrait;
use App\Entity\Traits\createdAtTrait;
use App\Entity\Traits\idTrait;
use App\Entity\Traits\titleTrait;

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