<?php

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\UpdatedAtTrait;

class User
{
    use IdTrait;
    use CreatedAtTrait;
    use UpdatedAtTrait;

    public const STATUS_USER = 'user';
    public const STATUS_ADMIN_USER = 'admin';

    private string $name;
    private string $email;
    private string $password;
    private string $status;

    public function __toString()
    {
        return $this->name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
    
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }
    public function getStatus(): string
    {
        return $this->status;
    }

    public function isAdmin(): bool
    {
        return $this->status === self::STATUS_ADMIN_USER;
    }

    public function setStatus(?string $status): self
    {
        if (!in_array($status, [self::STATUS_ADMIN_USER, self::STATUS_USER])) {
			trigger_error(sprintf('Le status %s n\'est pas valide. Les status possibles sont : %s', $status, implode(', ', [self::STATUS_ADMIN_USER, self::STATUS_USER])), E_USER_ERROR);
		}
        $this->status = $status;

        return $this;
    }
}