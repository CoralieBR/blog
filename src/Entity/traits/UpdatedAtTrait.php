<?php

namespace App\Entity\Traits;

trait UpdatedAtTrait 
{
    private ?\DateTime $updatedAt;

	public function getUpdatedAt(): ?\DateTime
	{
		return $this->updatedAt;
	}

	public function setUpdatedAt(?\DateTime $updatedAt): self
	{
		$this->updatedAt = $updatedAt;

		return $this;
	}
}