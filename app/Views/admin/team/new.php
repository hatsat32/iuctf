<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>

	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="/admin">Dashboard</a>
		</li>
		<li class="breadcrumb-item active"><?= lang('admin/Team.addTeam') ?></li>
	</ol>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			<?= lang('admin/Team.addTeam') ?></div>
		<div class="card-body">
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

			<form action="/admin/teams/" method="post">
				<?= csrf_field() ?>
				<div class="form-group">
					<label for="leader_username"><?= lang('admin/Team.leaderUsername') ?></label>
					<input type="username" name="leader_username" class="form-control" id="leader_username">
				</div>
				<div class="form-group">
					<label for="name"><?= lang('General.name') ?></label>
					<input type="name" name="name" class="form-control" id="name">
				</div>
				<button type="submit" class="btn btn-primary btn-block"><?= lang('admin/Team.addTeam') ?></button>
			</form>
		</div>
	</div>

<?= $this->endSection() ?>