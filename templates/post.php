
<?php $title = "Le super blog de COralie"; ?>

<?php ob_start(); ?>
<h1>Le blog de Coralie</h1>
<p><a href="index.php">Retour à la liste des billets</a></p>

<div class="news">
    <h3>
        <?= htmlspecialchars($post->title) ?>
    </h3>

    <p>
        <?= nl2br(htmlspecialchars($post->content)) ?>
    </p>
</div>

<h2>Commentaires</h2>

<form action="index.php?action=addComment&id=<?= $post->id ?>" method="post">
   <div>
  	<label for="title">Titre</label><br />
  	<input type="text" id="title" name="title" />
   </div>
   <div>
  	<label for="content">Commentaire</label><br />
  	<textarea id="content" name="content"></textarea>
   </div>
   <div>
  	<input type="submit" />
   </div>
</form>
<!-- ... -->

<?php
foreach ($comments as $comment) {
?>
	<p><strong><?= htmlspecialchars($comment->getTitle()) ?></strong> le <?php $date = new \Datetime($comment->getCreatedAt()); echo $date->format('d-m-Y à H:i:s'); ?></p>
	<p><?= nl2br(htmlspecialchars($comment->getContent())) ?></p>
    <?= var_dump($comment->getId()) ?>
    <a href="?action=comment&id=<?= urlencode($comment->getId()) ?>">Modifier</a>
<?php
}
?>

<?php $content = ob_get_clean(); ?>

<?php require('layout.php');