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
			<?= $this->include('admin/templates/message_block') ?>
			<form action="/admin/teams/" method="post">
				<?= csrf_field() ?>
				<div class="form-group">
					<label for="leader_username"><?= lang('admin/Team.leaderUsername') ?></label>
					<input type="username" name="leader_username" class="form-control" id="leader_username"
							value="<?= esc(old('leader_username')) ?>">
				</div>
				<div class="form-group">
					<label for="name"><?= lang('General.name') ?></label>
					<input type="name" name="name" class="form-control" id="name" value="<?= esc(old('name')) ?>">
				</div>
				<button type="submit" class="btn btn-primary btn-block"><?= lang('admin/Team.addTeam') ?></button>
			</form>
		</div>
	</div>

<?= $this->endSection() ?>