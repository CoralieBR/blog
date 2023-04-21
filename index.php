<?php

require_once('src/controllers/add_comment.php');
require_once('src/controllers/homepage.php');
require_once('src/controllers/post.php');
require_once('src/controllers/comment.php');
require_once('src/controllers/update_comment.php');

use Application\Controllers\AddComment\AddComment;
use Application\Controllers\UpdateComment\UpdateComment;
use Application\Controllers\Homepage\Homepage;
use Application\Controllers\Post\Post;
use Application\Controllers\Comment\Comment;

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