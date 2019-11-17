<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="#">Dashboard</a>
		</li>
		<li class="breadcrumb-item active"><?= lang('admin/User.addUser') ?></li>
	</ol>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			<?= lang('admin/User.addUser') ?></div>
		<div class="card-body">
			<?php if(session()->has('errors')): ?>
				<?php foreach(session()->get('errors') as $key => $message): ?>
				<div class="alert alert-danger" role="alert">
					<?= $message ?>
				</div>
				<?php endforeach ?>
			<?php endif; ?>
			<form action="/admin/users" method="post">
				<?= csrf_field() ?>
				<div class="form-group">
					<label for="username"><?= lang('admin/User.enterUsername') ?></label>
					<input type="text" name="username" class="form-control" id="username">
				</div>
				<div class="form-group">
					<label for="email"><?= lang('admin/User.enterEmail') ?></label>
					<input type="email" name="email" class="form-control" id="email">
				</div>
				<div class="form-group">
					<label for="name"><?= lang('admin/User.enterName') ?></label>
					<input type="text" name="name" class="form-control" id="name">
				</div>
				<div class="form-group">
					<label for="team_id"><?= lang('admin/User.selectTeam') ?></label>
					<select name="team_id" class="form-control" id="team_id">
						<option disabled selected value>--- <?= lang('admin/User.pickATeam') ?> ---</option>
						<?php foreach($teams as $team): ?>
							<option value="<?= esc($team["id"]) ?>"><?= esc($team["name"]) ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="password"><?= lang('admin/User.enterPassword') ?></label>
					<input type="password" name="password" class="form-control" id="password">
				</div>
				<div class="form-group">
					<label for="password-confirm"><?= lang('admin/User.confirmPassword') ?></label>
					<input type="password" name="password-confirm" class="form-control" id="password-confirm">
				</div>
				<button type="submit" class="btn btn-primary btn-block"><?= lang('admin/User.addUser') ?></button>
			</form>
		</div>
	</div>

<?= $this->endSection() ?>