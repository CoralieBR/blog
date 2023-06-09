<?php

namespace App\Entity\Traits;

trait TitleTrait 
{
    private ?string $title;

	public function getTitle(): ?string
	{
		return $this->title;
	}

	public function setTitle(?string $title): self
	{
		$this->title = $title;

		return $this;
	}
}