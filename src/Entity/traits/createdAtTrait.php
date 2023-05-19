<?php

namespace App\Entity\Traits;

trait CreatedAtTrait 
{
    private $createdAt;

	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	public function setCreatedAt($createdAt)
	{
		$this->createdAt = $createdAt;

		return $this;
	}
}