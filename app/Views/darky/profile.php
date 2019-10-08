<?= $this->extend("darky/templates/base") ?>

<?= $this->section('content') ?>

	<div class="my-4 text-center">
		<h1>Profile</h1>
	</div>

	<div class="row">
		<div class="col-sm-6">
			<h3>Bilgileri Güncelle</h3>

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
					<label for="username">Kullanıcı adı giriniz</label>
					<input type="text" name="username" class="form-control" id="username" placeholder="Kullanıcı adı"
					value="<?= esc($user['username']) ?>">
				</div>
				<div class="form-group">
					<label for="email">Email Giriniz</label>
					<input type="email" name="email" class="form-control" id="email" placeholder="Emailiniz"
					value="<?= esc($user['email']) ?>">
				</div>
				<div class="form-group">
					<label for="name">İsim Giriniz</label>
					<input type="text" name="name" class="form-control" id="name" placeholder="İsminiz"
					value="<?= esc($user['name']) ?>">
				</div>
				<div class="form-group">
					<label for="password-present">Eski Parola</label>
					<input type="password" name="password" class="form-control" id="password-present" placeholder="Eski Parola">
				</div>
				<button type="submit" class="btn btn-primary btn-block">Güncelle</button>
			</form>
		</div>

		<div class="col-sm-6">
			<h3>Parola Güncelle</h3>
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
					<label for="password-old">Eski Parola</label>
					<input type="password" name="password-old" class="form-control" id="password-old" placeholder="Eski Parola">
				</div>
				<div class="form-group">
					<label for="password">Yeni Parola</label>
					<input type="password" name="password" class="form-control" id="password" placeholder="Yeni Parola">
				</div>
				<div class="form-group">
					<label for="password-confirm">Yeni Parola Tekrar</label>
					<input type="password" name="password-confirm" class="form-control" id="password-confirm" placeholder="Parola Tekrar">
				</div>
				<button type="submit" class="btn btn-primary btn-block">Parola Güncelle</button>
			</form>
		</div>
	</div>

<?= $this->endSection() ?>