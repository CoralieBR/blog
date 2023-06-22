<?php

namespace App\Repository;

use App\Entity\User;
use App\Lib\Database;

class UserRepository
{
    public Database $connection;
    public PostRepository $postRepository;
    public CommentRepository $commentRepository;

    public function find(int $id): User
    {
        $statement = $this->connection->getConnection()->prepare(
            'SELECT * FROM user WHERE id = ?'
        );
        $statement->execute([$id]);

        $row = $statement->fetch();
        $user = $this->getUserInformations($row);

        return $user;
    }

    public function findAll()
    {
        $statement = $this->connection->getConnection()->query(
            'SELECT * FROM user'
        );
        $users = [];
        while ($row = $statement->fetch()) {
            $users[] = $this->getUserInformations($row);
        }

        return $users;
    }

    public function findUserWithEmail($email): ?User 
    {
        $statement = $this->connection->getConnection()->prepare(
            'SELECT * FROM user WHERE email = ?'
        );
        $statement->execute([$email]);

        $row = $statement->fetch();
        
        if (empty($row)) {
            return null;
        }
        $user = $this->getUserInformations($row);

        return $user;
    }

    public function findUserWithName($name): ?User 
    {
        $statement = $this->connection->getConnection()->prepare(
            'SELECT * FROM user WHERE name = ?'
        );
        $statement->execute([$name]);
        $row = $statement->fetch();
        
        if (empty($row)) {
            return null;
        }
        
        $user = $this->getUserInformations($row);
        return $user;
    }

    public function isEmailUsed($email): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            'SELECT * FROM user WHERE email = ?'
        );
        $statement->execute([$email]);
        $row = $statement->fetch();

        return !empty($row);
    }

    public function isNameUsed($name): bool
    {
        $statement = $this->connection->getConnection()->prepare(
            'SELECT * FROM user WHERE name = ?'
        );
        $statement->execute([$name]);
        $row = $statement->fetch();

        return !empty($row);
    }

    public function getUsers(): array
    {
        $statement = $this->connection->getConnection()->query(
            'SELECT * FROM user'
        );
        $users = [];
        while ($row = $statement->fetch()) {
            $users[] = $this->getUserInformations($row);
        }

        return $users;
    }

    public function createUser(User $user)
    {
        $statement = $this->connection->getConnection()->prepare(
            'INSERT INTO user(
                name,
                email,
                password,
                status,
                created_at
            ) VALUES (?, ?, ?, ?, NOW())'
        );
        $affectedLines = $statement->execute([
            $user->getName(),
            $user->getEmail(),
            $user->getPassword(),
            $user::STATUS_USER
        ]);

        return ($affectedLines > 0);
    }

    private function getUserInformations($row): User
    {
        $user = new User();
        $user->setId($row['id']);
        $user->setName($row['name']);
        $user->setEmail($row['email']);
        $user->setPassword($row['password']);
        $user->setStatus($row['status']);
        $user->setCreatedAt(new \DateTime($row['created_at']));
        if (empty($row['updated_at'])) {
            $user->setUpdatedAt(null);
        } else {
            $user->setUpdatedAt(new \DateTime($row['updated_at']));
        }

        return $user;
    }
}