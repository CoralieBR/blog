<?php

require_once 'vendor/autoload.php';

use App\Controllers\AddCommentController;
use App\Controllers\UpdateCommentController;
use App\Controllers\PostController;
use App\Controllers\CommentController;
use App\Controllers\HomeController;
use App\Lib\Database;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;

$loader = new \Twig\Loader\FilesystemLoader('src/templates');
$twig = new \Twig\Environment($loader);

$connection = new Database();

$postRepository = new PostRepository();
$postRepository->connection = $connection;

$commentRepository = new CommentRepository();
$commentRepository->connection = $connection;

$homeController = new HomeController($twig);
$commentController = new CommentController($twig, $commentRepository);
$postController = new PostController($twig, $postRepository, $commentRepository);

try {
	if (isset($_GET['action']) && $_GET['action'] !== '') {
		if ($_GET['action'] === 'summary') {
			$postController->list();
		} elseif ($_GET['action'] === 'post') {
			if (isset($_GET['id']) && $_GET['id'] > 0) {
				$id = intval($_GET['id']);
				$postController->show($id);
			} else {
				throw new Exception('Aucun identifiant de billet envoyé');
			}
		} elseif ($_GET['action'] === 'addPost') {
			$postController->add($_POST);
		} elseif ($_GET['action'] === 'updatePost') {
			if (isset($_GET['id']) && $_GET['id'] > 0) {
				$id = intval($_GET['id']);
				$postController->update($id, $_POST);
			}
		} elseif ($_GET['action'] === 'addComment') {
			if (isset($_GET['id']) && $_GET['id'] > 0) {
				$id = intval($_GET['id']);

				$commentController->add($id, $_POST);
			} else {
				throw new Exception('Aucun identifiant de billet envoyé');
			}
		} elseif ($_GET['action'] === 'updateComment') {
			if (isset($_GET['id']) && $_GET['id'] > 0) {
				$id = intval($_GET['id']);

				$commentController->update($id, $_POST);
			} else {
				throw new Exception('Aucun identifiant de commentaire envoyé');
			}
		} else {
			throw new Exception("La page que vous recherchez n'existe pas.");
		}
	} else {
		$homeController->homepage();
	}
} catch (Exception $e) {
	$errorMessage = $e->getMessage();
	
	echo $twig->render('error.html.twig', ['errorMessage' => $errorMessage]);
}