<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="#">Dashboard</a>
		</li>
		<li class="breadcrumb-item active"><?= lang('admin/Team.addTeam') ?></li>
	</ol>

	<div class="card mb-3">
		<div class="card-header">
			<i class="fas fa-chart-area"></i>
			<?= lang('admin/Team.addTeam') ?></div>
		<div class="card-body">
			<form action="/admin/teams/" method="post">
				<?= csrf_field() ?>
				<div class="form-group">
					<label for="leader_id"><?= lang('admin/Team.leader') ?> ID</label>
					<input type="number" name="leader_id" class="form-control" id="leader_id">
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