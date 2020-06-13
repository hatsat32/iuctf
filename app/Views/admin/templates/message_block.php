<?php if (session()->has( isset($name) ? "$name-message" : 'message')) : ?>
	<div class="alert alert-success">
		<?= esc( session( isset($name) ? "$name-message" : 'message') ) ?>
	</div>
<?php endif ?>

<?php if (session()->has(isset($name) ? "$name-error" : 'error')) : ?>
	<div class="alert alert-danger">
		<?= esc( session(isset($name) ? "$name-error" : 'error') ) ?>
	</div>
<?php endif ?>

<?php if (session()->has(isset($name) ? "$name-errors" : 'errors')) : ?>
	<ul class="alert alert-danger">
	<?php foreach (session(isset($name) ? "$name-errors" : 'errors') as $error) : ?>
		<li><?= esc($error) ?></li>
	<?php endforeach ?>
	</ul>
<?php endif ?>

<?php if (session()->has(isset($name) ? "$name-warning" : 'warning')) : ?>
	<div class="alert alert-warning">
		<?= esc( session(isset($name) ? "$name-warning" : 'warning') ) ?>
	</div>
<?php endif ?>

<?php if (session()->has(isset($name) ? "$name-warnings" : 'warnings')) : ?>
	<ul class="alert alert-warning">
	<?php foreach (session(isset($name) ? "$name-warnings" : 'warnings') as $error) : ?>
		<li><?= esc($error) ?></li>
	<?php endforeach ?>
	</ul>
<?php endif ?>
