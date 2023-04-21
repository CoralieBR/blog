<?php $title = "Le super blog de COralie"; ?>

<?php ob_start(); ?>
<h1>Le super blog de Coralie</h1>
<p>Derniers billets du blog :</p>

<?php
foreach ($posts as $post) {
?>
	<div class="news">
		<h3>
			<?= htmlspecialchars($post->title) ?>
		</h3>
		<p>
			<?= nl2br(htmlspecialchars($post->content)) ?>
			<br />
		</p>
		<em><a href="?action=post&id=<?= urlencode($post->id) ?>">Voir plus</a></em>
	</div>
<?php
}
?>
<?php $content = ob_get_clean(); ?>

<?php require('layout.php');