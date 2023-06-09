<?php

namespace App\Entity\Traits;

trait IdTrait 
{
    private int $id;

	public function getId(): int
	{
		return $this->id;
	}

	public function setId(?int $id): self
	{
		$this->id = $id;

		return $this;
	}
}