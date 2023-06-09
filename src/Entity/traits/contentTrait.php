<?php

namespace App\Entity\Traits;

trait ContentTrait 
{
    private ?string $content;

	public function getContent(): ?string
	{
		return $this->content;
	}

	public function setContent(?string $content): self
	{
		$this->content = $content;

		return $this;
	}
}