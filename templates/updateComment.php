
<?php $title = "Le super blog de COralie"; ?>

<?php ob_start(); ?>
<h1>Le blog de Coralie</h1>
<p><a href="index.php">Retour à la liste des billets</a></p>

<h2>Modifier le commentaire</h2>

<form action="index.php?action=updateComment&id=<?= $comment->getId() ?>" method="post">
   <div>
  	<label for="title">Titre</label><br />
  	<input type="text" id="title" name="title" value="<?= $comment->getTitle() ?>">
   </div>
   <div>
  	<label for="content">Commentaire</label><br />
  	<textarea id="content" name="content"><?= $comment->getContent() ?></textarea>
   </div>
   <div>
  	<input type="submit" />
   </div>
</form>


<?php $content = ob_get_clean(); ?>

<?php require('layout.php');