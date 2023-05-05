<?php
declare(strict_types=1);
namespace App\Model;

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