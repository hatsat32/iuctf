<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="/admin">Dashboard</a>
		</li>
		<li class="breadcrumb-item active"><?= lang('admin/User.userDetail') ?></li>
	</ol>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			<?= lang('admin/User.userDetail') ?></div>
		<div class="card-body">
			<form action="/admin/users/<?= esc($user->id) ?>" method="post">
				<?= csrf_field() ?>
				<div class="form-group">
					<label for="username"><?= lang('admin/User.enterUsername') ?></label>
					<input type="text" name="username" class="form-control" id="username" placeholder="Kullanıcı adı"
							value="<?= esc($user->username) ?>">
				</div>
				<div class="form-group">
					<label for="email"><?= lang('admin/User.enterEmail') ?></label>
					<input type="email" name="email" class="form-control" id="email" placeholder="Emailiniz"
							value="<?= esc($user->email) ?>">
				</div>
				<div class="form-group">
					<label for="name"><?= lang('General.name') ?></label>
					<input type="text" name="name" class="form-control" id="name" placeholder="İsminiz"
							value="<?= esc($user->name) ?>">
				</div>
				<div class="form-group">
					<label for="team_id"><?= lang('admin/User.selectTeam') ?></label>
					<select name="team_id" class="form-control" id="team_id">
						<?php foreach($teams as $team): ?>
							<option <?= $user->team_id === $team->id ? "selected":"" ?> value="<?= esc($team->id) ?>"><?= esc($team->name) ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<button type="submit" class="btn btn-primary btn-block"><?= lang('admin/User.updateUser') ?></button>
			</form>

			<div class="mt-4">
				<form action="/admin/users/<?= esc($user->id) ?>/delete" method="post"
						onsubmit="return confirm('Kullanıcıyı silmek istediğine eminmisin??')">
					<?= csrf_field() ?>
					<button type="submit" class="btn btn-danger btn-block"><?= lang('admin/User.deleteUser') ?></button>
				</form>
			</div>

			<?php if(Config\Services::authorization()->inGroup('admin', $user->id)): ?>
				<div class="mt-4">
					<form action="/admin/users/<?= esc($user->id) ?>/rmadmin" method="post"
							onsubmit="return confirm('Admin grubundan silmek istediğine eminmisin')">
						<?= csrf_field() ?>
						<button type="submit" class="btn btn-info btn-block"><?= lang('admin/User.unmakeAdmin') ?></button>
					</form>
				</div>
			<?php else: ?>
				<div class="mt-4">
					<form action="/admin/users/<?= esc($user->id) ?>/addadmin" method="post"
							onsubmit="return confirm('Admin grubuna eklemek istediğine eminmisin')">
						<?= csrf_field() ?>
						<button type="submit" class="btn btn-info btn-block"><?= lang('admin/User.makeAdmin') ?></button>
					</form>
				</div>
			<?php endif ?>

			<div class="mt-4">
				<?php if ($user->status == 'banned') : ?>
					<form action="/admin/users/<?= esc($user->id) ?>/unban" method="post">
						<?= csrf_field() ?>
						<button type="submit" class="btn btn-info btn-block"><?= lang('admin/User.doUnBan') ?></button>
					</form>
				<?php else : ?>
					<form action="/admin/users/<?= esc($user->id) ?>/ban" method="post">
						<?= csrf_field() ?>
						<button type="submit" class="btn btn-danger btn-block"><?= lang('admin/User.doBan') ?></button>
					</form>
				<?php endif ?>
			</div>
		</div>
	</div>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			<?= lang('Home.updatePassword') ?></div>
		<div class="card-body">

			<?php if (session()->has('success')) : ?>
				<div class="alert alert-success" role="alert">
					<?= session('success') ?>
				</div>
			<?php endif ?>

			<?php if (session()->has('errors')) : ?>
				<ul class="alert alert-danger" role="alert">
				<?php foreach (session('errors') as $error) : ?>
					<li><?= $error ?></li>
				<?php endforeach ?>
				</ul>
			<?php endif ?>

			<form action="/admin/users/<?= esc($user->id) ?>/change-password" method="post">
				<?= csrf_field() ?>
				<div class="form-group">
					<label for="password"><?= lang('admin/User.enterPassword') ?></label>
					<input type="password" name="password" class="form-control" id="password">
				</div>
				<div class="form-group">
					<label for="password-confirm"><?= lang('admin/User.confirmPassword') ?></label>
					<input type="password" name="password-confirm" class="form-control" id="password-confirm">
				</div>
				<button type="submit" class="btn btn-primary btn-block"><?= lang('Home.updatePassword') ?></button>
			</form>
		</div>
	</div>

<?= $this->endSection() ?>