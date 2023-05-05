<?php

namespace App\Model\Traits;

trait IdTrait 
{
    private int $id;

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}
}