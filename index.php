<?php

require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('src/templates');
$twig = new \Twig\Environment($loader);

use App\Controllers\AddComment;
use App\Controllers\UpdateComment;
use App\Controllers\Summary;
use App\Controllers\Post;
use App\Controllers\Comment;

try {
	if (isset($_GET['action']) && $_GET['action'] !== '') {
    	if ($_GET['action'] === 'post') {
        	if (isset($_GET['id']) && $_GET['id'] > 0) {
            	$id = intval($_GET['id']);

				(new Post())->execute($id, $twig);
        	} else {
            	throw new Exception('Aucun identifiant de billet envoyé');
        	}
    	} elseif ($_GET['action'] === 'comment') {
			if (isset($_GET['id']) && $_GET['id'] > 0) {
            	$id = intval($_GET['id']);

				(new Comment())->execute($id, $twig);
        	} else {
            	throw new Exception('Aucun identifiant de commentaire envoyé');
        	}
		} elseif ($_GET['action'] === 'addComment') {
        	if (isset($_GET['id']) && $_GET['id'] > 0) {
            	$id = intval($_GET['id']);

				(new AddComment())->execute($id, $_POST);
        	} else {
            	throw new Exception('Aucun identifiant de billet envoyé');
        	}
		} elseif ($_GET['action'] === 'updateComment') {
			if (isset($_GET['id']) && $_GET['id'] > 0) {
            	$id = intval($_GET['id']);

				(new UpdateComment())->execute($id, $_POST);
        	} else {
            	throw new Exception('Aucun identifiant de commentaire envoyé');
        	}
    	} else {
        	throw new Exception("La page que vous recherchez n'existe pas.");
    	}
	} else {
		(new Summary())->execute($twig);
	}
} catch (Exception $e) {
	$errorMessage = $e->getMessage();
	
	echo $twig->render('error.html.twig', ['errorMessage' => $errorMessage]);
}