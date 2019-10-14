<?= $this->extend("darky/templates/base") ?>

<?= $this->section('content') ?>

	<div class="my-4 text-center">
		<h1><?= lang('Home.profile') ?></h1>
	</div>

	<div class="row">
		<div class="col-sm-6">
			<h3><?= lang('Home.updateInfo') ?></h3>

			<?php if (session()->has('profile-success')) : ?>
				<div class="alert alert-success mb-0">	
					<?= session('profile-success') ?>
				</div>
			<?php endif ?>

			<?php if (session()->has('profile-errors')) : ?>
				<ul class="alert alert-danger">
				<?php foreach (session('profile-errors') as $error) : ?>
					<li><?= $error ?></li>
				<?php endforeach ?>
				</ul>
			<?php endif ?>

			<form action="/profile" method="post">
				<?= csrf_field() ?>
				<div class="form-group">
					<label for="username"><?= lang('Home.enterUsername') ?></label>
					<input type="text" name="username" class="form-control" id="username"
					value="<?= esc($user['username']) ?>">
				</div>
				<div class="form-group">
					<label for="email"><?= lang('Home.enterEmail') ?></label>
					<input type="email" name="email" class="form-control" id="email"
					value="<?= esc($user['email']) ?>">
				</div>
				<div class="form-group">
					<label for="name"><?= lang('Home.enterName') ?></label>
					<input type="text" name="name" class="form-control" id="name"
					value="<?= esc($user['name']) ?>">
				</div>
				<div class="form-group">
					<label for="password-present"><?= lang('General.password') ?></label>
					<input type="password" name="password" class="form-control" id="password-present">
				</div>
				<button type="submit" class="btn btn-primary btn-block"><?= lang('General.update') ?></button>
			</form>

			<div class="my-4">
				<form action="/language" method="get" id="language-form">
					<div class="input-group">
						<div class="input-group-prepend">
							<label class="input-group-text" for="language"><?= lang('General.language') ?></label>
						</div>
						<select class="custom-select" id="language" name="language">
							<?php foreach(config('Iuctf')->locales as $lang => $language): ?>
							<option <?= session('language')==$lang ? 'selected':'' ?> value="<?= $lang ?>"><?= $language ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</form>
			</div>
			<script>
				$("#language").change(function() {
					$("#language-form").submit();
				});
			</script>
		</div>

		<div class="col-sm-6">
			<h3><?= lang('Home.updatePassword') ?></h3>
			<?php if (session()->has('success')) : ?>
				<div class="alert alert-success mb-0">	
					<?= session('success') ?>
				</div>
			<?php endif ?>

			<?php if (session()->has('errors')) : ?>
				<ul class="alert alert-danger">
				<?php foreach (session('errors') as $error) : ?>
					<li><?= $error ?></li>
				<?php endforeach ?>
				</ul>
			<?php endif ?>

			<form action="/profile/change-password" method="post">
				<?= csrf_field() ?>
				<div class="form-group">
					<label for="password-old"><?= lang('General.password') ?></label>
					<input type="password" name="password-old" class="form-control" id="password-old">
				</div>
				<div class="form-group">
					<label for="password"><?= lang('Home.newPassword') ?></label>
					<input type="password" name="password" class="form-control" id="password">
				</div>
				<div class="form-group">
					<label for="password-confirm"><?= lang('Home.confirmNewPass') ?></label>
					<input type="password" name="password-confirm" class="form-control" id="password-confirm">
				</div>
				<button type="submit" class="btn btn-primary btn-block"><?= lang('Home.updatePassword') ?></button>
			</form>
		</div>
	</div>

<?= $this->endSection() ?>