<?php

require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('src/templates');
$twig = new \Twig\Environment($loader);

use App\Controllers\AddCommentController;
use App\Controllers\UpdateCommentController;
use App\Controllers\SummaryController;
use App\Controllers\PostController;
use App\Controllers\CommentController;

try {
	if (isset($_GET['action']) && $_GET['action'] !== '') {
		if ($_GET['action'] === 'post') {
			if (isset($_GET['id']) && $_GET['id'] > 0) {
				$id = intval($_GET['id']);

				(new PostController())->execute($id, $twig);
			} else {
				throw new Exception('Aucun identifiant de billet envoyé');
			}
		} elseif ($_GET['action'] === 'comment') {
			if (isset($_GET['id']) && $_GET['id'] > 0) {
				$id = intval($_GET['id']);

				(new CommentController())->execute($id, $twig);
			} else {
				throw new Exception('Aucun identifiant de commentaire envoyé');
			}
		} elseif ($_GET['action'] === 'addComment') {
			if (isset($_GET['id']) && $_GET['id'] > 0) {
				$id = intval($_GET['id']);

				(new AddCommentController())->execute($id, $_POST);
			} else {
				throw new Exception('Aucun identifiant de billet envoyé');
			}
		} elseif ($_GET['action'] === 'updateComment') {
			if (isset($_GET['id']) && $_GET['id'] > 0) {
				$id = intval($_GET['id']);

				(new UpdateCommentController())->execute($id, $_POST);
			} else {
				throw new Exception('Aucun identifiant de commentaire envoyé');
			}
		} else {
			throw new Exception("La page que vous recherchez n'existe pas.");
		}
	} else {
		(new SummaryController())->execute($twig);
	}
} catch (Exception $e) {
	$errorMessage = $e->getMessage();
	
	echo $twig->render('error.html.twig', ['errorMessage' => $errorMessage]);
}