<?php if (session()->has( isset($name) ? "$name-message" : 'message')) : ?>
	<div class="alert alert-success">
		<?= session( isset($name) ? "$name-message" : 'message') ?>
	</div>
<?php endif ?>

<?php if (session()->has(isset($name) ? "$name-error" : 'error')) : ?>
	<div class="alert alert-danger">
		<?= session(isset($name) ? "$name-error" : 'error') ?>
	</div>
<?php endif ?>

<?php if (session()->has(isset($name) ? "$name-errors" : 'errors')) : ?>
	<ul class="alert alert-danger">
	<?php foreach (session(isset($name) ? "$name-errors" : 'errors') as $error) : ?>
		<li><?= $error ?></li>
	<?php endforeach ?>
	</ul>
<?php endif ?>
