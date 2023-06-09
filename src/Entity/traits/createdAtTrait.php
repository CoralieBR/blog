<?php

namespace App\Entity\Traits;

trait CreatedAtTrait 
{
    private ?\DateTime $createdAt;

	public function getCreatedAt(): ?\DateTime
	{
		return $this->createdAt;
	}

	public function setCreatedAt(?\DateTime $createdAt): self
	{
		$this->createdAt = $createdAt;

		return $this;
	}
}