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

	private const STATUS_MODERATION_INVALID = 'invalid';
	private const STATUS_MODERATION_VALID = 'valid';

	private $moderatedAt;
	private string $moderationStatus;
	private int $author;
	private int $post;

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
		if (!in_array($moderationStatus, [self::STATUS_MODERATION_INVALID, self::STATUS_MODERATION_VALID])) {
			trigger_error(sprintf('Le status %s n\'est pas valide. Les status possibles sont : %s', $moderationStatus, implode(', ', [self::STATUS_MODERATION_INVALID, self::STATUS_MODERATION_VALID])), E_USER_ERROR);
		}
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