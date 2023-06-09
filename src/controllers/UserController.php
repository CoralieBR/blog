<?php

namespace App\Controllers;

use App\Entity\User;
use App\Repository\UserRepository;

class UserController extends AbstractController
{
    public function __construct(
        private \Twig\Environment $twig,
        private UserRepository $userRepository
    )
    {
        parent::__construct($twig);
        $this->userRepository = $userRepository;
    }

    public function login(array $input)
    {
        if (empty($input)) {
            return $this->render('login.html.twig');
        }

        $errorMessage = 'Votre email, votre nom ou votre mot de passe n\'est pas bon.';
        $hasError = false;
        if (is_string($input['email'])) {
            $user = $this->userRepository->findUserWithEmail($input['email']);
            if (!$user) {
                $user = $this->userRepository->findUserWithName($input['name']);
            }
            if (!$user) {
                $hasError = true;
            }
        }
        if ($user && is_string($input['password'])) {
            if (!password_verify($input['password'], $user->getPassword())) {
                $hasError = true;
            }
        } else {
            $hasError = true;
        }

        if ($hasError) {
            return $this->render('login.html.twig', ['email' => $input['email'], 'errorMessage' => $errorMessage]);
        }

        $_SESSION['user'] = $user;

        header("Location: /blog");
    }

    public function registration($input)
    {
        if (empty($input)) {
            return $this->render('registration.html.twig');
        }

        $errorMessages = [];
        $user = new User();
        if (empty($input['name'])) {
            $errorMessages['name'] = 'Vous devez remplir ce champ.';
        } elseif (!is_string($input['name'])) {
            $errorMessages['name'] = 'Votre nom doit être du texte.';
        } elseif ($this->userRepository->isNameUsed($input['name'])) {
            $errorMessages['name'] = 'Ce nom est déjà pris.';
        } else {
            $user->setName($input['name']);
        }

        if (empty($input['email'])) {
            $errorMessages['email'] = 'Vous devez remplir ce champ.';
        } elseif (!is_string($input['email'])) {
            $errorMessages['email'] = 'Votre email n\'est pas au bon format.';
        } elseif ($this->userRepository->isEmailUsed($input['email'])) {
            $errorMessages['email'] = 'Cet email est déjà utilisé.';
        } else {
            $user->setEmail($input['email']);
        }

        if (empty($input['password'])) {
            $errorMessages['password'] = 'Vous devez remplir ce champ.';
        } elseif (!is_string($input['password'])) {
            $errorMessages['password'] = 'Votre mot de passe n\'est pas au bon format.';
        } else {
            $password = $input['password'];
            $user->setPassword(password_hash($password, null));
        }

        if (!empty($errorMessages)) {
            return $this->render('registration.html.twig', [
                'errorMessages' => $errorMessages,
                'inputs' => $input,
            ]);
        }

        $this->userRepository->createUser($user);

        $_SESSION['user'] = $user;

        header("Location: /blog");
    }

    public function logout()
    {
        if ($_SESSION['user']) {
            session_destroy();
        }
        header("Location: /blog/connexion");
    }

    public function manage()
    {
        $users = $this->userRepository->findAll();
        return $this->render('admin/users.html.twig', [
            'users' => $users,
        ]);
    }
}