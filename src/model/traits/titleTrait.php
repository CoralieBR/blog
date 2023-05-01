<?php

namespace App\Model\Traits;

trait TitleTrait 
{
    private string $title;

	public function getTitle()
	{
		return $this->title;
	}

	public function setTitle($title)
	{
		$this->title = $title;

		return $this;
	}
}