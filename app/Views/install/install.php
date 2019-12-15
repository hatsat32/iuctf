<?= $this->extend("install/base") ?>

<?= $this->section('content') ?>

	<h1 class="text-center"><?= lang('Install.welcomeTitle') ?></h1>

	<div class="alert alert-secondary" role="alert">
		<?= lang('Install.welcomeWizard') ?>
	</div>

	<?php if (session()->has('error')) : ?>
		<div class="alert alert-danger">
			<?= session('error') ?>
		</div>
	<?php endif ?>

	<?php if (session()->has('errors')) : ?>
		<ul class="alert alert-danger">
		<?php foreach (session('errors') as $error) : ?>
			<li><?= $error ?></li>
		<?php endforeach ?>
		</ul>
	<?php endif ?>

	<form action="/install" method="post">
		<?= csrf_field() ?>
		<!-- ADMIN INFORMATION -->
		<div class="form-group">
			<label for="username"><?= lang('General.username') ?></label>
			<input type="username" name="username" class="form-control form-control-lg" id="username" value="<?= old('username') ?>">
		</div>
		<div class="form-group">
			<label for="email"><?= lang('General.email') ?></label>
			<input type="email" name="email" class="form-control form-control-lg" id="email" value="<?= old('email') ?>">
		</div>
		<div class="form-group">
			<label for="password"><?= lang('General.password') ?></label>
			<input type="password" name="password" class="form-control form-control-lg" id="password">
		</div>
		<div class="form-group">
			<label for="password-confirm"><?= lang('General.confirmPassword') ?></label>
			<input type="password" name="password-confirm" class="form-control form-control-lg" id="password-confirm">
		</div>

		<button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
	</form>

<?= $this->endSection() ?>
