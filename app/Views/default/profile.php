<?= $this->extend("templates/base") ?>


<?= $this->section('title') ?>
	<?= lang('Home.profile') ?>
<?= $this->endSection() ?>


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

			<form action="<?= route_to('profile') ?>" method="post">
				<?= csrf_field() ?>
				<div class="form-group">
					<label for="username"><?= lang('Home.enterUsername') ?></label>
					<input type="text" name="username" class="form-control form-control-lg" id="username"
					value="<?= esc($user->username) ?>">
				</div>
				<div class="form-group">
					<label for="email"><?= lang('Home.enterEmail') ?></label>
					<input type="email" name="email" class="form-control form-control-lg" id="email"
					value="<?= esc($user->email) ?>">
				</div>
				<div class="form-group">
					<label for="name"><?= lang('Home.enterName') ?></label>
					<input type="text" name="name" class="form-control form-control-lg" id="name"
					value="<?= esc($user->name) ?>">
				</div>
				<div class="form-group">
					<label for="password-present"><?= lang('General.password') ?></label>
					<input type="password" name="password" class="form-control form-control-lg" id="password-present">
				</div>
				<button type="submit" class="btn btn-primary btn-lg btn-block"><?= lang('General.update') ?></button>
			</form>
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

			<form action="<?= route_to('change-password') ?>" method="post">
				<?= csrf_field() ?>
				<input type="hidden" name="email" value="<?= user()->email ?>">
				<div class="form-group">
					<label for="password-old"><?= lang('General.password') ?></label>
					<input type="password" name="password-old" class="form-control form-control-lg" id="password-old">
				</div>
				<div class="form-group">
					<label for="password"><?= lang('Home.newPassword') ?></label>
					<input type="password" name="password" class="form-control form-control-lg" id="password">
				</div>
				<div class="form-group">
					<label for="password-confirm"><?= lang('Home.confirmNewPass') ?></label>
					<input type="password" name="password-confirm" class="form-control form-control-lg" id="password-confirm">
				</div>
				<button type="submit" class="btn btn-primary btn-lg btn-block"><?= lang('Home.updatePassword') ?></button>
			</form>
		</div>
	</div>

<?= $this->endSection() ?>