<?php

spl_autoload_register(function($fqcn){
	$path = str_replace(['App', '\\'], ['src', '/'], $fqcn) . '.php';
	require $path;
});

use App\Controllers\AddComment;
use App\Controllers\UpdateComment;
use App\Controllers\Homepage;
use App\Controllers\Post;
use App\Controllers\Comment;

try {
	if (isset($_GET['action']) && $_GET['action'] !== '') {
    	if ($_GET['action'] === 'post') {
        	if (isset($_GET['id']) && $_GET['id'] > 0) {
            	$id = intval($_GET['id']);

				(new Post())->execute($id);
        	} else {
            	throw new Exception('Aucun identifiant de billet envoyé');
        	}
    	} elseif ($_GET['action'] === 'comment') {
			if (isset($_GET['id']) && $_GET['id'] > 0) {
            	$id = intval($_GET['id']);

				(new Comment())->execute($id);
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
		(new Homepage())->execute();
	}
} catch (Exception $e) {
	$errorMessage = $e->getMessage();
	
	require('templates/error.php');
}