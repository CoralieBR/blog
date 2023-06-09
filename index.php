<?php

require_once 'vendor/autoload.php';

session_start();

use App\Controllers\PostController;
use App\Controllers\CommentController;
use App\Controllers\ErrorController;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Lib\Database;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;

$loader = new \Twig\Loader\FilesystemLoader('src/templates');
$twig = new \Twig\Environment($loader);

$connection = new Database();

$userRepository = new UserRepository();
$postRepository = new PostRepository();
$commentRepository = new CommentRepository();

$userRepository->connection = $connection;
$userRepository->postRepository = $postRepository;
$userRepository->commentRepository = $commentRepository;

$postRepository->connection = $connection;
$postRepository->userRepository = $userRepository;
$postRepository->commentRepository = $commentRepository;

$commentRepository->connection = $connection;
$commentRepository->userRepository = $userRepository;
$commentRepository->postRepository = $postRepository;

$homeController = new HomeController($twig);
$errorController = new ErrorController($twig);
$commentController = new CommentController($twig, $commentRepository, $postRepository, $errorController);
$postController = new PostController($twig, $postRepository, $commentRepository);
$userController = new UserController($twig, $userRepository);

$uri = $_SERVER['REQUEST_URI'];
$uri = explode('?', $uri)[0];
$uri = explode('/', $uri);
try {
	switch ($uri[2]) {
		case '':
			$homeController->homepage();
			break;
		case 'admin':
			if (isset($_SESSION['user']) && $_SESSION['user']->isAdmin()) {
				switch ($uri[3]) {
					case 'articles':
						$postController->manage();
						break;
					case 'commentaires':
						$commentController->manage();
						break;
					case 'moderate-comment':
						if (isset($_GET['id']) && is_numeric($_GET['id']) && isset($_GET['is-accepted'])) {
							$commentController->moderate(intval($_GET['id']), boolval($_GET['is-accepted']));
						}
						break;
					case 'utilisateurices':
						$userController->manage();
						break;
				}
			} else {
				$errorController->errorPage(403);
				break;
			}
			break;
		case 'tous-les-articles':
			$postController->list();
			break;
		case 'ajouter-un-article':
			$postController->add($_POST);
			break;
		case 'article':
			if (isset($_GET['id']) && is_numeric($_GET['id'])) {
				$id = intval($_GET['id']);
				if (isset($uri[3]) && $uri[3] = 'modifier') {
					$postController->update($id, $_POST);
				} else {
					$postController->show(intval($id));
				}
			} else {
				$errorController->errorPage(null, 'Article introuvable.');
				break;
			}
			break;
		case 'commentaire':
			if (isset($_GET['id']) && is_numeric($_GET['id'])) {
				$id = $_GET['id'];
				switch ($uri[3]) {
					case 'ajouter':
						$commentController->add($id, $_POST);
						break;
					case 'modifier':
						$commentController->update($id, $_POST);
						break;
				}
			}
		case 'inscription':
			$userController->registration($_POST);
			break;
		case 'connexion':
			$userController->login($_POST);
			break;
		case 'deconnexion':
			$userController->logout();
			break;
		default:
			$errorController->errorPage(404);
			break;
	}
} catch (Exception $e) {
	$errorMessage = $e->getMessage();
	$errorController->errorPage(null, $errorMessage);
}