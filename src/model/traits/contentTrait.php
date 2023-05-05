<?php

namespace App\Model\Traits;

trait ContentTrait 
{
    private string $content;

	public function getContent()
	{
		return $this->content;
	}

	public function setContent($content)
	{
		$this->content = $content;

		return $this;
	}
}